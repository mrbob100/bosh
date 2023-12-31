<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Response;
class CategorySuperController extends Controller
{
    public function index(Request $request)
    {
        $id=$request->id;
        $sigma='';
        $categories=Category::where('parent_id',$id)->get();
        $j=0;
        foreach ($categories as $category)
        {
            if($category->id==$id)
            {
                if(!isset($category->text)) {
                    $sigma="Привет ! Все хорошо, это проверка";
                } else  $sigma=$category->text;
                unset($categories[$j]);
            } $j++;
        }
        //  $this->vars=array_add($this->vars,  'content', $content);


        /* $articles=$this->getArticles($cat_alias);
         $content=view(env('THEME').'.articles_content')->with('articles',$articles)->render();
         $this->vars=array_add($this->vars,'content', $content);*/

        //  $this->template=env('THEME').'.product';
     //   if(!$sigma) return redirect('/');
        //   return $this->renderOutput();
        // return view($this->template)->with($this->vars);
        $content=view(env('THEME').'.category_super_choise')->with(['categories'=>$categories])->render();

        return Response::json(['success'=>true, 'content'=>$content, 'sigma'=>$sigma]);

    }
}
