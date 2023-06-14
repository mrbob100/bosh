<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {



            // $products=DB::table('products')->simplePaginate(10);
            $orders=Order::with('users')->paginate(6);

            // $products->img=json_decode( $products->img);
            //  $products=Product::paginate(10);
            //   $category= $products->load('getCategory');
            /*     $j=0;
           foreach ($products as $prod)
           {
               $parent=$prod->getCategory->parent_id;

              $parent_number=Category::where('id',$parent)->first();
             if($parent)  { $parent_name[$j]=$parent_number->name; }
             else $parent_name[$j]='Самостоятельная категория';
                $j++;
           } */


            return response()->json(['status'=>true,'orders'=>$orders]);

    }

    public function chart(){
        $orders=Order::all();
        $notChoise=0; $inWork=0;
        $overworked=0;$send=0;
        foreach ($orders as $order) {
            if($order->status==0 || $order->status==NULL) {
                $notChoise+=1;
            }
            if($order->status==1) {
                $inWork+=1;
            }
            if($order->status==2) {
                $overworked+=1;
            }
            if($order->status==3) {
                $send+=1;
            }

        }
       return response()->json([ 'status'=>true,
            'labels'=>['Не обработан','В работе', 'Обработан', 'Отправлен'],
            'datasets'=>array([
                'label'=>'Заказы',
                'backgroundColor'=>['rgba(235, 21, 68, 0.9)', 'rgba(13, 128, 13, 0.9)','rgba(54, 162, 235, 0.9)',
                'rgba(255, 206, 86, 0.9)'],
                'data'=>[$notChoise, $inWork, $overworked, $send]

            ])



        ]);


    }
}
