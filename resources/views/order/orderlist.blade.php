<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<br>
        <h2>订单展示</h2>
        <table>>

            @foreach($arr as $k=>$v)

              <p>商家名称：{{$k}}</p>

                @foreach($v as $k1=>$v1)
                    <p>商品名称：{{$v1->goods_name}}</p>
                    <p>商品价格：{{$v1->goods_price}}</p>
                @endforeach

            @endforeach
        </table>
        >>>>>订单号：<span class="a">{{$order_number}}</span></br>
        >>>>点击支付: <a href="http://weekend.lianshijiea.com/ali/ali?order={{$order_number}}">点击支付</a>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        $(document).on('click','.button',function(){
                var _this=$(this);
                var order_number=$('.a').html();
                $.get(
                    "/ali/ali?order="+order_number,
                    function(res){
                        console.log(res);
                    }
                )
        })
    })
</script>