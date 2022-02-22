<?php

namespace App\Controllers;
use App\Smarty\Smarty;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;

class Home extends BaseController
{
    protected $smarty;
    protected $session;
    protected $param;
    protected $nowparam;
    protected $school;

    public function __construct() {
        $this->session = \Config\Services::session();	
		$this->smarty = new Smarty();
        $this->param = new ParamModel();
        $this->nowparam = $this->param->getParam();
        $this->school = new SchoolModel();
        $this->smarty->assign('nowparam', $this->nowparam);
        $this->smarty->assign('allschool', $this->school->getAllSchool());
    }
    public function index()
    {
        $this->smarty->assign('pagetitle', '首頁');
        $this->smarty->assign('actiondays', json_decode($this->nowparam['actiondays'], true));
        $this->smarty->assign('actiontime', json_decode($this->nowparam['actiontime'], true));
        $this->smarty->assign('actionplace', json_decode($this->nowparam['actionplace'], true));
        return $this->smarty->display('index.tpl');
    }
}
