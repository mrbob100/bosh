<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;

class Product extends Model
{

    protected $table='products';
    protected $primaryKey='id';
    protected $fillable = ['id','category_id','code','name','description','text','price','pricedealer1','pricedealer2','img','type','country','groupTools','new','hit','sale','weightbrutto','sclad','ukvd',
        'weightnetto','width','length','height','termGuarantee','class','packing','company','created_at','updated_at','exactlyType1','keywords','meta_desc'];
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function categories()
    {
        return  $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function order_items()
    {
        return $this->belongsTo('App\Models\Order_item','product_id','id');
    }

    public function typeTools()
    {
        return $this->belongsTo('App\Models\TypeTool','type','id');
    }


    public function groupTools()
    {
        return $this->belongsTo('App\Models\Grouptool','groupTools','id');
    }


    public function newproducts()
    {
        return $this->belongsTo('App\Models\Newproduct','id','product_id');
    }

    public function outParameter($products)
    {
        $arka=[];
// блок вывода exactlyType1 в иконку продукта
        foreach ($products as $product)
        {
            $qTemp=$product->exactlyType1;
            if($qTemp)
            {
                ob_start();
                $content_char="<ul class='exact1'>"; $i=0;
                foreach($qTemp as $item)
                {

                    $wqTemp01=explode('-',$item);
                    if(!isset($wqTemp01[1]))
                    {
                        $wqTemp01=explode('–',$item);
                    }
                    if(isset($wqTemp01[2]))
                    {
                        $str=$wqTemp01[1].'-'.$wqTemp01[2];
                        $wqTemp01[1]=$str;
                    }

                    //____________________________________________________________________________________________________
                    if(!isset($wqTemp01[1])) // внесение в файл ошибок
                    {

                        // $app=['exacttlyType1'=>$product->exactlyType1, 'id'=>$product->id];
                        $s=0;
                        foreach ($qTemp as $itemic)
                        {
                            $arka[$s]=$itemic;
                            $s++;
                        }
                        $cint=count($arka);
                        $str=$product->id;
                        for($s=0; $s<$cint; $s++)
                        {
                            $str=$str.' '.$arka[$s].' ';
                        }
                        //  $app=['exacttlyType1'=> $str, 'id'=>$product->id];
                        Storage::prepend('file_error.txt',$str);
                        break;
                    }
                    //____________________________________________________________________________________________________
                    $wqTemp01[0]=trim($wqTemp01[0]);
                    $wqTemp01[1]=trim($wqTemp01[1]);
                    /*   if($priznakOut!=11)
                       {
                           $str=mb_substr($wqTemp01[0],0,22);
                           $wqTemp01[0]=$str;
                           $str=mb_substr($wqTemp01[1],0,11);
                           $wqTemp01[1]=$str;
                       }  */

                    $str=mb_substr($wqTemp01[0],0,19);
                    $wqTemp01[0]=$str;
                    $str=mb_substr($wqTemp01[1],0,11);
                    $wqTemp01[1]=$str;
                    $s1=strlen($wqTemp01[0]);
                    $s2=strlen($wqTemp01[1]);
                    $s3=52-($s1+$s2); $s4='';
                    for($j=0; $j<$s3; $j++)
                    { $s4 .= '.'; }
                    $content_char.="<li style='display: flex; flex-direction: row; flex-wrap: wrap;'>";
                    $content_char.="<div>".$wqTemp01[0]."</div>";
                    $content_char.="<div>$s4</div>";
                    $content_char.="<div>".$wqTemp01[1]."</div>";
                    $content_char.="</li>";

                    if($i>=3)break;
                    $i++;
                }
                $content_char.="</ul>" ;
                $product->exactlyType1=$content_char;
                ob_end_clean();
            }
        }
// конец блока вывода
    }
}
