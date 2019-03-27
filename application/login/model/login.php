<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27 0027
 * Time: 15:50
 */

namespace app\login\model;
use think\Model;
class login extends Model
{
    public function check($email, $pwd)
    {
        return 1;
    }
}