<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 控制台主页一</title>
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../../layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<script>
</script>
<div class="layui-fluid">
    <table class="layui-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>订单号</th>
            <th>比赛名称</th>
            <th>用户昵称</th>
            <th>用户头像</th>
            <th>付款金额</th>
            <th>支付状态</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach($data as $d)
        <tr pid="{{$d->p_id}}">
            <td>{{$d->p_id}}</td>
            <td>{{$d->out_trade_no}}</td>
            <td>{{$d->t_name}}</td>
            <td>{{$d->nickName}}</td>
            <td>
                <img src="{{$d->avatarUrl}}" alt="">
            </td>
            <td>
                @if(empty($d->money))
                88
                @else
                {{$d->money}}
                @endif
            </td>
            <td>
                @if($d->status == 1)
                未支付
                @elseif($d->status == 2)
                支付
                @endif
            </td>
            <td>
                <div class="layui-btn-group">
                    <button type="button" class="layui-btn layui-btn-sm edit">
                        <i class="layui-icon">&#xe642;</i>
                    </button>
                    <button type="button" class="layui-btn layui-btn-sm del">
                        <i class="layui-icon">&#xe640;</i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="10">{{$data->links()}}</td>
        </tr>
    </table>
    <script>
    </script>
</div>

<script src="../../layuiadmin/layui/layui.js?t=1"></script>
<script>
    layui.config({
        base: '../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'console']);
    layui.use(['form','laydate','upload'],function(){
        var $ = layui.$
            ,laydate = layui.laydate
            ,upload = layui.upload;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','.del',function(){
            var sid = $(this).parents('tr').attr('sid');
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"{{url('admin/shopdel')}}",
                    method:"post",
                    data:{sid:sid},
                    dataType:'json',
                    success:function(res){
                        if(res.code == 2){
                            layer.msg(res.message);
                            window.location.reload();
                        }else{
                            layer.msg(res.message);
                        }
                    }
                });
            });
        })
    });
</script>
</body>
</html>
