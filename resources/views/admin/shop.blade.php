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
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">选择球队</label>
            <div class="layui-input-block">
                <select name="t_id" lay-verify="required">
                    <option value="">请选择球队</option>
                    @foreach($team as $t)
                    <option value="{{$t->t_id}}">比赛名称：{{$t->t_name}}&nbsp;&nbsp;&nbsp;&nbsp;球队：{{$t->t_qiu1}}VS{{$t->t_qiu2}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">输入金额</label>
            <div class="layui-input-block">
                <input type="text" name="s_money" required  lay-verify="required" placeholder="请输入金额" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script src="../../layuiadmin/layui/layui.js?t=1"></script>
<script>
    layui.config({
        base: '../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'console']);
    layui.use(['form','laydate','upload'],function() {
        var $ = layui.$
            ,form = layui.form;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        form.on('submit(formDemo)', function(data){
            // layer.msg(JSON.stringify(data.field));
            $.ajax({
                url:"{{url('admin/doshop')}}",
                method:'post',
                data:data.field,
                dataType:'json',
                success:function(res){
                    console.log(res);
                    if(res.code == 2){
                        layer.msg(res.message);
                    }else if(res.code == 1){
                        layer.msg(res.message);
                    }else if(res.code == 3){
                        layer.msg(res.message)
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>


