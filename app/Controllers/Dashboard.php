<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
class Dashboard extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common');
		$this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		$data['view'] = true;
		if(!$this->model->list_validate('dashboard')){
			$data['view'] = false;
		}
		//$_SESSION['language'] = 'english';
		//global $lang;
		//echo $lang->login;
		//die;
		$dt= date('Y-m-d');
        $res['data']= $this->db->table('admin_profile')->get()->getRowArray();
		
		// $data['ubayam'] = $this->db->query("SELECT `ubayam_setting`.`name` as `ubname`, sum(ubayam.paidamount) as amount FROM `ubayam` JOIN `ubayam_setting` ON `ubayam_setting`.`id` = `ubayam`.`pay_for` WHERE `ubayam`.`dt` = '$dt' and (((ubayam.paid_through = 'ONLINE' or ubayam.paid_through = 'COUNTER') and ubayam.payment_status = 2) or (ubayam.paid_through = 'Direct')) GROUP BY `ubayam`.`pay_for` ORDER BY `ubayam`.`id` DESC")->getResultArray();
       
		$data['donation'] = $this->db->query("SELECT `donation_setting`.`name` as `dname`, sum(donation.amount) as amount FROM `donation` JOIN `donation_setting` ON `donation_setting`.`id` = `donation`.`pay_for` WHERE `donation`.`date` = '$dt' and (((donation.paid_through = 'ONLINE' or donation.paid_through = 'COUNTER') and donation.payment_status = 2) or (donation.paid_through = 'Direct')) GROUP BY `donation`.`pay_for` ORDER BY `donation`.`id` DESC")->getResultArray();
		
		// $data['hall'] = $this->db->query("SELECT `hall_booking`.`id`, `hall_booking`.`event_name`, sum(hall_booking_pay_details.amount) as amount FROM `hall_booking` JOIN `hall_booking_pay_details` ON `hall_booking_pay_details`.`hall_booking_id` = `hall_booking`.`id` WHERE DATE_FORMAT(hall_booking.entry_date, \"%Y-%m-%d\") = '$dt' AND `hall_booking`.`status` IN (1,2) and (((hall_booking.paid_through = 'ONLINE' or hall_booking.paid_through = 'COUNTER') and hall_booking.payment_status = 2) or (hall_booking.paid_through = 'Direct')) GROUP BY `hall_booking`.`id`")->getResultArray();
		
		$data['archanai'] = $this->db->query("SELECT sum(archanai_booking_details.quantity) as tQty, sum(archanai_booking_details.total_amount + archanai_booking_details.total_commision) as tAmt, archanai.id,archanai.name_eng,archanai.name_tamil FROM archanai join archanai_booking_details on archanai.id=archanai_booking_details.archanai_id join archanai_booking on archanai_booking.id=archanai_booking_details.archanai_booking_id where archanai_booking.date='". $dt ."' and (((archanai_booking.paid_through = 'ONLINE' or archanai_booking.paid_through = 'COUNTER') and archanai_booking.payment_status = 2) or (archanai_booking.paid_through = 'Direct')) group by id order by id")->getResultArray();
		
		$data['inventory_stock'] = $this->db->query("SELECT stock_outward_list.item_name,SUM(stock_outward_list.quantity) as inventory_qty FROM stock_outward join stock_outward_list on stock_outward.id = stock_outward_list.stack_out_id where stock_outward_list.item_type = 2 and stock_outward.date = '". $dt ."' group by stock_outward_list.item_id")->getResultArray();
		$data['minimum_stock'] = $this->db->query("SELECT name, opening_stock as stock, 'Raw Material' as type FROM `raw_matrial_groups` where opening_stock <= minimum_stock UNION ALl SELECT name, opening_stock as stock, 'Product' as type FROM `product` where opening_stock <= minimum_stock")->getResultArray();
        // $query = $this->db->query("SELECT * FROM ubayam ORDER BY id DESC LIMIT 5");
        // $data['ubayam'] = $query->getResultArray();
        //$query = $this->db->query("SELECT * FROM donation ORDER BY id DESC LIMIT 5");
        //$data['donation'] = $query->getResultArray();
        //echo '<pre>'; print_r($data);die;
		$data["archanai_charts"] = archanai_charts();
		//	$data["hallbooking_charts"] = hallbooking_charts();
		echo view('template/header', $res);
		echo view('template/sidebar');
		echo view('template/content', $data);
		echo view('template/footer');
    }
	public function reload_list(){
		$json_resp = array();
		$data = array();
		if(!empty($_POST['dt'])){
			$dt= date('Y-m-d',strtotime($_POST['dt']));
			$data['ubayam'] = $this->db->query("SELECT `ubayam_setting`.`name` as `ubname`, sum(ubayam.paidamount) as amount FROM `ubayam` JOIN `ubayam_setting` ON `ubayam_setting`.`id` = `ubayam`.`pay_for` WHERE `ubayam`.`dt` = '$dt' and (((ubayam.paid_through = 'ONLINE' or ubayam.paid_through = 'COUNTER') and ubayam.payment_status = 2) or (ubayam.paid_through = 'Direct')) GROUP BY `ubayam`.`pay_for` ORDER BY `ubayam`.`id` DESC")->getResultArray();
			$data['donation'] = $this->db->query("SELECT `donation_setting`.`name` as `dname`, sum(donation.amount) as amount FROM `donation` JOIN `donation_setting` ON `donation_setting`.`id` = `donation`.`pay_for` WHERE `donation`.`date` = '$dt' and (((donation.paid_through = 'ONLINE' or donation.paid_through = 'COUNTER') and donation.payment_status = 2) or (donation.paid_through = 'Direct')) GROUP BY `donation`.`pay_for` ORDER BY `donation`.`id` DESC")->getResultArray();
			$data['hall'] = $this->db->query("SELECT `hall_booking`.`id`, `hall_booking`.`event_name`, sum(hall_booking_pay_details.amount) as amount FROM `hall_booking` JOIN `hall_booking_pay_details` ON `hall_booking_pay_details`.`hall_booking_id` = `hall_booking`.`id` WHERE DATE_FORMAT(hall_booking.entry_date, \"%Y-%m-%d\") = '$dt' AND `hall_booking`.`status` IN (1,2) and (((hall_booking.paid_through = 'ONLINE' or hall_booking.paid_through = 'COUNTER') and hall_booking.payment_status = 2) or (hall_booking.paid_through = 'Direct')) GROUP BY `hall_booking`.`id`")->getResultArray();
			$data['archanai'] = $this->db->query("SELECT sum(archanai_booking_details.quantity) as tQty, sum(archanai_booking_details.total_amount + archanai_booking_details.total_commision) as tAmt, archanai.id,archanai.name_eng,archanai.name_tamil FROM archanai join archanai_booking_details on archanai.id=archanai_booking_details.archanai_id join archanai_booking on archanai_booking.id=archanai_booking_details.archanai_booking_id where archanai_booking.date='". $dt ."' and (((archanai_booking.paid_through = 'ONLINE' or archanai_booking.paid_through = 'COUNTER') and archanai_booking.payment_status = 2) or (archanai_booking.paid_through = 'Direct')) group by id order by id")->getResultArray();
			$data['inventory_stock'] = $this->db->query("SELECT stock_outward_list.item_name,SUM(stock_outward_list.quantity) as inventory_qty FROM stock_outward join stock_outward_list on stock_outward.id = stock_outward_list.stack_out_id where stock_outward_list.item_type = 2 and stock_outward.date = '". $dt ."' group by stock_outward_list.item_id")->getResultArray();
			$data['minimum_stock'] = $this->db->query("SELECT name, opening_stock as stock, 'Raw Material' as type FROM `raw_matrial_groups` where opening_stock <= minimum_stock UNION ALl SELECT name, opening_stock as stock, 'Product' as type FROM `product` where opening_stock <= minimum_stock")->getResultArray();
		}
		$json_resp['data'] = $data;
		$json_resp['success'] = true;
		echo json_encode($json_resp);
		exit;
	}
    public function ubayam_rep(){
		$dt= date('Y-m-d',strtotime($_POST['dt']));
		$data = [];
		$dat =  $this->db->table('ubayam', 'ubayam_setting.name as pname')
		->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
		->select('ubayam_setting.name as pname')
		->select('ubayam.*')
		->where('ubayam.dt=',$dt) 
		->get()->getResultArray();
        $i=0;
		foreach($dat as $row)
		{
            $i++;
			$data[] = array(
				$row ['name'],
				$row ['amount'],
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
    public function cash_don_rep(){
		$dt= date('Y-m-d',strtotime($_POST['dt']));
		$data = [];
		$dat = $this->db->table('donation', 'donation_setting.name as pname')
		->join('donation_setting', 'donation_setting.id = donation.pay_for')
		->select('donation_setting.name as pname')
		->select('donation.*')
		->where('donation.date=',$dt) 
		->get()->getResultArray();
        // echo '<pre>';
        // print_r($dat); exit;
        $i=0;
		foreach($dat as $row)
		{
            $i++;
			$data[] = array(
				$row ['pname'],
				$row ['amount'],
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
    public function arch_rep(){
		$dt= date('Y-m-d',strtotime($_POST['dt']));
		$data = [];

        $query   = $this->db->query("SELECT sum(archanai_booking_details.quantity) as tQty, sum(archanai_booking_details.amount) as tAmt, archanai.id,archanai.name_eng,archanai.name_tamil FROM archanai join archanai_booking_details on archanai.id=archanai_booking_details.archanai_id join archanai_booking on archanai_booking.id=archanai_booking_details.archanai_booking_id where archanai_booking.date='". $dt ."' group by id order by id");
		$i=0;
		foreach($query->getResultArray() as $row)
		{
            $i++;
			$data[] = array(
				$row ['name_eng'],
				$row ['tQty'],
				$row ['tAmt'],
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
    public function hall_rep(){
		$dt= date('Y-m-d',strtotime($_POST['dt']));
		$data = [];


		$dat = $this->db->table('hall_booking')->where('booking_date=',$dt) ->get()->getResultArray();
        // echo '<pre>';
        // print_r($dat); exit;

        $i=0;
		foreach($dat as $row)
		{
			if($row ['paid_amount'] > 0){
				$i++;
				$data[] = array(
					$row ['event_name'],
					$row ['paid_amount'],
				);
			}  
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
	public function AmountInWords(){
        $amount = (float)$_POST['number'];
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		// // return ($num).'';
		// // exit;
        // Check if there is any number after decimal
		function NumToWords($num){
			$num=floor($num);
			$amt_hundred = null;
			$count_length = strlen($num);
			$x = 0;
			$string = array();
			$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
				3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
				7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
				10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
				13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
				16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
				19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
				40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
				70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
				$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
				while( $x < $count_length ) {
					$get_divider = ($x == 2) ? 10 : 100;
					$amount = floor($num % $get_divider);
					$num = floor($num / $get_divider);
					$x += $get_divider == 10 ? 1 : 2;
					if ($amount) {
						$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
						$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
						$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
					}else $string[] = null;
			}
			//$implode_to_Rupees = implode('', array_reverse($string));
			return(implode('', array_reverse($string)));
		}
        
        /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
        //$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal])): '';
        
		$get_paise = ($amount_after_decimal > 0) ? " and Cents ". trim(NumToWords($amount_after_decimal)):'';
        //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        return (NumToWords($amount) ? 'Ringgit '.trim(NumToWords($amount)).'' : ''). $get_paise. ' Only';
        
		//return ($implode_to_paise).'';
		//echo json_encode($amt_words);
    }
	
	public function AmountInWords2(){
		
		// after decimal if 99 is nine nine
        
        $amount = (float)$_POST['number'];
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
            $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
            while( $x < $count_length ) {
                $get_divider = ($x == 2) ? 10 : 100;
                $amount = floor($num % $get_divider);
                $num = floor($num / $get_divider);
                $x += $get_divider == 10 ? 1 : 2;
                if ($amount) {
                    $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                    $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                    $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
                }else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
        $get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal /10]).' '. trim($change_words[$amount_after_decimal % 10]))  : '';
        
		//$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal])):'';
        //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        return ($implode_to_Rupees ? 'Ringgit '.trim($implode_to_Rupees).'' : ''). $get_paise. ' Only';
        
		//return ($amount_after_decimal).'';
		//echo json_encode($amt_words);
    }
    
    public function chart() {
		echo view('template/header');
		echo view('template/sidebar');
		echo view('template/chart');
		//echo view('template/footer');
    }
	
}
