<?php
namespace App\Repositories;
use App\Models\Directory;
class DirectoriesRepository extends Repository
{
    public function __construct(Directory $directory)
    {
        $this->model=$directory;
    }
}