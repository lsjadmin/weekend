<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品展示</title>
</head>
<body>
<h2>商品展示</h2>
<table>
    <tr>
        <td>ID</td>
        <td>商品名称</td>
        <td>图片</td>
    </tr>
    @foreach($info as $k=>$v)
        <tr>
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>

                <a href="/sku/details?goods_id={{$v->goods_id}}">
                    <img src="/storage/{{$v->goods_img}}" alt="暂无图片" width="50" high="50">
                </a>

            </td>

        </tr>
    @endforeach
</table>
</body>
</html>