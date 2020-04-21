<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>分析师后台</title>
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
    <script src="../layuiadmin/layui/layui.js"></script>
    <script>
        /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
    </script>
    <script>
        layui.use('form', function() {
            var form = layui.form
                , $ = layui.$;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
</head>
<body class="layui-layout-body" layadmin-themealias="default">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect="">
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>

                <li class="layui-nav-item" lay-unselect="">
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <span class="layui-nav-bar" style="left: 198px; top: 48px; width: 0px; opacity: 0;"></span></ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                <li data-name="component" class="layui-nav-item">
                    <a href="/login/logout">
                        <i class="layui-icon layui-icon-component"></i>
                        <cite>退出</cite>
                        <span class="layui-nav-more"></span></a>
                </li>
                <span class="layui-nav-bar"></span>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="home/console.html">
                    <span>layuiAdmin</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    <li data-name="home" class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;" lay-tips="主页" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>比赛管理</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="console">
                                <a layadmin-event="layadmin-event" lay-href="/admin/home">添加比赛</a>
                            </dd>
                            <dd data-name="console">
                                <a layadmin-event="layadmin-event" lay-href="/admin/list">比赛列表</a>
                            </dd>
                            <dd data-name="console">
                                <a layadmin-event="layadmin-event" lay-href="/admin/result">比赛结果</a>
                            </dd>
                        </dl>
                    </li>
                    <li data-name="component" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="组件" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>分析师管理</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="nav">
                                <a layadmin-event="layadmin-event" lay-href="/admin/analysts">添加分析师</a>
                            </dd>
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/anlist">分析师列表</a>
                            </dd>
                    </li>
                    <li data-name="component" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="组件" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>临场分析</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="nav">
                                <a layadmin-event="layadmin-event" lay-href="/admin/analysis">分析结果</a>
                            </dd>
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/anslist">分析师结果列表</a>
                            </dd>
                    </li>
                    <li data-name="component" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="组件" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>支付管理</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="nav">
                                <a layadmin-event="layadmin-event" lay-href="/admin/shop">添加商品</a>
                            </dd>
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/shoplist">商品列表</a>
                            </dd>
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/paylist">订单列表</a>
                            </dd>
                    </li>
                    <li data-name="component" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="组件" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>公告管理</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="nav">
                                <a layadmin-event="layadmin-event" lay-href="/admin/gonggao">添加我的公告</a>
                            </dd>
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/gglist">我的公告列表</a>
                            </dd>
                            <dd data-name="nav">
                                <a layadmin-event="layadmin-event" lay-href="/admin/shouye">添加首页公告</a>
                            </dd>
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/homelist">首页公告列表</a>
                            </dd>
                    </li>
                    <li data-name="component" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="组件" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>用户管理</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/ulist">用户列表</a>
                            </dd>
                    </li>
                    <li data-name="component" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="组件" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>头像管理</cite>
                            <span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd data-name="tabs">
                                <a layadmin-event="layadmin-event" lay-href="/admin/icon">头像添加</a>
                            </dd>
                    </li>
                    <span class="layui-nav-bar" style="top: 28px; height: 0px; opacity: 0;"></span></ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect="">
                        <a href="javascript:;"><span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                    <span class="layui-nav-bar"></span></ul>
            </div>
            <div class="layui-tab" lay-unauto="" lay-allowclose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i><i class="layui-icon layui-unselect layui-tab-close">ဆ</i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="home/console.html" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>
<script>
    layui.config({
        base: '../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');
    layui.use('form');
</script>
<script>
    layui.use('form',function(){
        var $  =layui.$;
        $('li').click(function(){
            $('.layui-this').children('a').attr("layadmin-event","refresh");
            $('.layui-this').attr("layadmin-event","refresh");
        });
    });
</script>

<!-- 百度统计 -->
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?d214947968792b839fd669a4decaaffc";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<style id="LAY_layadmin_theme">.layui-side-menu,.layadmin-pagetabs .layui-tab-title li:after,.layadmin-pagetabs .layui-tab-title li.layui-this:after,.layui-layer-admin .layui-layer-title,.layadmin-side-shrink .layui-side-menu .layui-nav>.layui-nav-item>.layui-nav-child{background-color:#20222A !important;}.layui-nav-tree .layui-this,.layui-nav-tree .layui-this>a,.layui-nav-tree .layui-nav-child dd.layui-this,.layui-nav-tree .layui-nav-child dd.layui-this a{background-color:#009688 !important;}.layui-layout-admin .layui-logo{background-color:#20222A !important;}</style></body>
</html>





