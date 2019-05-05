<?php
namespace app\user\controller;

use app\user\model\User;
use think\Controller;
use think\Cookie;
use think\Request;
use think\Session;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->users = new User();
        if (Cookie::has('user') && Session::has(Cookie::get('user'))){
            $this->uid = Session::get(Cookie::get('user'))['id'];
        }
    }

    public function getUserInfo()
    {
        return $this->users->getUserInfo($this->uid);
    }
}
