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
//测试任务调度
Route::get('/order/test','Order\OrderController@test'); //任务调度测试
//订单支付
Route::get('/ali/ali','Ali\AliController@pay'); //接受订单展示过来的信息
Route::post('/ali/notify','Ali\AliController@notify'); //微信支付异步
Route::get('/ali/aliReturn','Ali\AliController@aliReturn'); //微信支付同步
//测试 商品展示（SKU）
Route::get('/goods/goodslist','Goods\GoodsController@show');
Route::get('/goods/details','Goods\GoodsController@details');  //商品详情
Route::get('/goods/price','Goods\GoodsController@price');     //获得商品价格
//测试
Route::get('/test/test','Test\TestController@test');
Route::get('/test/test2','Test\TestController@test2');
//sku（商品展示）
Route::get('/sku/show','Sku\SkuController@show');//商品详情
Route::get('/sku/details','Sku\SkuController@details');//商品详情
//模拟客户端请求laravel_ks里面的登陆接口
Route::get('/test/log','Test\TestController@log'); //对称加密
Route::get('/test/log2','Test\TestController@log2'); //非对称加密
Route::get('/test/sign','Test\TestController@sign'); //自定义签名
Route::get('/test/TestSign','Test\TestController@TestSign'); //测试自定义签名