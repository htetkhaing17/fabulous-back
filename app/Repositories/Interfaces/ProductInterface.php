<?php

namespace App\Repositories\Interfaces;

interface ProductInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function delete(array $data, $id);
    public function find(array $data, $id);

}