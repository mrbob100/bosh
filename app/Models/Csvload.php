<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Image;
use Illuminate\Support\Str;
class Csvload extends Model
{
    public function workUpImages($myImage, $workImage)
    {


           // $line=str_random(7);
            $obj= new \stdClass;
            $obj->mini=$myImage.'_mini.jpg';
            $obj->max=$myImage.'_max.jpg';
            $obj->path=$myImage.'_path.jpg';
            $img=Image::make($workImage);
            //   $img->resize(null, 600, function ($constraint) {
            //      $constraint->aspectRatio();
            $img->resize(null,Config::get('settings.image')['height'],function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path().'/images/'.$obj->path);
            $img->resize(null,Config::get('settings.product_img')['max']['height'],function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path().'/images/'.$obj->max);

            $img->resize(null,Config::get('settings.product_img')['mini']['height'],function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path().'/images/'.$obj->mini);

        return $obj;
    }

    public function mergeUpImages($myImage, $workImage, $insertImages)
    {
        $line=Str::random(7);
        $obj= new \stdClass;
        $obj->mini=$line.$myImage.'_mini.jpg';
        $obj->max=$line.$myImage.'_max.jpg';
        $obj->path=$line.$myImage.'_path.jpg';
        $img=Image::make($workImage);
        $watermark = Image::make($insertImages);
            $watermark->resize(200,null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->insert($watermark,'bottom-right',10,10);
        $img->resize(null,Config::get('settings.image')['height'],function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path().'/images/'.$obj->path);
        $img->resize(null,Config::get('settings.product_img')['max']['height'],function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path().'/images/'.$obj->max);

        $img->resize(null,Config::get('settings.product_img')['mini']['height'],function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path().'/images/'.$obj->mini);

         return $obj;
    }
}
