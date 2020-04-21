<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="{{asset('/layout/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('/layout/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">

    <link href="{{asset('/layout/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('/layout/css/style.css?v=4.1.0')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">h</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>

        <form class="m-t" role="form" method="post">
            @csrf
            <div class="form-group">
                <input type="email" class="form-control email" placeholder="用户名"  name="name" required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control pwd" placeholder="密码" name="password" required="">
            </div>
            <button type="button" class="btn btn-primary block full-width m-b">登 录</button>
        </form>
    </div>
</div>

<!-- 全局js -->
<script src="{{asset('/layout/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('/layout/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
</body>
<script>

    $('.btn').on('click',function(){
        var user_name=$('.email').val();
        var password=$('.pwd').val();
        $.ajax({
            url: "{{url('login/dologin')}}",
            method:'post',
            data:{email:user_name,password:password},
            dataType:'json',
            success: function(res) {
                if(res.code==2){
                    // console.log(res);
                    alert(res.message);
                    location.href='/admin';
                }else{
                    alert(res.message);
                }
            },

        });
    });

    // //存cookie
    // function setCookie(name, value, iDay)
    // {
    //     var oDate=new Date();
    //     oDate.setDate(oDate.getDate()+iDay);
    //     document.cookie=name+'='+value+';expires='+oDate;
    // };
</script>
</html>
