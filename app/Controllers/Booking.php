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
		$action = esc($action);
		$id = intval(esc($id));
		if($action == 'delete' && $id >0){
			$bookingdata = $this->booking->getBookingFromId($id);
			if($bookingdata['id']>0){
				$itemdate = $bookingdata['itemdate'];
				$itemdata = $this->items->getItemFromDate($itemdate);
				$this->booking->delete($id);
				$bookingsum = $this->booking->getSumFromDate($itemdate);
				$this->items->save(['id'=>$itemdata['id'], 'booking'=>$bookingsum['num'], 'remain'=>($itemdata['limitnum']-$bookingsum['num'])]);
				$this->smarty->assign('msg', ['type'=>'info', 'text'=>'填報項目已刪除，統計已更新！']);
			}
		}
		$data = $this->booking->getBookingFromSchoolid($schoolid);
		$this->smarty->assign('pagetitle','學校填報紀錄');
        $this->smarty->assign('func', 'status');
        $this->smarty->assign('data', $data);
		$this->smarty->assign('schoolid', $schoolid);
        return $this->smarty->display('admin/booking.tpl');
	}
	public function schoolstat(){
		if($this->session->get('privilege')<2){
			return redirect()->to(base_url());
		}
		$data = $this->booking->getSumBySchoolid();
		$this->smarty->assign('pagetitle','學校填報情形');
        $this->smarty->assign('func', 'schoolstat');
		$this->smarty->assign('data', $data);
        return $this->smarty->display('admin/booking.tpl');
	}
	public function datetimestat(){
		if($this->session->get('privilege')<2){
			return redirect()->to(base_url());
		}
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$sdata = esc($this->request->getPost());
		if(!empty($sdata['itemdate'])){		
			$data = $this->booking->getBookingFromDate($sdata['itemdate']);
		}
		$this->smarty->assign('pagetitle',$sdata['itemdate'] . '學校參訪人數表');
        $this->smarty->assign('func', 'datetimestat');
		$this->smarty->assign('actiondays', $actiondays);
		$this->smarty->assign('data', $data);
		$this->smarty->assign('itemdate', $sdata['itemdate']);
        return $this->smarty->display('admin/booking.tpl');
	}
	public function datetimenum(){
		if($this->session->get('privilege')<2){
			return redirect()->to(base_url());
		}
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$actiontime = json_decode($this->nowparam['actiontime'], true);
		$actionplace = json_decode($this->nowparam['actionplace'], true);
		$data = array();
		foreach($actiondays as $val){
			foreach($val['time'] as $val2){
				$data[$val['date']][$val2]  = $this->booking->getSumFromDateAndTime($val['date'], $val2);
			}
		}
		$rowitem = $this->items->getItemFromDateAndTime($val['date'], $val2);
		$this->smarty->assign('pagetitle','車次人數情形');
        $this->smarty->assign('func', 'datetimenum');
		$this->smarty->assign('actiondays', $actiondays);
        $this->smarty->assign('actiontime', $actiontime);
        $this->smarty->assign('actionplace', $actionplace);
		$this->smarty->assign('rowitem', $rowitem);
		$this->smarty->assign('data', $data);
        return $this->smarty->display('admin/booking.tpl');
	}
	public function update($schoolid=null){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		if($this->session->get('privilege')=='1'){
			$schoolid = $this->session->get('schoolid');
		}
		if($schoolid == ''){
			$schoolid = $this->session->get('schoolid');
		}
		$sdata = esc($this->request->getPost());
		if($sdata['schoolid'] != $schoolid){
			return redirect()->to(base_url());
		}
		$bookingdata = $this->booking->getBookingFromSchoolidAndDate($schoolid, $sdata['itemdate']);
		$itemdata = $this->items->getItemFromDate($sdata['itemdate']);
		if($bookingdata['id']>0){
			if($sdata['num']=='0'){
				$this->booking->delete($bookingdata['id']);
			}elseif($sdata['num']>0){
				if($sdata['num'] > $bookingdata['num']){
					if($itemdata['remain'] >= ($sdata['num']-$bookingdata['num'])){
						$this->booking->save(['id'=>$bookingdata['id'], 'num'=>$sdata['num']]);
					}
				}else{
					$this->booking->save(['id'=>$bookingdata['id'], 'num'=>$sdata['num']]);
				}
			}
		}else{
			if($sdata['num']>0){
				if($itemdata['remain'] >= $sdata['num']){
					$this->booking->save($sdata);
				}
			}
		}
		$bookingsum = $this->booking->getSumFromDate($sdata['itemdate']);
		$this->items->save(['id'=>$itemdata['id'], 'booking'=>$bookingsum['num'], 'remain'=>($itemdata['limitnum']-$bookingsum['num'])]);
		$data = $this->booking->getBookingFromSchoolid($schoolid);
		$this->smarty->assign('pagetitle','學校填報紀錄');
        $this->smarty->assign('func', 'status');
        $this->smarty->assign('data', $data);
		$this->smarty->assign('schoolid', $schoolid);
        return $this->smarty->display('admin/booking.tpl');
	}
}
