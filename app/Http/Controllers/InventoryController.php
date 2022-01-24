<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\InventoryInterface;

class InventoryController extends Controller
{
    protected $repo;
    
    public function __construct(InventoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function my_products(Request $request)
    {
        $products = $this->repo->my_products($request->sortBy ?? ['id'], $request->sortDesc ?? ['true'], $request->page ?? 1, $request->itemsPerPage ?? 10);
        return response()->json(['data' => $products, 'message' => 'ok']);
    }

    public function createProduct(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'sku' => 'required | string',
            'description' => 'required | string ',
            'price' => 'required | numeric',
            'in_stock' => 'required',
            'is_public' => 'required'
        ];
        $messages = [
            'same' => 'The :attribute and :other must match.',
            'size' => 'The :attribute must be exactly :size.',
            'between' => 'The :attribute value :input is not between :min - :max.',
            'in' => 'The :attribute must be one of the following types: :values',
        ];
        $validator = Validator::make($request->input(), $rules, $messages);

        if($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        $product = $this->repo->createProduct($request->only('title', 'sku', 'description', 
        'price', 'is_public', 'in_stock', 'categories'));

        if($product){
            Cache::forget('recent_products');
            return response()->json(['message' => 'ok', 'product' => $product], 200);
        }

        return response()->json(['message', 'error in creating product'], 422);
    }


    public function edit($user_id, $id)
    {
        $product = $this->repo->edit($id);
        return response()->json(['data' => $product, 'message' => 'ok']);
    }

    /**
     * Product Update
     */
    public function update(Request  $request,$user_id,  $id)
    {
        $product = $this->repo->update($request->only('title', 'sku', 'description', 
        'price', 'is_public', 'in_stock', 'categories', 'new_images', 'removed_images'), $id);
        return response()->json(['data' => $product, 'message' => 'ok']);
    }

    function delete($id)
    {
        # code...
    }



    public function all()
    {
        return true;
    }

}
