<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品详情</title>
</head>
<br>
       <table>
           <tr>
               <td>商品编号</td>
               <td>商品名称</td>
               <td>商品图片</td>
           </tr>
            <tr>
                <td>{{$arr['goods_sn']}}</td>
                <td>{{$arr['goods_name']}}</td>
                <td>
                    <img src="/storage/{{$arr['goods_img']}}" alt="暂无图片" width="50" high="50">
                </td>
            </tr>
       </table>
    @foreach($attr as $k=>$v)
        <button>{{$v['attr_name']}}</button>
        @foreach($v['attr_v'] as $k1=>$v1)
            <button>{{$v1['title']}}</button>
        @endforeach
        <hr>
        @endforeach
</body>
</html>