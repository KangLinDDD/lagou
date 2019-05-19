<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/18 0018
 * Time: 22:20
 */

namespace app\job\model;


use think\Db;
use think\Exception;
use think\Model;

class Job extends Model
{
    public function getValidJob($companyId){
        Db::startTrans();
        try{
            $result=Db::name('job')->where('companyId',$companyId)->paginate(10, false, [
                'page' => $_POST['currentPage']
            ]);
            return json($result);
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
    public function getJobById(){
        Db::startTrans();
        try{
            $result = Db::name('job')->join('company','job.companyId=company.companyId')->where('jobId',$_POST['jobId'])->field('jobName,companyName,easyname,job.city,position,experience,education,nature,advantage,updatetime,min_salary,max_salary,describe')->find();
            return json($result);
        }catch(Exception $e){
            Db::rollback();
        }
    }
    public function addViewTime(){
        Db::startTrans();
        try{
            $result = Db::name('job')->where('jobId',$_POST['jobId'])->setInc('viewtimes',1);
            Db::commit();
            return $result;
        }catch(Exception $e){
            Db::rollback();
        }
    }
    public function getType(){
        Db::startTrans();
        try{
            $arr=array();
            $job_types = Db::name('job_types')->select();
            $arr['job_types']=$job_types;
            foreach ($job_types as $key => $value){
                $job_sorts=Db::name('job_sorts')->where('type_id',$value['id'])->select();
                $arr['job_types'][$key]['job_sorts']=$job_sorts;
                foreach ($job_sorts as $sort => $sorts){
                    $job_names=Db::name('job_names')->where('sort_id',$sorts['id'])->select();
                    $arr['job_types'][$key]['job_sorts'][$sort]['job_names']=$job_names;
                }
            }
            Db::commit();
            return json($arr);
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }
}