<?php

namespace App\Repositories\Interfaces;

interface InventoryInterface
{
    public function all();
    public function createProduct(array $data);
    public function edit($id);
    public function update(array $data, $id);
    public function delete($id);
    public function find(array $data, $id);

    public function my_products(array $sortBy, array $sortDesc, $page, $itemsPerPage);

    

}