<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Model\GoodsModel;
use App\Model\OrderModel;
use App\Model\OrderSonModel;
use Illuminate\Support\Facades\Redis;
class OrderController extends Controller
{
    //提交订单
    public function Order(Request $request){
        $c_id=$request->input('c_id');
        $count_price=$request->input('price');
        $u_id = Auth::id(); //用户id
        //dd($c_id);
        DB::beginTransaction(); //开启事务
        //添加到订单主表
            $data=[
                'order_number'=>$this->OrderNumBer(),
                'u_id'=>$u_id,
                'add_time'=>time(),
                'price'=>$count_price
            ];
         $o_id= DB::table('we_order')->insertGetId($data);
        $key='order_id';
        Redis::set($key,$o_id);
        //添加到订单子表
        $arr=explode(',',$c_id);

        foreach($arr as $k=>$v){
            $cart_info=DB::table('we_cart')->where(['c_id'=>$v])->first();
            $goods_info=DB::table('goods')->where(['goods_id'=>$cart_info->goods_id])->first();
            $array=[
                's_id'=>$cart_info->s_id,
                'u_id'=>$u_id,
                'goods_id'=>$cart_info->goods_id,
                'o_id'=>$o_id,
                'add_time'=>time(),
                'price'=>$goods_info->goods_price * $cart_info->goods_num
            ];
            $create=DB::table('we_order_son')->insert($array);
        }

        //判断两条SQL都成功就提交
        if( $o_id &&  $create){
            DB::commit();  //提交
            return 1;
        }else{
            DB::rollback();  //回滚
            return 0;
        }
    }
    //生成订单号
    function OrderNumBer(){
        $time=time();
        $str=Str::random(10);
        $orderNum=substr(md5($time.$str),0,10);
        return $orderNum;
    }
    //订单展示
    public function orderList(){
        $u_id = Auth::id(); //用户id
        $key='order_id';
        $o_id=Redis::get($key); //获得订单id
        $order_number=OrderModel::where(['o_id'=>$o_id])->value('order_number');
        $orderSon=DB::select("select * from (goods left join we_shop on we_shop.s_id=goods.s_id) left join we_order_son on we_order_son.goods_id=goods.goods_id where u_id=$u_id and status=1 and o_id=$o_id");


        return view('order/orderlist',['order'=>$orderSon,'order_number'=>$order_number]);

    }
}
