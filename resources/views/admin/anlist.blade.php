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
        <!--        <colgroup>-->
        <!--            <col width="150">-->
        <!--            <col width="200">-->
        <!--            <col>-->
        <!--        </colgroup>-->
        <thead>
        <tr>
            <th>ID</th>
            <th>分析师昵称</th>
            <th>头像</th>
            <th>title1</th>
            <th>title2</th>
            <th>胜率</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach($data as $d)
        <tr aid="{{$d->a_id}}">
            <td>{{$d->a_id}}</td>
            <td>{{$d->a_username}}</td>
            <td>
                <img src="{{$d->a_img}}" alt="暂无图片" width="50px">
            </td>
            <td>{{$d->a_title1}}</td>
            <td>{{$d->a_title2}}</td>
            <td>{{$d->a_sl}}</td>
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
    </table>
</div>


<div class="layui-fluid" id="edit" style="display: none;">
    <form class="layui-form" action="">
        <div style="float: left">
            <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-inline">
                    <input type="text" name="username" required lay-verify="required" class="username" placeholder="请输入昵称" autocomplete="off" class="layui-input">
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
                    <input type="text" name="title1" class="title1" required lay-verify="required" placeholder="14连红" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <input type="hidden" class="aid">
        <div style="float: left">
            <div class="layui-form-item">
                <label class="layui-form-label">title2</label>
                <div class="layui-input-inline">
                    <input type="text" name="title2" class="title2" required lay-verify="required" placeholder="近14红14" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">胜率</label>
                <div class="layui-input-inline">
                    <input type="text" name="sl" class="sl" required lay-verify="required" placeholder="100%" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">粉丝</label>
                <div class="layui-input-inline">
                    <input type="text" name="fensi" class="fensi" required lay-verify="required" placeholder="100%" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">最高连红</label>
                <div class="layui-input-inline">
                    <input type="text" name="zglh" class="zglh" required lay-verify="required" placeholder="100%" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">介绍</label>
                <div class="layui-input-block">
                    <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
                </div>
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
        upload = layui.upload;
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

        $(document).on('click','.del',function(){
            var aid = $(this).parents('tr').attr('aid');
            console.log(aid);
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"{{url('admin/ansdel')}}",
                    method:"post",
                    data:{aid:aid},
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

        $(document).on('click','.edit',function(){
            var aid = $(this).parents('tr').attr('aid');
            $.ajax({
                url:"{{url('admin/ansedit')}}",
                method:'post',
                data:{aid:aid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    if(res.code == 2){
                        var data = res.message;
                        console.log(data);
                        $('.aid').val(data.a_id);
                        $('.username').val(data.a_username);
                        $('.mg').attr('src',data.a_img);
                        $('.img').val(data.a_img);
                        $('.title1').val(data.a_title1);
                        $('.title2').val(data.a_title2);
                        $('.sl').val(data.a_sl);
                        $('.fensi').val(data.fensi);
                        $('.zglh').val(data.zglh);
                        $('.layui-textarea').text(data.a_desc);
                    }else{
                        layer.msg(res.message);
                    }
                }
            });
            layer.open({
                type:1,
                area:['200','100'],
                title: 'xiugai'
                ,content: $("#edit"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var aid = $('.aid').val();
                    var a_username = $('.username').val();
                    var a_img = $('.img').val();
                    var a_title1 = $('.title1').val();
                    var a_title2 = $('.title2').val();
                    var a_sl = $('.sl').val();
                    var fensi= $('.fensi').val();
                    var zglh = $('.zglh').val();
                    var a_desc = $('.layui-textarea').text();
                    var data = {a_username:a_username,a_img:a_img,a_title1:a_title1,a_title2:a_title2,a_sl:a_sl,fensi:fensi,zglh:zglh,a_desc:a_desc};
                    $.ajax({
                        url: "/admin/anupdate",
                        method: 'post',
                        dataType: 'json',
                        data: {data:data,aid:aid},
                        success: function (res) {
                            if (res.code == 2) {
                                layer.msg(res.message);
                                window.location.reload();
                            } else {
                                layer.msg(res.message);
                            }
                        }
                    });
                },
                btn2: function(index, layero){
                    return false;
                },
                cancel: function(layero,index){
                    layer.closeAll();
                }

            });
        });
    });


</script>
</body>
</html>


