<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WeGoodsModel;
use App\Model\SkuModel;
use Illuminate\Support\Facades\DB;
class TestController extends Controller
{
    //根据goodsid获得sku里面的商品
    public function test(){
        $goods_id=1000001;
        $info=WeGoodsModel::find($goods_id)->getSkuInfo->toArray();
        echo"<pre>";print_r($info);echo "</pre>";
    }
    //逆向
    public function test2(){
        $sku_id=2;
        $info=SkuModel::find($sku_id)->getGoodsInfo->toArray();
        echo"<pre>";print_r($info);echo "</pre>";
    }
    //log test (对称加密)
    public function log(){
        $info=[
            'email'=>'3023668879@qq.com',
            'password'=>111111
        ];
        $str=json_encode($info,JSON_UNESCAPED_UNICODE);
        //对称加密
        $data = $str;//加密明文
        $method = 'AES-256-CBC';//加密方法
        $key = '123';//加密密钥
        $options = OPENSSL_RAW_DATA;//数据格式选项（可选）
        $iv='aassddffgghhjjkl';
        $result = openssl_encrypt($data, $method, $key, $options,$iv);
        $b64=base64_encode($result);

         //echo '原文:'.$b64;echo "<hr>";die;

        $url="http://1809a.ks.com/api/log";
        //初始化curl
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST,1);
        //把数据传输过去
        curl_setopt($ch,CURLOPT_POSTFIELDS,$b64);
        //执行会话
        $res=curl_exec($ch);
        echo $res;
        //结束一个会话
        curl_close($ch);



    }
    //log test (非对称加密)
    public function log2(){
        $info=[
            'email'=>'3023668879@qq.com',
            'password'=>111111
        ];
        $str=json_encode($info,JSON_UNESCAPED_UNICODE);
        //非对称加密
         //获取私钥
        // echo storage_path('app/keys/private.pem');die;
        $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem')); //获取私钥
        openssl_private_encrypt($str,$enc_date,$k);//使用私钥加密数据

        $url="http://1809a.ks.com/api/log2";
        //初始化curl
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST,1);
        //把数据传输过去
        curl_setopt($ch,CURLOPT_POSTFIELDS,$enc_date);
        //执行会话
        $res=curl_exec($ch);
        echo $res;
        //结束一个会话
        curl_close($ch);

    }
    //log test (自定义签名)
    public function sign(){
        $info=[
            'email'=>'3023668879@qq.com',
            'password'=>111111,
        ];
        $key=222222;
        ksort($info);
        $str='';
        foreach($info as $k=>$v){    //key=value形式
            $str.=$k.'='.$v.'&';
        }
        $str=rtrim($str,'&');
        $sign=$str.$key;
        $sign=strtoupper(md5($sign));    //MD5加密后全部转换大写
        return $sign;

    }
    //测试签名
    public function TestSign(){
        $sign=$this->sign();
        $url="http://1809a.ks.com/api/sign";
        //初始化curl
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
         //curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST,1);
        //把数据传输过去
        curl_setopt($ch,CURLOPT_POSTFIELDS,$sign);
        //执行会话
        curl_exec($ch);

        //结束一个会话
        curl_close($ch);
        //验证签名

        
    }
}
