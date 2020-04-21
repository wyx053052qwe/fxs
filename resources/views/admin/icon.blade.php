

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
            <label class="layui-form-label">多少人获取</label>
            <div class="layui-input-block">
                <input type="text" name="i_us" required  lay-verify="required" placeholder="请输入数字" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">比赛名称和分析师</label>
            <div class="layui-input-block">
                <select name="s_id" lay-verify="required">
                    <option value="">请选择</option>
                    @foreach($data as $d)
                    <option value="{{$d->s_id}}">比赛名称:{{$d->t_name}}   分析师：{{$d->a_username}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="slide_show" class="multiple_show_img" value="">
        <div class="layui-form-item">
            <label class="layui-form-label">头像：</label>
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="multiple_img_upload">多图片上传</button>
                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                    预览：
                    <div class="layui-upload-list" id="div-slide_show"></div>
                </blockquote>
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
        layui.use(['form','upload'], function() {
            var form = layui.form;
            var $ = layui.$
                , upload = layui.upload;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var multiple_images = [];
            //执行实例
            // var uploadInst = upload.render({
            //     elem: '#test1' //绑定元素
            //     ,url: "{{url('admin/uploads')}}" //上传接口
            //     ,multiple:'true'
            //     ,done: function(res){
            //         console.log(res);
            //         if(res.code == 1){
            //             $('.mg').attr('src',res.message);
            //             $('.img').val(res.message);
            //         }
            //         //上传完毕回调
            //     }
            //     ,error: function(){
            //         //请求异常回调
            //     }
            // });
            //文件上传
            //多图片上传
            upload.render({
                elem: '#multiple_img_upload'
                , url: "{{url('admin/uploads')}}"
                , multiple: true
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#div-slide_show').append('<img src="' + result + '" alt="' + file.name
                            + '" title="点击删除" style="width: 100px;height: 100px;" class="layui-upload-img img" οnclick="delMultipleImgs(this)">')
                    });
                }
                , done: function (res) {
                    console.log(res);
                    //如果上传成功
                    if (res.code == 1) {
                        //追加图片成功追加文件名至图片容器
                        multiple_images.push(res.message);
                        $('.multiple_show_img').val(multiple_images);
                    } else {
                        //提示信息
                        layer.msg(res.message);
                    }
                }
            });
            $(document).on('click','.img',function(){
                delMultipleImgs(this)
            });

            //单击图片删除图片 【注册全局函数】
            function delMultipleImgs(this_img) {
                //获取下标
                var subscript = $("#div-slide_show img").index(this_img);
                //删除图片
                this_img.remove();
                //删除数组
                multiple_images.splice(subscript, 1);
                //重新排序
                multiple_images.sort();
                $('.multiple_show_img').val(multiple_images);
                //console.log("multiple_images",multiple_images);
                //返回
                return;
            }

            //监听提交
            form.on('submit(formDemo)', function (data) {
                // layer.msg(JSON.stringify(data.field));
                $.ajax({
                    url: "{{url('admin/doicon')}}",
                    method: 'post',
                    data: data.field,
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 2) {
                            layer.msg(res.message);
                        } else if (res.code == 1) {
                            layer.msg(res.message);
                        } else {
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


