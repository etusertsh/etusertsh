<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Smarty\Smarty;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;

class Admin extends BaseController
{
	protected $session;
	protected $smarty;
	protected $param;
	protected $school;
	protected $user;
	protected $nowparam;
	protected $allschool;
	

	public function __construct() {
		$this->session = \Config\Services::session();	
		$this->smarty = new Smarty();
		$this->param = new ParamModel();
		$this->user = new UserModel();
		$this->school = new SchoolModel();

		$this->nowparam = $this->param->getParam();
		$this->allschool = $this->school->getAllSchool();
		$this->smarty->assign('nowparam', $this->nowparam);
		$this->smarty->assign('allschool', $this->allschool);
    }	
    public function index()
    {
        if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		$this->smarty->assign('pagetitle','管理');
		$this->smarty->assign('actiontime', json_decode($this->nowparam['actiontime'],true));
        return $this->smarty->display('admin/admin.tpl');
    }
	public function user($action=null,$id=null){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		$action = esc($action);
		$id = intval(esc($id));
		if($this->session->get('privilege')=='1'){
			$action = 'view';
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
					if($this->user->save($sdata)===false){
						$this->smarty->assign('msg',['type'=>'warning','text'=>'更新使用者發生錯誤！' . $this->user->error()['message']]);
					}else{
						$this->smarty->assign('msg',['type'=>'primary','text'=>'更新使用者成功！']);
					}
					$data = $this->user->getUserFromId($id);
					$func = 'user_view';
					$pagetitle = '管理|使用者|檢視';
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
			default:
				return redirect()->to(base_url('/admin'));
				break;
		}
		$this->smarty->assign('data', $data);
		$this->smarty->assign('func', $func);
		$this->smarty->assign('pagetitle', $pagetitle);
		return $this->smarty->display('admin/admin.tpl');
	}
}
