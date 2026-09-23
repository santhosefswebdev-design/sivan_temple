<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Userpermission extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        if( ($this->session->get('login') ) == false ){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function validation(){
		
		//echo '<pre>';
		//print_r ($_POST['role_id']); 
		if ($_POST['role_id']) 
			$role_id=$_POST['role_id'];
			
		else
			$role_id=0;
		
		//exit;
        $name = trim($_POST['name']);
        $data = array();
        $res = $this->db->query("select count(*) as cnt from role_list where id<>$role_id and name = '$name'")->getRowArray();
        if ($res['cnt'] >0) {
			
			
            $data['err'] = "Role Name Already Exits";
            $data['succ']= '';
			
        }else{
            $data['succ'] = "Form validate";
            $data['err'] ='';
        }
        echo json_encode($data);
    }

    public function save_role(){
        $data['name']        = $_POST['name'];
        $data['description'] = $_POST['description'];
        $data['created']     = date("Y-m-d H:i:s");
        $data['modified']     = date("Y-m-d H:i:s");
        $res = $this->db->table('role_list')->insert($data);
        if($res){
            $ins_id = $this->db->insertID();
            if(!empty($_POST['permission'])){
                foreach($_POST['permission'] as $key => $value){
                    $per = array();
                    $per['role_id'] = $ins_id;
                    $per['name']    = $key;
                    foreach($value as $pkey => $pval){
                        $per[$pkey] = 1;
                    }
					
                    $per['created'] = date('Y-m-d H:i:s');
                    $per['modified'] = date('Y-m-d H:i:s');
					
                    $this->db->table("role_permission")->insert($per);
                }
            }
            $this->session->setFlashdata('succ', 'Role Added Successfully');
            header("Location: ".base_url()."/user/add_user_role");
        }else{
            $this->session->setFlashdata('fail', 'Please Try Again');
            header("Location: ".base_url()."/user/add_user_role");
        }
        
 	}
	
	public function update_role(){
		
		
        $data['name']        = $_POST['name'];
        $data['description'] = $_POST['description'];
        $data['modified']     = date("Y-m-d H:i:s");
		$role_id=$_POST['role_id'];
        //$res = $this->db->table('role_list')->insert($data);
		$res = $this->db->table('role_list')->where('id', $role_id)->update($data);
		
		
        if($res){
				$dat['view']        = 0;
                $dat['create_p']    = 0;
                $dat['edit']        = 0;
                $dat['delete_p']    = 0;
                $dat['print']       = 0;
                $res = $this->db->table('role_permission')->where('role_id', $role_id)->update($dat);
            if(!empty($_POST['permission'])){
				foreach($_POST['permission'] as $key => $value){
                    $per = array();
                    
                    $per['name']    = $key;
					
					
					foreach($value as $pkey => $pval){
                        $per[$pkey] = 1;
                    }
					
					$per['modified'] = date('Y-m-d H:i:s');
						
						
					
					$res1 = $this->db->query("select count(*) as cnt from role_permission where role_id=$role_id and name = '$key'")->getRowArray();
					
					if ($res1['cnt'] >0) {
					
						$this->db->table('role_permission')->where('role_id', $role_id)->where('name', $key)->update($per);
						
					}else{
						$per['role_id'] = $role_id;
						$per['created'] = date('Y-m-d H:i:s');
                    
                    $this->db->table("role_permission")->insert($per);						
					}
					// echo '<pre>';
						// print_r($role_id);
						// print_r($key);
						// print_r($res1['cnt']);
						// exit;
					
                }
            }
			
				//$res2 = array();
               // $res2 = $this->db->table("role_permission")->where("role_id", $role_id)->get()->getResultArray();
            
                /*$session = array(
                            'permission' => $res2
                        );
                $this->session->set($session);*/
            $this->session->setFlashdata('succ', 'Role Updated Successfully');
            header("Location: ".base_url()."/user/user_role");
        }else{
            $this->session->setFlashdata('fail', 'Please Try Again');
            header("Location: ".base_url()."/user/user_role");
        }
        
 	}

    public function edit($id){
        //echo '<pre>'; print_r($_SESSION);die;
        $data['role'] = $this->db->table("role_list")->where("id", $id)->get()->getRowArray();
        $data['permission'] = $this->db->table("role_permission")->where("role_id", $id)->get()->getResultArray();
        
		echo view('template/header');
        echo view('template/sidebar');
        echo view('user/edit_user_role', $data);
        echo view('template/footer');
    }
	public function view($id){
        // echo '<pre>'; print_r($_SESSION);die;
        $data['role'] = $this->db->table("role_list")->where("id", $id)->get()->getRowArray();
        $data['permission'] = $this->db->table("role_permission")->where("role_id", $id)->get()->getResultArray();
        $data['view'] =true; 
		echo view('template/header');
        echo view('template/sidebar');
        echo view('user/edit_user_role', $data);
        echo view('template/footer');
    }

}
