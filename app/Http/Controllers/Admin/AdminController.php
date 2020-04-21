<?php

namespace App\Http\Controllers\Admin;

use App\Model\Analysi;
use App\Model\Analysts;
use App\Model\Gg;
use App\Model\Home;
use App\Model\Icon;
use App\Model\Pay;
use App\Model\Result;
use App\Model\Shop;
use App\Model\Team;
use App\Model\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function home()
    {
        $data = Analysts::get(['a_id','a_username']);
        return view('admin.home',[
            'data'=>$data
        ]);
    }
    public function upload()
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 1048576) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = trim($file_path,'.');
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function dohome()
    {
        $data = request()->input();
//        dd($data);
        if(empty($data['aid'])){
            return json_encode(['code'=>4,'message'=>"请选择分析师"]);
        }
        $name = $data['name'];
        $result = Team::where('t_name',$name)->first();
        if($result){
            return json_encode(['code'=>1,'message'=>"已有该比赛"]);
        }
        $time = strtotime($data['time']);
        $date = strtotime($data['date']);
        $arr = [
            't_name'=>$data['name'],
            't_qiu1'=>$data['qiu1'],
            't_qiu2'=>$data['qiu2'],
            't_img1'=>$data['img1'],
            't_img2'=>$data['img2'],
            't_date'=>$date,
            't_time'=>$time,
            't_jing'=>$data['jing'],
            't_status'=>1,
            't_create_time'=>time(),
        ];

        $tid = Team::insertGetId($arr);
        if($tid){
            foreach($data['aid'] as $k=>$v){
                $res = Analysi::where(['a_id'=>$v,'t_id'=>$tid])->first();
                if($res){
                    Team::where(['t_id'=>$tid])->delete();
                    return json_encode(['code'=>4,'message'=>"已有分析师分析了该比赛请重新添加"]);
                }
                Analysi::insert(['a_id'=>$v,'t_id'=>$tid]);
            }
            return json_encode(['code'=>2,'message'=>"添加成功"]);
        }else{
            return json_encode(['code'=>3,'message'=>"添加失败"]);
        }
    }
    public function dostatus()
    {
        $data = request()->input();
//        dd($data);
        $res = Team::where('t_id',$data['tid'])->update(['t_status'=>$data['status']]);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function list()
    {
        $data = Team::orderBy('t_date','desc')->paginate(10);
        return view('admin.list',[
            'data'=>$data,
        ]);
    }
    public function del()
    {
        $tid = request()->input('tid');
//        dd($tid);
        $res = Team::where('t_id',$tid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"删除成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"删除失败"]);
        }
    }
    public function edit()
    {
        $tid = request()->input('tid');
//        dd($tid);
        $data = Team::where('t_id',$tid)->first();
//        dd($data);
        $data['t_date'] = date('Y-m-d',$data['t_date']);
        $data['t_time'] = date('H:i:s',$data['t_time']);
        if($data){
            return json_encode(['code'=>2,'message'=>$data]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function update()
    {
        $data = request()->input();
        $arr = $data['data'];
        $time = strtotime($arr['t_time']);
        $date = strtotime($arr['t_date']);
        $arr['t_date'] = $date;
        $arr['t_time'] = $time;
        $arr['t_create_time'] = time();
//        dd($arr);
        $tid = $data['tid'];
        $res = Team::where('t_id',$tid)->update($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function result()
    {
        $team = Team::get(['t_id','t_qiu1','t_qiu2','t_name']);
        return view('admin.result',[
            'team'=>$team
        ]);
    }
    public function dores()
    {
        $data = request()->input();
//        dd($data);
        $result = Result::where('t_id',$data['t_id'])->first();
        if($result){
            return json_encode(['code'=>3,'message'=>"该球队已有结果"]);
        }
        $res = Result::insert($data);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function analysts()
    {
        return view('admin.analysts');
    }
    public function doan()
    {
        $data = request()->input();
//        dd($data);
        $result = Analysts::where('a_username',$data['username'])->first();
        if($result){
            return json_encode(['code'=>3,'messsage'=>"已有该分析师"]);
        }
        $arr = [
            'a_username'=>$data['username'],
            'a_img'=>$data['img'],
            'a_title1'=>$data['title1'],
            'a_title2'=>$data['title2'],
            'a_sl'=>$data['sl'],
            'a_desc'=>$data['desc'],
            'create_time'=>time(),
        ];
        $res = Analysts::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function anlist()
    {
        $data = Analysts::paginate(10);
        return view('admin.anlist',[
            'data'=>$data,
        ]);
    }
    public function ansedit()
    {
        $aid = request()->input('aid');
       $data = Analysts::where('a_id',$aid)->first();
       if($data){
           return json_encode(['code'=>2,'message'=>$data]);
       }else{
           return json_encode(['code'=>1,'message'=>"失败"]);
       }
    }
    public function anupdate()
    {
        $data = request()->input();
//        dd($data);
        $arr = $data['data'];
        $res = Analysts::where('a_id',$data['aid'])->update($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function analysis()
    {
        $analysts = Analysts::get();
        $team = Team::get();
        return view('admin.analysis',[
            'analysts'=>$analysts,
            'team'=>$team
        ]);
    }
    public function doanalysis()
    {
        $data = request()->input();
//        dd($data);
        $result = Analysi::where(['t_id'=>$data['t_id'],'a_id'=>$data['a_id']])->first();
        if($result){
            return json_encode(['code'=>3,'message'=>'该球队已分析']);
        }
        $res = Analysi::insert($data);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function anslist()
    {
        $data = Analysi::
        join('team','analysi.t_id','=','team.t_id')->orderBy('s_id','desc')
            ->join('analysts','analysi.a_id','=','analysts.a_id')
            ->paginate(10);
//        dd($data);
        $analysts = Analysts::get();
        $team = Team::get();
        return view('admin.anslist',[
            'data'=>$data,
            'analysts'=>$analysts,
            'team'=>$team
        ]);
    }
    public function anedit()
    {
        $data = request()->input();
        $an = Analysi::
        where(['analysi.t_id'=>$data['tid'],'analysi.a_id'=>$data['aid']])
            ->join('team','analysi.t_id','=','team.t_id')
            ->join('analysts','analysi.a_id','=','analysts.a_id')
            ->first();
        $analysts = Analysts::get();
        $team = Team::get();
        return view('admin.anedit',[
            'analysts'=>$analysts,
            'team'=>$team,
            'an'=>$an,
        ]);

    }

    public function aneditdo()
    {
        $data = request()->input();
        $arr = [
            "a_id" =>$data['a_id'],
            "t_id" => $data['t_id'],
            "s_status" => $data['s_status'],
            "s_result" => $data['s_result'],
        ];
        $res = Analysi::where('s_id',$data['s_id'])->update($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }

    public function ansdel()
    {
        $aid = request()->input('aid');
        $res = Analysts::where('a_id',$aid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }

    public function andel()
    {
        $sid = request()->input('sid');
       $res = Analysi::where('s_id',$sid)->delete();
       if($res){
           return json_encode(['code'=>2,'message'=>"成功"]);
       }else{
           return json_encode(['code'=>1,'message'=>"失败"]);
       }
    }
    public function shop()
    {
        $team = Team::get(['t_id','t_qiu1','t_qiu2','t_name']);
        return view('admin.shop',[
            'team'=>$team
        ]);
    }
    public function doshop()
    {
        $data = request()->input();
//        dd($data);
        $result = Shop::where('t_id',$data['t_id'])->first();
        if($result){
            return json_encode(['code'=>3,'message'=>"该之球队已经添加金额，如需改变金额请修改"]);
        }
        $res = Shop::insert($data);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function shoplist()
    {
        $data = Shop::join('team','shop.t_id','=','team.t_id')->paginate(10);
        return view('admin.shoplist',[
            'data'=>$data
        ]);
    }
    public function shopdel()
    {
        $sid = request()->input('sid');
        $res = Shop::where('s_id',$sid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function paylist()
    {
        $data = Pay::join('team','pay.t_id','=','team.t_id')
            ->join('users','pay.openid','=','users.openid')
            ->paginate(10);
        $money = Shop::get()->toArray();
        foreach($data as $k=>$v){
            foreach($money as $key=>$val){
                if($v['t_id'] == $val['t_id']){
                    if(empty($val['s_money'])){
                        $v['money'] = 0;
                    }else{
                        $v['money'] = $val['s_money'];
                    }
                }else{
                    $v['money'] = 0;
                }
            }
            $data[$k] = $v;
        }
        return view('admin.paylist',[
            'data'=>$data
        ]);
    }
    public function gonggao()
    {
        return view('admin.gonggao');
    }
    public function dogong()
    {
        $data = request()->input();
        $res = Gg::insert([
            'g_title'=>$data['g_title'],
            'g_text'=>$data['text'],
            'create_time'=>time()
        ]);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function gglist()
    {
        $data = Gg::paginate(10);
        return view('admin.gglist',[
            'data'=>$data
        ]);
    }
    public function gdel()
    {
        $gid = request()->input('gid');
        $res = Gg::where('g_id',$gid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function shouye()
    {
        return view('admin.shouye');
    }
    public function doshou()
    {
        $data = request()->input();
        $arr = [
            'h_title'=>$data['g_title'],
            'h_text'=>$data['text'],
        ];
        $res = Home::insert($arr);
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function homelist()
    {
        $data = Home::paginate(10);
        return view('admin.homelist',[
            'data'=>$data
        ]);
    }
    public function hdel(){
        $hid = request()->input('hid');
        $res = Home::where('h_id',$hid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function ulist()
    {
        $data = UserInfo::paginate(10);
        return view('admin.ulist',[
            'data'=>$data
        ]);
    }
    public function udel()
    {
        $iid = request()->input('iid');
        $res = UserInfo::where('i_id',$iid)->delete();
        if($res){
            return json_encode(['code'=>2,'message'=>"成功"]);
        }else{
            return json_encode(['code'=>1,'message'=>"失败"]);
        }
    }
    public function icon()
    {
        $data = Analysi::where('team.t_status',[1,2])
            ->join('team','analysi.t_id','=','team.t_id')
            ->join('analysts','analysi.a_id','=','analysts.a_id')
            ->get();
        return view('admin.icon',[
            'data'=>$data,
        ]);
    }
    public function uploads(Request $request)
    {
        if ($_FILES) {
            //上传图片具体操作
            $file_name = $_FILES['file']['name'];
            //$file_type = $_FILES["file"]["type"];
            $file_tmp = $_FILES["file"]["tmp_name"];
            $file_error = $_FILES["file"]["error"];
            $file_size = $_FILES["file"]["size"];
            if ($file_error > 0) { // 出错
                $status = 2;
                $message = $file_error;
            } elseif($file_size > 1048576) { // 文件太大了
                $status = 5;
                $message = "上传文件不能大于1MB";
            }else{
                $date = date('Ymd');
                $file_name_arr = explode('.', $file_name);
                $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
                $path = "./upload/".$date."/";
                $file_path = $path . $new_file_name;
                if (!file_exists($path)) {
                    //TODO 判断当前的目录是否存在，若不存在就新建一个!
                    mkdir($path,0777,true);
                }
                $upload_result = move_uploaded_file($file_tmp, $file_path);
                $status = '';
                //此函数只支持 HTTP POST 上传的文件
                if ($upload_result) {
                    $status = 1;
                    $message = trim($file_path,'.');
                } else {
                    $status = 3;
                    $message = "文件上传失败，请稍后再尝试";
                }
            }
        } else {
            $status = 4;
            $message = "参数错误";
        }
        return json_encode(['code'=>$status,'message'=>$message]);
    }
    public function doicon()
    {
        $data = request()->input();
        $icon = Icon::where('s_id',$data['s_id'])->first();
        if($icon){
            return json_encode(['code'=>3,'message'=>"该比赛已经添加了"]);
        }
        $img =json_encode(explode(',',$data['slide_show']));
       $arr = [
           's_id'=>$data['s_id'],
           'i_img'=>$img,
           'i_us'=>$data['i_us']
       ];
       $res = Icon::insert($arr);
       if($res){
           return json_encode(['code'=>2,'message'=>"成功"]);
       }else{
           return json_encode(['code'=>1,'message'=>"失败"]);
       }
    }
}
