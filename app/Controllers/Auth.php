<?php
namespace App\Controllers;

use App\Smarty\Smarty;
use App\Oauth2\GoogleOauth;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;

class Auth extends BaseController {

	protected $googleauth;
	protected $session;
	protected $smarty;
	protected $param;
	protected $school;
	protected $user;
	protected $nowparam;
	

	public function __construct() {
		$this->googleauth = new GoogleOauth();
		$this->session = \Config\Services::session();	
		$this->smarty = new Smarty();
		$this->param = new ParamModel();
		$this->user = new UserModel();

		$this->nowparam = $this->param->getParam();
		$this->smarty->assign('nowparam', $this->nowparam);
    }	

	public function index(){
		
		$data['google_login_url']=$this->googleauth->getLoginUrl();
		$this->smarty->assign('data', $data);
		$this->smarty->assign('func', 'login');
		$this->smarty->assign('pagetitle','登入頁');
		return $this->smarty->display('auth.tpl');

	}

	public function oauth2callback(){
		$this->googleauth->setAccessToken();
		$google_data = $this->googleauth->getUserInfo();
		//$this->session->set('gdata', $google_data);
		$theuser=$this->user->getUserFromEmail($google_data['email']);
		if(count($theuser)>0){
			$session_data=array(
				'user_id'=>$theuser[0]['id'],
				'openid'=>$google_data['id'],
				'name'=>explode('@', $google_data['email'])[0],
				'realname'=>$theuser[0]['realname'],
				'email'=>$google_data['email'],
				'sess_logged_in'=>'1',
				'privilege'=>$theuser[0]['privilege'],
				'privilege_text'=>$this->param->getPrivilegeText($theuser[0]['privilege']),
				'schoolid'=>$theuser[0]['schoolid'],
				'status'=>$theuser[0]['status'],
				'profile_pic'=>$google_data['picture']
				);
			$update_data = array(
				'id'=>$theuser[0]['id'],
				'openid'=>$google_data['id'],
				'name'=>explode('@', $google_data['email'])[0],
				'source'=>$google_data['hd'],
				'profile_pic'=>$google_data['picture'],
				'sess_logged_in'=>'1'
			);

			$this->session->set($session_data);
			$this->session->set('isLoggedIn', true);
			$this->user->save($update_data);		
		}else{			
			if($nowparam['autoadduser']==true){
				$session_data=array(
					'openid'=>$google_data['id'],
					'name'=>explode('@', $google_data['email'])[0],
					'realname'=>$google_data['name'],
					'email'=>$google_data['email'],
					'source'=>$google_data['hd'],
					'profile_pic'=>$google_data['picture'],
					'sess_logged_in'=>'1',
					'privilege'=>'0',
					'status'=>'1'
					);
				$this->session->set($session_data);
				$this->session->set('isLoggedIn', true);
				$this->user->save($session_data);
				$newid = $this->user->insertID();
				$this->session->set('user_id', $newid);
			}else{
				$data['google_login_url']=$this->googleauth->getLoginUrl();
				$this->smarty->assign('data', $data);
				$this->smarty->assign('authurl', $data['google_login_url']);
				$this->smarty->assign('param', $this->nowparam);
				$this->smarty->assign('msg', ['type'=>'warning','text'=>'帳號不存在，本系統不提供帳號申請，請洽主辦單位。']);
				$this->smarty->assign('func', 'login');
				$this->smarty->assign('pagetitle','登入頁');
				return $this->smarty->display('auth.tpl');
			}
		}
		if($session_data['schoolid']==''){
			return redirect()->to(base_url('/auth/grant'));
		}else{
			return redirect()->to(base_url('/admin'));
		}
	}
	
