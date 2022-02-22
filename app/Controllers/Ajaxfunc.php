<?php

namespace App\Controllers;

use App\Controllers\BaseController;
//use App\Models\ItemModel;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;
//use App\Models\SignupformModel;

class Ajaxfunc extends BaseController
{
    //protected $smarty;
    protected $session;
    protected $param;
    protected $nowparam;
    //protected $item;
   // protected $allitem;
    //protected $news;
    protected $school;
    protected $user;

    public function __construct() {
		$this->session = \Config\Services::session();	
        $this->param = new ParamModel();
        //$this->item = new ItemModel();
        //$this->news = new NewsModel();
        $this->school = new SchoolModel();
        $this->user = new UserModel();

        $this->nowparam = $this->param->getParam();
    }

    public function index()
    {
        return '';
    }

    public function schoolavailable($id=null,$newavailable=null){
        if($id>0){
            if(empty($newavailable)){
                $newavailable = '0';
            }
            $sdata = ['id'=>$id,'available'=>$newavailable];
            if($this->school->save($sdata)===false){
                return 'error-save';
            }else{
                return 'ok';
            }
        }else{
            return 'error-data-' . $id . '-' . $newavailable;
        }
    }
    public function schoolcar($id=null,$newnum=null){
        if($id>0){
            $newnum = intval(esc($newnum));
            $sdata = ['id'=>$id,'cars'=>$newnum];
            if($this->school->save($sdata)===false){
                return 'error-save';
            }else{
                return 'ok';
            }
        }else{
            return 'error-data-' . $id . '-' . $newnum;
        }
    }

    public function setgrade($id=null,$type=null,$grade=null){
        
        $signup = new SignupformModel();

        if($id>0 && !empty($type) && $grade > 0){
            if(in_array($type,array('first','final'))){
                if($signup->save(['id'=>$id,$type . 'grade'=>$grade])===false){
                    return 'error-inputerror';
                }else{
                    return 'ok';
                }
            }else{
                return 'error-notype';
            }
        }else{
            return 'error-nodata';
        }
    }

    public function toupgrade($id=null,$tofinal=null){
        $signup = new SignupformModel();
        if($id>0){
            $tofinal == '1' ? '1' : '0';
            if($signup->save(['id'=>$id, 'tofinal'=>$tofinal])===false){
                return 'error-inputerror';
            }else{
                return 'ok';
            }
        }else{
            return 'error-nodata';
        }
    }

    public function torank($id=null,$type=null,$rankitem=null){
        $signup = new SignupformModel();
        if($id >0){
            if(in_array($type, array('rank1', 'rank2'))){
                if($type == 'rank1'){
                    if($rankitem == '' || in_array($rankitem, $this->param->rank1)){
                        if($signup->save(['id'=>$id, 'rank1'=>$rankitem])===false){
                            return 'error-rank1error';
                        }else{
                            return 'ok';
                        }
                    }else{
                        return 'error-outrangerank1';
                    }
                }else{
                    if($rankitem == '' || in_array($rankitem, $this->param->rank2)){
                        if($signup->save(['id'=>$id, 'rank2'=>$rankitem])===false){
                            return 'error-rank2error';
                        }else{
                            return 'ok';
                        }
                    }else{
                        return 'error-outrangerank2';
                    }
                }
            }else{
                return 'error-errortype';
            }
        }else{
            return 'error-nodata';
        }
    }
}
