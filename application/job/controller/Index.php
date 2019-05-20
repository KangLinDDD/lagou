<?php
namespace app\job\controller;

use think\Controller;
use think\Request;
use app\job\model\Job;
use think\Cookie;
use think\Session;
class Index extends Controller
{
    public $uid;
    public $companyId;
    public $job;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->job = new Job();
        if (Cookie::has('user') && Session::has(Cookie::get('user'))){
            $this->uid = Session::get(Cookie::get('user'))['id'];
            $this->companyId = Session::get(Cookie::get('user'))['companyId'];
        }
    }

    public function getJob()
    {
        return $this->job->getJob($this->companyId);
    }
    public function getJobAndComById()
    {
        return $this->job->getJobAndComById();
    }
    public function addViewTime()
    {
        return $this->job->addViewTime();
    }
    public function getType()
    {
        return $this->job->getType();
    }
    public function changeStatus(){
        return $this->job->changeStatus();
    }
    public function getJobById()
    {
        if(isset($_POST['jobId'])){
            return $this->job->getJobById($_POST['jobId']);
        }else{
            return '';
        }
    }
    public function collect(){
        return $this->job->collect($this->uid);
    }
    public function getCollect(){
        if(isset($_POST['currentPage'])){
            return $this->job->getCollect($this->uid,$_POST['currentPage']);
        }
    }
    public function checkCollect(){
        return $this->job->checkCollect($this->uid);
    }
    public function cancleCollect(){
        if (isset($_POST['id'])){
            return $this->job->cancleCollect($_POST['id']);
        }
    }
}
