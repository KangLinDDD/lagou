<?php

namespace app\jianli\controller;

use think\Controller;
use app\jianli\model\Jianli;
use think\Request;
use think\Cookie;
use think\Session;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->jianli = new Jianli();
        if (isset(Cookie::get('user')) && isset(Session::get(Cookie::get('user')))) {
            $this->error('用户未登录');
        }
    }

    public function index()
    {

    }
}
