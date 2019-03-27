<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return 'nihaoa';
    }
    public function hello($name='hello world',$city='bejing')
    {
        return $name.$city;
    }
}
