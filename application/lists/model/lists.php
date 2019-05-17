<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/21 0021
 * Time: 15:36
 */

namespace app\lists\model;


use think\Model;
use think\Db;
use think\Exception;

class lists extends Model
{
//    获取兼职信息
    public function getJobLists($field, $currentPage)
    {
        $field = json_encode($field);
        $field = json_decode($field, true);
        if (isset($field['jobName'])) {
            $field['jobName'] = array('like', '%' . $field['jobName'] . '%');
        }
        if (isset($field['companyName'])) {
            $field['companyName'] = array('like', '%' . $field['companyName'] . '%');
        }
        if (isset($field['min_salary'])) {
            $field['min_salary'] = array('egt', $field['min_salary']);
        }
        if (isset($field['updatetime'])) {
            $field['updatetime'] = array('egt', date("Y-m-d H:i:s",$field['updatetime']/1000));
        }
        if (isset($field['max_salary'])) {
            $field['max_salary'] = array('elt', $field['max_salary']);
        }
        if (isset($field['city'])) {
            $field['company.city'] = array('like', '%'.$field['city'].'%');
            unset($field['city']);
        }
        try {
            $result = Db::table('job')->join('company', 'job.companyId = company.companyId')->field('jobId,jobName,company.companyId,companyName,min_salary,max_salary,experience,education,advantage,company.city,updatetime,welfare,field,founder,scale,dev_statge')->order('viewtimes desc')->where($field)->paginate(10, false, [
                'page' => $currentPage
            ]);
            return json($result);
        } catch (Exception $e) {

        }
    }

    public function getAllJobs($page)
    {
        try {
            $result = Db::table('job')->join('company', 'job.companyId = company.companyId')->field('jobId,jobName,company.companyId,companyName,min_salary,max_salary,experience,education,advantage,company.city,updatetime,welfare,field,founder,scale,dev_statge')->order('viewtimes desc')->limit($page, 10)->paginate(10, false, [
                'page' => $page
            ]);
            return json($result);
        } catch (Exception $e) {

        }
    }
}