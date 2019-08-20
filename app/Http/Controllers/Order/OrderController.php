<?php

namespace App\Http\Controllers\Order;

use App\Model\CartModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Model\GoodsModel;
use App\Model\OrderModel;
use App\Model\OrderGoodsModel;
use App\Model\OrderVenderModel;

use Illuminate\Support\Facades\Redis;
class OrderController extends Controller
{
    //提交订单
    public function Order(Request $request){
        $c_id=$request->input('c_id');
        $count_price=$request->input('price'); //总价
        $u_id = Auth::id();             //用户id
        $arr_cid=explode(',',$c_id);
        $order_sn=OrderModel::OrderSn();  //总订单号
        $vender_order=[];
        $arr_goods_price=[];
        //总订单
        $order=[
            'order_sn'=>$order_sn,
            'created_at'=>time(),
            'total'=>$count_price
        ];



        foreach($arr_cid as $k=>$v){     //根据键生成个订单
            $cart_info=DB::table('we_cart')->where(['c_id'=>$v])->first();
            $vender_order[$cart_info->s_id][]=$cart_info;
        }


        // 事务开始
        DB::beginTransaction();
        try {
            //添加总订单
            OrderModel::insert($order);
            //添加子订单
            //分订单
            foreach ($vender_order as $k1 => $v1) {
                $v_total = 0;
                $v_order_sn = OrderModel::VenderOrderSn();   //分单号
                //计算分单商品价格
                foreach ($v1 as $k2 => $v2) {
                    $goods_info=DB::table('goods')->where(['goods_id'=>$v2->goods_id])->first();
                    $v_total += $goods_info->goods_price * $v2->goods_num;
                    //记录订单商品
                    $order_goods = [
                        'goods_id'  => $v2->goods_id,
                        'sku'       => 1,
                        'order_sn'  => $order_sn,
                        'v_order_sn'    => $v_order_sn,
                        'price'     => $goods_info->goods_price
                    ];
                    OrderGoodsModel::insert($order_goods);
                }
                $v_o = [
                    'order_sn'  => $order_sn,
                    'v_order_sn'  => $v_order_sn,
                    'amount'    => $v_total,
                    'c_id' => $k1,

                ];
                //记录分单
                OrderVenderModel::insert($v_o);
                // 事务 结束
                DB::commit();

            }
        }catch  (\Exception $e){
            DB::rollBack();     //回滚
            echo $e->getMessage();
            // TODO 记录异常信息 blabla
        }


}


    //订单展示
    public function orderList(){
        $u_id = Auth::id(); //用户id
        $key='order_id';
        $o_id=Redis::get($key); //获得订单id
        $order_number=OrderModel::where(['o_id'=>$o_id])->value('order_number');
        $orderdetail=DB::select("select * from (goods left join we_shop on we_shop.s_id=goods.s_id) left join we_order_detail on we_order_detail.goods_id=goods.goods_id where u_id=$u_id and o_id=$o_id");
        $arr=[];
        foreach($orderdetail as $k=>$v){
            $arr[$v->shop_name][]=$v;
        }
//        echo "<pre>";print_r($arr);echo "</pre>";die;
        return view('order/orderlist',['arr'=>$arr,'order_number'=>$order_number]);

    }
    //任务调度测试
    public function test(){

        //
        $u_id = Auth::id(); //用户id
        $key='order_id';
        $o_id=Redis::get($key); //获得o_id
        $where=[
            'u_id'=>$u_id,
            'o_id'=>$o_id,
            'is_status'=>2
        ];
        $first=DB::table('we_order')->where($where)->first();
        if(!isset($first)){
            echo "11";
            $time=date('Y-m-d, H:i:s');
            $str=$time."没有该订单"."\n";
            file_put_contents('/wwwroot/weekend/public/log/a.log',$str,FILE_APPEND);
        }else{
            echo "22";
            $time=time();
            $add_time=$first->add_time;
            if(($time-$add_time)>=60*2){
                echo "33";die;
                DB::beginTransaction(); //开启事务
                $del=DB::table('we_order')->where(['o_id'=>$o_id])->delete(); //删除超时未支付的订单
                //删除对应的子表
                $dela=DB::table('we_order_son')->where(['o_id'=>$o_id,'u_id'=>$u_id])->delete();
                if( $del &&  $dela){
                    DB::commit();  //提交
                    $time=time();
                    $str=$time."未支付的订单已经删除"."\n";
                    file_put_contents('/wwwroot/weekend/public/log/a.log',$str,FILE_APPEND);
                }else{
                    DB::rollback();  //回滚
                    $time=time();
                    $str=$time."错误的订单信息"."\n";
                    file_put_contents('/wwwroot/weekend/public/log/a.log',$str,FILE_APPEND);
                }
            }

        }


    }
}
