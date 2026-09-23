<?php
namespace App\Controllers;
require_once('Classes/PHPExcel.php');
include 'Classes/PHPExcel/IOFactory.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Libraries;
use App\Controllers\BaseController;

class Import extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        if( ($this->session->get('login') ) == false ){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/import');
		echo view('template/footer');
    }
	
	public function save(){

		helper(array('form', 'url'));
		if(!empty($_FILES['entry_file']['name']) > 0){
			$file = time() . '_' .$_FILES['entry_file']['name'];
			$target = "uploads/import/";
			$res = move_uploaded_file($_FILES['entry_file']['tmp_name'],$target.$file);
			if($res){
				print_r($target.$file);
				$img_path = $target.$file;
				
				//$file = fopen($img_path,"r");
				$reader = PHPExcel_IOFactory::createReaderForFile($img_path);
				print_r($reader);
        	    $excel_obj = $reader->load($img_path);
        	    $worksheet = $excel_obj->getSheet('0');
			}else{
				echo 'fail';
			}
			//header('Location: '.base_url().'/import');
		} 
	}
}
