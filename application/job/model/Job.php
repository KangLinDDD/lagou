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
    public function getJob($companyId)
    {
        Db::startTrans();
        try {
            $result = Db::name('job')->where('companyId', $companyId)->where($_POST['fields'])->paginate(10, false, [
                'page' => $_POST['currentPage']
            ]);
            return json($result);
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function getJobById($jobId)
    {
        Db::startTrans();
        try {
            $result = Db::name('job')->where('jobId', $jobId)->find();
            return json($result);
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function getJobAndComById()
    {
        Db::startTrans();
        try {
            $result = Db::name('job')->join('company', 'job.companyId=company.companyId')->where('jobId', $_POST['jobId'])->field('jobName,companyName,easyname,job.city,position,experience,education,nature,advantage,updatetime,min_salary,max_salary,describe,company.companyId,easyname,logo,field,scale,url,dev_statge,confirmStatus')->find();
            return json($result);
        } catch (Exception $e) {
            Db::rollback();
        }
    }

    public function getCompanyByJobId()
    {
    }

    public function addViewTime()
    {
        Db::startTrans();
        try {
            $result = Db::name('job')->where('jobId', $_POST['jobId'])->setInc('viewtimes', 1);
            Db::commit();
            return $result;
        } catch (Exception $e) {
            Db::rollback();
        }
    }

    public function getType()
    {
        Db::startTrans();
        try {
            $arr = array();
            $job_types = Db::name('job_types')->select();
            $arr['job_types'] = $job_types;
            foreach ($job_types as $key => $value) {
                $job_sorts = Db::name('job_sorts')->where('type_id', $value['id'])->select();
                $arr['job_types'][$key]['job_sorts'] = $job_sorts;
                foreach ($job_sorts as $sort => $sorts) {
                    $job_names = Db::name('job_names')->where('sort_id', $sorts['id'])->select();
                    $arr['job_types'][$key]['job_sorts'][$sort]['job_names'] = $job_names;
                }
            }
            Db::commit();
            return json($arr);
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function changeStatus()
    {
        Db::startTrans();
        try {
            $result = Db::name('job')->where('jobId', $_POST['jobId'])->update(['status' => $_POST['status']]);
            Db::commit();
            return $result;
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }

    public function collect($uid)
    {
        Db::startTrans();
        try {
            $result = Db::name('collect')->insert(['jobId' => $_POST['jobId'], 'userId' => $uid]);
            Db::commit();
            return $result;
        } catch (Exception $e) {
            Db::rollback();
            $e->getMessage();
        }
    }
    public  function checkCollect($uid){
        try{
            $check=Db::name('collect')->where('jobId',$_POST['jobId'])->where('userId',$uid)->find();
            return json($check);
        }catch(Exception $e){
            $e->getMessage();
        }
    }

    public function getCollect($uid,$currentPage){
        try{
            $collect=Db::name('collect')->join('job','job.jobId=collect.jobId')->join('company','job.companyId=company.companyId')->where('collect.userId',$uid)->where('collect.status',0)->field('collect.id,collect.jobId,jobName,min_salary,max_salary,easyname,job.city,education,experience,advantage,job.updatetime,logo')->order('job.updatetime desc')->paginate(10, false, [
                'page' => $currentPage
            ]);
            return json($collect);
        }catch(Exception $e){
            $e->getMessage();
        }
    }
    public function cancleCollect($collectId){
        Db::startTrans();
        try{
            $result = Db::name('collect')->where('id',$collectId)->update(['status'=>1]);
            Db::commit();
            return json($result);
        }catch(Exception $e){
            Db::rollback();
            $e->getMessage();
        }
    }

}