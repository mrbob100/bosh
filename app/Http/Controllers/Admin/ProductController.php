<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use DB;
use App\Models\Product;
use App\Models\Category;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {

           // $products=DB::table('products')->simplePaginate(10);
            $products=Product::with('categories')->paginate(6);
            $products->transform(function ($item, $key){
                if(is_string($item->img) && is_object(json_decode($item->img))&& json_last_error()==JSON_ERROR_NONE)
                {   $item->img=json_decode($item->img); }

                return $item;
            });

            return response()->json(['status'=>true,'products'=>$products]);

    }
}
