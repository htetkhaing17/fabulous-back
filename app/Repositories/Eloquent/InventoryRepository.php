<?php

namespace App\Repositories\Eloquent;

use App\Jobs\Cloudinary\CloudinaryImageDelete;
use ProductInterface;
use App\Models\Product;
use Cloudinary\Cloudinary;
use App\Repositories\Interfaces\InventoryInterface;
use Illuminate\Support\Facades\Cache;

class InventoryRepository implements InventoryInterface
{
    protected $model;
    protected $cloudinary;

    public function __construct(Product $product)
    {
        $this->model = $product;
        $this->cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_NAME'),
                    'api_key'    => env('CLOUDINARY_KEY'),
                    'api_secret' => env('CLOUDINARY_SECRETE'),
                ],                
            ]
        );
    }
    

    public function all()
    {
        return true;
        # code...
    }

    public function my_products($sortBy = ['id'], $sortDesc = ['true'], $page = '1', $per_page = 10)
    {
        return $this->model->where('user_id', auth('sanctum')->user()->id)
            ->when(count($sortBy), function($q) use ($sortBy, $sortDesc){
                foreach($sortBy as $key=>$s){
                    $q->orderBy($sortBy[$key], $sortDesc[$key] === 'true'? 'desc' : 'asc');
                }
            })
            ->paginate($per_page);
    }

    public function createProduct($request)
    {
        $product = $this->model->create(array_merge($request, ['user_id' => auth('sanctum')->user()->id]));
        $product->categories()->sync($request['categories']);
        return $product;

    }

    public function edit($id)
    {
        $product = $this->model->with('images')->findOrFail($id);
        $product->categories = $product->categories()->allRelatedIds();
        return $product;
    }

    public function update($request, $id)
    {
        $product = $this->model->with('images')->findOrFail($id);
        
        // $request['is_public'] = $request['is_public'] === 'true'? true: false;
        // return $request['new_images'];
        $images = $request['new_images']?? [];
        $delete_images = $request['removed_images']?? [];

        $images = collect($images)->map(function($img){
            $old = $img;
            $img['filename'] = str_replace('_temp', 'products', $img['filename']);
            $img['url'] = str_replace('_temp', 'products', $img['url']);

            $this->cloudinary->uploadApi()->rename($old['filename'], $img['filename'], $options = []);
            return $img;
        });
        $product->update($request);
        $product->categories()->sync($request['categories']);
        $product->images()->createMany($images??[]);


        /**
         * delete image from cloud and database
         */
        $image_ids = [];
        foreach($delete_images as $obj){
            $product->images()->where('id', '=', $obj['id'])->delete();
            array_push( $image_ids, $obj['filename']);
        }
        if(count($image_ids) > 0) CloudinaryImageDelete::dispatch($this->cloudinary, $image_ids);

        Cache::forget('recent_products');
        return $product;
    }

    public function delete($id)
    {
        # code...
    }

    public function find($request, $id)
    {
        # code...
    }
}