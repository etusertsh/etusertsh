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

    public function __construct() {
        $this->session = \Config\Services::session();	
		$this->smarty = new Smarty();
        $this->param = new ParamModel();
        $this->nowparam = $this->param->getParam();
        $this->smarty->assign('nowparam', $this->nowparam);
    }
    public function index()
    {
        return $this->smarty->display('index.tpl');
    }
}
