<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    //
    protected $table="we_order";
    public $timestamps=false;
    protected $primaryKey="o_id";

}
