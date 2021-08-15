<?php

namespace App\Repositories\Eloquent;

use ProductInterface;
use App\Models\Product;
use App\Repositories\Interfaces\InventoryInterface;

class InventoryRepository implements InventoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
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
        return  $this->model->create(array_merge($request, ['user_id' => auth('sanctum')->user()->id]));

        
    }

    public function update($request, $id)
    {
        # code...
    }

    public function delete($request, $id)
    {
        # code...
    }

    public function find($request, $id)
    {
        # code...
    }
}