<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WeGoodsModel;
use App\Model\AttraModel;
use App\Model\SkuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    //商品展示
    public function show(){
        $where=[
            'status'=>1,
            'is_delete'=>1
        ];
    //  $info=DB::select("select * from we_goods join we_sku on we_goods.goods_id=we_sku.goods_id ");
        $info=WeGoodsModel::where($where)->get();

        return view('goods/show',['info'=>$info]);
    }
    //商品详情
    public function details(){
        $goods_id=$_GET['goods_id'];
        $goods=WeGoodsModel::where(['goods_id'=>$goods_id])->first();
        $attr=AttraModel::where(['goods_id'=>$goods_id])->get();
        $color=[];
        foreach($attr as $k=>$v){
                $color[]=$v->colour1;
        }
        $color=array_filter($color);

        $type=[];
        foreach($attr as $k=>$v){
            $type[]=$v->type1;
        }
        $type=array_filter($type);
//        echo "<pre>";print_r($attr);echo"</pre>";die;
        return view('goods/details',['goods'=>$goods,'color'=>$color],['type'=>$type]);
    }
    //价格
    public function price(Request $request){
        $colour=$request->input('colour');
        $type=$request->input('type');
        $where=[
            'sku'=>$colour.$type
        ];
        $price=SkuModel::where($where)->value('price');
        if($price){
           $arr=[
               'code'=>1,
               'price'=>$price,
               'mes'=>'欢迎购买该型号'
           ];
           return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }else{
            $arr=[
                'code'=>2,
                'mes'=>'该型号已经售完'
            ];
            return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
    }
}
