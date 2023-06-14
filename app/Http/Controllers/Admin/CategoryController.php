<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {

        //  $categories=Category::simplePaginate(10);

        $categories=Category::where('id','!=',9999)->select('id','parent_id','name', 'img')->get();


        return response()->json(['status' => true, 'categories'=>$categories],

            200);
    }
}
