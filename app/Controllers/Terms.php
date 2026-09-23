<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Terms extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		$this->model = new PermissionModel(); 
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
	public function edit(){
		// if(!$this->model->permission_validate('terms_setting', 'edit')){
		// 	header('Location: '.base_url().'/dashboard');
		// }
		// $data['term'] = $this->db->table('terms_conditions')
		// 					->select('terms_conditions.*')
		// 					->get()->getRowArray();
		// echo view('template/header');
		// echo view('template/sidebar');
		// echo view('terms/edit', $data);
		// echo view('template/footer');


		// if (!$this->model->permission_validate('terms_setting', 'edit')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// 	exit();
		// }
	
		// Fetch the data
		$term = $this->db->table('terms_conditions')
						 ->select('terms_conditions.*')
						 ->get()
						 ->getRowArray();
		
		if (isset($term['ubayam'])) {
			$term['ubayam'] = json_decode($term['ubayam'], true);
		}
		if (isset($term['hall'])) {
			$term['hall'] = json_decode($term['hall'], true);
		}
			
		$data['term'] = $term;

		$packages = $this->db->table('temple_packages')
                         ->where('package_type', 1)
                         ->where('status', 1)
                         ->get()
                         ->getResultArray();
    	$data['packages'] = $packages; 
	
		echo view('template/header');
		echo view('template/sidebar');
		echo view('terms/edit', $data);
		echo view('template/footer');
	}
	
	public function save() {
		$ubayamEditorJson = $this->request->getPost('ubayam_editor_json');
		$ubayamEditorArray = json_decode($ubayamEditorJson, true);
		
		$data['ubayam'] = json_encode($ubayamEditorArray);
		
		$res = $this->db->table('terms_conditions')->update($data);
		if($res) {
			$this->session->setFlashdata('succ', 'Terms Updated Successfully');
			return redirect()->to("/terms/edit");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			return redirect()->to("/terms/edit");
		}
	}

	public function save_hall_old(){

		$ubayamEditorJsonh = $_POST['hall_editor_json'];
		$ubayamEditorArrayh = json_decode($ubayamEditorJsonh, true);
		$data['hall'] = json_encode($ubayamEditorArrayh);
		
	
		$res = $this->db->table('terms_conditions')->update($data);
		if($res){
			$this->session->setFlashdata('succ', 'Terms Updated Successfully');
			return redirect()->to("/terms/edit");
		}else{
			$this->session->setFlashdata('fail', 'Please Try Again');
			return redirect()->to("/terms/edit");
		}
	}
	public function save_hall() 
{
    if ($this->request->getMethod() === 'post') {
        $hallEditorJson = $this->request->getPost('hall_editor_json');
        
        log_message('info', 'Received hall_editor_json: ' . $hallEditorJson);

        $newHallEditorArray = json_decode($hallEditorJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error_message = json_last_error_msg();
            log_message('error', 'JSON decoding error: ' . $error_message);
            // return $this->response->setJSON(['success' => false, 'message' => 'Invalid input data: ' . $error_message]);
			$this->session->setFlashdata('fail', 'Invalid input data');
				return redirect()->to("/terms/edit");
        }

        if ($newHallEditorArray !== null) {
            // Fetch existing data
            $builder = $this->db->table('terms_conditions');
            $existingData = $builder->get()->getRowArray();
            
            if ($existingData) {
                $existingHall = json_decode($existingData['hall'], true) ?? [];
                
                // Replace existing data with new data
                foreach ($newHallEditorArray as $packageId => $newContents) {
                    $existingHall[$packageId] = $newContents;
                }
                
                $data['hall'] = json_encode($existingHall);

                $res = $builder->update($data);

                if ($res) {
					$this->session->setFlashdata('succ', 'Terms Updated Successfully');
					return redirect()->to("/terms/edit");

                } else {
					$this->session->setFlashdata('fail', 'Database update failed. Please try again.');
					return redirect()->to("/terms/edit");
                }
            } else {
				$this->session->setFlashdata('fail', 'No existing record found to update');
				return redirect()->to("/terms/edit");
            }
        } else {
			$this->session->setFlashdata('fail', 'Decoded JSON is null');
			return redirect()->to("/terms/edit");
        }
    } else {
		$this->session->setFlashdata('fail', 'Invalid request method');
		return redirect()->to("/terms/edit");
    }
}
	
	
	
	
	
	
}


