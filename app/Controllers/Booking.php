<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Smarty\Smarty;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;
use App\Models\ItemModel;
use App\Models\LimitModel;

class Booking extends BaseController
{
    protected $session;
	protected $smarty;
	protected $param;
	protected $school;
	protected $user;
	protected $nowparam;
	protected $allschool;
	protected $items;
	protected $schoollimit;
    
    public function __construct() {
		$this->session = \Config\Services::session();	
		$this->smarty = new Smarty();
		$this->param = new ParamModel();
		$this->user = new UserModel();
		$this->school = new SchoolModel();
		$this->schoollimit = new LimitModel();
		$this->items = new ItemModel();

		$this->nowparam = $this->param->getParam();
		$this->allschool = $this->school->getAllSchool();
		$this->smarty->assign('nowparam', $this->nowparam);
		$this->smarty->assign('allschool', $this->allschool);
		$this->smarty->assign('privilegetext', $this->param->params);
    }
    public function index()
    {
        //
    }
    public function list($schoolid=null,$itemdate=null,$itemtime=null,$id=null){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		if($this->session->get('privilege')=='1'){
			$schoolid = $this->session->get('schoolid');
		}
		$action = esc($action);
		$itemdate = esc($itemdate);
		$itemtime = esc($itemtime);
		$schoolid = intval(esc($schoolid));
		if(empty($itemdate) || empty($itemtime) || empty($schoolid)){
			return redirect()->to(base_url('/admin'));
		}
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$actiontime = json_decode($this->nowparam['actiontime'], true);
		$actionplace = json_decode($this->nowparam['actionplace'], true);
		$id = intval(esc($id));
		$limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $schoolid)[0];
		$data = $this->items->getItemFromDateAndTime($itemdate, $itemtime);
		$this->smarty->assign('pagetitle','參訪填報');
        $this->smarty->assign('func', 'list');
        $this->smarty->assign('data', $data);
		$this->smarty->assign('limitdata', $limitdata);
		$this->smarty->assign('schoolid', $schoolid);
		$this->smarty->assign('actiondays', $actiondays);
        $this->smarty->assign('actiontime', $actiontime);
        $this->smarty->assign('actionplace', $actionplace);
		$this->smarty->assign('itemdate', $itemdate);
		$this->smarty->assign('itemtime', $itemtime);
        return $this->smarty->display('admin/booking.tpl');
	}
}
