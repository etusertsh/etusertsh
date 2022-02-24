<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Booking extends BaseController
{
    public function index()
    {
        //
    }
    public function booking($action=null,$schoolid=null,$itemdate=null,$itemtime=null,$id=null){
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
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$actiontime = json_decode($this->nowparam['actiontime'], true);
		$actionplace = json_decode($this->nowparam['actionplace'], true);
		$id = intval(esc($id));
		$this->smarty->assign('pagetitle','參訪報');
		$this->smarty->assign('schoolid', $schoolid);
		$this->smarty->assign('actiondays', json_decode($this->nowparam['actiondays'], true));
        $this->smarty->assign('actiontime', json_decode($this->nowparam['actiontime'], true));
        $this->smarty->assign('actionplace', json_decode($this->nowparam['actionplace'], true));
        return $this->smarty->display('admin/admin.tpl');
	}
}
