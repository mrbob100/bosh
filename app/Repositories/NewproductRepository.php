<?php
namespace App\Repositories;
use App\Models\Newproduct;
class NewproductRepository extends Repository
{
    public function __construct(Newproduct $product)
    {
        $this->model=$product;
    }
}