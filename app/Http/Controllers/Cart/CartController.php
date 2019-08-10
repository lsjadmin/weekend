<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    //所有商品展示
    public function goodsList(){
        $info=GoodsModel::get();
//        dd($info);
        $data=[
            'info'=>$info
        ];

        return view('cart/goodslist',$data);
    }
    //添加购物车
    public function cart(){
        $goods_id=$_GET['goods_id'];
        $num=$_GET['num'];
        //dd($goods_id);
        // 获取当前认证用户的ID...
        $goods_info=GoodsModel::where(['goods_id'=>$goods_id])->first();
        $u_id = Auth::id();
        $info=[
               'u_id'=>$u_id,
               'goods_id'=>$goods_id,
                'goods_num'=>$num,
                's_id'=>$goods_info['s_id']
         ];
        //判断购买相同的商品
        $where=[
            'goods_id'=>$goods_id,
            'u_id'=>$u_id
        ];
        $get=CartModel::where($where)->first();
        $numa=$get['goods_num'];
        //查询出本商品的库存
        $numb=GoodsModel::where(['goods_id'=>$goods_id])->value('goods_num');
        //dd($numb);
        if($get){
            $data=[
                'goods_num'=>$num+$numa
            ];
            $update=CartModel::where($where)->update($data);
            // $num_a=$numb-$num;
            //  $update_a=GoodsModel::where(['goods_id'=>$goods_id])->update(['goods_num'=>$num_a]);
            if($update){
                return 1;
            }else{
                return 2;
            }
        }else{
            $create=CartModel::insert($info);
        // $num_b=$numb-$num;
        //  $update_b=GoodsModel::where(['goods_id'=>$goods_id])->update(['goods_num'=>$num_b]);
            if($create){
                return 1;
            }else{
                return 2;
            }
        }

    }
    //购物车下架
    public function  out(){
        $u_id = Auth::id();
        $get=DB::select("select * from goods join we_cart on goods.goods_id=we_cart.goods_id where u_id=$u_id and goods.status=2");
        if($get){
            return 1;
        }else{
            return 2;
        }
    }
    //购物车展示
    public function CartList(){
        $u_id = Auth::id();
        // dd($info);
        $get=DB::select("select * from goods join we_cart on goods.goods_id=we_cart.goods_id where u_id=$u_id and goods.status=1");
//        dd($get);
        $b=DB::select("select * from goods join we_cart on goods.goods_id=we_cart.goods_id where u_id=$u_id and goods.status=2");

        $data=[
            'arr'=>$get,
            'out'=>$b
        ];
        return view('cart/cartlist',$data);
    }
    //购物车删除
    public function Cartdel(Request $request){
        $c_id=$request->input('c_id');
        //dd($c_id);
        $del=CartModel::where(['c_id'=>$c_id])->delete();
        if($del){
            return 1;
        }else{
            return 2;
        }
    }




}
