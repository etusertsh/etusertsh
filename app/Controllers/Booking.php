<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Smarty\Smarty;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;
use App\Models\ItemModel;
use App\Models\LimitModel;
use App\Models\BookingModel;

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
	protected $booking;
    
    public function __construct() {
		$this->session = \Config\Services::session();	
		$this->smarty = new Smarty();
		$this->param = new ParamModel();
		$this->user = new UserModel();
		$this->school = new SchoolModel();
		$this->schoollimit = new LimitModel();
		$this->items = new ItemModel();
		$this->booking = new BookingModel();

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
		$this->smarty->assign('schoolbooking', $this->booking->getBookingFromSchoolidAndDateAndTime($schoolid, $itemdate, $itemtime));
        return $this->smarty->display('admin/booking.tpl');
	}
	public function status($schoolid=null, $action=null, $id=null){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		if($this->session->get('privilege')=='1'){
			$schoolid = $this->session->get('schoolid');
		}
		$schoolid = intval(esc($schoolid));
		$data = $this->booking->getBookingFromSchoolid($schoolid);
		foreach($data as $key=>$val){
			$data[$key]['itemplace'] = $this->items->getItemFromDateAndTimeAndCode($val['itemdate'],$val['itemtime'],$val['itemcode'])[0];
		}
		$limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $schoolid)[0];
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$actiontime = json_decode($this->nowparam['actiontime'], true);
		$actionplace = json_decode($this->nowparam['actionplace'], true);
		$id = intval(esc($id));
		$this->smarty->assign('pagetitle','學校填報紀錄');
        $this->smarty->assign('func', 'status');
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
	public function schoolstat(){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$actiontime = json_decode($this->nowparam['actiontime'], true);
		$actionplace = json_decode($this->nowparam['actionplace'], true);
		$limitdata = $this->schoollimit->getLimitFromYear($this->nowparam['actionyear']);
		$this->smarty->assign('pagetitle','學校填報情形');
        $this->smarty->assign('func', 'schoolstat');
		$this->smarty->assign('limitdata', $limitdata);
		$this->smarty->assign('actiondays', $actiondays);
        $this->smarty->assign('actiontime', $actiontime);
        $this->smarty->assign('actionplace', $actionplace);
        return $this->smarty->display('admin/booking.tpl');
	}
}
