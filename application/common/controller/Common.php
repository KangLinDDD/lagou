<?php

namespace app\common\controller;

use think\Cookie;
use think\Request;
use think\Session;
use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        if (!Cookie::has('user') && !(Cookie::has('user') && Session::has(Cookie::get('user')))) {
            header('content-type:text/json;charset=utf-8');
            $arr = array('statusCode'=>100,'message'=>'用户未登录');
//            header("location:http://localhost:9000/login.html");
//            exit (Session::get(Cookie::get('user')));
            exit(json_encode($arr));
        }
    }
}
