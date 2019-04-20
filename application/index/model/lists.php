<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/10 0010
 * Time: 20:06
 */

namespace app\index\model;
use think\Session;
use think\Cookie;
use think\Model;
use think\Db;
use think\Exception;
class lists extends Model
{
//     获取主页左侧列表
    public function getJobList()
    {
        Db::startTrans();
        try {
            $result = Db::name('job_types')->select();
            for ($row = 0; $row < count($result); $row++) {
                $tops = Db::name('jobNames')->where('type_id', $result[$row]['id'])->order('viewtimes desc')->limit($result[$row]['viewNums'])->column('name');
                $result[$row]['tops'] = $tops;
                $sorts = Db::name('job_sorts')->where('type_id', $result[$row]['id'])->field('id,name')->select();
                $result[$row]['sorts'] = $sorts;
                foreach ($result[$row]['sorts'] as $index => $val) {
                    $names = Db::name('job_names')->where('sort_id', $val['id'])->column('name');
                    $result[$row]['sorts'][$index]['child'] = $names;
                }
            }
            return json($result);
        } catch (Exception $e) {
            DB::rollback();
        }
    }

//  获取主页热门职位
    public function getHotJobs()
    {
        try {
            $result = Db::table('job')->join('company', 'job.companyId = company.companyId')->field('jobId,jobName,company.companyId,companyName,min_salary,max_salary,experience,education,advantage,job.city,updatetime,welfare,field,founder,scale,dev_statge')->order('viewtimes desc')->limit(15)->select();
            return json($result);
        } catch (Exception $e) {

        }
    }

    public function getNewJobs()
    {
        try {
            $result = Db::table('job')->join('company', 'job.companyId = company.companyId')->field('jobId,jobName,company.companyId,companyName,min_salary,max_salary,experience,education,advantage,job.city,updatetime,welfare,field,founder,scale,dev_statge')->order('updatetime desc')->limit(15)->select();
            return json($result);
        } catch (Exception $e) {

        }
    }
    public function getHotSearch()
    {
        try {
            $result = Db::table('search')->field('id,searchName')->order('searchTimes desc')->limit(10)->select();
            return json($result);
        } catch (Exception $e) {
        }
    }
}