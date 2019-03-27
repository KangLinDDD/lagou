<?php
namespace app\login\controller;
use app\login\model\login;
use think\Controller;
use think\Request;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->login = new login();
    }

    public function index()
    {
        return $this->fetch('login');
    }
    public function check_login()
    {
        if(isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $pwd = $_POST['password'];
            return $this->login->check($email,$pwd);
        }
    }
}
