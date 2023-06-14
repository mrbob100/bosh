<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Order_item;

use App\User;
use App\Models\Role;
use App\Models\Discount;
use Response;

use Cache;
use DB;

use Auth;
use Illuminate\Support\Facades\Hash;



class CartController extends SiteController
{

    public function index(Request $request)
    {
        $user= $request->input('user');

        $goods=$request->input('products');


     //  DB::table('orders')->truncate();
    //    DB::table('order_items')->truncate();

        $order = new Order();

        $quantity=null;
        $total=null;
        foreach ($goods as $prod) {
          $total+=$prod['product']['price'] * $prod['cnt'];

            $quantity+=$prod['cnt'];
        }
        $order->user_id = $user;
      $order->qty=$quantity;
      $order->sum=$total;


        // блок расчета ранга пользователя

        $saa=new Discount();
        $status=$saa->discounts($user,$total);

       //  DB::table('users')->where('id',$user)->update(['role'=>3,'discount' =>$status ]);
        User::where('id',$user)->update(['role_id'=>3,'discount' =>$status ]);

        //$user->discount=$status['discount'];


       // $order->qty=
        if($order->save()) {
            $this->saveOrderItems( $goods, $order->id);
            return response()->json(['status' => true,

            ],
                200);
        }
        else return redirect('/');
        //_______________________________________________

    }



    protected function saveOrderItems($items, $order_id){
        foreach($items as $id => $item){
            $order_items = new Order_item();
            $order_items->order_id = $order_id;
            $order_items->product_id = $item['product']['id'];
            $order_items->name = $item['product']['name'];
            $order_items->code=$item['product']['code'];
            $order_items->price = $item['product']['price'];
            $order_items->qty_item = $item['cnt'];
            $order_items->sum_item = $item['cnt'] * $item['product']['price'];
            $order_items->save();
        }

    }






   /* public function loadCart(Request $request)
    {
        $id=$request->id;
        // $qty =(int) $request->qty;

        // $qty=!$qty ? 1 : $qty;
        $qty=1;
        $product = Product::where('id',$id)->select('id','name','code','description','img','price','category_id','keywords','meta_desc')->first();
        // $product=DB::table('products')->where('id',$id)->select('id','name','code','description','img','price','category_id','keywords','meta_desc')->get();
        if(empty($product)) return false;
        $products=json_decode($product->img);
        $product->img=$products->max;
        $newprice=Session::get('Price');
        if($newprice)  // установка новой цены
        {
            $product->price=$newprice[0]['newprice'];
        }

        $this->layout = false;
        $cart = new Cart();
        $cart->addToCart($product, $qty);
       $content=view('cart.cartModal')->render();
        return Response::json(['success'=>true, 'content'=>$content]);
    } */

}
