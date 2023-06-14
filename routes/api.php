<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {

    Route::get('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});



Route::get('/', 'IndexController@index')->name('index'); // для вывода слайдера
Route::get('left', 'categoryMenuController@index')->name('left');
Route::get('category/{id}', 'CategoryController@index')->name('category');
Route::post('sociallogin/{provider}', 'Auth\AuthController@SocialSignup');
Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');
Route::post('cart', 'CartController@index');
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('cabinet','CabinetController@index');
Route::get('cabinet/{id}','CabinetController@index');

Route::post('productSearch', 'SearchController@index');


Route::get('categoriesAdmin','Admin\CategoryController@index');
Route::get('productsAdmin','Admin\ProductController@index');
Route::post('categoryAdd','Admin\CategoryAddController@index');
Route::get('categoryEdit/{id}','Admin\CategoryEditController@index');
Route::post('categoryEdit/{id}','Admin\CategoryEditController@index');

//Route::get('productAdd','Admin\ProductAddController@index');
//Route::post('productAdd','Admin\ProductAddController@index');

Route::match(['get','post'],'productAdd','Admin\ProductAddController@index');

Route::get('productEdit/{id}', 'Admin\ProductEditController@index');
Route::post('productEdit/{id}', 'Admin\ProductEditController@index');


// Заказы товаров

Route::get('orderListAdmin', 'Admin\OrderController@index');

Route::match(['get','post'],'orderEdit/{id}','Admin\OrderEditController@index');

Route::get('chart', 'Admin\OrderController@chart');


//});
