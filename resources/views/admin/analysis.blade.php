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
            <label class="layui-form-label">分析师</label>
            <div class="layui-input-block">
                <select name="a_id" lay-filter="aid" lay-verify="required">
                    <option value="">请选择分析师</option>
                    @foreach($analysts as $a)
                    <option value="{{$a->a_id}}">{{$a->a_username}}</option>
                  @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">球队</label>
            <div class="layui-input-block">
                <select name="t_id" lay-verify="required">
                    <option value="">请选择球队</option>
                    @foreach($team as $t)
                    <option value="{{$t->t_id}}">{{$t->t_qiu1}}VS{{$t->t_qiu2}} {{$t->t_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分析误差</label>
            <div class="layui-input-block">
                <input type="radio" name="s_status" value="1" title="走">
                <input type="radio" name="s_status" value="2" title="黑">
                <input type="radio" name="s_status" value="3" title="红" checked>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分析结果</label>
            <div class="layui-input-block">
                <textarea name="s_result" placeholder="请输入内容" class="layui-textarea"></textarea>
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
    layui.use(['form'],function() {
        var $ = layui.$
        ,form = layui.form;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        form.on('select(aid)', function(data){
         console.log(data.value);
         $.ajax({

         });
        });
            //监听提交
            form.on('submit(formDemo)', function(data){
                // layer.msg(JSON.stringify(data.field));
                console.log(data.field);
                $.ajax({
                    url:"{{url('/admin/doanalysis')}}",
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
                            layer.msg(res.message);
                        }
                    }
                });

                return false;
            });
    });
</script>
</body>
</html>

