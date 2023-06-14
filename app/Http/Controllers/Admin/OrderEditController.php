<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order_item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Validator;
use DB;
class OrderEditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index(Request $request,Order $order)
    {
        $id=$request->id;



        if($request->isMethod('post'))
        {
            $input=$request->except('_token');

          /*  $validator=Validator::make($input,[
                // уникальное поле в таблице categories, поле - которое игнорируется, по какому полю поиск
                'name'=>'required | max:255, '.$input['id'],
               // 'Production.category_id'=>'required | min:0',
                'order'=>'required',
                'price'=>'required|numeric | min:0',
                'qty'=>'integer',
                'sum'=>'required|numeric | min:0',
                'status'=>'required | max:9'
            ]);

            if( $validator->fails())
            {
                return redirect()->route('productEdit',['id'=>$input['id']])->withErrors( $validator)->withInput();
            } */
//_________________________________________________________________________________________________________________
            // если есть основное изображение


//______________________________________________________________________________________________________________
            //   dump($input);


            $order= new Order();
            $order->id=$input['server']['id'];
            $order->user_id=$input['server']['user_id'];
            $order->qty=$input['server']['qty'];
            $order->sum=$input['server']['sum'];
            $order->status=intval($input['server']['status']);
            $order->manager=$input['server']['manager'];
            $order->comment='NULL';

            $orders=$input['products'];



                  foreach ( $orders as $item) {
                      $order_items= new Order_item;
                      $order_items->fill($item);
                   //   $ordersOut=DB::table('order_items')->where('id',$item['id'])->update($order_items->toArray());
                      $ordersOut=$order->order_items()->where('id',$item['id'] )->update($order_items->toArray());
                      if($ordersOut) {
                          $str='Пункт обновлен';
                      }
                      else abort(404);
                  }

            $prod=DB::table('orders')->where('id',$id)->update($order->toArray());

            if($prod)
            {
                return response()->json(['status'=>true]);
            }
            else abort(404);




           // $order->fill($input);

           /* array_key_exists('hit',$input) ?  $product['hit']=1 : $product['hit']=0;
            array_key_exists('new',$input) ?  $product['new']=1: $product['new']=0;
            array_key_exists('sale',$input) ?  $product['sale']=1 : $product['sale']=0; */

      /*      $prod=DB::table('orders')->where('id',$id)->update($order->toArray());

            // $prod=Product::where('id',$id)->update($product->toArray());
            if($prod)
            {
                return response()->json(['status'=>true]);
            }
             else abort(404); */

        }


        $old=Order::find($id);
        $old->load('users','order_items');



            return response()->json(['status'=>true,'orders'=>$old]);

        abort(404);
    }

    /*  protected function updateOrderItems($items, $order_id){
       foreach($items as $id => $item){
           $order

        $order_items = new Order_item();
           $order_items->order_id = $order_id;
           $order_items->product_id = $item['product']['id'];
           $order_items->name = $item['product']['name'];
           $order_items->code=$item['product']['code'];
           $order_items->price = $item['product']['price'];
           $order_items->qty_item = $item['cnt'];
           $order_items->sum_item = $item['cnt'] * $item['product']['price'];
           $order_items->update();*/






}
