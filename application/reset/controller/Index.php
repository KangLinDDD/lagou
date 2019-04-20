<?php
namespace app\reset\controller;
use think\Controller;
use app\reset\model\reset;
use think\Request;
class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->reset = new reset();
    }

    public function index()
    {
        if (isset($_POST['email']) && isset($_POST['pwd'])) {
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $result = $this->reset->reset($email, $pwd);
            return $result;
        } else {
            return 0;
        }
    }
}
