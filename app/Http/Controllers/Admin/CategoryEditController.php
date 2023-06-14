<?php

namespace App\Http\Controllers\Admin;


use App\Models\Csvload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
//use Illuminate\Support\Facades\DB;
use Validator;
use Config;
use Image;
use Illuminate\Support\Facades\Storage;
use DB;
class CategoryEditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Category $category, Request $request)

    {
        $id=$request->id;


        if($request->isMethod('post'))
        {
            $input=$request->except('_token');
            if($request->input('delete')) {

                $category->where('id',$id)->delete();
                return response()->json(['status' => true], 200);

            }

            // если есть изображение
          if($request->hasFile('img'))
           {
               $file=$request->file('img');
               if($file->isValid())
               {
                   $qw= $file->getClientOriginalName(); // вставка реального имени
                   $qw1=explode('.',$qw);

                   if($file->isValid())
                   {

                       if (!isset($doblo))
                       {
                           $doblo= new Csvload();
                       }


                       //  $qw1=$input['old_images'];
                       // $input['img']='{"mini":"'.$qw2.'","max":"'.$qw1.'","path":"'.$qw3.'"}';
                       $obj = $doblo->mergeUpImages($qw1[0], $file,  $file);
                       // $obj= $this->workUpImages( $str2->EAN_code,$workImage);



                       $input['img']=trim($obj->max, '\"');

                       // move - команда перемещения файла из временного хранилища в постоянное
                       //   $file->move(public_path().'/images',$input['img']);  // записывает в библиотеку public содержимое файла $input['images']
                   }
               }
           }
           else
               {
                   $input['img']=$input['old_images'];

               }
               unset($input['old_images']);  // удаление ячейки

          //  $ssa=$input["Category"];
          //  $input['parent_id']=$input["Category"]['parent_id'];
          //  $sdd=$input["Category"]['parent_id'];


            $category->fill($input); //заполнение полей category значениями $input

           $cat=DB::table('categories')->where('id',$id)->update($category->toArray());
            if($cat)
            {
                return response()->json(['status' => true], 200);
            }
            else abort(404);
        }


        $old=Category::find($id);
        $categories=Category::where('id','!=',9999)->select('id','parent_id','name', 'img')->get();
      //  $old=$category->toArray();
      //  dd($old);

if($old->parent_id==0){
    $parent='Самостоятельная категория';
} else {
   $parent= $old->getCategory->name;

}

//$model=$old;
        if($old)
        {


            return response()->json(['status' => true,'category'=>$old, 'categories'=> $categories], 200);
        }
        abort(404);
    }
}
