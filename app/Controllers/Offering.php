<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Offering extends BaseController
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
    
    public function offering_category(){
        $data['list'] = $this->db->table('offering_category')->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/offering_category', $data);
		echo view('template/footer');
    }
    public function category_validation()
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
    public function save_category()
	{
    	$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);

		if (empty($id)) {
			$builder = $this->db->table('offering_category')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Offering Category Added Successfully');
				header("Location: " . base_url() . "/offering/offering_category");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/offering/offering_category");
			}
		} else {

			$builder = $this->db->table('offering_category')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Offering Category Update Successfully');
				header("Location: " . base_url() . "/offering/offering_category");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/offering/offering_category");
			}
		}

	}
	public function del_cat_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("product_category")->where("off_cat_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_category()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('offering_category')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Donation Category Delete Successfully');
			header("Location: " . base_url() . "/master/offering_category");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/offering_category");
		}
	}
	public function edit_category()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('offering_category')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_category', $data);
		echo view('template/footer');
	}
	public function view_category()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('offering_category')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_category', $data);
		echo view('template/footer');
	}
	public function product_category(){
        $data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
        $data['list'] = $this->db->table('product_category')
						->select('product_category.*, offering_category.name as category')
						->join('offering_category', 'offering_category.id = product_category.off_cat_id')
						->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/product_category', $data);
		echo view('template/footer');
    }
    public function product_category_validation()
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
    public function save_product_category()
	{
    	$id = $_POST['id'];
		$data['off_cat_id'] = trim($_POST['off_cat_id']);
		$data['name'] = trim($_POST['name']);

		if (empty($id)) {
			$builder = $this->db->table('product_category')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Product Category Added Successfully');
				header("Location: " . base_url() . "/offering/product_category");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/offering/product_category");
			}
		} else {

			$builder = $this->db->table('product_category')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Product Category Update Successfully');
				header("Location: " . base_url() . "/offering/product_category");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/offering/product_category");
			}
		}

	}
	
	public function delete_pro_category()
	{

		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('product_category')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Donation Category Delete Successfully');
			header("Location: " . base_url() . "/master/product_category");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/product_category");
		}
	}

	public function edit_pro_category()
	{

		$id = $this->request->uri->getSegment(3);
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		$data['data'] = $this->db->table('product_category')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_pro_category', $data);
		echo view('template/footer');
	}
	public function view_pro_category()
	{

		$id = $this->request->uri->getSegment(3);
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		$data['data'] = $this->db->table('product_category')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_pro_category', $data);
		echo view('template/footer');
	}
	
	public function product_offering(){
        $data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
        $data['list'] = $this->db->table('product_offering')->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/product_offering', $data);
		echo view('template/footer');
    }
    public function add_product_offering(){
        $data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
        $data['product'] = $this->db->table('product_category')->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_product_offering', $data);
		echo view('template/footer');
    }
    
    public function get_category()
	{
		$json_resp = array();
		if (!empty ($_REQUEST['id'])) {
		    $id = $_REQUEST['id'];
    		$res = $this->db->table('product_category')->where('off_cat_id', $id)->get()->getResultArray();
    		if ($res)
				$json_resp['data'] = $res;
			else
				$json_resp['data'] = array();
		}
		echo json_encode($json_resp);
		exit;
	}
	public function pro_offering_save()
	{
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
	    $id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		
		$data['date'] = date('Y-m-d', strtotime($_POST['date']));
		$data['name'] = trim($_POST['name']);
	    $data['phone'] = trim($_POST['phone']);
	    $data['address'] = trim($_POST['address']);
		$yr= date('Y', strtotime($_POST['date']));
		$mon= date('m', strtotime($_POST['date']));
		$query = $this->db->query("SELECT ref_no FROM product_offering WHERE id=(SELECT max(id) FROM product_offering WHERE year(date)='". $yr ."' AND month(date)='". $mon ."')")->getRowArray();
		$data['ref_no'] = 'PO' .date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['paid_through'] = 'ADMIN';
	    $data['created'] = date("Y-m-d H:i:s");
	    $res = $this->db->table('product_offering')->insert($data);
		$ins_id = $this->db->insertID();
		if (!empty($_POST['sout'])) {
			foreach ($_POST['sout'] as $row) {
				$sdata['pro_off_id'] = $ins_id;
				$sdata['offering_id'] = $row['offering_id'];
				$sdata['product_id'] = $row['product_id'];
				$sdata['grams'] = $row['grams'];
				$sdata['value'] = $row['value'];
				$detail_res = $this->db->table("product_offering_detail")->insert($sdata);
		
				$productCategory = $this->db->table("product_category")
											->select('id, off_cat_id, stock_grams, stock_items')
											->where('off_cat_id', $row['offering_id'])
											->where('id', $row['product_id'])
											->get()
											->getRowArray();
		
				if (!empty($productCategory)) {
					$updatedData = [
						'stock_grams' => $productCategory['stock_grams'] + $row['grams'],
						'stock_items' => $productCategory['stock_items'] + 1
					];
					
					$res = $this->db->table("product_category")
							 ->where('id', $row['product_id'])
							 ->update($updatedData);
				}
			}
		}
		
		if($res){
			$msg_data['succ'] = 'Stock In Added Successfully';
			$msg_data['id'] = $ins_id;
		}else{
			$msg_data['err'] = 'Please Try Again';
		}
		
		echo json_encode($msg_data);
		exit();
	}
	public function edit_prod_offering()
	{
		$id = $this->request->uri->getSegment(3);
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		$data['data'] = $this->db->table('product_offering')->where('id', $id)->get()->getRowArray();
		$data['pro'] = $this->db->table('product_offering_detail')->where('pro_off_id', $id)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_product_offering', $data);
		echo view('template/footer');
	}
	public function view_prod_offering()
	{
		$id = $this->request->uri->getSegment(3);
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		$data['data'] = $this->db->table('product_offering')->where('id', $id)->get()->getRowArray();
		$data['pro'] = $this->db->table('product_offering_detail')->where('pro_off_id', $id)->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/add_product_offering', $data);
		echo view('template/footer');
	}
	
	public function report()
	{
	    $data['data'] = $this->db->table('product_offering')->get()->getResultArray();
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('offering/report', $data);
		echo view('template/footer');
	}

	public function offering_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$type = $_POST['offering_id'];
		$ptype = $_POST['product_id'];
		$data = [];
		$qry = $this->db->query("SELECT 
											product_offering.*, product_offering.id as main_id,
											product_offering_detail.*,
											product_category.name as product_name,  
											offering_category.name as category_name
										FROM 
											`product_offering`
										INNER JOIN 
											product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
										INNER JOIN 
											product_category ON product_offering_detail.product_id = product_category.id
										INNER JOIN 
											offering_category ON product_offering_detail.offering_id = offering_category.id
										ORDER BY 
											product_offering.id DESC")->getResultArray();
		
		if(!empty($type)) {
			$qry = $this->db->query("SELECT 
											product_offering.*, product_offering.id as main_id,
											product_offering_detail.*,
											product_category.name as product_name,  
											offering_category.name as category_name
										FROM 
											`product_offering`
										INNER JOIN 
											product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
										INNER JOIN 
											product_category ON product_offering_detail.product_id = product_category.id
										INNER JOIN 
											offering_category ON product_offering_detail.offering_id = offering_category.id
										WHERE 
											product_offering_detail.offering_id = ?
										ORDER BY 
											product_offering.id DESC", [$type])->getResultArray();
											
		}
		if(!empty($type)&&!empty($ptype)) {
			$qry = $this->db->query("SELECT 
										product_offering.*, product_offering.id as main_id,
										product_offering_detail.*,
										product_category.name AS product_name,  
										offering_category.name AS category_name
									FROM 
										`product_offering`
									INNER JOIN 
										product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
									INNER JOIN 
										product_category ON product_offering_detail.product_id = product_category.id
									INNER JOIN 
										offering_category ON product_offering_detail.offering_id = offering_category.id
									WHERE 
										product_offering_detail.offering_id = ? AND product_offering_detail.product_id = ?
									ORDER BY 
										product_offering.id DESC", [$type, $ptype])->getResultArray();
		}
	
		$totalGramsByCategory = [];
		$i = 1;
		foreach ($qry as $row) {
			
			$data[] = array(
				$i++,
				'<p style="text-align:left;">' . $row['name'] . '</p>',
				$row['phone'],
				$row['category_name'],
				$row['product_name'],
				$row['grams'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/offering/print_offering/'. $row['main_id'].'" target="_blank"><i class="material-icons">print</i> </a>'
			);

			if (isset($totalGramsByCategory[$row['category_name']])) {
				$totalGramsByCategory[$row['category_name']] += $row['grams'];
			} else {
				$totalGramsByCategory[$row['category_name']] = $row['grams'];
			}
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
			"totals" => $totalGramsByCategory
		);
		echo json_encode($result);
		exit();
	}

	public function print_offeringreport()
	{
		
		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$tdt = date('Y-m-d', strtotime($_REQUEST['tdt']));
		$type = $_REQUEST['offering_id'];
		$ptype = $_REQUEST['product_id'];

		$data['fdate'] = $fdt;
		$data['tdate'] = $tdt;
		$data['type'] = $type;
		$data['ptype'] = $ptype;
		
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_stockreport'] == "PDF") {
			
			$file_name = "Offering_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/offering_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_stockreport'] == "EXCEL") {
			$fileName = "Offering_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Name');
			$sheet->setCellValue('C2', 'Phone');
			$sheet->setCellValue('D2', 'Category');
			$sheet->setCellValue('E2', 'Product');
			$sheet->setCellValue('F2', 'Grams');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			// $sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_offering($data['fdate'], $data['tdate'], $data['cdate'], $data['type'], $data['ptype']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['name']);
				$sheet->setCellValue('C' . $rows, $val['phone']);
				$sheet->setCellValue('D' . $rows, $val['category_name']);
				$sheet->setCellValue('E' . $rows, $val['product_name']);
				$sheet->setCellValue('F' . $rows, $val['grams']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				// $sheet->setCellValue('G' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/offering_print', $data);
		}
	}

	public function excel_format_get_offering($fdata, $tdata, $cdata, $type, $ptype)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt= date('Y-m-d',strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];
		
		// $dat = $this->db->table('templebooking', 'booked_packages.name as pname')
		// 	->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
		// 	->select('booked_packages.name as pname')
		// 	->select('templebooking.*')
		// 	->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		// $dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);
		
		// if ($booking_type) {
		// 	$dat = $dat->where('booked_packages.booking_type', $booking_type);
		// }
		// if (!empty($cdt)) {
		// 	$dat = $dat->where('templebooking.booking_date =', $cdt);
		// }

		// if (!empty($group_filter_fill) && $group_filter_fill != "0") {
		// 	$dat = $dat->where('templebooking.payment_type', $group_filter_fill);
		// }
		
		// $dat = $dat->orderBy('entry_date', 'desc');
		// $dat = $dat->get()->getResultArray();


		$builder = $this->db->table('product_offering')
    ->select('
        product_offering.*,
        product_offering_detail.*,
        product_category.name AS product_name,
        offering_category.name AS category_name
    ')
    ->join('product_offering_detail', 'product_offering_detail.pro_off_id = product_offering.id')
    ->join('product_category', 'product_offering_detail.product_id = product_category.id')
    ->join('offering_category', 'product_offering_detail.offering_id = offering_category.id');

	// Apply condition if $type is not empty
	if (!empty($type)) {
		$builder->where('product_offering_detail.offering_id', $type);
	}

	// Apply condition if $ptype is not empty
	if (!empty($ptype)) {
		$builder->where('product_offering_detail.product_id', $ptype);
	}

	// Order the results
	$builder->orderBy('product_offering.id', 'DESC');

	// Execute the query
	$qry = $builder->get()->getResultArray();

		$i = 1;
		foreach ($qry as $row) {
			
			$data[] = array(
				"s_no" => $i++,
				"name" => $row['name'],
				"phone" => $row['phone'],
				"category_name" => $row['category_name'],
				"product_name" => $row['product_name'],
				"grams" => $row['grams']
			);
		}
		return $data;
	}


	public function print_offering()
	{
		// if(!$this->model->permission_validate('annathanam', 'print')){
		// 	header('Location: '.base_url().'/dashboard');
		// }
		$id=  $this->request->uri->getSegment(3);
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		
	    $data['data'] = $this->db->table('product_offering')->select('product_offering.*')
							->where('id', $id)
							->get()
							->getRowArray();
		
		$data['offering_items'] = $this->db->table('product_offering_detail')
											->select('product_offering_detail.*, product_category.name as product_name, offering_category.name as category_name')
											->join('offering_category', 'product_offering_detail.offering_id = offering_category.id')
											->join('product_category', 'product_offering_detail.product_id = product_category.id')
											->where('product_offering_detail.pro_off_id', $id)->get()->getResultArray();
		
		echo view('offering/print_offering',$data);
	}
	
	
	
}
