<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['schoolid','itemdate','itemtime','itemcode','num'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getBookingFromSchoolid($schoolid=null){
        if($schoolid>0){
            $data = array();
            $res = $this->where('schoolid', $schoolid)->orderBy('itemdate asc, itemtime asc, itemcode asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['id']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getBookingFromYearAndSchoolid($year=null, $schoolid=null){
        if($year>0 && $schoolid>0){
            $data = array();
            $res = $this->where('schoolid', $schoolid)->like('itemdate', '2022%')->orderBy('itemdate asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemdate']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getBookingFromSchoolidAndDate($schoolid=null, $itemdate=null){
        if($schoolid > 0 && $itemdate != ''){
            return $this->where(['schoolid'=>$schoolid, 'itemdate'=> $itemdate])->findAll()[0];
        }else{
            return false;
        }
    }
    public function getBookingFromSchoolidAndDateAndTime($schoolid=null, $itemdate=null, $itemtime=null){
        if($schoolid>0 && !empty($itemdate) && !empty($itemtime)){
            $data = array();
            $res = $this->where(['schoolid'=>$schoolid,'itemdate'=>$itemdate,'itemtime'=>$itemtime])->orderBy('itemcode asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemcode']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getBookingFromSchoolidAndDateAndTimeAndCode($schoolid=null, $itemdate=null, $itemtime=null, $itemcode=null){
        if($schoolid>0 && !empty($itemdate) && !empty($itemtime) && !empty($itemcode)){
            $data = array();
            $res = $this->where(['schoolid'=>$schoolid,'itemdate'=>$itemdate,'itemtime'=>$itemtime, 'itemcode'=>$itemcode])->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemcode']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getBookingFromDate($itemdate=null){
        if(!empty($itemdate)){
            $data = array();
            $res = $this->where('itemdate', $itemdate)->orderBy('schoolid asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['id']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getBookingFromDateAndTime($itemdate=null, $itemtime=null){
        if(!empty($itemdate) && !empty($itemtime)){
            $data = array();
            $res = $this->where(['itemdate'=>$itemdate,'itemtime'=>$itemtime])->orderBy('itemcode asc, schoolid asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['id']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getSumFromDateAndTime($itemdate = null, $itemtime = null){
        if(!empty($itemdate) && !empty($itemtime)){
            $data = array();
            $res = $this->selectSum('num')->select('itemcode')->groupBy('itemcode')->where(['itemdate'=>$itemdate, 'itemtime'=>$itemtime])->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemcode']] = $tmp['num'];
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getSumBySchoolid(){
        $data = array();
        $res = $this->selectSum('num')->select('schoolid')->groupBy('schoolid')->findAll();
        foreach($res as $tmp){
            $data[$tmp['schoolid']]=$tmp;
        }
        return $data;
    }
    public function getSumFromDate($itemdate=null){
        if(!empty($itemdate)){
            return $this->selectSum('num')->where('itemdate',$itemdate)->findAll()[0];
        }else{
            return false;
        }
    }
}
