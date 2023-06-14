<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class categoryMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    public  function index()
    {
        $categories=Category::where('id','!=',9999)->select('id','parent_id','name', 'img')->get();
        return response()->json([
            'categories'=> $categories
        ]);
    }
}
