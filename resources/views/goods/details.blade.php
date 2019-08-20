<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .h2{
        color:red;
    }
    .h3{
        color:black;
    }
</style>
<br>
        <h2>商品详情</h2>
    <table>
        <tr>
            <td>商品名称</td>
            <td>商品图片</td>
            <td>商品描述</td>
        </tr>

        <tr>
            <td>{{$arr['goods_name']}}</td>
{{--            <td>--}}
{{--                <img src="/storage/{{$goods['goods_img']}}" alt="暂无图片" width="50" high="50">--}}
{{--            </td>--}}
{{--            <td>{{$goods['short_desc']}}</td>--}}
        </tr>
        @foreach($color as $k=>$v)
        <tr>
            <td>
                <button class="colour">{{$v}}</button>
            </td>
        </tr>
            @endforeach
        @foreach($type as $k=>$v)
           <button class="type">{{$v}}</button>
        @endforeach
    </table>
    <input type="hidden" value="" class="a">
    <input type="hidden" value="" class="b">
    >>>>>商品价格：<span></span></br>
    >>>>>加入购物车: <button>点击加入购物车</button>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>

    $(function(){
        //点击颜色
        $(document).on('click','.colour',function(){
            var _this=$(this);
            var colour=_this.html();
            _this.addClass("h2");
             _this.parents("tr").siblings('tr').find("button").removeClass("h2");
             $(".a").val(colour);
            var type=$(".b").val();
            if(type!=='' && colour!==''){
                $.get(
                    "/goods/price",
                    {colour:colour,type:type},
                    function(res){
                        var arr=JSON.parse(res);
                        if(arr.code==1){
                            $('span').html(arr.price);
                        }else{
                            alert('该商品以卖完');
                        }
                    }
                )
            }
        })
        //点击类型
        $(document).on('click','.type',function(){
                var colour=$(".a").val();
                if(colour==''){
                    alert('请先选择颜色');
                    return false;
                }
                var _this=$(this);
                var type=_this.html();
                _this.addClass("h2");
                _this.siblings('button').removeClass("h2");
                $(".b").val(type);
                $.get(
                    "/goods/price",
                    {colour:colour,type:type},
                    function(res){
                        var arr=JSON.parse(res);
                        if(arr.code==1){
                            $('span').html(arr.price);
                        }else{
                            alert('该商品以卖完');
                        }
                    }
                )
            })
    })

</script>