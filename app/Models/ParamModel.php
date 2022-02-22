<?php

namespace App\Models;

use CodeIgniter\Model;

class ParamModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'params';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['name','value'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name'=>'required'
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

    protected $params = array(
        '0'=>'未啟用','1'=>'學校承辦','2'=>'教育行政','3'=>'系統管理'
    );

    public function getParam(){
        $data = array();
        $res = $this->findAll();
        foreach($res as $tmp){
            $data[$tmp['name']]=$tmp['value'];
        }
        return $data;
    }
    public function getPrivilege(){
        return $this->params;
    }
    public function getPrivilegeText($id=null){
        if(!empty($id)){
            return $this->params[$id];
        }else{
            return false;
        }
    }
}
