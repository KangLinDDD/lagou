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

    public function check()
    {
        // 获取用户信息
        return $this->jianli->checkJianLi($this->uid);

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
    public function addWorkShow(){
        $result = $this->jianli->addWorkShow();
        return $result;
    }
    public function updateProject(){
        $result = $this->jianli->updateProject();
        return $result;
    }
    public function updateEducation(){
        $result = $this->jianli->updateEducation();
        return $result;
    }
    public function updateWorkExperience(){
        $result = $this->jianli->updateWorkExperience();
        return $result;
    }
    public function getJianLi(){
        $result = $this->jianli->getJianLi($this->uid);
        return $result;
    }
    public function delete(){
        return $this->jianli->delete();
    }
}
