<?php

namespace App\Http\Controllers\Api;

use App\Model\Analysi;
use App\Model\Analysts;
use App\Model\Dingyue;
use App\Model\Gg;
use App\Model\Home;
use App\Model\Icon;
use App\Model\Shop;
use App\Model\Team;
use App\Model\User;
use App\Model\UserInfo;
use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Yansongda\Pay\Pay;
//use Yansongda\Pay\Log;
use App\Model\Pay;

class ApiController extends Controller
{
    public function index()
    {
        $data = Team::where('t_status','<>',3)
            ->join('analysi','team.t_id','analysi.t_id')
            ->join('analysts','analysi.a_id','analysts.a_id')
            ->orderBy('t_date','desc')
            ->limit(8)->get();
//        dd($data);
        $first =  Team::where('t_jing','=',2)->first();
        if($first){
            $first['t_date'] = date('m-d',$first['t_date']);
            $first['t_time'] = date('H:i',$first['t_time']);
        }
        if($data){
            $arr = [];
            foreach($data as $k=>$v){
                $v['t_date'] = date('m-d',$v['t_date']);
                $v['t_time'] = date('H:i',$v['t_time']);
                $arr[$k] =$v;
            }
        }else{
            $arr = [];
        }

        return json_encode(['arr'=>$arr,'first'=>$first]);
    }
    public function home()
    {
        $data = Home::get();
        return json_encode($data);
    }
    //获取用户信息
    public function user()
    {
        $openid = request()->input('openid');
//        dd($openid);
        $data = Users::where('openid',$openid)->first();
        return json_encode($data);
    }
    //获取分析师
    public function analyst()
    {
        $data = Analysts::orderBy('a_id','desc')->get();
//        dd($data);
        $aid = "";
        foreach($data as $k=>$v){
            $aid .=','.$v['a_id'];
        }
        $aid = explode(',',trim($aid,','));
        $arr = [];
        foreach($aid as $k=>$v){
           $arr[$k] =['a_id'=>$v,'count'=>$count = Analysi::where(['analysi.a_id'=>$v])->whereIN('team.t_status',[1,2])->join('team','analysi.t_id','=','team.t_id')->count()];
        }
        foreach($data as $k=>$v){
            if($v['a_id'] == $arr[$k]['a_id']){
                $v['count'] =$arr[$k]['count'];
            }
        }
        return json_encode($data);
    }
    //分析师分的结果
    public function details()
    {
        $aid = request()->input('a_id');
        $openid = request()->input('openid');
//        dd($openid);
        $data = Analysi::where(['analysi.a_id'=>$aid])
            ->whereIN('team.t_status',[1,2])
            ->join('analysts','analysi.a_id','=','analysts.a_id')
            ->join('team','analysi.t_id','=','team.t_id')
            ->get();
        foreach($data as $k=>$v){
            $v['t_date'] = date('m-d',$v['t_date']);
            $v['t_time'] = date('H:i',$v['t_time']);
            $data[$k] =$v;
        }
        $js = Analysi::where(['analysi.a_id'=>$aid,'team.t_status'=>3])
            ->join('analysts','analysi.a_id','=','analysts.a_id')
            ->join('team','analysi.t_id','=','team.t_id')
            ->join('result','analysi.t_id','=','result.t_id')
            orderBy('t_date','desc')
            ->get();

        foreach($js as $k=>$v){
            $v['t_date'] = date('m-d',$v['t_date']);
            $v['t_time'] = date('H:i',$v['t_time']);
            $js[$k] =$v;
        }
        $an = Analysts::where('a_id',$aid)->first();
        $result = Dingyue::where(['openid'=>$openid,'a_id'=>$aid])->first();
//        dd($result);
        if($result){
            $aa = 2;
        }else{
            $aa = 1;
        }
//        dd($arr);
        return json_encode(['team'=>$data,'an'=>$an,'code'=>$aa,'jie'=>$js]);
    }
    //订阅 修改粉丝数量
    public function fensi()
    {
        $aid = request()->input('a_id');
        $openid = request()->input('openid');
        $result = Dingyue::where(['openid'=>$openid,'a_id'=>$aid])->first();
        if($result){
            Analysts::where('a_id',$aid)->decrement('fensi');
            Dingyue::where(['openid'=>$openid,'a_id'=>$aid])->delete();
        }else{
            Analysts::where('a_id',$aid)->increment('fensi');
            Dingyue::insert(['openid'=>$openid,'a_id'=>$aid]);
        }
        return 1;
    }
    //查看分析结果
    public function analysis()
    {
        $data  = request()->input();
//        dd($data);
        $an = Analysts::where('a_id',$data['a_id'])->first();
        $team = Team::where('t_id',$data['t_id'])->first();
        $team['t_date'] = date('m-d',$team['t_date']);
        $team['t_time'] = date('H:i',$team['t_time']);
        $money = Shop::where('t_id',$data['t_id'])->first();
        return json_encode(['an'=>$an,'team'=>$team,'money'=>$money]);

    }
    //获取金额
    public function money()
    {
        $tid = request()->post();
        $money = Shop::where('t_id',$tid)->first();
        return json_encode($money);
    }
    //检测是否付款
    public function jian()
    {
        $data = request()->input();
       $res = Pay::where(['openid'=>$data['openid'],'pay.t_id'=>$data['t_id'],'status'=>2])
           ->join('team','pay.t_id','=','team.t_id')
           ->first();
       $time = date('H:i:s',$res['t_time']);
       $date = date('Y-m-d',$res['t_date']);
       $date = explode('-',$date);
        $time = explode(':',$time);
       $hour = $time[0];
      if($hour == 00){
          $hours = 24 - 1;
      }else{
          $hours = $hour - 1;
      }
      $Minutes = $time[1];
      $Seconds = $time[2];
      $year = $date[0];
      $month = $date[1];
      $dates = $date[2];
       return json_encode(['data'=>$res,'hour'=>$hours,'Minutes'=>$Minutes,'Seconds'=>$Seconds,'year'=>$year,'month'=>$month,'dates'=>$dates]);
    }
    //回调
    public function notify()
    {
        $data = request()->input();
//        dd($data);
        $res = Pay::where(['t_id'=>$data['t_id'],'status'=>2])->first();
        if(!$res) {
            $pay = Pay::where(['openid' => $data['openid'], 'status' => 1, 'sign' => $data['sign']])->first();
            if ($pay['sign'] == $data['sign']) {
                //判断返回状态
                Pay::where('out_trade_no', $data['out_trade_no'])->update(['status' => 2]);
                //判断订单金额
            }
        }
    }
    public function wechatPay()
    {
        $request=request()->input();
//        dd($request);
        $shop = Shop::where('t_id',$request['t_id'])->first();
        if($shop['s_money']){
            $money = 88;
        }else{
            $money = $shop['s_money'];
        }
        $fee=$money;
        $details="即嗨鲸";//商品的详情，比如iPhone8，紫色
        // $fee = 0.01;//举例充值0.01
        $appid =        'wx26ff8c9db22f9510';//appid
        $body =        "即嗨鲸";// '金邦汇商城';//'【自己填写】'
        $mch_id =       '1586415601';//'你的商户号【自己填写】'
        $nonce_str =    $this->nonce_str();//随机字符串
        $notify_url =   'http://www.fxs.com/api/notify';//回调的url【自己填写】';
        $openid =       $request['openid'];//'用户的openid【自己填写】';
        $out_trade_no = $this->order_number($openid);//商户订单号
        $spbill_create_ip = '127.0.0.1';//'服务器的ip【自己填写】';
        $total_fee =    0.01*100;//因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
        $trade_type = 'JSAPI';//交易类型 默认
        //这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
        $post['appid'] = $appid;

        $post['body'] = $body;

        $post['mch_id'] = $mch_id;

        $post['nonce_str'] = $nonce_str;//随机字符串

        $post['notify_url'] = $notify_url;

        $post['openid'] = $openid;

        $post['out_trade_no'] = $out_trade_no;

        $post['spbill_create_ip'] = $spbill_create_ip;//终端的ip

        $post['total_fee'] = $total_fee;//总金额 最低为一块钱 必须是整数

        $post['trade_type'] = $trade_type;
        $sign = $this->sign($post);//签名
//        dd($sign);
        $post_xml = '<xml>
           <appid>'.$appid.'</appid>
           <body>'.$body.'</body>
           <mch_id>'.$mch_id.'</mch_id>
           <nonce_str>'.$nonce_str.'</nonce_str>
           <notify_url>'.$notify_url.'</notify_url>
           <openid>'.$openid.'</openid>
           <out_trade_no>'.$out_trade_no.'</out_trade_no>
           <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
           <total_fee>'.$total_fee.'</total_fee>
           <trade_type>'.$trade_type.'</trade_type>
           <sign>'.$sign.'</sign>
        </xml> ';
        //统一接口prepay_id
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = $this->http_request($url,$post_xml);
//        dd($xml);
        $array = $this->xml($xml);//全要大写
        $data = [];
        if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
            $time = time();
            $tmp=[];//临时数组用于签名
            $tmp['appId'] = $appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = "$time";

            $data['state'] = 1;
            $data['timeStamp'] = "$time";//时间戳
            $data['nonceStr'] = $nonce_str;//随机字符串
            $data['signType'] = 'MD5';//签名算法，暂支持 MD5
            $data['package'] = 'prepay_id='.$array['PREPAY_ID'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->sign($tmp);//签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;
            $arr = [
                'openid'=>$openid,
                'total_fee'=>$total_fee,
                'out_trade_no'=>$out_trade_no,
                'sign'=> $data['paySign'],
                'status'=>1,
                't_id'=>$request['t_id'],
                'create_time'=>time()
            ];
            Pay::insert($arr);
        }else{
            $data['state'] = 0;
            $data['text'] = "错误";
            $data['RETURN_CODE'] = $array['RETURN_CODE'];
            $data['RETURN_MSG'] = $array['RETURN_MSG'];
        }
        return  json_encode($data);
    }


//随机32位字符串
    private function nonce_str(){
        $result = '';
        $str = 'QWERTYUIOPASDFGHJKLZXVBNMqwertyuioplkjhgfdsamnbvcxz';
        for ($i=0;$i<32;$i++){
            $result .= $str[rand(0,48)];
        }
        return $result;
    }


//生成订单号
    private function order_number($openid){
        //date('Ymd',time()).time().rand(10,99);//18位
        return md5($openid.time().rand(10,99));//32位
    }




//签名 $data要先排好顺序
    public function sign($data)
    {
        $stringA = '';
        foreach ($data as $key => $value) {
            if (!$value) continue;
            if ($stringA) $stringA .= '&' . $key . "=" . $value;
            else $stringA = $key . "=" . $value;
        }
        $wx_key = 'aaeef645fb172e4697d0e27e01d5f87f';//申请支付后有给予一个商户账号和密码，登陆后自己设置key
        $stringSignTemp = $stringA . '&key=' . $wx_key;//申请支付后有给予一个商户账号和密码，登陆后自己设置key
        return strtoupper(md5($stringSignTemp));
    }

//curl请求啊
    function http_request($url, $data = null, $headers = array())
    {
        $curl = curl_init();
        if (count($headers) >= 1) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

//获取xml
    private function xml($xml){
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $vals, $index);
        xml_parser_free($p);
        $data = [];
        foreach ($index as $key=>$value) {
                if ($key == 'xml' || $key == 'XML') continue;
                $tag = $vals[$value[0]]['tag'];
                $value = $vals[$value[0]]['value'];
//                $tag = explode(',',$tag);
//                var_dump($tag);
                $data[$tag] = $value;
            }
        return $data;
    }
//微信支付结束
    //查看分析结果
    public function jie()
    {
        $data = request()->input();
//        dd($data);
        $team = Team::where('t_id',$data['t_id'])->first();
        $an = Analysts::where('a_id',$data['a_id'])->first();
        $fen = Analysi::where(['a_id'=>$data['a_id'],'t_id'=>$data['t_id']])->first();
        $team['t_date'] = date('m-d',$team['t_date']);
        $team['t_time'] = date('H:i',$team['t_time']);
        return json_encode(['team'=>$team,'an'=>$an,'fen'=>$fen]);
    }
    //我的订阅
    public function myding()
    {
        $openid= request()->input('openid');
//        dd($openid);
        $ding = Dingyue::where('openid',$openid)->orderBy('a_id','desc')->get();
        $aid = "";
        foreach($ding as $k=>$v){
            $aid .=','.$v['a_id'];
        }
        $aid = explode(',',trim($aid,','));
        $an = Analysts::whereIN('a_id',$aid)->orderBy('a_id','desc')->get();
        $arr = [];
        foreach($aid as $k=>$v){
            $arr[$k] =['a_id'=>$v,'count'=>$count = Analysi::where(['analysi.a_id'=>$v])->whereIN('team.t_status',[1,2])->join('team','analysi.t_id','=','team.t_id')->count()];
        }
        foreach($an as $k=>$v) {
            if ($v['a_id'] == $arr[$k]['a_id']) {
                $v['count'] = $arr[$k]['count'];
            }
        }
        return json_encode($an);
    }
    //我的比赛
    public function my()
    {
        $data = request()->input();
       $xin = Pay::where(['openid'=>$data['openid'],'status'=>2])
           ->whereIN('team.t_status',[1,2])
           ->join('team','pay.t_id','=','team.t_id')
           ->get();
       $jie = Pay::where(['openid'=>$data['openid'],'status'=>2,'t_status'=>3])
           ->join('team','pay.t_id','=','team.t_id')
           ->join('result','pay.t_id','=','result.t_id')
           ->join('analysi','pay.t_id','=','analysi.t_id')
           ->get();
       return json_encode(['xin'=>$xin,'jie'=>$jie]);
    }

