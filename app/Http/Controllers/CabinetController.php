<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Orderoption;
use App\Models\Selectorder;
use App\Repositories\OrdersRepository;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use Auth;
use Carbon\Carbon;
use Session;
use Response;
use DB;

use Illuminate\Database\Query\Builder;
class CabinetController extends SiteController
{
    public function __construct( OrdersRepository $o_rep)
    {


        $this->o_rep=$o_rep;  // portfolio
        // $this->a_rep=$a_rep;  // articles

        $this->template=env('THEME').'.left_barCab';
        $this->barCabinet=true;  // устанавливает сайт бар значения: left, right, no
        $this->bar=true;
    }

    public function index(Request $request)
    {
       // $user= $request->input('user');
        $id = $request->input('user');

    If(!$id ) return redirect('/');


        $options=OrderOption::all();
        $optionTool=array();

        foreach(  $options as $tool)
        {
            $optionTool[$tool->id]=$tool->name;

        }



//______________________________________________________________________________________________________________________________
        // если данные переданы методом GET
        $priznak=0;
        $role_id=0;
        $alias=$id;

        $user=User::where('id', $id)->first();
        $role_id=strval($user->role_id);





       if($role_id==2){
           $orders=Order::where("status",0)->orWhere('manager',$alias)->orderBy('status','asc')->simplePaginate();
           $priznak=1;
       }
         else {

          $orders=$this->getOrders($role_id,$alias);



      }

       if($orders)
       {
               $orders->load('users','order_items');
       } else {  // внесение статуса пользователя в поле tatus
           if($role_id==0)
           {
             //  $role = Role::find(3);  // внесение записи в таблицу role_user категории 3
            //   $role->users()->save($user);

           }


       }

       $records=[];
        $point_user= new User();
        $n=count($orders);
          $data= $point_user->countData( $orders,$priznak);


for( $i=0; $i< $n; $i++ )
{
    $records[$i]= $orders[$i];
   // $res= $records[$i];
   // $orderitems= $res->order_items;
   // $n1= count($orderitems);



  //  for($j=0; $j< $n1; $j++)
  //  {
   //     $items[$i][$j] = $orderitems[$j];
   // }

}

        return response()->json(['success'=>true, 'records'=> $records, 'data'=> $data ]);

      //  return Response::json(['success'=>true, 'orders'=>$orders, 'data'=> $data ]);
 }



    protected function getOrders($role_id=false, $alias=false)
    {
        $id=false;
        $were=false;
        if($role_id==2) {

            //  $id=Category::select('id')->where('id',$alias)->first()->id;
            //  $id=DB::table('categories')->select('id')->where('alias',$alias)->get();

            $were=['manager',$alias];
        }elseif ($role_id==7)
        {
            $were=['id',$alias];
        }
        else{
            $were=['user_id',$alias];
            $samp='created_at';
           }
        $orders= $this->o_rep->get(['id','user_id','qty','sum','status','manager','created_at','comment'], false,true,$were,$samp);
        // if($products) $articles->load('user','category','comments');
        // dd($id);

        return $orders;
    }




// программа приним ающая ajax запрос
    public function caboption()
    {
        $user=Auth::user();
        $request=Request::createFromGlobals();
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');


             $orders=$this->viborOrders($input, $user);


            $options=OrderOption::all();
            $optionTool=array();

            foreach(  $options as $tool)
            {
                $optionTool[$tool->id]=$tool->name;

            }

            $role_id=0;
            $roleIds=$user->roles;
            $priznak=0;
            foreach( $roleIds as $role)
            {
                $item=$role->id;

                if( $item==2)
                {
                    $role_id=2;
                    $alias=$user->secondname;
                    break;
                }
                if($item==3)
                {
                    $role_id=3;
                    $alias=$user->id;
                    break;
                }

            }
            if( $role_id==2) {$priznak=1;}




            $content = view(env('THEME') . '.orders_cabinet')->with(['orders'=> $orders,'priznak' =>$priznak,'optionTool'=>$optionTool])->render();

            return Response::json(["success"=>true, "content"=>$content]);
        }
    }




}
