<?php
namespace App\Repositories;
use App\Models\Menu;
class MenusRepositories extends Repository
{
  public function __construct(Menu $menu)
  {
    $this->model=$menu;
  }
}

