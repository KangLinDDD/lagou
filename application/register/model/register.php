<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/4 0004
 * Time: 13:03
 */

namespace app\register\model;

use think\Model;
use think\Db;
use think\Exception;

class register extends Model
{
    public function index($email, $pwd, $type)
    {
        Db::startTrans();
        try {
            $result = Db::name('users')->where('username', $email)->find();
            if ($result['name'] === $email) {
                $arr = array('register'=>false, 'message' => urlencode('该用户名已注册'));
                return urldecode(json_encode($arr));
            } else {
                Db::name('users')->insert(['username' => $email, 'password' => md5($pwd), 'type' => $type]);
                Db::commit();
                return urldecode(json_encode(['register'=>true]));
            }
        } catch (Exception $e) {
            Db::rollback();
            return $e->getMessage();
        }
    }
}