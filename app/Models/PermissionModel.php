<?php
namespace App\Models;
use CodeIgniter\Model;
class PermissionModel extends Model {
    public function __construct()
    {
  	  parent::__construct();
        $this->session = \Config\Services::session($config);
    }

    public function permission_validate($name, $access){
        $res2 = $this->db->table("role_permission")->where("role_id", $_SESSION['role'])->get()->getResultArray();
        $session = array('permission' => $res2);
        $this->session->set($session);
        $permission = $_SESSION['permission'];
        $dkey = array_search($name, array_column($permission, 'name'));
        if ($permission[$dkey]['name']== $name)
		{
            $val = $permission[$dkey][$access];
            if($val == 1) $res = true;
            else $res = false;
		}else{
            $res = false;
        }
        return $res;
    }

    public function list_validate($name){
        $res2 = $this->db->table("role_permission")->where("role_id", $_SESSION['role'])->get()->getResultArray();
        $session = array('permission' => $res2);
        $this->session->set($session);
        $permission = $_SESSION['permission'];
        $dkey = array_search($name, array_column($permission, 'name'));
        if ($permission[$dkey]['name']== $name)
        {
            $view = $permission[$dkey]['view'];
            $create = $permission[$dkey]['create_p'];
            $edit = $permission[$dkey]['edit'];
            $delete = $permission[$dkey]['delete_p'];
            $print = $permission[$dkey]['print'];

            if($view == 1 || $create == 1 || $edit == 1 || $delete == 1 || $print == 1 ) $res = true;
            else $res = false;
		}else{
            $res = false;
        }
        return $res;
    }

    public function get_permission($name){
        $res = $this->db->table('role_permission')->where('role_id', $_SESSION['role'])->where('name', $name)->get()->getRowArray();
        return $res;
    }
	
}