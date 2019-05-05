<?php

namespace app\jianli\controller;

use think\Controller;
use app\jianli\model\Jianli;
use think\Db;
use think\Exception;
use think\Request;
use think\Cookie;
use think\Session;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->jianli = new Jianli();
        if (Cookie::has('user') && Session::has(Cookie::get('user'))){
            $this->uid = Session::get(Cookie::get('user'))['id'];
        }
    }

    public function index()
    {
        // 获取用户信息

    }

    public function basicInfo()
    {
//        if(isset($_POST['headImg'])){
//            return $_POST['headImg'];
//        }else{
//            return 0;
//        }
        return 0;
    }

    public function headImg()
    {
        if (isset($_FILES['file'])) {
            $result = $this->jianli->addHeadImg(Cookie::get('user'),$this->uid);
            $time=date('Y-M-D h:i:s',time());
            return json($result);
        } else {
            return 0;
        }
    }
    public function addUserInfo(){
        if(!isset($this->uid)){
            return 400;
        }
        if(isset($_POST)){
            $result = $this->jianli->addBasicInfo($this->uid);
            return $result;
        }else{
            return 0;
        }
    }
    public function addExpectInfo(){
        $result = $this->jianli->addExceptInfo($this->uid);
        return $result;
    }
}
