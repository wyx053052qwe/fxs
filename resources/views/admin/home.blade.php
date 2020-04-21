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
    <link id="layuicss-layer" rel="stylesheet" href="https://www.layui.com/admin/std/dist/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all">
</head>
<body>

<div class="layui-fluid">
    <form class="layui-form" action="">
        <div style="float: left">
            <div class="layui-form-item">
                <label class="layui-form-label">比赛名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" required lay-verify="required" placeholder="请输入比赛名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">球队</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" name="qiu1"  required lay-verify="required" placeholder="请输入球队名称" autocomplete="off" class="layui-input">
                    </div>
                    <label class="layui-form-label"></label>
                    <div class="layui-form-mid">VS</div>
                    <label class="layui-form-label">球队</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" name="qiu2"  required lay-verify="required" placeholder="请输入球队名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">队徽</label>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn" id="qiu1">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                        <img src="" alt="暂无图片" class="qiu1" width="50px">
                        <input type="hidden" name="img1" value="" class="q1">
                    </div>
                    <label class="layui-form-label"></label>
                    <div class="layui-form-mid">VS</div>
                    <label class="layui-form-label">队徽</label>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn" id="qiu2">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                        <img src="" alt="暂无图片" class="qiu2"  width="50px">
                        <input type="hidden" name="img2" value="" class="q2">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开始日期</label>
                <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                    <input type="text" name="date" required lay-verify="required" class="layui-input" id="test1" placeholder="yyy-mm-dd">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开始时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="time" required lay-verify="required" placeholder="请输入时间--23:00" id="time" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否设置为精选</label>
                <div class="layui-input-block">
                    <input type="radio" name="jing" value="2" title="是">
                    <input type="radio" name="jing" value="1" title="否" checked>
                </div>
            </div>
        </div>
        <div style="float: left;height:500px;border-left:1px solid #0a0a0a">
            <div class="layui-form-item">
                <label class="layui-form-label">分析师</label>
                <div class="layui-input-block">
                    @foreach($data as $d)
                    <input type="checkbox" name="aid[]" title="{{$d->a_username}}" value="{{$d->a_id}}">
                    @endforeach
                </div>
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
</script>
</body>
</html>
<script>
    //Demo
    layui.use(['form','laydate','upload'], function(){
        var form = layui.form
            ,$ = layui.$
            ,laydate = layui.laydate
            ,upload = layui.upload;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        laydate.render({
            elem: '#test1',
        });
        laydate.render({
            elem: '#time',
            type:'time'//指定元素
        });
        var uploadInst = upload.render({
            elem: '#qiu2' //绑定元素
            ,url: "{{url('admin/upload')}}"
            ,method:'post'
            ,exts:'jpg|png|gif|bmp|jpeg'
            ,accept:'images'//上传接口
            ,done: function(res){
                //上传完毕回调
                console.log(res);
                if(res.code == 1){
                    layer.msg("上传成功");
                    $('.qiu2').attr('src',res.message);
                    $('.q2').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 4){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });
        var uploadInst = upload.render({
            elem: '#qiu1' //绑定元素
            ,url: "{{url('admin/upload')}}"
            ,method:'post'
            ,exts:'jpg|png|gif|bmp|jpeg'
            ,accept:'images'//上传接口
            ,done: function(res){
                //上传完毕回调
                console.log(res);
                if(res.code == 1){
                    layer.msg("上传成功");
                    $('.qiu1').attr('src',res.message);
                    $('.q1').val(res.message);
                }else if(res.code == 2){
                    layer.msg(res.message);
                }else if(res.code == 3){
                    layer.msg(res.message);
                }else if(res.code == 5){
                    layer.msg(res.message);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });
        //监听提交
        form.on('submit(formDemo)', function(data){
            var img1 =  $('.q1').val();
            var img2 =  $('.q2').val();
            if(img1 == ''){
                data.field.img1 = "/upload/null.png";
            }
            if(img2 == ''){
                data.field.img2 = "/upload/null.png";
            }
            $.ajax({
                url:"{{url('admin/dohome')}}",
                method:'post',
                data:data.field,
                dataType:'json',
                success:function(res){
                    console.log(res);
                    if(res.code == 1){
                        layer.msg(res.message);
                    }else if(res.code == 2){
                        layer.msg(res.message);
                        window.reload();
                    }else if(res.code == 3){
                        layer.msg(res.message);
                    }else if(res.code == 4){
                        layer.msg(res.message);
                    }
                }
            });
            return false;
        });
    });
</script>

