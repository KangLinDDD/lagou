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
            $result = Db::name('jianli')->where('userId',$id)->find();
            if(isset($result)){
                Db::commit();
                return json($result);
            }else{
                Db::name('jianli')->where('userId',$id)->insert(['userId'=>$id]);
                $insert = Db::name('jianli')->getLastInsID();
                Db::commit();
                return $insert;
            }
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
            $result = Db::name('project_experience')->where('jianId',$_POST['jianId'])->find();
            if (isset($result)){
                // 更新
                $update = Db::name('project_experience')->where('jianId',$_POST['jianId'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                $insert = Db::name('project_experience')->insert($_POST);
                Db::commit();
                return $insert;
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function updateEducation(){
        try{
            $result = Db::name('education')->where('jianId',$_POST['jianId'])->find();
            if (isset($result)){
                // 更新
                $update = Db::name('education')->where('jianId',$_POST['jianId'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                $insert = Db::name('education')->insert($_POST);
                Db::commit();
                return $insert;
            }
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function updateWorkExperience(){
        try{
            $result = Db::name('work_experience')->where('jianId',$_POST['jianId'])->find();
            if (isset($result)){
                // 更新
                $update = Db::name('work_experience')->where('jianId',$_POST['jianId'])->update($_POST);
                Db::commit();
                return $update;
            }else{
                // 插入
                $insert = Db::name('work_experience')->insert($_POST);
                Db::commit();
                return $insert;
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
            $work_experience = Db::name('work_experience')->where('jianId',$result['id'])->field('jobName,startTime,endTime,companyName')->select();
            $project_experience = Db::name('project_experience')->where('jianId',$result['id'])->field('projectName,job,startTime,endTime,describe')->select();
            $education = Db::name('education')->where('jianId',$result['id'])->field('schoolName,education,majorName,startYear,endYear')->select();
            $self_describe = $result['self_describe'];
            $works = Db::name('opus')->where('jianId',$result['id'])->field('url,works_describe')->find();
            $arr = array('expectInfo'=>$expectInfo,'work_experience'=>$work_experience,'project_experience'=>$project_experience,'education'=>$education,'self_describe'=>$self_describe,'works'=>$works);
            return json($arr);
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
}