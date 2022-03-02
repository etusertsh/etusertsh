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
    public function getBookingFromDate($itemdate=null){
        if(!empty($itemdate)){
            $data = array();
            $res = $this->where('itemdate', $itemdate)->orderBy('itemtime asc, itemcode asc, schoolid asc')->findAll();
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
}
