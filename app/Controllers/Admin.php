<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Smarty\Smarty;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;
use App\Models\ItemModel;
use App\Models\LimitModel;

class Admin extends BaseController
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

		$this->nowparam = $this->param->getParam();
		$this->allschool = $this->school->getAllSchool();
		$this->smarty->assign('nowparam', $this->nowparam);
		$this->smarty->assign('allschool', $this->allschool);
		$this->smarty->assign('privilegetext', $this->param->params);
    }	
    public function index()
    {
        if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}

		$schoolid = $this->session->get('schoolid');
		$limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $schoolid)[0];
		$this->smarty->assign('pagetitle','管理|填報');
		$this->smarty->assign('schoolid', $schoolid);
		$this->smarty->assign('limitdata', $limitdata);
		$this->smarty->assign('actiondays', json_decode($this->nowparam['actiondays'], true));
        $this->smarty->assign('actiontime', json_decode($this->nowparam['actiontime'], true));
        $this->smarty->assign('actionplace', json_decode($this->nowparam['actionplace'], true));
        return $this->smarty->display('admin/admin.tpl');
    }
	
	public function user($action=null,$id=null){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		$action = esc($action);
		$id = intval(esc($id));
		if($this->session->get('privilege')=='1'){
			if(!in_array($action, array('view','update'))){
				$action = 'view';
			}
			$id = $this->session->get('user_id');
		}
		switch($action){
			case 'list':
				$data = $this->user->getAllUser();
				$func = 'user_list';
				$pagetitle = '管理|使用者|列表';
				break;
			case 'view':
				if($id > 0){
					$data = $this->user->getUserFromId($id);
					$func = 'user_view';
					$pagetitle = '管理|使用者|檢視';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'update':
				if($id>0){
					$sdata = esc($this->request->getPost());
					//if($sdata['email'] != ''){
						if($this->user->save($sdata)===false){
							$this->smarty->assign('msg',['type'=>'warning','text'=>'更新使用者發生錯誤！' . $this->user->error()['message']]);
						}else{
							$this->smarty->assign('msg',['type'=>'primary','text'=>'更新使用者成功！']);
						}
						$data = $this->user->getUserFromId($id);
						$func = 'user_view';
						$pagetitle = '管理|使用者|檢視';
					//}else{
					//	return redirect()->to(base_url('/admin'));
					//}
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'delete':
				if($id>0){
					if($this->user->delete($id)===falae){
						$this->smarty->assign('msg',['type'=>'warning','text'=>'刪除使用者發生錯誤！' . $this->user->error()['message']]);
					}else{
						$this->smarty->assign('msg',['type'=>'primary','text'=>'刪除使用者成功！']);
					}
				}else{
					return redirect()->to(base_url('/admin'));
				}
				$data = $this->user->getAllUser();
				$func = 'user_list';
				$pagetitle = '管理|使用者|列表';
				break;
			case 'addnew':
				$sdata = esc($this->request->getPost());
				$sdata['name'] = strtolower(explode('@', $sdata['email'])[0]);
				$sdata['source'] = strtolower(end(explode('@', $sdata['email'])))=='gm.kl.edu.tw' ? 'gm.kl.edu.tw' : 'manual';
				if($sdata['source'] == 'manual'){
					$sdata['pw'] = md5($this->allschool[$sdata['schoolid']]['eduid']);
				}
				$sdata['privilege'] = '1';
				$sdata['status'] = '1';
				if($this->user->save($sdata)===false){
					$this->smarty->assign('msg',['type'=>'warning','text'=>'新增使用者發生錯誤！' . $this->user->error()['message']]);
				}else{
					$this->smarty->assign('msg',['type'=>'primary', 'text'=>'新增使用者成功！']);
				}
				$data = $this->user->getAllUser();
				$func = 'user_list';
				$pagetitle = '管理|使用者|列表';
				break;
			case 'setprivilege_0':
				if($id>0){
					$sdata = ['id'=>$id, 'privilege'=>'0'];
					if($this->user->save($sdata)===false){
						$this->smarty->assign('msg',['type'=>'warning','text'=>'變更使用者權限發生錯誤！' . $this->user->error()['message']]);
					}else{
						$this->smarty->assign('msg', ['type'=>'primary','text'=>'使用者權限變更為「未啟用」！']);
					}
					$data = $this->user->getUserFromId($id);
					$func = 'user_view';
					$pagetitle = '管理|使用者|檢視';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'setprivilege_1':
				if($id>0){
					$sdata = ['id'=>$id, 'privilege'=>'1'];
					if($this->user->save($sdata)===false){
						$this->smarty->assign('msg',['type'=>'warning','text'=>'變更使用者權限發生錯誤！' . $this->user->error()['message']]);
					}else{
						$this->smarty->assign('msg', ['type'=>'primary','text'=>'使用者權限變更為「學校承辦」！']);
					}
					$data = $this->user->getUserFromId($id);
					$func = 'user_view';
					$pagetitle = '管理|使用者|檢視';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'setprivilege_2':
				if($id>0){
					$sdata = ['id'=>$id, 'privilege'=>'2'];
					if($this->user->save($sdata)===false){
						$this->smarty->assign('msg',['type'=>'warning','text'=>'變更使用者權限發生錯誤！' . $this->user->error()['message']]);
					}else{
						$this->smarty->assign('msg', ['type'=>'primary','text'=>'使用者權限變更為「教育行政」！']);
					}
					$data = $this->user->getUserFromId($id);
					$func = 'user_view';
					$pagetitle = '管理|使用者|檢視';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'setprivilege_3':
				if($id>0){
					$sdata = ['id'=>$id, 'privilege'=>'3'];
					if($this->user->save($sdata)===false){
						$this->smarty->assign('msg',['type'=>'warning','text'=>'變更使用者權限發生錯誤！' . $this->user->error()['message']]);
					}else{
						$this->smarty->assign('msg', ['type'=>'primary','text'=>'使用者權限變更為「系統管理」！']);
					}
					$data = $this->user->getUserFromId($id);
					$func = 'user_view';
					$pagetitle = '管理|使用者|檢視';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			default:
				return redirect()->to(base_url('/admin'));
				break;
		}
		$this->smarty->assign('data', $data);
		$this->smarty->assign('func', $func);
		$this->smarty->assign('pagetitle', $pagetitle);
		return $this->smarty->display('admin/admin.tpl');
	}
	public function school($action=null, $id=null){
		if($this->session->get('privilege')<2){
			return redirect()->to(base_url());
		}		
		$action = esc($action);
		$id = intval(esc($id));
		switch($action){
			case 'list':
				$func = 'school_list';
				$data = $this->school->getFullSchool();
				foreach($data as $key=>$tmp){
					if($tmp['available']=='1'){
						$limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $tmp['schoolid']);
						if($limitdata[0]['id']>0){
							$data[$key]['limitdata'] = $limitdata[0];
						}else{
							$sdata = array('year'=>$this->nowparam['actionyear'], 'schoolid'=>$tmp['schoolid'],'limitnum'=>$tmp['cars'],'userd'=>'0', 'remain'=>$tmp['cars']);
							$this->schoollimit->save($sdata);
							$newid = $this->schoollimit->insertID();
							$sdata['id']=$newid;
							$data[$key]['limitdata'] = $sdata;
						}
					}
				}
				$pagetitle = '管理|學校|列表';
				break;
			case 'update':
				break;
			default:
				return redirect()->to(base_url('/admin'));
				break;
		}
		$this->smarty->assign('data', $data);
		$this->smarty->assign('func', $func);
		$this->smarty->assign('pagetitle', $pagetitle);
		return $this->smarty->display('admin/admin.tpl');
	}
	public function param($action=null, $id=null){
		if($this->session->get('privilege')<2){
			return redirect()->to(base_url());
		}
		$action = esc($action);
		$id = intval(esc($id));
		switch($action){
			case 'list':
				$data = $this->param->getParam();
				$func = 'param_list';
				$pagetitle = '管理|系統參數';
				break;
			case 'update1':
				$sdata = esc($this->request->getPost());
				foreach($sdata as $key=>$val){
					$this->param->set(['value'=>$val])->where('name', $key)->update();
				}
				$this->smarty->assign('msg',['type'=>'primary','text'=>'系統參數已更新！']);
				$data = $this->param->getParam();
				$this->nowparam = $data;
				$this->smarty->assign('nowparam', $this->nowparam);
				$func = 'param_list';
				$pagetitle = '管理|系統參數';
				break;
			case 'updateactiondays':
				$sdata = $this->request->getPost();
				if($sdata['actiondays'] != ''){
					$this->param->set(['value'=>$sdata['actiondays']])->where('name','actiondays')->update();
					$this->smarty->assign('msg',['type'=>'primary','text'=>'系統參數已更新！']);
					$data = $this->param->getParam();
					$this->nowparam = $data;
					$this->smarty->assign('nowparam', $this->nowparam);
					$func = 'param_list';
					$pagetitle = '管理|系統參數';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'updateactiontime':
				$sdata = $this->request->getPost();
				if($sdata['actiontime'] != ''){
					$this->param->set(['value'=>$sdata['actiontime']])->where('name','actiontime')->update();
					$this->smarty->assign('msg',['type'=>'primary','text'=>'系統參數已更新！']);
					$data = $this->param->getParam();
					$this->nowparam = $data;
					$this->smarty->assign('nowparam', $this->nowparam);
					$func = 'param_list';
					$pagetitle = '管理|系統參數';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			case 'updateactionplace':
				$sdata = $this->request->getPost();
				if($sdata['actionplace'] != ''){
					$this->param->set(['value'=>$sdata['actionplace']])->where('name','actionplace')->update();
					$this->smarty->assign('msg',['type'=>'primary','text'=>'系統參數已更新！']);
					$data = $this->param->getParam();
					$this->nowparam = $data;
					$this->smarty->assign('nowparam', $this->nowparam);
					$func = 'param_list';
					$pagetitle = '管理|系統參數';
				}else{
					return redirect()->to(base_url('/admin'));
				}
				break;
			default:
				return redirect()->to(base_url('/admin'));
				break;
		}
		$this->smarty->assign('data', $data);
		$this->smarty->assign('func', $func);
		$this->smarty->assign('actiondays', json_decode($data['actiondays'], true));
        $this->smarty->assign('actiontime', json_decode($data['actiontime'], true));
        $this->smarty->assign('actionplace', json_decode($data['actionplace'], true));
		$this->smarty->assign('pagetitle', $pagetitle);
		return $this->smarty->display('admin/admin.tpl');
	}
	public function itemmanager($action=null,$itemdate=null,$itemtime=null, $id=null){
		if($this->session->get('privilege')<2){
			return redirect()->to(base_url());
		}
		$this->items = new ItemModel();
		$action = esc($action);
		$itemdate = esc($itemdate);
		$itemtime = esc($itemtime);
		$actiondays = json_decode($this->nowparam['actiondays'], true);
		$actiontime = json_decode($this->nowparam['actiontime'], true);
		$actionplace = json_decode($this->nowparam['actionplace'], true);
		$id = intval(esc($id));
		if($action == ''){
			$action = 'list';
		}
		if($action == 'batchadd'){
			$tmp = array();
			$addstr = esc($this->request->getPost())['addstr'];
			$tmp = explode(' ', $addstr);
			foreach($tmp as $addcode){
				$old = $this->items->getItemFromDateAndTimeAndCode($itemdate,$itemtime,$addcode);
				if(!$old[0]['id']>0){
					$sdata = ['itemdate'=>$itemdate,'itemtime'=>$itemtime,'itemcode'=>$addcode,'subitem'=>$addcode, 'booking'=>0];
					if(strlen($addcode)>1){
						$code1 = substr($addcode,0,1);
						$code2 = substr($addcode,1,1);
						$sdata['itemtype'] = 'M';
						$sdata['itemplace'] = $actionplace[$code1]['name'] . '+' . $actionplace[$code2]['name'];
						$sdata['description'] = $actionplace[$code1]['description'] . '+' . $actionplace[$code2]['description'];
						$sdata['limitnum'] = min($actionplace[$code1]['limit'], $actionplace[$code2]['limit']);
						//print_r($sdata);
					}else{
						$sdata['itemtype'] = 'S';
						$sdata['itemplace'] = $actionplace[$addcode]['name'];
						$sdata['description'] = $actionplace[$addcode]['description'];
						$sdata['limitnum'] = $actionplace[$addcode]['limit'];
					}
					$this->items->save($sdata);
				}
			}
		}
		if($action == 'delete'){
			if($id>0){
				$this->items->delete($id);
			}
		}
		
		if($itemdate == '' || $itemtime == ''){
			$func = 'item';
			$pagetitle = '管理|參訪場館場次';
		}else{
			$func = 'item_list';
			$pagetitle = '管理|參訪場館場次|' . $itemdate .'|' . $actiontime[$itemtime]['title'];
			$data = $this->items->getItemFromDateAndTime($itemdate, $itemtime);
		}
		
		$this->smarty->assign('data', $data);
		$this->smarty->assign('func', $func);
		$this->smarty->assign('itemdate', $itemdate);
		$this->smarty->assign('itemtime', $itemtime);
		$this->smarty->assign('actiondays', $actiondays);
        $this->smarty->assign('actiontime', $actiontime);
        $this->smarty->assign('actionplace', $actionplace);
		$this->smarty->assign('pagetitle', $pagetitle);
		return $this->smarty->display('admin/admin.tpl');
	}
}
