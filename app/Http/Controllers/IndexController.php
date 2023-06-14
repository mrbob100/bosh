<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Widgets\MainWidget;
use Cache;
use App\Models\Newproduct;
use App\Repositories\ProductsRepository;
//use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use App\Repositories\SlidersRepository;
use App\Repositories\NewproductRepository;
use App\Models\Menuone;
use Config;
use Auth;
use App\User;
//use Session;
use Cookie;
use Storage;



class IndexController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }



    public function index($id=12)
    {
     $new=[]; $hit=[];

        $products = Product::where('hit',1)->orWhere('new',1)->select('*')->get(); // пункты кадров слайдера


        if( $products ->isEmpty()) return false;
        $products ->transform(function ($item, $key){
            if(is_string($item->img) && is_object(json_decode($item->img))&& json_last_error()==JSON_ERROR_NONE)
            {   $item->img=json_decode($item->img); }

            if(is_string($item->exactlyType1) && is_object(json_decode($item->exactlyType1))&& json_last_error()==JSON_ERROR_NONE)
            {   $item->exactlyType1=json_decode($item->exactlyType1); }
            return $item;
        });
        $arka=[];
        $products->load('categories');
        $nicks=DB::table('typetools')->get();
        $groups=DB::table('grouptools')->get();
        $type=""; $type1="";
        forEach($products as $product ) {

            foreach ( $nicks as $sv) {
                $as=$product['type'];
                if($sv->id==$product['type']) {
                    $type=$sv->name; continue;
                }
            }

            foreach ( $groups as $sv) {
                $as=$product['groupTools'];
                if($sv->id==$product['groupTools']) {
                    $type1=$sv->name; continue;
                }
            }


            $product->exactlyType2 =   $type.'!'  .$type1;
        }
        $priznakOut=0;
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
                        foreach($qTemp as $itemic)
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



        //  $categories=DB::table('categories')->toArray()->get();
       //  $akkord = new MainWidget();
       //    $a='menu.php';
        //   $akkord->init($a);
       //   $akkordeon= $akkord->run();
        //  $articles = DB::table('products')->simplePaginate(4);

        return response()->json([
            'products'=>$products

        ]);

    }




    protected function getArticles()
    {
        $articles= $this->a_rep->get(['title','created_at','img','alias'],Config::get('settings.home_articles_count'));
        return $articles;
    }


    public function show($id) {

        //$article = Article::find($id);

        //WHERE id = $id
        $article = Product::select(['id','name','content'])->where('id',$id)->first();

        //dump($article);

        return view('article-content')->with(['message'=>$this->message,
            'header' => $this->header,
            'article' => $article

        ]);

    }



    public function getNew()
    {
        $newproduct=$this->new_rep->get();
        if($newproduct->isEmpty()) return false;
        $newproduct->transform( function ($item, $key){
            $item->path =Config::get('settings.newproduct') .'/'.$item->path;

            return $item;
        });
        // dd($sliders);
        return $newproduct;
    }







    public function identityUser()
    {
        $user=Auth::user();
        if(!Auth::check()) {
            return redirect()->home();
        }
        $request=Request::createFromGlobals();
        //Session::flush();
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');
            $rules = [
                'name' => 'required|max:255',
                'secondname' => 'required|max:255',
             //   'password' => 'required|min:6|confirmed',
                'email' => 'required|email|max:255|unique:users,email,'. $input['id'],
                'phone' => 'required||min:10',
                'address' => 'required|max:255',

            ];

            $this->validate($request, $rules);



            $userx = new User();
            $userx->id=$user->id;
            $userx->name =$input['name'];
            $userx->email =$input['email'];
            $userx->secondname = $input['secondname'];
            $userx->phone = $input['phone'];
            $userx->address = $input['address'];

           // $userx->password =  bcrypt($input['password']);
            $userx->status=$user->status;
            $user->where('id',$user->id)->update( $userx->toArray());

                // $prod=DB::table('products')->where('id',$id)->update($product->toArray());
            return redirect('cabinet');
        }








        $old=$user;
        $this->template=env('THEME').'.change';
        $headers = view(env('THEME') . '.header')->render();
        $this->vars = array_add($this->vars, 'headers', $headers);
        $footer = view(env('THEME') . '.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);
        $content = view(env("THEME") . ".changeIdentity")->with('old',$old)->render();
        $this->vars = array_add($this->vars, 'content', $content);
        return view($this->template)->with($this->vars); // template устанавливается в дочернем классе
    }
}
