<?php

namespace App\Http\Controllers\Admin;

use App\Models\Csvload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Category;


class CategoryAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
       if($request->isMethod('post'))
       {
           $input=$request->except('_token');

           $file=false; $qw1=false;
           if($request->hasFile('img'))
           {
               $file=$request->file('img');
               if($file->isValid())
               {
                   $qw= $file->getClientOriginalName(); // вставка реального имени
                   $qw1=explode('.',$qw);

                   // $img = Image::make($file1)->resize(120,75);

                   // move - команда перемещения файла из временного хранилища в постоянное
                   //   $file->move(public_path().'/images',$input['img']);  // записывает в библиотеку public содержимое файла $input['images']
               }
           }

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


           if($input['parent_id']==NULL) $input['parent_id']=0*1;
           $category=new Category();
           //  $category->unguard(); // снимает ограничения fillable
           $category->fill($input);  // заполнение полей category

           if($category->save())
           {
               return response()->json(['status' => true], 200);
           }
       }
        abort(404);
    }


}