	public function login(){
		$logindata = esc($this->request->getPost());
		if(empty($logindata['a']) || empty($logindata['b']) || empty($logindata['g-recaptcha-response'])){
			$data['google_login_url']=$this->googleauth->getLoginUrl();
			$this->smarty->assign('data', $data);
			$this->smarty->assign('param', $this->nowparam);
			$this->smarty->assign('msg', ['type'=>'warning','text'=>'帳號密碼及驗證有誤！']);
			$this->smarty->assign('func', 'login');
			$this->smarty->assign('pagetitle','登入頁');
			return $this->smarty->display('auth.tpl');
		}else{
			if(strtolower(end(explode('@', $logindata['a'])))=='gm.kl.edu.tw'){
				$data['google_login_url']=$this->googleauth->getLoginUrl();
				$this->smarty->assign('data', $data);
				$this->smarty->assign('param', $this->nowparam);
				$this->smarty->assign('msg', ['type'=>'warning','text'=>'gm.kl.edu.tw網域請以直接認證登入！']);
				$this->smarty->assign('func', 'login');
				return $this->smarty->display('auth.tpl');
			}else{
				if(!$this->recaptcha_auth($logindata['g-recaptcha-response'])){
					$data['google_login_url']=$this->googleauth->getLoginUrl();
					$this->smarty->assign('data', $data);
					$this->smarty->assign('param', $this->nowparam);
					$this->smarty->assign('msg',  ['type'=>'warning','text'=>'驗證未通過！']);
					$this->smarty->assign('func', 'login');
					return $this->smarty->display('auth.tpl');
				}else{
					$theuser=$this->user->checkLogin($logindata['a'], $logindata['b']);
					if(count($theuser)<1){
						$data['google_login_url']=$this->googleauth->getLoginUrl();
						$this->smarty->assign('data', $data);
						$this->smarty->assign('param', $this->nowparam);
						$this->smarty->assign('msg', ['type'=>'warning','text'=>'帳號密碼錯誤！']);
						$this->smarty->assign('func', 'login');
						return $this->smarty->display('auth.tpl');
					}else{
						$session_data=array(
							'user_id'=>$theuser[0]['id'],
							'openid'=>$theuser[0]['openid'],
							'name'=>$theuser[0]['name'],
							'realname'=>$theuser[0]['realname'],
							'email'=>$theuser[0]['email'],
							'source'=>$theuser[0]['source'],
							'profile_pic'=>$theuser[0]['profile_pic'],
							'sess_logged_in'=>'1',
							'privilege'=>$theuser[0]['privilege'],
							'schoolid'=>$theuser[0]['schoolid'],
							'status'=>$theuser[0]['status']
							);
						$this->session->set($session_data);
						$this->session->set('isLoggedIn', true);
						$update_data = array(
							'id'=>$theuser[0]['id'],
							'sess_logged_in'=>'1'
						);
						$this->user->save($update_data);

						$this->school = new SchoolModel();

						$usereduid = $this->school->getEduidFromSchoolid($theuser[0]['schoolid']);
						if(empty($usereduid)){
							return redirect()->to(base_url('/auth/logout'));
						}else{
							if(md5($usereduid)==$theuser[0]['pw']){
								return redirect()->to(base_url('/auth/noticepass'));
							}else{					
								return redirect()->to(base_url('/admin'));
							}
						}
					}
				}
			}
		}
	}

	public function logout(){
		if($this->user->UserLogout($this->session->get('user_id'))){
			$this->session->destroy();
			$this->session->remove('access_token');
			$session_data=array(
					'sess_logged_in'=>'0',
					'isLoggedIn'=>false
					);
			$this->session->set($session_data);
		}		
		return redirect()->to(base_url());
	}

