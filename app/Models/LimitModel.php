<?php

namespace App\Models;

use CodeIgniter\Model;

class LimitModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'limits';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['year','schoolid','limitnum','used','remain'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    public function getLimitFromYear($year=null){
        if(intval(esc($year))>0){
            $res = $this->where('year', $year)->orderBy('schoolid asc')->findAll();
            foreach($res as $tmp){
                $data[$tmp['schoolid']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
    }
    public function getLimitFromYearAndSchoolid($year=null, $schoolid=null){
        if(intval(esc($year))>0 && intval(esc($schoolid))>0){
            return $this->where(['year'=>$year,'schoolid'=>$schoolid])->findAll();
        }else{
            return false;
        }
    }
}
