<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27 0027
 * Time: 15:50
 */

namespace app\login\model;

use think\Model;
use think\Db;
use think\Exception;
class login extends Model
{
    // 检查登录
    public function check($email, $password)
    {
        // 开启事务
        Db::startTrans();
        try {
            $result = Db::name('users')->where('username', $email)->where('password',md5($password))->field('id,name,username,type')->find();
            if($result['type']==='0'){
                $jianId=Db::name('jianli')->where('userId',$result['id'])->field('id')->find();
                $result['jianId']=$jianId['id'];
            }else{
                $companyId=Db::name('company')->where('userId',$result['id'])->field('companyId')->find();
                $result['companyId']=$companyId['companyId'];
            }
            Db::commit();
            return $result;
        } catch (Exception $e) {
            // 回滚
            Db::rollback();
            return '';
        }
    }
}