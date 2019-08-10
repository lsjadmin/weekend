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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//商品展示
Route::get('/goods/list','Cart\CartController@goodsList');
Route::get('/cart/create','Cart\CartController@cart');  //添加购物车
Route::get('/cart/list','Cart\CartController@CartList');  //购物车展示
Route::get('/cart/del','Cart\CartController@Cartdel');  //购物车展示
Route::get('/cart/out','Cart\CartController@out');  //购物车展示
//订单
Route::get('/order/create','Order\OrderController@Order'); //添加订单
Route::get('/order/list','Order\OrderController@orderList'); //添加展示

//订单支付
Route::get('/ali/ali','Ali\AliControler@pay'); //接受订单展示过来的信息
Route::post('/ali/notify','Ali\AliControler@notify'); //微信支付异步
Route::get('/ali/aliReturn','Ali\AliControler@aliReturn'); //微信支付同步