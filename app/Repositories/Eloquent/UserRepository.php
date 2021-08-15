<?php

namespace App\Repositories\Eloquent;

use ProductInterface;
use App\Models\Product;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
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