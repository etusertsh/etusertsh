<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['itemdate','itemtime','itemtype','itemcode','itemplace','description','limitnum','booking','remain','subitem'];

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

    public function getAllItem(){
        return $this->orderBy('itemdate asc, itemtime asc, itemtype desc, itemplace asc')->findAll();
    }
    public function getAllSingleItem(){
        return $this->where('itemtype', 'S')->orderBy('itemdate asc, itemtime asc, itemplace asc')->findAll();
    }
    public function getAllMultiItem(){
        return $this->where('itemtype', 'M')->orderBy('itemdate asc, itemtime asc, itemplace asc')->findAll();
    }
    public function getItemFromDate($itemdate=null){
        if(!empty(esc($itemdate))){
            return $this->where('itemdate',$itemdate)->orderBy('itemtime asc, itemtype desc, itemplace asc')->findAll()[0];
        }else{
            return false;
        }
    }
    public function getSingleItemFromDate($itemdate=null){
        if(!empty(esc($itemdate))){
            return $this->where(['itemdate'=>$itemdate,'itemtype'=>'S'])->orderBy('itemtime asc, itemplace asc')->findAll();
        }else{
            return false;
        }
    }
    public function getMultiItemFromDate($itemdate=null){
        if(!empty(esc($itemdate))){
            return $this->where(['itemdate'=>$itemdate,'itemtype'=>'M'])->orderBy('itemtime asc, itemplace asc')->findAll();
        }else{
            return false;
        }
    }
    public function getItemFromDateAndTime($itemdate=null, $itemtime=null){
        if(!empty(esc($itemdate)) && !empty(esc($itemtime))){
            $data = array(); 
            $res = $this->where(['itemdate'=>$itemdate,'itemtime'=>$itemtime])->orderBy('itemtype asc, itemplace asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemcode']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getSingleItemFromDateAndTime($itemdate=null, $itemtime=null){
        if(!empty(esc($itemdate)) && !empty(esc($itemtime))){
            return $this->where(['itemdate'=>$itemdate,'itemtime'=>$itemtime,'itemtype'=>'S'])->orderBy('itemtime asc, itemplace asc')->findAll();
        }else{
            return false;
        }
    }
    public function getMultiItemFromDateAndTime($itemdate=null, $itemtime=null){
        if(!empty(esc($itemdate)) && !empty(esc($itemtime))){
            return $this->where(['itemdate'=>$itemdate,'itemtime'=>$itemtime,'itemtype'=>'M'])->orderBy('itemplace asc')->findAll();
        }else{
            return false;
        }
    }
    public function getItemFromDateAndTimeAndCode($itemdate=null, $itemtime=null, $code=null){
        if(!empty(esc($itemdate)) && !empty(esc($itemtime)) && !empty(esc($code))){
            $data = array();
            $res = $this->where(['itemdate'=>$itemdate,'itemtime'=>$itemtime, 'itemcode'=>$code])->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemcode']] = $tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getItemFromYear($year=null){
        if($year>0){
            $data = array();
            $res = $this->like('itemdate', $year . '%')->orderBy('itemdate')->findAll();
            foreach($res as $tmp){
                $data[$tmp['itemdate']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
}
