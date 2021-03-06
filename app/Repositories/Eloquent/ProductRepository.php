<?php

namespace App\Repositories\Eloquent;

use ProductInterface;
use App\Models\Product;
use App\Repositories\Interfaces\ProductInterface as InterfacesProductInterface;

class ProductRepository implements InterfacesProductInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }
    

    public function create($request)
    {
        # code...
    }

    public function edit($id)
    {
        # code...
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