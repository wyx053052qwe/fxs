<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login.login');
});
Route::post('/login/dologin','Login\LoginController@dologin');
Route::get('/login/logout','Login\LoginController@logout');
Route::get('/wxapp/login','Login\LoginController@wxLogin');
Route::get('/wxapp/save','Login\LoginController@save');

Route::prefix('admin')->middleware('checklogin')->group(function(){
    Route::get('','Admin\AdminController@index');
    Route::get('home','Admin\AdminController@home');
    Route::post('upload','Admin\AdminController@upload');
    Route::post('dohome','Admin\AdminController@dohome');
    Route::get('list','Admin\AdminController@list');
    Route::post('del','Admin\AdminController@del');
    Route::post('edit','Admin\AdminController@edit');
    Route::post('update','Admin\AdminController@update');
    Route::get('result','Admin\AdminController@result');
    Route::post('dores','Admin\AdminController@dores');
    Route::post('dostatus','Admin\AdminController@dostatus');
    Route::get('analysts','Admin\AdminController@analysts');
    Route::post('doan','Admin\AdminController@doan');
    Route::get('anlist','Admin\AdminController@anlist');
    Route::post('ansedit','Admin\AdminController@ansedit');
    Route::post('anupdate','Admin\AdminController@anupdate');
    Route::get('analysis','Admin\AdminController@analysis');
    Route::post('doanalysis','Admin\AdminController@doanalysis');
    Route::get('anslist','Admin\AdminController@anslist');
    Route::get('anedit','Admin\AdminController@anedit');
    Route::post('aneditdo','Admin\AdminController@aneditdo');
    Route::post('andel','Admin\AdminController@andel');
    Route::get('shop','Admin\AdminController@shop');
    Route::post('doshop','Admin\AdminController@doshop');
    Route::get('shoplist','Admin\AdminController@shoplist');
    Route::post('shopdel','Admin\AdminController@shopdel');
    Route::get('paylist','Admin\AdminController@paylist');
    Route::get('gonggao','Admin\AdminController@gonggao');
    Route::post('dogong','Admin\AdminController@dogong');
    Route::get('gglist','Admin\AdminController@gglist');
    Route::get('shouye','Admin\AdminController@shouye');
    Route::post('doshou','Admin\AdminController@doshou');
    Route::get('homelist','Admin\AdminController@homelist');
    Route::post('hdel','Admin\AdminController@hdel');
    Route::post('gdel','Admin\AdminController@gdel');
    Route::get('ulist','Admin\AdminController@ulist');
    Route::post('udel','Admin\AdminController@udel');
    Route::post('ansdel','Admin\AdminController@ansdel');
    Route::get('icon','Admin\AdminController@icon');
    Route::post('uploads','Admin\AdminController@uploads');
    Route::post('doicon','Admin\AdminController@doicon');
});
Route::prefix('api')->group(function(){
    Route::post('index','Api\ApiController@index');
    Route::post('home','Api\ApiController@home');
    Route::post('auth','Api\ApiController@user');
    Route::post('analyst','Api\ApiController@analyst');
    Route::post('details','Api\ApiController@details');
    Route::post('fensi','Api\ApiController@fensi');
    Route::post('analysis','Api\ApiController@analysis');
    Route::post('money','Api\ApiController@money');
    Route::post('pay','Api\ApiController@wechatPay');
    Route::post('notify','Api\ApiController@notify');
    Route::post('jie','Api\ApiController@jie');
    Route::post('myding','Api\ApiController@myding');
    Route::post('jian','Api\ApiController@jian');
    Route::post('my','Api\ApiController@my');
    Route::post('userinfo','Api\ApiController@userinfo');
    Route::post('doinfo','Api\ApiController@doinfo');
    Route::post('gg','Api\ApiController@gg');
    Route::post('icon','Api\ApiController@icon');
});

