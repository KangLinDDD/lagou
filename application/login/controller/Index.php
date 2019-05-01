<?php

namespace app\login\controller;

use think\Controller;
use app\login\model\login;
use think\Request;
use think\Session;
use think\Cookie;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->login = new login();
    }

    public function check_login(Request $request)
    {
        session_start();
        $result = $this->check_pwd();
        return $result;
    }
    // 设置登录信息
    public function check_pwd()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $this->login->check($email, $password);
            $arr = array();
            if (isset($result['id'])) {
//                setcookie('user', md5($result['id']), time() + 60,'/');
                Cookie::set('user', md5($result['id']));
                Session::set(md5($result['id']), $result);
                $arr['statusCode'] = 200;
                $arr['type'] = $result['type'];
            } else {
                $arr['statusCode'] = 400;
//                $arr['type']=$result['type'];
            }
            return json($arr);
        } else {
            return 0;
        }
    }

//    检查cookie及session信息
    public function checkCookie()
    {
        if (Cookie::has('user')) {
            Cookie::set('user', Cookie::get('user'));
            Session::set(Cookie::get('user'), Session::get(Cookie::get('user')));
            return json(Session::get(Cookie::get('user')));
        } else {
            $arr = array('id' => '');
            return json($arr);
        }
    }
}
