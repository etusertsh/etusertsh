<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ItemModel;
use App\Models\ParamModel;
use App\Models\SchoolModel;
use App\Models\UserModel;
use App\Models\LimitModel;
use App\Models\BookingModel;

class Ajaxfunc extends BaseController
{
    protected $session;
    protected $param;
    protected $nowparam;
    protected $items;
    protected $school;
    protected $user;
    protected $schoollimit;
    protected $booking;

    public function __construct() {
		$this->session = \Config\Services::session();	
        $this->param = new ParamModel();
        $this->items = new ItemModel();
        $this->school = new SchoolModel();
        $this->user = new UserModel();
        $this->booking = new BookingModel();
        $this->schoollimit = new LimitModel();

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
            $sdata = ['id'=>$id,'limitnum'=>$newnum, 'remain'=>$newnum];
            if($this->schoollimit->save($sdata)===false){
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
    public function renew($schoolid=null,$itemdate=null,$itemtime=null){
        $itemdata = $this->items->getItemFromDateAndTime($itemdate, $itemtime);
        $limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $schoolid)[0];
        $thebooking = $this->booking->getBookingFromSchoolidAndDateAndTime($schoolid,$itemdate,$itemtime);
        $data=array('msg'=>'ok',
        'limitdata'=>$limitdata,
        'itemdata'=>$itemdata,
        'booking'=>$thebooking);
        return json_encode($data);
    }

    public function bookplus($schoolid=null,$itemdate=null,$itemtime=null,$itemcode=null){
        if($schoolid>0 && !empty($itemdate) && !empty($itemtime) && !empty($itemcode)){
            $itemdata = $this->items->getItemFromDateAndTime($itemdate, $itemtime);
            $limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $schoolid)[0];
            $thebooking = $this->booking->getBookingFromSchoolidAndDateAndTime($schoolid,$itemdate,$itemtime);
            if($limitdata['remain']>0){
                if($itemdata[$itemcode]['remain']>0){
                    $itemdata[$itemcode]['booking']++;
                    $itemdata[$itemcode]['remain']--;                    
                    if($thebooking[$itemcode]['id']>0){
                        $thebooking[$itemcode]['num']++;
                        $this->booking->save(['id'=>$thebooking[$itemcode]['id'], 'num'=>$thebooking[$itemcode]['num']]);
                    }else{
                        $sdata = ['schoolid'=>$schoolid, 'itemdate'=>$itemdate, 'itemtime'=>$itemtime, 'itemcode'=>$itemcode, 'num'=>'1'];
                        $this->booking->save($sdata);
                        $newid = $this->booking->insertID();
                        $sdata['id']=$newid;
                        $thebooking[$itemcode]=$sdata;
                    }
                    $this->items->save(['id'=>$itemdata[$itemcode]['id'], 'booking'=>$itemdata[$itemcode]['booking'], 'remain'=>$itemdata[$itemcode]['remain']]);
                    if($itemdata[$itemcode]['itemtype']=='M'){
                        $code1 = substr($itemcode,0,1);
                        $code2 = substr($itemcode,1,1);
                        $itemdata[$code1]['booking']++;
                        $itemdata[$code1]['remain']--;
                        $this->items->save(['id'=>$itemdata[$code1]['id'], 'booking'=>$itemdata[$code1]['booking'], 'remain'=>$itemdata[$code1]['remain']]);
                        $itemdata[$code2]['booking']++;
                        $itemdata[$code2]['remain']--;
                        $this->items->save(['id'=>$itemdata[$code2]['id'], 'booking'=>$itemdata[$code2]['booking'], 'remain'=>$itemdata[$code2]['remain']]);
                    }
                    foreach($itemdata as $key=>$val){
                        if($val['itemtype']=='M' && strpos($val['itemcode'], $itemcode)>-1){
                            $code1 = substr($val['itemcode'],0,1);
                            $code2 = substr($val['itemcode'],1,1);
                            $itemdata[$key]['booking'] = min(max($itemdata[$code1]['booking'], $itemdata[$code2]['booking']),$itemdata[$key]['limitnum']);
                            $itemdata[$key]['remain'] = min($itemdata[$code1]['remain'], $itemdata[$code2]['remain']);
                            $this->items->save(['id'=>$itemdata[$key]['id'], 'booking'=>$itemdata[$key]['booking'], 'remain'=>$itemdata[$key]['remain']]);
                        }
                    }
                    $limitdata['used']++;
                    $limitdata['remain']--;
                    $this->schoollimit->save(['id'=>$limitdata['id'],'used'=>$limitdata['used'], 'remain'=>$limitdata['remain']]);
                    $result = 'ok';
                }else{
                    $result = '已額滿';
                }
            }else{
                $result = '已可用的車輛單位';
            }
        }else{
            $result = '參數錯誤';
        }
        $data=array('msg'=>$result,
        'limitdata'=>$limitdata,
        'itemdata'=>$itemdata,
        'booking'=>$thebooking);
        return json_encode($data);
    }
    public function bookminus($schoolid=null, $itemdate=null, $itemtime=null, $itemcode=null){
        if($schoolid>0 && !empty($itemdate) && !empty($itemtime) && !empty($itemcode)){
            $itemdata = $this->items->getItemFromDateAndTime($itemdate, $itemtime);
            $limitdata = $this->schoollimit->getLimitFromYearAndSchoolid($this->nowparam['actionyear'], $schoolid)[0];
            $thebooking = $this->booking->getBookingFromSchoolidAndDateAndTime($schoolid,$itemdate,$itemtime);
            if($limitdata['used']>0){
                if($itemdata[$itemcode]['booking']>0){
                    $itemdata[$itemcode]['booking']--;
                    $itemdata[$itemcode]['remain']++;
                    $thebooking[$itemcode]['num']--;
                    if($thebooking[$itemcode]['num']>0){
                        $this->booking->save(['id'=>$thebooking[$itemcode]['id'], 'num'=>$thebooking[$itemcode]['num']]);
                    }else{
                        $this->booking->delete($thebooking[$itemcode]['id']);
                        unset($thebooking[$itemcode]);
                    }
                    $this->items->save(['id'=>$itemdata[$itemcode]['id'], 'booking'=>$itemdata[$itemcode]['booking'], 'remain'=>$itemdata[$itemcode]['remain']]);
                    if($itemdata[$itemcode]['itemtype']=='M'){
                        $code1 = substr($itemcode,0,1);
                        $code2 = substr($itemcode,1,1);
                        $itemdata[$code1]['booking']--;
                        $itemdata[$code1]['remain']++;
                        $this->items->save(['id'=>$itemdata[$code1]['id'], 'booking'=>$itemdata[$code1]['booking'], 'remain'=>$itemdata[$code1]['remain']]);
                        $itemdata[$code2]['booking']--;
                        $itemdata[$code2]['remain']++;
                        $this->items->save(['id'=>$itemdata[$code2]['id'], 'booking'=>$itemdata[$code2]['booking'], 'remain'=>$itemdata[$code2]['remain']]);
                    }
                    foreach($itemdata as $key=>$val){
                        if($val['itemtype']=='M' && strpos($val['itemcode'], $itemcode)>-1){
                            $code1 = substr($val['itemcode'],0,1);
                            $code2 = substr($val['itemcode'],1,1);
                            $itemdata[$key]['booking'] = min(max($itemdata[$code1]['booking'], $itemdata[$code2]['booking']),$itemdata[$key]['limitnum']);
                            $itemdata[$key]['remain'] = min($itemdata[$code1]['remain'], $itemdata[$code2]['remain']);
                            $this->items->save(['id'=>$itemdata[$key]['id'], 'booking'=>$itemdata[$key]['booking'], 'remain'=>$itemdata[$key]['remain']]);
                        }
                    }
                    $limitdata['used']--;
                    $limitdata['remain']++;
                    $this->schoollimit->save(['id'=>$limitdata['id'],'used'=>$limitdata['used'], 'remain'=>$limitdata['remain']]);
                    $result = 'ok';
                }else{
                    $result = 'error1';
                }
            }else{
                $result = 'error2';
            }
        }else{
            $result = 'error3';
        }
        $data=array('msg'=>$result,
        'limitdata'=>$limitdata,
        'itemdata'=>$itemdata,
        'booking'=>$thebooking);
        return json_encode($data);
    }
}
