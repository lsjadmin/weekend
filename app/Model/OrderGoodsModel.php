<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGoodsModel extends Model
{
    //
    protected $table="shop_order_goods";
    public $timestamps=false;
    protected $primaryKey="id";
}
