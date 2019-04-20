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

    public function check_pwd()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $this->login->check($email, $password);
            if (isset($result['id'])) {
//                setcookie('user', md5($result['id']), time() + 60,'/');
                Cookie::set('user',md5($result['id']));
                Session::set(md5($result['id']),$result);
            }
            //  1：登陆成功，0：登录失败
            return $result['id'] ? 1 : 0;
        } else {
            return 0;
        }
    }
}
