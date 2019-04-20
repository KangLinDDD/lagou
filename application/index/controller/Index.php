<?php

namespace app\index\controller;
use think\Controller;
//use app\common\controller\Common;
use think\Request;
use app\index\model\lists;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->lists = new lists();
    }

    public function index()
    {
        return $this->lists->getJobList();
    }

    public function hotJobs()
    {
        return $this->lists->getHotJobs();
    }

    public function newJobs()
    {
        return $this->lists->getNewJobs();
    }
    public function hotSearch(){
        return $this->lists->getHotSearch();
    }
}
