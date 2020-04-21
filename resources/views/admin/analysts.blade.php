

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 控制台主页一</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../../layuiadmin/style/admin.css" media="all">
</head>
<body>

<div class="layui-fluid">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-inline">
                <input type="text" name="username" required lay-verify="required" placeholder="请输入昵称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-block">
                <div style="height: 100px;width: 100px;border: 1px solid #000;">
                    <img src="" alt="暂无图片" class="mg" width="100px">
                    <input type="hidden" name="img" class="img">
                </div>
                <button type="button" class="layui-btn" id="test1" style="margin-top: 10px;">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">title1</label>
            <div class="layui-input-inline">
                <input type="text" name="title1" required lay-verify="required" placeholder="14连红" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">title2</label>
            <div class="layui-input-inline">
                <input type="text" name="title2" required lay-verify="required" placeholder="近14红14" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">胜率</label>
            <div class="layui-input-inline">
                <input type="text" name="sl" required lay-verify="required" placeholder="100%" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">粉丝</label>
            <div class="layui-input-inline">
                <input type="text" name="fensi" required lay-verify="required" placeholder="100%" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">最高连红</label>
            <div class="layui-input-inline">
                <input type="text" name="zglh" required lay-verify="required" placeholder="100%" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">介绍</label>
            <div class="layui-input-block">
                <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
    <script src="../../layuiadmin/layui/layui.js?t=1"></script>
    <script>
        //Demo
        layui.config({
            base: '../../layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'console']);
        layui.use(['form','upload'], function(){
            var form = layui.form;
            var $ = layui.$
                ,upload = layui.upload;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //执行实例
            var uploadInst = upload.render({
                elem: '#test1' //绑定元素
                ,url: "{{url('admin/upload')}}" //上传接口
                ,done: function(res){
                    console.log(res);
                    if(res.code == 1){
                        $('.mg').attr('src',res.message);
                        $('.img').val(res.message);
                    }
                    //上传完毕回调
                }
                ,error: function(){
                    //请求异常回调
                }
            });
            //监听提交
            form.on('submit(formDemo)', function(data){
                // layer.msg(JSON.stringify(data.field));
                $.ajax({
                    url:"{{url('admin/doan')}}",
                    method:'post',
                    data:data.field,
                    dataType:'json',
                    success:function(res){
                        console.log(res);
                        if(res.code == 2){
                            layer.msg(res.message);
                        }else if(res.code == 1){
                            layer.msg(res.message);
                        }else{
                            layer.msg(res.message);
                        }
                    }
                });
                return false;
            });
        });
    </script>
</div>
</body>
</html>


