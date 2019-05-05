<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/1 0001
 * Time: 20:35
 */

namespace app\jianli\model;


use think\Cookie;
use think\Model;
use think\Db;
use think\Exception;
use think\Session;

class Jianli extends Model
{
    public function addHeadImg($userId = '', $uId)
    {
        $filepath = 'static/images/';
        $filename = $userId . time() . strstr($_FILES['file']['name'], '.');
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath . $filename)) {
            // 将图片路径写进数据库并返回
            $picPath = 'http://tp5.com/' . $filepath . $filename;
            Db::startTrans();
            try {
                $result = Db::table('users')->where('id', $uId)->update(['headImgUrl' => $picPath]);
                Db::commit();
                return $picPath;
            } catch (Exception $e) {
                Db::rollback();
                $e->getMessage();
            }
        } else {
            return 100;
        }
    }
    public function addBasicInfo($uid){
        Db::startTrans();
        try{
            $result = Db::table('users')->where('id',$uid)->update($_POST);
            Db::commit();
            return $result;
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function addExceptInfo($id)
    {
        try{
            $result = Db::name('jianli')->where('userId',$id)->find();
            if (isset($result)){
                // 更新
                // 插入
                $arr = $_POST;
                $arr['userId'] = $id;
                $update = Db::name('jianli')->where('userId',$id)->update($arr);
                Db::commit();
                return $update;
            }else{
                // 插入
                $arr = $_POST;
                $arr['userId'] = $id;
                $insert = Db::name('jianli')->insert($arr,true);
                Db::commit();
                return $insert;
            }

        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
}