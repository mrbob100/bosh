<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Discount extends Model
{
    public function discounts($user, $total,$start=0)
    {
        $discounts=Discount::all();  // загрузка таблицы скидок
        $art=[]; $j=0; $cnt=count($discounts);
        $summa=0;
        $orderStore= Order::where('user_id',$user)->get();
        if($orderStore)
        {
            foreach ($orderStore as $order)
            {
                $summa += $order->sum;
            }
        } else {
            $summa=0;
        }
        $summa+=$total;
        foreach($discounts as $discount)
        {
            $art[$discount->rang]=$discount->volume;
            if($summa>=$art[$discount->rang])
            {
                $j++;
            }
        }
        $disco=0;
        if($j>0)  { $disco=$discounts[$j-1]->discount; }
        $data=[
           'summa' =>$summa,
            'discount'=>$disco
        ];
        return $data;
    }
}
