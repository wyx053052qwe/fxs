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
</head>
<body>
<div class="layui-fluid">
    <table class="layui-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>分析师</th>
            <th>球队</th>
            <th>分析误差</th>
            <th>分析结果</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
        <tr sid="{{$d->s_id}}">
            <td>{{$d->s_id}}</td>
            <td>{{$d->a_username}}</td>
            <td>{{$d->t_qiu1}}VS{{$d->t_qiu2}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;比赛名称：{{$d->t_name}}</td>
            <td>
                @if($d->s_status == 1)
                走
                @elseif($d->s_status == 2)
                黑
                @elseif($d->s_status == 3)
                红
                @endif
            </td>
            <td>{{$d->s_result}}</td>
            <td>
                <div class="layui-btn-group">
                    <a type="button" class="layui-btn layui-btn-sm" href='{{url("admin/anedit?aid=$d->a_id&tid=$d->t_id")}}'>
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                    <button type="button" class="layui-btn layui-btn-sm del">
                        <i class="layui-icon">&#xe640;</i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6">{{$data->links()}}</td>
        </tr>
        </tbody>
    </table>
</div>

<script src="../../layuiadmin/layui/layui.js?t=1"></script>
<script>
    layui.config({
        base: '../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'console']);
    layui.use(['form','laydate','upload'],function() {
        var $ = layui.$;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click','.del',function(){
            var sid = $(this).parents('tr').attr('sid');
            console.log(sid);
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"{{url('admin/andel')}}",
                    method:"post",
                    data:{sid:sid},
                    dataType:'json',
                    success:function(res){
                        console.log(res);
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

