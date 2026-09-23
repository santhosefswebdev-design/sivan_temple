<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Templeblock extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}
	public function index()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('templeblock/temple_block');
		echo view('template/footer');
	}
	public function block_event_list()
	{
		$query = $this->db->query("SELECT DATE_FORMAT(overall_temple_block.date, '%Y-%m-%d') as booking_date,
									overall_temple_block.description,overall_temple_block.id FROM overall_temple_block 
									GROUP BY DATE_FORMAT(overall_temple_block.date, '%Y-%m-%d')");
		$res = $query->getResultArray();
		echo json_encode($res);
	}
	public function blocked_event_check()
  	{
    	$eventdate = $_POST['eventdate'];
    	$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $eventdate)->get()->getRowArray();
    	echo !empty($retndate['date']) ? $retndate['date'] : "";
  	}
	public function hall_ubayam_event_check()
  	{
    	$eventdate = $_REQUEST['eventdate'];
    	$event_list = $this->db->query("SELECT ref_no, event_name, booking_date as date, 'hall' as type FROM `hall_booking` where booking_date = '$eventdate' UNION ALL SELECT u.ref_no, us.name as event_name, u.dt as date, 'ubayam' as type FROM `ubayam` u left join ubayam_setting us on us.id = u.pay_for where u.dt = '$eventdate'")->getResultArray();
    	echo json_encode($event_list);
		exit;
  	}
	public function block_event_add()
	{
		if (!empty($_POST['event_id'])) {
		  	$id = $_POST['event_id'];
		  	$updatedata["description"] = $_POST['description'];
		  	$this->db->table('overall_temple_block')->where('id', $id)->update($updatedata);
		  	$this->session->setFlashdata('succ', 'Templeblock Data Updated Successfully');
		  	return redirect()->to("/templeblock");
		} else {
		  	$data["date"] = $_POST['event_date'];
		  	$data["description"] = $_POST['description'];
		  	$data["created_at"] = date("Y-m-d H:i:s");
		  	$this->db->table('overall_temple_block')->insert($data);
		  	$this->session->setFlashdata('succ', 'Templeblock Data Created Successfully');
		  	return redirect()->to("/templeblock");
		}
	}
	public function block_event_delete()
	{
		$id = $_POST['id'];
		$res = $this->db->table('overall_temple_block')->delete(['id' => $id]);
		$this->session->setFlashdata('succ', 'Hallblocking Data Deleted Successfully');
		return redirect()->to("/templeblock");
	}
}