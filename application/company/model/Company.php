<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/8 0008
 * Time: 10:58
 */

namespace app\company\model;


use think\Model;
use think\Db;
use think\Exception;

class Company extends Model
{
    public function confirm($userId, $uId)
    {
        $filepath = 'static/companyConfirms/';
        $filename = $userId . time() . strstr($_FILES['file']['name'], '.');
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath . $filename)) {
            // 将图片路径写进数据库并返回
            $picPath = 'http://tp5.com/' . $filepath . $filename;
            Db::startTrans();
            try {
                $result = Db::table('company')->where('userId', $uId)->update(['license' => $picPath, 'confirmStatus' => 3]);
                Db::commit();
                return $result;
            } catch (Exception $e) {
                Db::rollback();
                $e->getMessage();
            }
        } else {
            return 100;
        }
    }

    public function checkCompany($id)
    {
        Db::startTrans();
        try {
            $result = Db::name('company')->where('userId', $id)->find();
            if (isset($result)) {
                Db::commit();
                return json($result);
            } else {
                Db::name('company')->where('userId', $id)->insert(['userId' => $id]);
                $insertId = Db::name('company')->getLastInsID();
                Db::commit();
                return $insertId;
            }
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function addLogo($userId, $uId)
    {
        $filepath = 'static/logo/';
        $filename = $userId . time() . strstr($_FILES['file']['name'], '.');
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath . $filename)) {
            // 将图片路径写进数据库并返回
            $picPath = 'http://tp5.com/' . $filepath . $filename;
            Db::startTrans();
            try {
                Db::table('company')->where('userId', $uId)->update(['logo' => $picPath,]);
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

    public function addData($id)
    {
        Db::startTrans();
        try {
            $result = Db::name('company')->where('userId', $id)->update($_POST);
            return $result;
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function addFounderImg($userId, $uId)
    {
        Db::startTrans();
        try {
            $founderId = Db::name('founder')->where('userId', $uId)->field('id')->find();
            $founderId = $founderId['id'];
            if (!isset($founderId)) {
                Db::name('founder')->insert(['userId' => $uId]);
                $founderId = Db::name('founder')->getLastInsID();
            }
            $res = Db::name('company')->where('userId', $uId)->where('founderId', $founderId)->find();
            if (!isset($res)) {
                Db::name('company')->where('userId', $uId)->update(['founderId' => $founderId]);
            }
            $filepath = 'static/founder/';
            $filename = $userId . time() . strstr($_FILES['file']['name'], '.');
            if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath . $filename)) {
                // 将图片路径写进数据库并返回
                $picPath = 'http://tp5.com/' . $filepath . $filename;

                Db::table('founder')->where('userId', $uId)->update(['headImg' => $picPath,]);
                Db::commit();
                return $picPath;
            } else {
                return 100;
            }
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function addFounderInfo($uid)
    {
        Db::startTrans();
        try {
            $founderId = Db::name('founder')->where('userId', $uid)->field('id')->find();
            if (!isset($founderId)) {
                Db::name('founder')->insert(['userId' => $uid]);
                $founderId = Db::name('founder')->getLastInsID();
            } else {
                $founderId = $founderId['id'];
            }
            $res = Db::name('company')->where('userId', $uid)->where('founderId', $founderId)->find();
            if (!isset($res)) {
                Db::name('company')->where('userId', $uid)->update(['founderId' => $founderId]);
            }
            $result = Db::name('founder')->where('userId', $uid)->update($_POST);
            return json($result);
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function getAllData($uid)
    {
        Db::startTrans();
        try {
            $result = Db::name('company')->where('userId', $uid)->find();
            $founder = Db::name('founder')->where('userId', $uid)->field('name,instroduction,headImg')->find();
            $founderHeadImg = $founder['headImg'];
            $founder = ['name' => $founder['name'], 'instroduction' => $founder['instroduction']];
            $cityInfo = ['city'=>$result['city'],'field'=>$result['field'],'scale'=>$result['scale'],'url'=>$result['url']];
            $basic = ['logo' => $result['logo'], 'companyName' => $result['companyName'], 'easyname' => $result['easyname'], 'coreValues' => $result['coreValues']];
            $dev_statge = $result['dev_statge'];
            $introduce = $result['introduce'];
            $arr = ['founderHeadImg'=>$founderHeadImg,'founder'=>$founder,'cityInfo'=>$cityInfo,'basic'=>$basic,'dev_statge'=>$dev_statge,'introduce'=>$introduce];
            return json($arr);
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }
}