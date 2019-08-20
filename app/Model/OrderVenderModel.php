<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderVenderModel extends Model
{
    //
    protected $table="shop_vendor_orders";
    public $timestamps=false;
    protected $primaryKey="v_oid";
}
