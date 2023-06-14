<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    public function index(Request $request)
    {
        // $user= $request->input('user');
        $text = $request->input('nominate');
       // $products = Product::where('name','like',$text)->orWhere('code','like', $text)->select('*')->get();
        $products = Product::where('name','like','%'.$text.'%')->orWhere('code','like', '%'.$text.'%')->select('*')->get();
        $products->transform(function ($item, $key){
            if(is_string($item->img) && is_object(json_decode($item->img))&& json_last_error()==JSON_ERROR_NONE)
            {   $item->img=json_decode($item->img); }

            if(is_string($item->exactlyType1) && is_object(json_decode($item->exactlyType1))&& json_last_error()==JSON_ERROR_NONE)
            {   $item->exactlyType1=json_decode($item->exactlyType1); }
            return $item;
        });


        $prod=$products[0];
        $prod->load('categories');
        // $prod->load('typetools');
        $nicks=DB::table('typetools')->get();
        $groups=DB::table('grouptools')->get();

        $npcount=count($products);

        for($j=0; $j<$npcount; $j++) {

            $type=""; $type1="";

            foreach ( $nicks as $sv) {

                if($sv->id==$products[$j]['type']) {
                    $type=$sv->name; continue;
                }
            }

            foreach ( $groups as $sv) {

                if($sv->id==$products[$j]['groupTools']) {
                    $type1=$sv->name; continue;
                }
            }


            $products[$j]->exactlyType2 =   $type.'!'  .$type1;


        }

        // блок вывода exactlyType1 в иконку продукта
        $result= new Product();
        $result->outParameter($products);
        return response()->json([
            'status' => true,
            'products'=>$products

        ]);
    }
}
