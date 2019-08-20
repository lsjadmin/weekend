<?php

namespace App\Http\Controllers\Sku;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PGoodsModel;
use App\Model\PAttrModel;
use App\Model\PAttrValueModel;
class SkuController extends Controller
{
    //商品展示
    //商品展示
    public function show(){
        $where=[
            'is_onsale'=>1,
            'is_delete'=>1
        ];
        //  $info=DB::select("select * from we_goods join we_sku on we_goods.goods_id=we_sku.goods_id ");
        $info=PGoodsModel::where($where)->get();

        return view('sku/show',['info'=>$info]);
    }
    //详情
    public function details(){
        $goods_id=$_GET['goods_id'];
        $get=PGoodsModel::where(['goods_id'=>$goods_id])->first();
        $attr=explode(',',$get['attr']);
        foreach($attr as $k=>$v){
            $attr_info = PAttrModel::select('id','title')->find($v)->toArray();
            $arr[$attr_info['id']]['attr_name']=$attr_info['title'];
            $arr[$attr_info['id']]['attr_v'] = PAttrValueModel::select('id','title')->where(['attr_id'=>$v])->get()->toArray();
        }
      echo '<pre>';print_r($arr);echo '</pre>';

        return view('sku/detail',['arr'=>$get,'attr'=>$arr]);
    }
}
