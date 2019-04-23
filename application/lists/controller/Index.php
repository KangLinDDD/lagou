<?php
namespace app\lists\controller;

use think\Controller;
use think\Request;
use app\lists\model\lists;
class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->lists = new Lists();
    }

    public function getJob()
    {
        if(isset($_POST['fields'])&&isset($_POST['currentPage'])){
            return $this->lists->getJobLists($_POST['fields'],$_POST['currentPage']);
        }else{
            return $this->lists->getAllJobs($_POST['currentPage']);
        }
    }
    public function getCompany()
    {
        if(isset($_POST['fields'])&&isset($_POST['currentPage'])){
            return $this->lists->getJobLists($_POST['fields'],$_POST['currentPage']);
        }else{
            return $this->lists->getAllJobs($_POST['currentPage']);
        }
    }
}
