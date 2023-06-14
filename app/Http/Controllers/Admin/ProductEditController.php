<?php

namespace App\Http\Controllers\Admin;


namespace App\Http\Controllers\Admin;

use App\Models\Airflow;
use App\Models\Company;
use App\Models\Cutdepth;
use App\Models\Cutmatdepth;
use App\Models\Cutedgewidth;
use App\Models\Defence;
use App\Models\Frequency;
use App\Models\Grouptool;
use App\Models\Packing;
use App\Models\TypeTool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Anglecutdepth;
use App\Models\Capacity;
use App\Models\Diametrdsk;
use App\Models\Idle;
use App\Models\Impact;
use App\Models\Maxhole;
use App\Models\Performance;
use App\Models\Power;
use App\Models\Qntimpact;
use App\Models\Rotationspeed;
use App\Models\Spindle;
use App\Models\Voltage;
use App\Models\Cartridge;
use App\Models\Grindingplate;
use App\Models\Holestand;
use App\Models\Maxcapacity;
use App\Models\Scaffold;
use App\Models\Shankrange;
use App\Models\Steel;
use App\Models\Strokelength;
use App\Models\Vibration;
use App\Models\Workingwidth;
use App\Models\Country;
use App\Models\Accumulatortype;
use App\Models\Accuracy;
use App\Models\Accuracyslope;
use App\Models\Android;
use App\Models\Angle;
use App\Models\Brightness;
use App\Models\Calculation;
use App\Models\Chargetime;
use App\Models\Containervol;
use App\Models\Crownlength;
use App\Models\Display;
use App\Models\Fixture;
use App\Models\Functional;
use App\Models\Gluediameter;
use App\Models\Gluelength;
use App\Models\Goaldistance;
use App\Models\Holediameter;
use App\Models\Ignition;
use App\Models\Iphone;
use App\Models\Laserclass;
use App\Models\Magnificate;
use App\Models\Measurange;
use App\Models\Measurenumber;
use App\Models\Oscillationangle;
use App\Models\Powersupply;
use App\Models\Screw;
use App\Models\Strokeqnt;
use App\Models\Temperature;
use App\Models\Thread;
use App\Models\Turbinpower;
use App\Models\Typeaccuracy;
use App\Models\Unit;
use App\Models\Wheeldiameter;
use App\Models\Worktime;
use App\Models\Classprofy;



use App\Models\Csvload;

use Validator;
use Config;
use DB;
use Intervention\Image\File;

class ProductEditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index( Request $request,Product $product)
    {
        $capacity=Capacity::all();
        $angleCuttingDepth=Anglecutdepth::all();
        $cuttingDepth=Cutdepth::all();
        $cutmatdepth=Cutmatdepth::all();
        $diametrDisk=Diametrdsk::all();
        $idle=Idle::all();
        $impact=Impact::all();
        $maxHole=MaxHole::all();
        $performance=Performance::all();
        $power=Power::all();
        $qntImpact=Qntimpact::all();
        $rotationSpeed=Rotationspeed::all();
        $spindle=Spindle::all();
        $voltage=Voltage::all();
        $cartridge=Cartridge::all();
        $airflow=Airflow::all();
        $cutEdgeWidth=Cutedgewidth::all();
        $defence=Defence::all();
        $frequency=Frequency::all();
        $grindplate=Grindingplate::all();
        $holestand=Holestand::all();
        $maxcapacity=Maxcapacity::all();
        $scaffold=Scaffold::all();
        $shankrange=Shankrange::all();
        $steel=Steel::all();
        $strokelength=Strokelength::all();
        $vibration=Vibration::all();
        $workingwidth=Workingwidth::all();

        $accumulatortype=Accumulatortype::all();
        $accuracy=Accuracy::all();
        $accuracyslope=Accuracyslope::all();
        $android=Android::all();
        $angle=Angle::all();
        $brightness=Brightness::all();
        $calculation=Calculation::all();
        $chargetime=Chargetime::all();
        $containervol=Containervol::all();
        $crownlength=Crownlength::all();
        $display=Display::all();
        $fixture=Fixture::all();
        $functional=Functional::all();
        $gluediameter=Gluediameter::all();
        $gluelength=Gluelength::all();
        $goaldistance=Goaldistance::all();
        $holediameter=Holediameter::all();
        $ignition=Ignition::all();
        $iphone=Iphone::all();
        $laserclass=Laserclass::all();
        $magnificate=Magnificate::all();
        $measurange=Measurange::all();
        $measurenumber=Measurenumber::all();
        $oscillationangle=Oscillationangle::all();
        $powersupply=Powersupply::all();
        $screw=Screw::all();
        $strokeqnt=Strokeqnt::all();
        $temperature=Temperature::all();
        $thread=Thread::all();
        $turbinpower=Turbinpower::all();
        $typeaccuracy=Typeaccuracy::all();
        $unit=Unit::all();
        $wheeldiameter=Wheeldiameter::all();
        $worktime=Worktime::all();



        $typetools=TypeTool::all();
        $countrys=Country::all();
        $grouptools=Grouptool::all();
        $companies=Company::all();
        $packings=Packing::all();
        $class=Classprofy::all();





        $id=$request->id;


        if($request->isMethod('post'))
        {
            $input=$request->except('_token');
            if($request->input('delete')) {

                    Product::where('id', $id)->delete();
                    return response()->json(['status' => true], 200);

            }


//_________________________________________________________________________________________________________________
            // если есть основное изображение



            if($request->hasFile('img'))
            {
                $file=$request->file('img');
                if($file->isValid())
                {
                    $qw= $file->getClientOriginalName(); // вставка реального имени
                    $qw1=explode('.',$qw);
                    if (!isset($doblo))
                    {
                        $doblo= new Csvload();
                    }


                       $obj = $doblo->workUpImages(  $qw1[0], $file);
                    // $obj= $this->workUpImages( $str2->EAN_code,$workImage);
                    $input['img']=json_encode($obj);

                    // move - команда перемещения файла из временного хранилища в постоянное
                    //   $file->move(public_path().'/images',$input['img']);  // записывает в библиотеку public содержимое файла $input['images']
                }
            }

               else
                   {
                       $qw1=explode('_',$input['old_images']);
                     //  $feet=public_path() .'/public/'.env('THEME').'/images/'.$input['old_images'];
                     //  $file1 =file_get_contents('/public/'.env('THEME').'/images/'. $input['old_images']);
                    //   $img = Image::make($file1)->resize(120,75);

                       $sa=strval($qw1[1]);
                       $as=explode('.',$sa);

                       $qw2=$qw1[0]."_mini.".$as[1];
                       $qw3=$qw1[0]."_path.".$as[1];
                       $qw1=$input['old_images'];
                       $input['img']='{"mini":"'.$qw2.'","max":"'.$qw1.'","path":"'.$qw3.'"}';
                     //  $input['img']=json_encode($obj);

                   }
                   unset($input['old_images']);  // удаление ячейки

            $product=new Product();

            if(!$input['category_id']) {
                $input['category_id']=9999;

            }
            $input['category_id']=intval($input['category_id']);
            $input['type']=intval($input['type']);


            $product->fill($input);




           $prod=DB::table('products')->where('id',$id)->update($product->toArray());

          // $prod=Product::where('id',$id)->update($product->toArray());
            if($prod)
            {

                return response()->json(['status' => true], 200);
            }
            else abort(404);

        } // конец метода post
//______________________________________________________________________________________________________
//______________________________________________________________________________________________________
        $old=Product::find($id);
       // $model=$old;
        //$old=$sold->toArray();
       // dd($old);
       // $category= $old->getCategory->name;
        $sas =json_decode($old->img);
       $pic=$sas->max;
        $data=[
            //  'title' =>'Новая продукция',
            //  'model' =>  $model,
            'capacity'=>$capacity,
            'anglecuttingdepth'=>$angleCuttingDepth,
            'cuttingdepth'=>$cuttingDepth,
            'cutmatdepth'=>$cutmatdepth,
            'diametrdisk'=>$diametrDisk,
            'idle'=>$idle,
            'impact'=>$impact,
            'maxhole'=>$maxHole,
            'performance'=>$performance,
            'power'=>$power,
            'qntimpact'=>$qntImpact,
            'rotationspeed'=>$rotationSpeed,
            'spindle'=>$spindle,
            'voltage'=>$voltage,
            'cartridge'=>$cartridge,
            'airflow'=>$airflow,
            'cutedgewidth'=>$cutEdgeWidth,
            'defence'=>$defence,
            'frequency'=> $frequency,
            'grindplate'=>$grindplate,
            'holestand'=>$holestand,
            'maxcapacity'=>$maxcapacity,
            'scaffold'=>$scaffold,
            'shankrange'=>$shankrange,
            'steel'=>$steel,
            'strokelength'=>$strokelength,
            'vibration'=>$vibration,
            'workingwidth'=>$workingwidth,

            'accumulatortype'=>$accumulatortype,
            'accuracy'=>$accuracy,
            'accuracyslope'=> $accuracyslope,
            'android'=>$android,
            'angle'=>$angle,
            'brightness'=>$brightness,
            'calculation'=>$calculation,
            'chargetime'=> $chargetime,
            'containervol'=>$containervol,
            'crownlength'=> $crownlength,
            'display'=>$display,
            'fixture'=>$fixture,
            'functional'=>$functional,
            'gluediameter'=> $gluediameter,
            'gluelength'=>$gluelength,
            'goaldistance'=> $goaldistance,
            'holediameter'=> $holediameter,
            'ignition'=>$ignition,
            'iphone'=> $iphone,
            'laserclass'=> $laserclass,
            'magnificate'=>$magnificate,
            'measurange'=> $measurange,
            'measurenumber'=> $measurenumber,
            'oscillationangle'=> $oscillationangle,
            'powersupply'=>$powersupply,
            'screw'=>$screw,
            'strokeqnt'=>$strokeqnt,
            'temperature'=> $temperature,
            'thread'=>$thread,
            'turbinpower'=> $turbinpower,
            'typeaccuracy'=>$typeaccuracy,
            'unit'=> $unit,
            'wheeldiameter'=>$wheeldiameter,
            'worktime'=>$worktime,
            'typetools'=>$typetools,
            'country'=>$countrys,
            'grouptool'=>$grouptools,
            'company'=>$companies,
            'packing'=>$packings,
            'class'=>$class

        ];

        $old->load('categories');

     //  $old->transform(function ($item, $key){
      //      if(is_string($item->img) && is_object(json_decode($item->img))&& json_last_error()==JSON_ERROR_NONE)
      //      {   $item->img=json_decode($item->img); }

      //      return $item;
      //  });
        $old->img=$pic;
        $picture=$old->categories->name;
        $categories=Category::where('id','!=',9999)->select('id','parent_id','name', 'img')->get();
        //  return view(env('THEME').'.admin.products.product_add', $data);
        return response()->json(['status' => true, 'data'=>$data, 'categories'=> $categories,'product'=>$old, 'picture'=>$picture]);

        abort(404);
    }
}
