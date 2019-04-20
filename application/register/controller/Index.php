<?php

namespace app\register\controller;

use think\Controller;
use think\Request;
use app\register\model\register;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->register = new register();
    }

    public function index()
    {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['type'])) {
            $result = $this->register->index($_POST['email'],$_POST['password'],$_POST['type']);
            return $result;
        }
    }
}
