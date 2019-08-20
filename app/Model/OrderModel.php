<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    //
    protected $table="shop_orders";
    public $timestamps=false;
    protected $primaryKey="oid";

    /*
     * 生成订单号
     * string
     */
    public static function OrderSn(){
        return 'O' . date('ymdH') . rand(11111,99999) . rand(2222,9999);
    }

    /*
     * 生成子订单号
     * string
     */
    public static function VenderOrderSn(){
        return 'V' . date('ymdH') . rand(11111,99999) . rand(2222,9999);
    }
}
