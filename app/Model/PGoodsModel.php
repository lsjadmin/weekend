<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PGoodsModel extends Model
{
    //
    protected $table="p_goods";
    public $timestamps=false;
    protected $primaryKey="goods_id";
}