	public function registration($action = null, $otpstr = null){
		$this->school= new SchoolModel();
		$sysinfo = new SysformModel();
		$usermodel = new UserModel();

		$action = empty($action) ? 'index' : $action;

		if($action == 'form'){			
			if($this->request->getPost()['toconfirm'] != '1'){
				$action = 'index';
				$this->smarty->assign('msg', '您未同意系統個資保護說明書！');
			}
		}elseif($action == 'add'){
			$data = esc($this->request->getPost());
			$captcha_response = $data['g-recaptcha-response'];
			if(empty($captcha_response)){
				$this->smarty->assign('msg', '未點選驗證！');
				$action = 'form';
			}else{
				if(!$this->recaptcha_auth($captcha_response)){
					$this->smarty->assign('msg', '驗證未通過！');
					$action = 'form';	
				}else{
					$tmp=$this->generalmodel->GetAllInfo('user','id',array('name'=>$data['name']));
					if(count($tmp)>0){
						$this->smarty->assign('msg', '帳號重覆了喔！');
						$action = 'form';
					}else{
						$tmp=$this->generalmodel->GetAllInfo('user','id',array('email'=>$data['email']));
						if(count($tmp)>0){
							$this->smarty->assign('msg', '電子郵件重覆了喔！');
							$action = 'form';
						}else{
							if(strtolower(end(explode('@', $data['email'])))=='gm.kl.edu.tw'){
								$this->smarty->assign('msg', '您所使用為 gm.kl.edu.tw 網域之電子郵件，請改以OPENID方式登入！');
								$action = 'form';
							}else{
								$data['privilege'] = '0';
								$data['status'] = '0';
								$data['otp'] = $this->otp();
								$data['pw'] = $data['otp'];
								$data['source'] = 'manual';
								$data['sess_logged_in'] = '0';
								if($usermodel->save($data)===false){
									$this->smarty->assign('msg', '註冊新用戶發生錯誤！' . $usermodel->error()['message']);
									$action = 'form';
								}else{
									$sysmessage = $sysinfo->getInfoFromName('confirm_mail');
									require_once APPPATH . 'ThirdParty/mail.func.php';
									if(mailfunc($data['email'], $data['realname'] . '('. $data['name'] .')', $sysmessage['title'], $sysmessage['value'] . '<a href="' . site_url('/auth/registration/confirm') . '/' . $data['otp'] . '">請點選認證連結</a>')){
										$this->smarty->assign('msg', '註冊完成，認證信已發送至您的信箱，請至認證信中進行後續帳號啟用程序！');
										$action = 'message';
									}else{
										$this->smarty->assign('msg', '認證信函發送錯誤！');
										$action = 'message';
									}
								}
							}
						}
					}
				}
			}
		}elseif($action == 'confirm'){
			if(empty($otpstr)){
				$action = 'message';
				$this->smarty->assign('msg', '認證信函錯誤！');				
			}else{
				$tmp=$this->generalmodel->GetAllInfo('user','id',array('otp'=>$otpstr));
				if(!count($tmp)>0){
					$action = 'message';
					$this->smarty->assign('msg', '認證連結不存在或者已過期！');
				}else{					
					$data=$tmp[0];
					$expired = strtotime($data['modifydate'] . ' +1 day');
					if($expired < time()){
						$action = 'message';
						$this->smarty->assign('msg', '認證連結已過期！');
					}else{
						$this->smarty->assign('msg', '連結期限： ' . date('Y-m-d H:i:s', $expired));
						$this->smarty->assign('data', $data);
					}
				}
			}
		}elseif($action == 'setpassword'){
			$data = esc($this->request->getPost());			
			if(empty($data['pw']) || empty($data['g-recaptcha-response']) || empty($data['name'])){
				$action = 'message';
				$this->smarty->assign('msg', '密碼未輸入或驗證錯誤！');				
			}else{
				if(!$this->recaptcha_auth($data['g-recaptcha-response'])){
					$action = 'message';
					$this->smarty->assign('msg', '驗證未通過！');
				}else{
					$tmp=$this->generalmodel->GetAllInfo('user','id',array('name'=>$data['name']));
					if(!count($tmp)>0){
						$action = 'message';
						$this->smarty->assign('msg', '使用者帳號錯誤！');
					}else{
						$savedata=array(
							'id'=>$tmp[0]['id'],
							'otp'=>null,
							'pw'=>md5($data['pw']),
							'privilege'=>'1',
							'status'=>'1'
						);
						if($usermodel->save($savedata)===false){
							$action = 'message';
							$this->smarty->assign('msg', '密碼重設錯誤！');
						}else{
							$action = 'message';
							$this->smarty->assign('msg', '密碼重設成功，請回登入頁以帳號密碼登入！');
						}
					}
				}
			}
		}elseif($action=='forgetpassword'){
			if($otpstr == 'done'){
				$data = esc($this->request->getPost());
				$captcha_response = $data['g-recaptcha-response'];
				if(empty($captcha_response)){
					$this->smarty->assign('msg', '未點選驗證！');					
				}else{
					if(!$this->recaptcha_auth($captcha_response)){
						$this->smarty->assign('msg', '驗證未通過！');
					}else{
						$tmp=$this->generalmodel->GetAllInfo('user','id',array('email'=>$data['email']));
						if(!count($tmp)>0){
							$this->smarty->assign('msg', '您輸入的電子郵件不存在！');
						}else{
							if(strtolower(end(explode('@', $data['email'])))=='gm.kl.edu.tw'){
								$this->smarty->assign('msg', '您所使用的電子郵件網域為gm.kl.edu.tw，請直接登入！');
							}else{
								$savedata = array(
									'id'=>$tmp[0]['id'],
									'otp'=>$this->otp()
								);
								if($usermodel->save($savedata)===false){
									$this->smarty->assign('msg', '密碼重設申請發生錯誤！' . $usermodel->error()['message']);
								}else{
									$sysmessage = $sysinfo->getInfoFromName('forgot_mail');
									require_once APPPATH . 'ThirdParty/mail.func.php';
									if(mailfunc($data['email'], $tmp[0]['realname'] . '('. $tmp[0]['name'] .')', $sysmessage['title'], $sysmessage['value'] . '<a href="' . site_url('/auth/registration/confirm') . '/' . $savedata['otp'] . '">請點選密碼連結</a>')){
										$this->smarty->assign('msg', '完成，密碼重設認䛠信函已發送至您的信箱，請至認證信中進行後續密碼重設啟用程序！');
										$action = 'message';
									}else{
										$this->smarty->assign('msg', '密碼重設認證信函發送錯誤！');
										$action = 'message';
									}
								}
							}
						}
					}
				}
			}
		}else{
			$action = 'index';
		}

		$this->smarty->assign('sysinfo', $sysinfo->getAllInfo());
		$this->smarty->assign('func', $action);
		$this->smarty->assign('allschool', $this->school->getAllSchool());
		$this->smarty->assign('param', $this->param->getParam());

		return $this->smarty->display('loginfunc.tpl');
	}

