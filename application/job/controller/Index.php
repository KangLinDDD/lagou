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

    public function getValidJob()
    {
        return $this->job->getValidJob($this->companyId);
    }
    public function getJobById()
    {
        return $this->job->getJobById();
    }
    public function addViewTime()
    {
        return $this->job->addViewTime();
    }
    public function getType()
    {
        return $this->job->getType();
    }
}
