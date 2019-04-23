<?php

namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\indexModel;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->getIndex = new indexModel();
    }

    public function index()
    {
        return $this->getIndex->getJobList();
    }

    public function hotJobs()
    {
        return $this->getIndex->getHotJobs();
    }

    public function newJobs()
    {
        return $this->getIndex->getNewJobs();
    }
    public function hotSearch(){
        return $this->getIndex->getHotSearch();
    }
}
