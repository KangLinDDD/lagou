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
    public function checkJianLi($id){
        Db::startTrans();
        try{
            Db::name('jianli')->where('userId',$id)->insert(['userId'=>$id]);
            $insert = Db::name('jianli')->getLastInsID();
            Db::commit();
            return $insert;
        }catch (Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
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
            // 更新
            $arr = $_POST;
            $arr['userId'] = $id;
            $update = Db::name('jianli')->where('userId',$id)->update($arr);
            Db::commit();
            return $update;
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function addWorkShow(){
        try{
            $result = Db::name('opus')->where('jianId',$_POST['jianId'])->find();
            if (isset($result)){
                // 更新
                $update = Db::name('opus')->where('jianId',$_POST['jianId'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                $insert = Db::name('opus')->insert($_POST);
                Db::commit();
                return $insert;
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function updateProject(){
        try{
            if (isset($_POST['id'])){
                // 更新
                $update = Db::name('project_experience')->where('id',$_POST['id'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                Db::name('project_experience')->insert($_POST);
                $insertId = Db::name('project_experience')->getLastInsID();
                $arr = array();
                $arr['id']=$insertId;
                Db::commit();
                return json($arr);
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function updateEducation(){
        try{
            if (isset($_POST['id'])){
                // 更新
                $update = Db::name('education')->where('id',$_POST['id'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                Db::name('education')->insert($_POST);
                $insertId = Db::name('education')->getLastInsID();
                Db::commit();
                $arr = array();
                $arr['id']=$insertId;
                return json($arr);
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function updateWorkExperience(){
        try{
            if (isset($_POST['id'])){
                // 更新
                $update = Db::name('work_experience')->where('id',$_POST['id'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                Db::name('work_experience')->insert($_POST);
                $insertId = Db::name('work_experience')->getLastInsID();
                $arr = array();
                $arr['id']=$insertId;
                Db::commit();
                return json($arr);
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function getJianLi($userId){
        Db::startTrans();
        try{
            $result = Db::name('jianli')->where('userId',$userId)->find();
            $expectInfo = ['expectCity'=>$result['expectCity'],'nature'=>$result['nature'],'expectJob'=>$result['expectJob'],'min_salary'=>$result['min_salary'],'max_salary'=>$result['max_salary']];
            $work_experience = Db::name('work_experience')->where('jianId',$result['id'])->field('id,jobName,startTime,endTime,companyName')->order('startTime asc')->select();
            $project_experience = Db::name('project_experience')->where('jianId',$result['id'])->field('id,projectName,job,startTime,endTime,describe')->order('startTime asc')->select();
            $education = Db::name('education')->where('jianId',$result['id'])->field('id,schoolName,education,majorName,startTime,endTime')->order('startTime asc')->select();
            $self_describe = $result['self_describe'];
            $works = Db::name('opus')->where('jianId',$result['id'])->field('url,works_describe')->find();
            $arr = array('expectInfo'=>$expectInfo,'work_experience'=>$work_experience,'project_experience'=>$project_experience,'education'=>$education,'self_describe'=>$self_describe,'works'=>$works);
            return json($arr);
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function delete(){
        Db::startTrans();
        try{
            $result = Db::name($_POST['name'])->where('id',$_POST['id'])->delete();
            Db::commit();
            return $result;
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function delivery($uid){
        Db::startTrans();
        try{
            $jianId=Db::name('jianli')->where('userId',$uid)->field('id')->find();
            $search = Db::name('delivery')->where('jobId',$_POST['jobId'])->where('jianId',$jianId['id'])->find();
            if(count($search)!==0){
                return 2;
            }else{
                $result = Db::name('delivery')->insert(['jianId'=>$jianId['id'],'userId'=>$uid,'jobId'=>$_POST['jobId']]);
                Db::commit();
                return $result;
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
}