	public function grant(){
		$this->school= new SchoolModel();		
		$this->smarty->assign('allschool', $this->school->getAllSchool());
		$this->smarty->assign('param', $this->param->getParam());
		$this->smarty->assign('sub', 'grant');
		return $this->smarty->display('login.tpl');
	}

	public function togrant(){
		$request = \Config\Services::request();
		if($this->session->get('openid')==$request->getPost('useropenid')){
			if($newschoolid = $request->getPost('newschoolid')){
				$session_data=array(
					'schoolid'=>$newschoolid,
					'privilege'=>'1'
				);
				$this->session->set($session_data);
				$this->generalmodel->Manage('user',$session_data,array('openid'=>$this->session->get('openid')));
				return redirect()->to('/admin/dashboard');
			}			
		}		
		return redirect()->to(base_url());
	}

	public function noticepass(){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		$this->school = new SchoolModel();
		$this->smarty->assign('param', $this->nowparam);
		$this->smarty->assign('allschool', $this->school->getAllSchool());
		$this->smarty->assign('func', 'noticepass');
		return $this->smarty->display('auth.tpl');
	}

	public function noticeset(){
		if($this->session->get('privilege')<1){
			return redirect()->to(base_url());
		}
		$this->school = new SchoolModel();
		$data = esc($this->request->getPost());
		$captcha_response = $data['g-recaptcha-response'];
		if(empty($captcha_response) || empty($data['pw'])){
			$this->smarty->assign('msg', ['type'=>'warning','text'=>'未點選驗證或未輸入密碼！']);
			$this->smarty->assign('param', $this->nowparam);
			$this->smarty->assign('allschool', $this->school->getAllSchool());
			$this->smarty->assign('func', 'noticepass');
			return $this->smarty->display('auth.tpl');					
		}else{
			if(!$this->recaptcha_auth($captcha_response)){
				$this->smarty->assign('msg', ['type'=>'warning','text'=>'驗證未通過！']);
				$this->smarty->assign('param', $this->nowparam);
				$this->smarty->assign('allschool', $this->school->getAllSchool());
				$this->smarty->assign('func', 'noticepass');
				return $this->smarty->display('auth.tpl');
			}else{
				$savedata = array(
					'id'=>$this->session->get('user_id'),
					'pw'=>md5($data['pw'])
				);
				$this->user->save($savedata);
				return redirect()->to(base_url('/auth/logout'));
			}
		}
	}

	public function recaptcha_auth($gresponse){
		if($gresponse == ''){
			return false;
		}else{			
			$secret = '6Lf3nw0cAAAAANxHx6HVKmTWXR5xH90gChVbezx4';
			$credential = array(
				'secret' => $secret,
				'response' => $gresponse);
			$verify = curl_init();
			curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($verify, CURLOPT_POST, true);
			curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
			curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($verify);
		
			$status= json_decode($response, true);
			return $status['success'];
		}
		return false;
	}

	

	public function otp(){
		return md5(date('s') . 'kl_art_contest' . date('YmdHis'));
	}
	
}