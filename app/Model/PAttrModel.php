<?php

namespace App\Model;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class PAttrModel extends Model
{
    //
    use ModelTree;
    protected $table="p_goods_attr";
    public $timestamps=false;
    protected $primaryKey="id";
}
