<?php

namespace App\Http\Controllers\Login;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use DB;

class LoginController extends Controller
{
    public function wxLogin(Request $request)
    {
        $param=array();
        $param[]='appid='.env('APPID');
        $param[]='secret='.env('SECRET');
        $param[]='js_code='.$request->code;
        $param[]='grant_type=authorization_code';
        $params=implode('&',$param);    //用&符号连起来
        $url = env('WECHAT_GET_OPEN_ID').'?'.$params;
        //请求接口
        $client = new \GuzzleHttp\Client([
            'timeout' => 60
        ]);
        $res = $client->request('GET',$url);
//        dd($res);
        //openid和session_key
        $data = json_decode($res->getBody()->getContents(),true);
        //openid查重
        $result = DB::table('users')->where('openid',$data['openid'])->first();
        $result = json_decode(json_encode($result), true);
        if($result==NULL){ //首次登录，存openid
            DB::beginTransaction();
            try{
                DB::table('users')->insert(['openid'=>$data['openid']]);
                DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        }else if($result['nickName']!=NULL){ //非首次登录，且已授权，存用户信息
            $user = array();
            $user['nickName'] = $result['nickName'];
            $user['avatarUrl'] = $result['avatarUrl'];
            $user['isBoss'] = $result['isBoss'];
            return json_encode(['data'=>$data,'user'=>$user]);
        }
        return json_encode($data);
    }
    public function save(Request $request)
    {
        DB::beginTransaction();
        try{
            DB::table('users')->where('openid',$request->openid)->update([
                'avatarUrl'=>$request->avatarUrl,
                'nickName'=>$request->nickName
            ]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return 1;
    }
    public function login()
    {
        return view('login.login');
    }
    public function dologin()
    {
        $data = request()->input();
//        dd($data);
        $name = $data['email'];
        $pass = md5(md5($data['password']));
        $res = Admin::where(['a_name'=>$name,'a_password'=>$pass])->first();
        if($res){
            session(['aid'=>$res->a_id,'name'=>$res->a_name]);
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"用户名或者密码输入错误"]);
        }

    }
    public function logout(Request $request)
    {
        $request->session()->forget('aid');
        return redirect('/');
    }
}
