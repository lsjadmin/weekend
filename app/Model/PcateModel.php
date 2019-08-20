<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\ModelTree;
class PcateModel extends Model
{
    //
    use ModelTree;
    protected $table="p_category";
    public $timestamps=false;
    protected $primaryKey="cid";
}
