<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>购物车展示</title>
</head>
<h2>购物车展示</h2>

        <table>
            <tr>
                <td>请选择</td>
                <td>购物车ID</td>
                <td>商品名称</td>
                <td>商品价格</td>
                <td>商品总价</td>
                <td>操作</td>
            </tr>

            @foreach($arr as $k=>$v)
            <tr>
                <td><input type="checkbox" c_id="{{$v->c_id}}"  price ="{{$v->goods_num * $v->goods_price}}" class="a"></td>
                <td>{{$v->c_id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->goods_price}}</td>
                <td>{{$v->goods_num * $v->goods_price}}</td>
                <td><button class="del" c_id="{{$v->c_id}}">点击删除</button></td>
            </tr>
            @endforeach
        </table>
        >>>>>>>>><button class="close"> 生成订单</button></br>
    >>>>>>>>所选择商品的总价格：<span class="num">0</span>


    <table class="show">
        <tr>
            <td>该商品已经下架</td>
            <td>购物车ID</td>
            <td>商品名称</td>
            <td>商品价格</td>
        </tr>
        @foreach($out as $k=>$v)
            <tr>
                <td >{{$v->c_id}}</td>
                <td class="aa">{{$v->goods_name}}</td>
                <td>{{$v->goods_price}}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        $.get(
            "/cart/out",
            function(res){
               if(res==2){
                   $(".show").remove();
               }
            }
        )
        //获得总价格
        $(document).on('click','.a',function(){
            var count=parseInt($(".num").html());
            console.log(count);
            var price='';
            $(this).each(function(index){
                if($(this).prop("checked")==true){
                    price+=parseInt($(this).attr('price'))+parseInt(count);
                    $(".num").html(price)
                }else{
                    price+=parseInt(count)-parseInt($(this).attr('price'));
                    $(".num").html(price)
                }
            })
        })
        //删除
        $(document).on('click','.del',function(){
            var _this=$(this);
            var c_id=$(this).attr('c_id');
            //console.log(c_id);
            $.get(
                "/cart/del",
                {c_id:c_id},
                function(res){
                    // console.log(res);
                    if(res==1){
                        alert('已将此商品移除购物车');
                    }
                }
            )

        })
        //点击结算
        $(document).on('click','.close',function(){
            var box=$(this).prev('table').find("input[class='a']");
            var price=$(".num").html();
            var id='';
            box.each(function(index){
                if($(this).prop("checked")==true){
                    id+=$(this).attr('c_id')+',';
                }
            })
            var id=id.substr(0,id.length-1);
            console.log(id);


            $.get(
                "/order/create",
                {c_id:id,price:price},
                function(res){
                    console.log(res);
                }
            )


        })

    })
</script>