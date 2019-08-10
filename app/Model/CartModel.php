<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    //
    protected $table="we_cart";
    public $timestamps=false;
    protected $primaryKey="c_id";
}
