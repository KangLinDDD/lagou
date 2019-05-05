<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/5 0005
 * Time: 23:54
 */

namespace app\user\model;


use think\Exception;
use think\Model;
use think\Db;
class User extends Model
{
    public function getUserInfo($id){
        try{
            $result = Db::name('users')->where('id',$id)->find();
            return json($result);
        }catch(Exception $e){
            $e->getMessage();
        }
    }
}