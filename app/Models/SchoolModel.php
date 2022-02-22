<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'schools';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['schoolid','schoolname','schoolfullname','schooltype','schooltype2','area','ps','classnum','cars','available','openid','eduid','zip','address','tel','citycode','schoollevel'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'schoolid'=>'required',
        'schoolname'=>'required'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function getAllSchool(){
        $data = array();
        $res = $this->where(['available'=>'1'])->orderBy('schoolid asc')->findAll();
        foreach($res as $tmp){
            $data[$tmp['schoolid']]=$tmp;
        }
        return $data;
    }

    public function getFullSchool(){
        $data = array();
        $res = $this->orderBy('available asc, schooltype desc, eduid asc, schoolfullname asc')->findAll();
        foreach($res as $tmp){
            $data[$tmp['schoolid']]=$tmp;
        }
        return $data;
    }
    public function getSchoolFromId($id=null){
        if($id>0){
            return $this->find($id);
        }else{
            return false;
        }
    }
    public function getSchoolFromSchoolid($schoolid=null){
        if($schoolid>0){
            return $this->where(['schoolid'=>$schoolid])->findAll()[0];
        }else{
            return false;
        }
        return false;
    }
    public function getEduidFromSchoolid($schoolid=null){
        if($schoolid>0){
            return $this->select('eduid')->where(['schoolid'=>$schoolid])->findAll()[0]['eduid'];
        }else{
            return false;
        }
        return false;
    }
    public function getSchoolFromSchoolname($schoolname = null){
        if(!empty($schoolname)){
            return $this->where('schoolname', esc($schoolname))->findAll();
        }else{
            return false;
        }
    }
}
