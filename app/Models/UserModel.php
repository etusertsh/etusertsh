<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['openid','name','pw','realname','email','officetel','mobile','schoolid','privilege','status','otp','source','profile_pic','sess_logged_in'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = '';

    // Validation
    protected $validationRules      = [
        'name'=>'required',
        'realname'=>'required',
        'email'=>'required'
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

    public function getAllUser(){
        return $this->findAll();
    }
    public function getUserFromEmail($email){
        if(!empty($email)){
            return $this->where(['email'=>esc($email)])->findAll();
        }else{
            return false;
        }
        return false;
    }
    public function getUserFromId($id){
		$tmp = $this->find($id);
		return $tmp;
	}
    public function checkLogin($email, $pw){
		if(empty($email) || empty($pw)){
			return false;
		}else{
			return $this->where(['email'=>esc($email), 'pw'=>md5($pw), 'source'=>'manual'])->findAll();
		}
		return false;
	}
    public function UserLogout($id){
        if($id>0){
            $data = array(
                'id'=>$id,
                'sess_logged_in'=>'0'
            );
            return $this->save($data);      
        }else{
            return false;
        }
        return false;
    }
    public function getUserFromPrivilege($p=null){
        if(!empty($p)){
            $data = array();
            $res = $this->where('privilege', $p)->orderBy('schoolid')->findAll();
            foreach($res as $tmp){
                $data[$tmp['id']]=$tmp;
            }
            return $data;
        }else{
            return false;
        }
        return false;
    }
}