    //添加個人信息
    public function userinfo()
    {
        $data = request()->input();
        $aa = UserInfo::where('i_openid',$data['openid'])->first();
        $arr = [
            'i_name'=>$data['name'],
            'i_openid'=>$data['openid'],
            'i_sex'=>$data['sex'],
            'i_phone'=>$data['phone'],
            'i_id_cart'=>$data['idNumber'],
            'create_time'=>time(),
        ];
        if($aa){
            $res = UserInfo::where('i_openid',$data['openid'])->update($arr);
        }else{
            $res = UserInfo::insert($arr);
        }

        if($res){
            return json_encode(['code'=>2,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"添加失败"]);
        }
    }
    //查询个人信息
    public function doinfo()
    {
        $openid = request()->input('openid');
        $data = UserInfo::where('i_openid',$openid)->first();
            return json_encode($data);
    }
    //公告
    public function gg()
    {
        $data = Gg::get();
        return json_encode($data);
    }
    public function icon()
    {
        $data = request()->input();
//        dd($data);
        $an = Analysi::where(['a_id'=>$data['a_id'],'t_id'=>$data['t_id']])->first(['s_id']);
        $id = Pay::where(['t_id'=>$data['t_id'],'status'=>2])->get();
        $openid = '';
        foreach($id as $k => $v){
            $openid .=','.$v['openid'];
        }
        $openid = explode(',',trim($openid,','));
        $count = Users::whereIN('openid',$openid)->count();
        $icons = Users::whereIN('openid',$openid)->get(['avatarUrl']);
        $s_id = $an['s_id'];
       $icon = Icon::where('s_id',$s_id)->first();
       $img = json_decode($icon['i_img']);
        $i_us = $icon['i_us'];
        return json_encode(['img'=>$img,'i_us'=>$i_us,'count'=>$count,'avatarUrl'=>$icons]);
    }
}
