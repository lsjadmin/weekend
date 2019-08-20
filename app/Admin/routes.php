<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('goods', GoodsController::class);  //商品管理
    $router->resource('cate', CateValueController::class);  //分类管理
    $router->resource('attr', AttrController::class);  //属性管理
    $router->resource('attrvalue', AttrValueController::class);  //属性值管理
    $router->resource('sku', SkuController::class);  //SKU管理

    $router->get('/sku-detail/{goods_id}', 'SkuController@skuDetail');
    $router->post('/sku-detail-update', 'SkuController@skuUpdate');

});
