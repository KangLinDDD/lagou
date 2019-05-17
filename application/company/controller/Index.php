<?php
namespace app\company\controller;

use app\company\model\Company;
use think\Controller;
use think\Cookie;
use think\Request;
use think\Session;

class Index extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->company = new Company();
        if (Cookie::has('user') && Session::has(Cookie::get('user'))){
            $this->uid = Session::get(Cookie::get('user'))['id'];
            $this->companyId = Session::get(Cookie::get('user'))['companyId'];
        }
    }

    public function confirm()
    {
        if (isset($_FILES['file'])) {
            return $this->company->confirm(Cookie::get('user'),$this->uid);
        } else {
            return 0;
        }
    }
    public function checkCompany(){
        return $this->company->checkCompany($this->uid);
    }
    public function addLogo(){
        if(isset($_FILES['file'])){
            return $this->company->addLogo(Cookie::get('user'),$this->uid);
        }
    }
    public function getCompanyInfo(){
        return $this->company->getCompanyInfo($this->uid);
    }
    public function addData(){
        return $this->company->addData($this->uid);
    }
    public function addFounderImg(){
        if(isset($_FILES['file'])){
            return $this->company->addFounderImg(Cookie::get('user'),$this->uid);
        }
    }
    public function addFounderInfo(){
        return $this->company->addFounderInfo($this->uid);
    }
    public function getAllData(){
        return $this->company->getAllData($this->uid);
    }
    public function addProduct(){
        return $this->company->addProduct($this->uid);
    }
    public function addProductImg(){
        if(isset($_FILES['file'])){
            return $this->company->addProductImg(Cookie::get('user'),$this->uid);
        }
    }
    public function createJob(){
        return $this->company->createJob($this->companyId);
    }
}
