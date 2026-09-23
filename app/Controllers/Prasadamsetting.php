<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Prasadamsetting extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper("common_helper");
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{

		$data['permission'] = $this->model->get_permission('prasadam_setting');
		$data['list'] = $this->db->table('prasadam_setting')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/index', $data);
		echo view('template/footer');
	}
	public function add()
	{
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('prasadam_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/add', $data);
		echo view('template/footer');
	}

	public function edit()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));

		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('prasadam_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/add', $data);
		echo view('template/footer');
	}

	public function view()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('prasadam_group')->orderBy('id', 'desc')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/add', $data);
		echo view('template/footer');
	}

	public function save()
	{
		$id = $_POST['id'];
		$data['name_eng'] = trim($_POST['name_eng']);
		$data['name_tamil'] = trim($_POST['name_tamil']);
		$data['amount'] = trim($_POST['amount']);
		$data['groupname'] = trim($_POST['groupname']);
		$data['added_by'] = $this->session->get('log_id');
		if (!empty($_POST['ledger_id']))
			$data['ledger_id'] = $_POST['ledger_id'];
		if (!empty($_POST['stock_prasadam']))
			$data['dedection_from_stock'] = 1;
		else
			$data['dedection_from_stock'] = 0;
		if (!empty($_FILES['prasadam_image']['name']) > 0) {
			echo $_FILES['prasadam_image']['name'];
			$name = time() . '_' . $_FILES['prasadam_image']['name'];
			$target_dir = "uploads/prasadam_setting/";
			move_uploaded_file($_FILES['prasadam_image']['tmp_name'], $target_dir . $name);
			$data['image'] = $name;
		}
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('prasadam_setting')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Prasadam Setting Added Successfully');
				header("Location: " . base_url() . "/prasadamsetting");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/prasadamsetting");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('prasadam_setting')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Prasadam Setting Update Successfully');
				header("Location: " . base_url() . "/prasadamsetting");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/prasadamsetting");
			}
		}
	}

	public function delete()
	{
		if (!$this->model->permission_validate('prasadam_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('prasadam_setting')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Prasadam Setting Delete Successfully');
			header("Location: " . base_url() . "/prasadamsetting");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/prasadamsetting");
		}
	}

	public function del_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("prasadam")->where("id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function prasadam_setting_validation()
	{
		$name_eng = trim($_POST['name_eng']);
		$name_tamil = trim($_POST['name_tamil']);
		$amount = trim($_POST['amount']);
		$data = array();
		if (empty($name_eng) || empty($name_tamil) || empty($amount)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
	public function prasadam_group()
	{
		if (!$this->model->list_validate('prasadam_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('prasadam_setting');
		$data['list'] = $this->db->table('prasadam_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadamgrp/prasadam_group', $data);
		echo view('template/footer');
	}
	public function add_prasadam_group()
	{
		if (!$this->model->permission_validate('prasadam_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadamgrp/add_prasadam_group');
		echo view('template/footer');
	}

	public function save_prasadam_group()
	{
		$id = $_POST['id'];

		$data['name'] = trim($_POST['name']);
		$data['status'] = $_POST['status'];
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('prasadam_group')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'prasadam group Added Successfully');
				header("Location: " . base_url() . "/prasadamsetting/prasadam_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/prasadamsetting/prasadam_group");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('prasadam_group')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'prasadam group Update Successfully');
				header("Location: " . base_url() . "/prasadamsetting/prasadam_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/prasadamsetting/prasadam_group");
			}
		}

	}

	public function delete_prasadam_group()
	{
		if (!$this->model->permission_validate('prasadam_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('prasadam_group')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'prasadam group Delete Successfully');
			header("Location: " . base_url() . "/prasadamsetting/prasadam_group");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/prasadamsetting/prasadam_group");
		}
	}

	public function edit_prasadam_group()
	{
		if (!$this->model->permission_validate('prasadam_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_group')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadamgrp/add_prasadam_group', $data);
		echo view('template/footer');
	}

	public function view_prasadam_group()
	{
		if (!$this->model->permission_validate('prasadam_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_group')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		// print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadamgrp/add_prasadam_group', $data);
		echo view('template/footer');
	}
	public function prasadam_g_validation()
	{
		$name = trim($_POST['name']);
		$data = array();
		if (empty($name)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
	public function del_prasadam_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("prasadam")->where("id", $id)->get()->getResultArray();
		echo count($res);
	}


}
