<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>商品展示</h2>
<table>
    <tr>
        <td>商品ID</td>
        <td>商品名称</td>
        <td>商品价格</td>
        <td>库存</td>
        <td>选择购买数量</td>
        <td>加入购物车</td>
    </tr>
    @foreach($info as $k=>$v)

        <tr>
            <td class="id">{{$v->goods_id}}</td>
            <td class="name">{{$v->goods_name}}</td>
            <td class="price">{{$v->goods_price}}</td>
            <td >{{$v->goods_num}}</td>
            <td>
                <input type="button" value="+" class="plus" num="{{$v->goods_num}}">
                <input type="text" value="0" class ="numa" num="{{$v->goods_num}}">
                <input type="button" value="-" class="min">
            </td>
            <td><button class="button" goods_id="{{$v->goods_id}}">点击加入购物车</button></td>
        </tr>
    @endforeach
</table>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        //加号
        $(document).on('click','.plus',function(){
            var _this=$(this);
            var goods_num=_this.attr('num');   //库存
            // console.log(goods_num);
            var numa=parseInt(_this.next("input").val());
            numa++;
            if(numa>=goods_num){
                _this.prop("disabled", true);
            }else{
                _this.next("input").val(numa);
            }
        })
        //减号
        $(document).on('click','.min',function(){
            var _this=$(this);
            var goods_num=_this.attr('num');   //库存
            // console.log(goods_num);
            var numa=parseInt(_this.prev("input").val());
            if(numa==0){
                _this.prop("disabled", true);
            }else{
                numa--;
                _this.prev("input").val(numa);
            }
        })
        //失去焦点
        $(document).on('blur','.numa',function(){
            var _this=$(this);
            var num=parseInt(_this.val());
            console.log(num);
            var goods_num=parseInt(_this.attr('num'));   //库存
            console.log(goods_num);
           if(num>=goods_num){
                _this.val(goods_num);
                alert("超过了库存");
            }
        })
        //提交
        $(document).on("click",".button",function(){
            // alert('aa');
            var id=$(this).attr('goods_id');
            var numc=$(this).parents('tr').find("input[class='numa']").val();
            //console.log(numc);
            $.get(
                   "/cart/create?goods_id="+id+'&num='+numc,
                  function(res){
                       console.log(res);
                      if(res==1){
                          alert('添加购物车成功');
                      }
                  }
            )
        })

    })

</script>
