<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;

class Bom extends BaseController
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
    public function archanai(){
		$data = array();
		$data['archanai_boms'] = $this->db->table('archanai')->where('dedection_from_stock',1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/archanai', $data);
		echo view('template/footer');
    }
	public function edit_archanai(){
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('archanai')->where('id', $id)->get()->getRowArray();
		$data['raw_matrials'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('archanai_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['edit'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/edit_archanai', $data);
		echo view('template/footer');
	}
	public function view_archanai(){
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('archanai')->where('id', $id)->get()->getRowArray();
		$data['raw_matrials'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('archanai_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/edit_archanai', $data);
		echo view('template/footer');
	}
	public function save_archanai(){
        $id = $_POST['id'];
		if(!empty($_POST['rawmaterial']))
		{
			foreach($_POST['rawmaterial'] as $row){
				$raws['product_id'] = $id;
				$raws['raw_id'] = $row['raw_id'];
				$raws['qty'] = $row['raw_qty'];
				$this->db->table('archanai_raw_material_items')->insert($raws);
			}
		}
		$this->session->setFlashdata('succ', 'Bom Added Successfully');
    	header("Location: ".base_url()."/bom/archanai");
	}
	public function prasadam(){
		$data = array();
		$data['prasadam_boms'] = $this->db->table('prasadam_setting')->where('dedection_from_stock',1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/prasadam', $data);
		echo view('template/footer');
    }
	public function edit_prasadam(){
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('prasadam_setting')->where('id', $id)->get()->getRowArray();
		$data['raw_matrials'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('prasadam_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['edit'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/edit_prasadam', $data);
		echo view('template/footer');
	}
	public function view_prasadam(){
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('prasadam_setting')->where('id', $id)->get()->getRowArray();
		$data['raw_matrials'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('prasadam_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/edit_prasadam', $data);
		echo view('template/footer');
	}
	public function save_prasadam(){
        $id = $_POST['id'];
		if(!empty($_POST['rawmaterial']))
		{
			foreach($_POST['rawmaterial'] as $row){
				$raws['product_id'] = $id;
				$raws['raw_id'] = $row['raw_id'];
				$raws['qty'] = $row['raw_qty'];
				$this->db->table('prasadam_raw_material_items')->insert($raws);
			}
		}
		$this->session->setFlashdata('succ', 'Bom Added Successfully');
    	header("Location: ".base_url()."/bom/prasadam");
	}
	public function archanai_report(){
		
		if(!$this->model->list_validate('bom_archanai_report')){
			header('Location: '.base_url().'/dashboard');
		}	
        $data['prds_name'] =  $this->db->table('archanai')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/archanai_report', $data);
		echo view('template/footer');
    }
	public function archanai_rep_ref(){
		$fdt= date('Y-m-d',strtotime($_POST['fdt']));
		$tdt= date('Y-m-d',strtotime($_POST['tdt']));
		$productname= $_POST['productname'];
		$data = [];
		$data_archanais = $this->db->table('stock_outward as s')
								->join('stock_outward_list as sl', 'sl.stack_out_id = s.id')
								->select('sum(sl.quantity) as stockout,s.date,sl.item_name,sl.dedection_id,sl.item_id,sl.quantity')
								->where('sl.item_type', 2)
								->where('sl.dedection_from', "Archanai")
								->where('s.date >=', $fdt)
								->where('s.date <=', $tdt);
							if(!empty($productname))
							{
								$data_archanais = $data_archanais->where('sl.dedection_id =', $productname);
							}
							$data_archanais = $data_archanais->groupBy('s.date')
							->groupBy('sl.item_id')
							->orderBy('s.date','DESC')
							->get()->getResultArray();
		$i = 1;	
		foreach($data_archanais as $data_archanai)
		{
			$archanai_data = $this->db->table('archanai')->where('id',$data_archanai['dedection_id'])->get()->getRowArray();
			$archanai_name = $archanai_data["name_eng"]." / ".$archanai_data["name_tamil"];
			$archanai_raw_mat_data = $this->db->table('archanai_raw_material_items')
										->where('product_id',$data_archanai['dedection_id'])
										->where('raw_id',$data_archanai['item_id'])
										->get()->getRowArray();
			$archanai_count = 	(float)$data_archanai['quantity'] / (float)$archanai_raw_mat_data['qty'];					
			if($data_archanai['stockout'] > 0) $sotq = $data_archanai['stockout']; else $sotq = 0;
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($data_archanai['date']))  ,
				$archanai_name,
				$archanai_count,
				$data_archanai['item_name'],
				$sotq
			);
		}
		
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i-1,
			"recordsFiltered" => $i-1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();		
    }
	public function print_archanaireport()
	{
		if(!$this->model->list_validate('bom_archanai_report')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['fdate']= $_REQUEST['fdt'];
		$data['tdate']= $_REQUEST['tdt'];
		$productname = $_REQUEST['productname'];
		$data['productname'] = $productname;
		$data_archanais = $this->db->table('stock_outward as s')
								->join('stock_outward_list as sl', 'sl.stack_out_id = s.id')
								->select('sum(sl.quantity) as stockout,s.date,sl.item_name,sl.dedection_id,sl.item_id,sl.quantity')
								->where('sl.item_type', 2)
								->where('sl.dedection_from', "Archanai")
								->where('s.date >=', $data['fdate'])
								->where('s.date <=', $data['tdate']);
							if(!empty($productname))
							{
								$data_archanais = $data_archanais->where('sl.dedection_id =', $productname);
							}
							$data_archanais = $data_archanais->groupBy('s.date')
							->groupBy('sl.item_id')
							->orderBy('s.date','DESC')
							->get()->getResultArray();
		$data['data'] = $data_archanais;
		
		if($_REQUEST['pdf_archanaireport'] == "PDF")
		{
			$file_name = "BOM_Archanai_Report_".$data['fdate']."_to_".$data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions(); 
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);			
			$dompdf->loadHtml(view('bom/pdf/archanai_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		}
		elseif($_REQUEST['excel_archanaireport'] == "EXCEL")
		{
			$fileName = "BOM_Archanai_Report_".$data['fdate']."_to_".$data['tdate'];  
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1'); 
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Item Name');
			$sheet->setCellValue('D2', 'Item Count');      
			$sheet->setCellValue('E2', 'Raw Material Name');    
			$sheet->setCellValue('F2', 'Used Quantity');    
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			foreach ($data['data'] as $val)
			{
				$archanai_data = $this->db->table('archanai')->where('id',$val['dedection_id'])->get()->getRowArray();
				$archanai_name = $archanai_data["name_eng"]." / ".$archanai_data["name_tamil"];
				$archanai_raw_mat_data = $this->db->table('archanai_raw_material_items')
											->where('product_id',$val['dedection_id'])
											->where('raw_id',$val['item_id'])
											->get()->getRowArray();
				$archanai_count = 	(float)$val['quantity'] / (float)$archanai_raw_mat_data['qty'];					
				if($val['stockout'] > 0) $sotq = $val['stockout']; else $sotq = 0;
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($val['date'])));
				$sheet->setCellValue('C' . $rows, $archanai_name);
				$sheet->setCellValue('D' . $rows, $archanai_count);
				$sheet->setCellValue('E' . $rows, $val['item_name']);
				$sheet->setCellValue('F' . $rows, $sotq);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/'.$fileName.'.xlsx');
			return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');
		}
		else
		{
			echo view('bom/archanai_print', $data);
		}
	}
	public function prasadam_report(){
		
		if(!$this->model->list_validate('bom_prasadam_report')){
			header('Location: '.base_url().'/dashboard');
		}	
        $data['prds_name'] =  $this->db->table('prasadam_setting')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('bom/prasadam_report', $data);
		echo view('template/footer');
    }
	public function prasadam_rep_ref(){
		$fdt= date('Y-m-d',strtotime($_POST['fdt']));
		$tdt= date('Y-m-d',strtotime($_POST['tdt']));
		$productname= $_POST['productname'];
		$data = [];
		$data_prasadams = $this->db->table('stock_outward as s')
								->join('stock_outward_list as sl', 'sl.stack_out_id = s.id')
								->select('sum(sl.quantity) as stockout,s.date,sl.item_name,sl.dedection_id,sl.item_id,sl.quantity')
								->where('sl.item_type', 2)
								->where('sl.dedection_from', "Prasadam")
								->where('s.date >=', $fdt)
								->where('s.date <=', $tdt);
							if(!empty($productname))
							{
								$data_prasadams = $data_prasadams->where('sl.dedection_id =', $productname);
							}
							$data_prasadams = $data_prasadams->groupBy('s.date')
							->groupBy('sl.item_id')
							->orderBy('s.date','DESC')
							->get()->getResultArray();
		$i = 1;	
		foreach($data_prasadams as $data_prasadam)
		{
			$prasadam_data = $this->db->table('prasadam_setting')->where('id',$data_prasadam['dedection_id'])->get()->getRowArray();
			$prasadam_name = $prasadam_data["name_eng"]." / ".$prasadam_data["name_tamil"];
			$prasadam_raw_mat_data = $this->db->table('prasadam_raw_material_items')
										->where('product_id',$data_prasadam['dedection_id'])
										->where('raw_id',$data_prasadam['item_id'])
										->get()->getRowArray();
			$prasadam_count = 	(float)$data_prasadam['quantity'] / (float)$prasadam_raw_mat_data['qty'];					
			if($data_prasadam['stockout'] > 0) $sotq = $data_prasadam['stockout']; else $sotq = 0;
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($data_prasadam['date']))  ,
				$prasadam_name,
				$prasadam_count,
				$data_prasadam['item_name'],
				$sotq
			);
		}
		
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i-1,
			"recordsFiltered" => $i-1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();		
    }
	public function print_prasadamreport()
	{
		if(!$this->model->list_validate('bom_prasadam_report')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['fdate']= $_REQUEST['fdt'];
		$data['tdate']= $_REQUEST['tdt'];
		$productname = $_REQUEST['productname'];
		$data['productname'] = $productname;
		$data_prasadams = $this->db->table('stock_outward as s')
								->join('stock_outward_list as sl', 'sl.stack_out_id = s.id')
								->select('sum(sl.quantity) as stockout,s.date,sl.item_name,sl.dedection_id,sl.item_id,sl.quantity')
								->where('sl.item_type', 2)
								->where('sl.dedection_from', "Prasadam")
								->where('s.date >=', $data['fdate'])
								->where('s.date <=', $data['tdate']);
							if(!empty($productname))
							{
								$data_prasadams = $data_prasadams->where('sl.dedection_id =', $productname);
							}
							$data_prasadams = $data_prasadams->groupBy('s.date')
							->groupBy('sl.item_id')
							->orderBy('s.date','DESC')
							->get()->getResultArray();
		$data['data'] = $data_prasadams;
		
		if($_REQUEST['pdf_prasadamreport'] == "PDF")
		{
			$file_name = "BOM_Prasadam_Report_".$data['fdate']."_to_".$data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions(); 
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);			
			$dompdf->loadHtml(view('bom/pdf/prasadam_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		}
		elseif($_REQUEST['excel_prasadamreport'] == "EXCEL")
		{
			$fileName = "BOM_Prasadam_Report_".$data['fdate']."_to_".$data['tdate'];  
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1'); 
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Item Name');
			$sheet->setCellValue('D2', 'Item Count');      
			$sheet->setCellValue('E2', 'Raw Material Name');    
			$sheet->setCellValue('F2', 'Used Quantity');    
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			foreach ($data['data'] as $val)
			{
				$prasadam_data = $this->db->table('prasadam_setting')->where('id',$val['dedection_id'])->get()->getRowArray();
				$prasadam_name = $prasadam_data["name_eng"]." / ".$prasadam_data["name_tamil"];
				$prasadam_raw_mat_data = $this->db->table('prasadam_raw_material_items')
											->where('product_id',$val['dedection_id'])
											->where('raw_id',$val['item_id'])
											->get()->getRowArray();
				$prasadam_count = 	(float)$val['quantity'] / (float)$prasadam_raw_mat_data['qty'];					
				if($val['stockout'] > 0) $sotq = $val['stockout']; else $sotq = 0;
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($val['date'])));
				$sheet->setCellValue('C' . $rows, $prasadam_name);
				$sheet->setCellValue('D' . $rows, $prasadam_count);
				$sheet->setCellValue('E' . $rows, $val['item_name']);
				$sheet->setCellValue('F' . $rows, $sotq);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/'.$fileName.'.xlsx');
			return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');
		}
		else
		{
			echo view('bom/prasadam_print', $data);
		}
	}


}
