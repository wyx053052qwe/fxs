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
            <th>比赛名称</th>
            <th>球队名称</th>
            <th>队徽</th>
            <th>  </th>
            <th>球队名称</th>
            <th>队徽</th>
            <th>开始日期</th>
            <th>开始时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach($data as $d)
        <tr tid="{{$d->t_id}}">
            <td>{{$d->t_id}}</td>
            <td>{{$d->t_name}}</td>
            <td>{{$d->t_qiu1}}</td>
            <td width="100">
                <img src="{{$d->t_img1}}" alt="暂无图片" width="150px">
            </td>
            <td>VS</td>
            <td>{{$d->t_qiu2}}</td>
            <td width="100">
                <img src="{{$d->t_img2}}" alt="暂无图片" width="150px">
            </td>
            <td>{{date('Y-m-d',$d->t_date)}}</td>
            <td>{{date('H:i:s',$d->t_time)}}</td>
            <td class="status">
                @if($d->t_status == 1) 未开始
                @elseif($d->t_status == 2) 已开始
                @elseif($d->t_status == 3) 已结束
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
<div class="layui-fluid" id="edit" style="display: none;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">比赛名称</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required lay-verify="required" placeholder="请输入比赛名称" autocomplete="off" class="layui-input name">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">球队</label>
                <div class="layui-input-inline" style="width: 150px;">
                    <input type="text" name="qiu1"  required lay-verify="required" placeholder="请输入球队名称" autocomplete="off" class="layui-input t_qiu1">
                </div>
                <label class="layui-form-label"></label>
                <div class="layui-form-mid">VS</div>
                <label class="layui-form-label">球队</label>
                <div class="layui-input-inline" style="width: 150px;">
                    <input type="text" name="qiu2"  required lay-verify="required" placeholder="请输入球队名称" autocomplete="off" class="layui-input t_qiu2" >
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
                <input type="hidden" name="tid" class="tid">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开始日期</label>
            <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                <input type="text" name="date" required lay-verify="required" class="layui-input date" id="test1" placeholder="yyy-mm-dd">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开始时间</label>
            <div class="layui-input-inline">
                <input type="text" name="time" required lay-verify="required" placeholder="请输入时间--23:00" id="time" autocomplete="off" class="layui-input time">
            </div>
        </div>
    </form>
</div>
<div  style="display: none;" id="status">
<form class="layui-form" action="">
<div class="layui-form-item">
    <label class="layui-form-label">状态</label>
    <div class="layui-input-block">
        <select name="city" lay-verify="required" class="sta">
            <option value="">请选择</option>
            <option value="1">未开始</option>
            <option value="2">已开始</option>
            <option value="3">已结束</option>
        </select>
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
    layui.use(['form','laydate','upload'],function(){
        var $ = layui.$
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
        $(document).on('click','.del',function(){
            var tid = $(this).parents('tr').attr('tid');
            layer.confirm("确认要删除吗，删除后不能恢复", { title: "删除确认" }, function (index) {
                $.ajax({
                    url:"{{url('admin/del')}}",
                    method:"post",
                    data:{tid:tid},
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
            var tid = $(this).parents('tr').attr('tid');
            $.ajax({
                url:"{{url('admin/edit')}}",
                method:'post',
                data:{tid:tid},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    if(res.code == 2){
                        var data = res.message;
                        console.log(data);
                        $('.tid').val(data.t_id);
                        $('.name').val(data.t_name);
                        $('.t_qiu1').val(data.t_qiu1);
                        $('.t_qiu2').val(data.t_qiu2);
                        $('.qiu1').attr('src',data.t_img1);
                        $('.q1').val(data.t_img1);
                        $('.qiu2').attr('src',data.t_img2);
                        $('.q2').val(data.t_img2);
                        $('.date').val(data.t_date);
                        $('.time').val(data.t_time);
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
                    var name = $('.name').val();
                    var qiu1 = $('.t_qiu1').val();
                    var qiu2 = $('.t_qiu2').val();
                    var img1 = $('.q1').val();
                    var img2 = $('.q2').val();
                    var date = $('.date').val();
                    var time = $('.time').val();
                    var tid = $(".tid").val();
                    var data = {t_name:name,t_qiu1:qiu1,t_qiu2:qiu2,t_img1:img1,t_img2:img2,t_date:date,t_time:time};
                        $.ajax({
                            url: "/admin/update",
                            method: 'post',
                            dataType: 'json',
                            data: {data:data,tid:tid},
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

        $(document).on('click','.status',function(){
            var tid = $(this).parents('tr').attr('tid');
            layer.open({
                type:1,
                area:['500px','400px'],
                title: '状态'
                ,content: $("#status"),
                shade: 0,
                btn: ['提交', '重置']
                ,btn1: function(index, layero){
                    var  status= $(".sta").val();
                  console.log(status);
                    $.ajax({
                        url: "/admin/dostatus",
                        method: 'post',
                        dataType: 'json',
                        data: {status:status,tid:tid},
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
