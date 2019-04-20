<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/3 0003
 * Time: 11:18
 */

namespace app\reset\model;

use think\Exception;
use think\Model;
use think\Db;

class reset extends Model
{
    public function reset($email, $pwd)
    {
        Db::startTrans();
        try {
            $result = Db::name('users')->where('name', $email)->find();
            if ($result['password'] === md5($pwd)) {
                $arr = array('statusCode'=>200,'message'=>urlencode('新旧密码不能相同'));
                return urldecode(json_encode($arr));
            } else {
                $result = Db::name('users')->where('name', $email)->update(['password'=> md5($pwd)]);
                Db::commit();
                return $result;
            }
        } catch (Exception $e) {
            Db::rollback();
        }
    }
}