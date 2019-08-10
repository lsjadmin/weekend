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
        <table>
              <tr>
                  <td>ID</td>
                  <td>商品名称</td>
                  <td>商家</td>
                  <td>总价</td>
              </tr>
            @foreach($order as $k=>$v)
            <tr>
                <td>{{$v->son_id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->shop_name}}</td>
                <td>{{$v->price}}</td>
            </tr>
            @endforeach
        </table>
        >>>>>订单号：<span class="a">{{$order_number}}</span></br>
        >>>>点击支付:  <button class="button">请点击</button>
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