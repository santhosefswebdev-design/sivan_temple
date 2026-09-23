<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Archanai extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper("common_helper");
		$this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login'); 
            exit;
		}
    }
    
    public function index(){
        if(!$this->model->list_validate('archanai_setting')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('archanai_setting');
		$data['staff'] = $this->db->table('staff')->get()->getResultArray();
		$data['list'] = $this->db->table('archanai')
								->select('archanai.*,archanai_category.name as category_name')
								->join('archanai_category', 'archanai.archanai_category = archanai_category.id')
								->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/index', $data);
		echo view('template/footer');
    }
	public function add()
	{
		if(!$this->model->permission_validate('archanai_setting', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['staff'] = $this->db->table('staff')->get()->getResultArray();
		$data['archanai_categories'] = $this->db->table('archanai_category')->where('status',1)->get()->getResultArray();
		$data['archanai_group'] = $this->db->table('archanai_group')->get()->getResultArray();
		//$three_level_group = get_three_level_in_group($code = array("4000"));
		$data['ledgers'] = $this->db->query("SELECT * FROM ledgers where group_id in (SELECT id FROM groups WHERE code in (4000, 8000) or parent_id in (SELECT id FROM groups WHERE code in (4000, 8000)) or parent_id in (select id from groups where parent_id in (SELECT id FROM groups WHERE code in (4000, 8000))))")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/add', $data);
		echo view('template/footer');
	}
	
	public function edit(){
	    if(!$this->model->permission_validate('archanai_setting', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('archanai')->where('id', $id)->get()->getRowArray();
		//var_dump($data['data']);
		//exit;
		$data['staff'] = $this->db->table('staff')->get()->getResultArray();
	    $data['archanai_group'] = $this->db->table('archanai_group')->get()->getResultArray();
		$data['archanai_categories'] = $this->db->table('archanai_category')->where('status',1)->get()->getResultArray();
		//$three_level_group = get_three_level_in_group($code = array("4000"));
		$data['ledgers'] = $this->db->query("SELECT * FROM ledgers where group_id in (SELECT id FROM groups WHERE code in (4000, 8000) or parent_id in (SELECT id FROM groups WHERE code in (4000, 8000)) or parent_id in (select id from groups where parent_id in (SELECT id FROM groups WHERE code in (4000, 8000))))")->getResultArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/add', $data);
		echo view('template/footer');
	}
	
	public function view(){
	    if(!$this->model->permission_validate('archanai_setting', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('archanai')->where('id', $id)->get()->getRowArray();
	    $data['archanai_group'] = $this->db->table('archanai_group')->get()->getResultArray();
		$data['archanai_categories'] = $this->db->table('archanai_category')->where('status',1)->get()->getResultArray();
		//$three_level_group = get_three_level_in_group($code = array("4000"));
		$data['ledgers'] = $this->db->query("SELECT * FROM ledgers where group_id in (SELECT id FROM groups WHERE code in (4000, 8000) or parent_id in (SELECT id FROM groups WHERE code in (4000, 8000)) or parent_id in (select id from groups where parent_id in (SELECT id FROM groups WHERE code in (4000, 8000))))")->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/add', $data);
		echo view('template/footer');
	}
	
	public function category_store() {
	    $data['name']		 =	trim($_POST['groupname']);
	    $data['created']  =	date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$builder = $this->db->table('archanai_group')->insert($data);
		if($builder){
    	    header("Location: ".base_url()."/archanai/add");
    	}
	}
	
	public function save(){
        $id = $_POST['id'];	
		$comission_to = $_POST['comission_to'];
		if(isset($_POST['view_archanai'])) $data['view_archanai'] = 0;
		else $data['view_archanai'] = 1;
		if(!empty($_POST['stock_archanai'])) $data['dedection_from_stock'] = 1;
		else $data['dedection_from_stock'] = 0;
		
		$data['name_eng']	 =	trim($_POST['name_eng']);
		$data['comission_to'] =   $comission_to;
		$data['name_tamil']		 =	trim($_POST['name_tamil']);
		$data['amount']	 =	trim($_POST['amount']);
		$data['commission']	 =	trim($_POST['commission']);
		$data['commission_percentage']	 =	trim($_POST['com_per']);
		$data['groupname']		 =	trim($_POST['groupname']);
		$data['order_no'] =	trim($_POST['order_no']);
		$data['archanai_category'] =	$_POST['archanai_category'];
		if(!empty($_POST['ledger_id'])) $data['ledger_id'] = $_POST['ledger_id'];
		$data['added_by']	 =	$this->session->get('log_id');
		if(!empty($_FILES['archanai_image']['name']) > 0){
			echo $_FILES['archanai_image']['name'];
			$name = time() . '_' .$_FILES['archanai_image']['name'];
			$target_dir = "uploads/archanai/";
			move_uploaded_file($_FILES['archanai_image']['tmp_name'],$target_dir.$name);
			$data['image'] = $name;
		}
		if(!empty($_FILES['watermark_image']['name']) > 0){
			echo $_FILES['watermark_image']['name'];
			$name = time() . '_' .$_FILES['watermark_image']['name'];
			$target_dir = "uploads/archanai/watermark/";
			move_uploaded_file($_FILES['watermark_image']['tmp_name'],$target_dir.$name);
			$data['watermark_image'] = $name;
		}
		$hallEditorArray = $_POST['desc_editor'];
		$data['description'] = json_encode($hallEditorArray);
		if(empty($id)){
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('archanai')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Archanai Added Successfully');
    		    header("Location: ".base_url()."/archanai");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/archanai");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('archanai')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Archanai Update Successfully');
    		    header("Location: ".base_url()."/archanai");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/archanai");
    		}
		}
	}
	
	public function delete(){
	    if(!$this->model->permission_validate('archanai_setting', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('archanai')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Archanai Delete Successfully');
		    header("Location: ".base_url()."/archanai");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/archanai");
		}
	}
	public function del_check(){
			$id = $_POST['id'];
			$res = $this->db->table("archanai_booking_details")->where("archanai_id", $id)->get()->getResultArray();
			echo count($res);
		}
	public function get_group() {
		$name = $_POST['search'];
		$data = array();
		$res = $this->db->query("select name from archanai_group where name like '%".$name."%' ")->getResultArray();
		foreach($res as $row){
			$data[] = $row['name'];
		}
		$datas = implode(',', $data);
		echo json_encode($data);
	}
	
	public function rasi(){
        if(!$this->model->list_validate('archanai_setting')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('archanai_setting');
		$data['list'] = $this->db->table('rasi')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/rasi', $data);
		echo view('template/footer');
    }
	
	public function rasi_add()
	{
		if(!$this->model->permission_validate('archanai_setting', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		//echo "<pre>"; print_r($data); die();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/rasi_add', $data);
		echo view('template/footer');
	}
	
	public function rasi_validation(){
		$name_eng = trim($_POST['name_eng']);
		$name_tamil = trim($_POST['name_tamil']);
		
		$data = array();
		if (empty($name_eng) || empty($name_tamil)) {
		  $data['err'] = "Please Fill Required Fields";
		  $data['succ']= '';
		}else{
		  $data['succ'] = "Form validate";
		  $data['err'] ='';
		}
		echo json_encode($data);
	  }
	
	public function rasi_save(){
        $id = $_POST['id'];	
		$data['name_eng']	 =	trim($_POST['name_eng']);
		$data['name_tamil']		 =	trim($_POST['name_tamil']);
		$nat = $_POST['natchathra_id'];
		if(!empty($nat)) {
		    $natchathra = implode(',',$nat);
		    $data['natchathra_id'] = $natchathra;
		} else { 
		    $data['natchathra_id'] = ""; 
		}
		//print_r($nat); die();
		if(empty($id)){
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('rasi')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Rasi Added Successfully');
    		    header("Location: ".base_url()."/archanai/rasi");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/archanai/rasi");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('rasi')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Rasi Update Successfully');
    		    header("Location: ".base_url()."/archanai/rasi");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/archanai/rasi");
    		}
		}
	}
	
	public function rasi_edit(){
	    if(!$this->model->permission_validate('archanai_setting', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('rasi')->where('id', $id)->get()->getRowArray();
		$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		//echo"<pre>"; print_r($data); die();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/rasi_add', $data);
		echo view('template/footer');
	}
	
	public function rasi_view(){
	    if(!$this->model->permission_validate('archanai_setting', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('rasi')->where('id', $id)->get()->getRowArray();
		$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/rasi_add', $data);
		echo view('template/footer');
	}
	public function rasi_delete(){
	    if(!$this->model->permission_validate('archanai_setting', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('rasi')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Rasi Delete Successfully');
		    header("Location: ".base_url()."/archanai/rasi");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/archanai/rasi");
		}
	}
	
	public function natchathiram(){
        if(!$this->model->list_validate('archanai_setting')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('archanai_setting');
		$data['list'] = $this->db->table('natchathram')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/natchathiram', $data);
		echo view('template/footer');
    }
	
	public function natchathiram_add()
	{
		if(!$this->model->permission_validate('archanai_setting', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/natchathiram_add');
		echo view('template/footer');
	}
	
	public function nat_validation(){
		$name_eng = trim($_POST['name_eng']);
		$name_tamil = trim($_POST['name_tamil']);
		
		$data = array();
		if (empty($name_eng) || empty($name_tamil)) {
		  $data['err'] = "Please Fill Required Fields";
		  $data['succ']= '';
		}else{
		  $data['succ'] = "Form validate";
		  $data['err'] ='';
		}
		echo json_encode($data);
	  }
	
	public function natchathiram_save(){
        $id = $_POST['id'];	
		
		$data['name_eng']	 =	trim($_POST['name_eng']);
		$data['name_tamil']		 =	trim($_POST['name_tamil']);
		if(empty($id)){
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('natchathram')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Natchathiram Added Successfully');
    		    header("Location: ".base_url()."/archanai/natchathiram");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/archanai/natchathiram");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('natchathram')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Natchathiram Update Successfully');
    		    header("Location: ".base_url()."/archanai/natchathiram");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/archanai/natchathiram");
    		}
		}
	}
	
	public function natchathiram_edit(){
	    if(!$this->model->permission_validate('archanai_setting', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('natchathram')->where('id', $id)->get()->getRowArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/natchathiram_add', $data);
		echo view('template/footer');
	}
	
	public function natchathiram_view(){
	    if(!$this->model->permission_validate('archanai_setting', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('natchathram')->where('id', $id)->get()->getRowArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/natchathiram_add', $data);
		echo view('template/footer');
	}
	public function natchathiram_delete(){
	    if(!$this->model->permission_validate('archanai_setting', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('natchathram')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Rasi Delete Successfully');
		    header("Location: ".base_url()."/archanai/natchathiram");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/archanai/natchathiram");
		}
	}

	public function group_list() {
		$data['list'] = $this->db->table('archanai_group')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/group', $data);
		echo view('template/footer');
    }
    
    public function save_group(){
        $id = $_POST['id'];
		$data['name']	 =	trim($_POST['name']);
		$data['order_no']	 =	trim($_POST['order_no']);
		if(isset($_POST['rasi'])) 
		$data['rasi'] = 1;
		else $data['rasi'] = 0;
		
		if($data['name']){
			if(empty($id)){
				$data['created']  =	date('Y-m-d H:i:s');
				$builder = $this->db->table('archanai_group')->insert($data);
				if($builder){ $this->session->setFlashdata('succ', 'Group Added Successfully');}
				else{ $this->session->setFlashdata('fail', 'Please Try Again'); }
			}else{
				$data['modified']  =	date('Y-m-d H:i:s');
				$builder = $this->db->table('archanai_group')->where('id', $id)->update($data);
				if($builder){ $this->session->setFlashdata('succ', 'Group Update Successfully');}
				else{ $this->session->setFlashdata('fail', 'Please Try Again'); }
			}
		}else{
			$this->session->setFlashdata('fail', 'Please Fill Category'); 
		}
		header("Location: ".base_url()."/archanai/group_list");
	}
	
	public function edit_group(){
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('archanai_group')->where('id', $id)->get()->getRowArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/add_group', $data);
		echo view('template/footer');
	}
	
	public function view_group(){
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('archanai_group')->where('id', $id)->get()->getRowArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('archanai/add_group', $data);
		echo view('template/footer');
	}
	public function delete_group(){
		$id=  $this->request->uri->getSegment(3);
		$archanai_group = $this->db->table('archanai_group')->where('id', $id)->get()->getRowArray();
		$existing_check = $this->db->table('archanai')->where('groupname', $archanai_group['name'])->get()->getResultArray();
		if(count($existing_check) > 0)
		{
			$this->session->setFlashdata('fail', 'This group already chooosed in archanai.');
		}
		else
		{
			$res = $this->db->table('archanai_group')->delete(['id' => $id]);
			if($res){$this->session->setFlashdata('succ', 'Group Delete Successfully');}
			else{ $this->session->setFlashdata('fail', 'Please Try Again');}
		}
		header("Location: ".base_url()."/archanai/group_list");
	}
	
}
