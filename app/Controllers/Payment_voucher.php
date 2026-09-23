<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Payment_voucher extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('log_id_frend') ) == false ){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/member_login');
            exit;
		}
    }
    
    public function index(){
      $uid = 2;
      $yr=date('Y');
	  $mon=date('m');
	  $log_id_frend = $this->session->get('log_id_frend');
	  $query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $uid and month (date)='". $mon ."')")->getRowArray();
		  if($uid == 1) $bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
		  if($uid == 2) $bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
		  if($uid == 3) $bill_no = 'CON' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
		  if($uid == 4) $bill_no = 'JOR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
		  $data['entry_code'] = $bill_no;
	  $data['ledgers'] = $this->db->query("SELECT * FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)))) or (type = 1 and reconciliation = 1)")->getResultArray();
	  $data['bank_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('type', 1)->get()->getResultArray();
	  $data['en_id'] = $uid;
	  $data['reprintlists'] = $this->db->table("entries")->select('id,entry_code,narration,dr_total as amount')->where('paid_through', 'COUNTER')->Where('entry_by', $log_id_frend)->get()->getResultArray();;
      echo view('frontend/layout/header');
      //echo view('template/sidebar');
      echo view('frontend/paymentvoucher/index',$data);
      //echo view('frontend/layout/footer');
    }
    public function save_payment_entries(){
		//var_dump($_POST['entries']);
		//exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$entry_type_id = $_POST['entry_type_id'];
		$payment_date = $_POST['payment_date'];
		$payment_paymode = $_POST['payment_paymode'];
		
		$payment_entrycode = $_POST['payment_entrycode'];
		$payment_receivedfrom = $_POST['payment_receivedfrom'];
		$payment_particulars = $_POST['payment_particulars'];
		$tot_amt_input = $_POST['tot_amt_input'];
		if( !empty($tot_amt_input) && !empty($payment_paymode) ) {
            // petty_cash ledger
            $payment_debit_ac = $this->db->table('ledgers')->select('id')->where('group_id', 3)->where('name','Petty Cash')->get()->getResultArray();
            if(count($payment_debit_ac) > 0){
                $crdt_ledger_id = $payment_debit_ac[0]['id'];
            }
            else{
                $leddata['group_id'] = 3;
				$leddata['name'] = "Petty Cash";
				$leddata['code'] = "";
				$leddata['op_balance'] = "0.00";
				$leddata['op_balance_dc'] = "D";
				$leddata['type'] = NULL;
				$leddata['reconciliation'] = NULL;
				$leddata['notes'] = NULL;
				$leddata['left_code'] = "3700";
				$leddata['right_code'] = "001";
                $this->db->table('ledgers')->insert($leddata);
                $crdt_ledger_id=$this->db->insertID();
            }
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', $entry_type_id)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$data['number'] = 1;
			} else {
				$data['number'] = $number['number'] + 1;
			}
			$data['entrytype_id']   = $entry_type_id;
			$data['payment']   = $payment_paymode;
			$data['date']           = $payment_date; 
			$data['dr_total']        = $tot_amt_input; 
			$data['cr_total']        = $tot_amt_input; 
			$data['narration']      = $payment_particulars;
			$data['entry_code']      = $payment_entrycode;
			$data['paid_to']      = $payment_receivedfrom; 
			$data['narration']      = "COUNTER Payment(".$payment_entrycode.")"; 
			$data['paid_through']      = "COUNTER"; 
			$data['entry_by']      = $_SESSION['log_id_frend'];
			$this->db->table("entries")->insert($data);
        	$insid = $this->db->insertID();
			if(!empty($insid)){
				// DEBIT as of Now CREDIT
				if(!empty($payment_debit_ac))
				{
					$entryitems_c['entry_id']  = $insid;
					$entryitems_c['ledger_id'] = $crdt_ledger_id;
					$entryitems_c['details'] = $payment_receivedfrom;
					$entryitems_c['amount'] = $tot_amt_input;
					$entryitems_c['dc'] = "C";
					$this->db->table('entryitems')->insert($entryitems_c);
				}
				if(!empty($_POST['entries'])){
					foreach($_POST['entries'] as $row)
					{
						$entryitems_d['entry_id']  = $insid;
                    	$entryitems_d['ledger_id'] = $row['ledgerid'];
                    	$entryitems_d['details'] = $row['particulars'];
                    	$entryitems_d['amount'] = $row['amount'];
                    	$entryitems_d['dc'] = "D";
						$this->db->table('entryitems')->insert($entryitems_d);
					}
				}
				$msg_data['succ'] = 'Payment Entry Added Successfully';
              	$msg_data['id'] = $insid;
			}
			else{
            	$msg_data['err'] = 'Please Try Again';
        	}
		}
		else
		{
			$msg_data['err'] = 'Please Fill All Required Field';
		}
		echo json_encode($msg_data);
      	exit();
	}
    public function print_page(){
		
		$id = $this->request->uri->getSegment(3);
			
		$data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
		$tmp_id = 1;
		$data['temple_details'] = $this->db->table("admin_profile")->where('id', $tmp_id)->get()->getRowArray();
		//print_r($data['results']['entrytype_id']); die;
		if ($data['results']['entrytype_id'] !=4)
		
			echo view('entries/entries_print', $data);
		else
			echo view('entries/entries_print_journal', $data);
	}
    public function payment_debit_ac()
	{
		$rtdebit_ac = $_POST['rtdebit_ac'];
		// $reslt_data = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('left_code !=', '3600')->where('left_code !=', '3700')->get()->getResultArray();
		$reslt_data = $this->db->query("SELECT * FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)))) or (type = 1 and reconciliation = 1)")->getResultArray();
		$html = "<option value='0'>Select credit a/c</option>";
		foreach($reslt_data as $res)
		{
			$html .= "<option value=".$res["id"].">(" . $res["left_code"] . '/' . $res["right_code"] . ") - ".$res["name"]."</option>";
		}
		echo $html;
	}
    public function AmountInWords_old(){
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

	public function AmountInWords()
	{
		$amount = (float) $_POST['number'];
		$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;

		// Function to convert number to words
		function convertNumberToWords($number)
		{
			$words = [
				0 => 'zero',
				1 => 'one',
				2 => 'two',
				3 => 'three',
				4 => 'four',
				5 => 'five',
				6 => 'six',
				7 => 'seven',
				8 => 'eight',
				9 => 'nine',
				10 => 'ten',
				11 => 'eleven',
				12 => 'twelve',
				13 => 'thirteen',
				14 => 'fourteen',
				15 => 'fifteen',
				16 => 'sixteen',
				17 => 'seventeen',
				18 => 'eighteen',
				19 => 'nineteen',
				20 => 'twenty',
				30 => 'thirty',
				40 => 'forty',
				50 => 'fifty',
				60 => 'sixty',
				70 => 'seventy',
				80 => 'eighty',
				90 => 'ninety'
			];

			$suffixes = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

			if ($number == 0) {
				return $words[0];
			}

			$output = '';
			$groupIndex = 0;

			// Split number into groups of 3 digits from right to left
			while ($number > 0) {
				$group = $number % 1000;
				if ($group > 0) {
					$groupWords = convertThreeDigitNumberToWords($group, $words);
					$output = $groupWords . ' ' . $suffixes[$groupIndex] . ' ' . $output;
				}
				$number = (int) ($number / 1000);
				$groupIndex++;
			}

			return trim($output);
		}

		// Function to convert 3-digit number to words
		function convertThreeDigitNumberToWords($number, $words)
		{
			$hundreds = (int) ($number / 100);
			$remainder = $number % 100;

			$result = '';

			if ($hundreds > 0) {
				$result .= $words[$hundreds] . ' hundred';
				if ($remainder > 0) {
					$result .= ' and ';
				}
			}

			if ($remainder > 0) {
				if ($remainder < 20) {
					$result .= $words[$remainder];
				} else {
					$tens = (int) ($remainder / 10) * 10;
					$units = $remainder % 10;
					$result .= $words[$tens];
					if ($units > 0) {
						$result .= '-' . $words[$units];
					}
				}
			}

			return $result;
		}

		// Get the amount in words (Ringgit)
		$amount_in_words = convertNumberToWords(floor($amount));

		// Get the amount after decimal (paise/cents) in words
		$get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(convertNumberToWords($amount_after_decimal)) : '';

		// Return the result
		return 'Ringgit ' . trim($amount_in_words) . $get_paise . ' Only';
	}
    public function getladgerName()
	{
		$ledger_id = $_POST['ledger_id'];
		$row_data = $this->db->table('ledgers')->where('id', $ledger_id)->get()->getRowArray();
		echo '(' . $row_data['left_code'] . '/' . $row_data['right_code'] . ") - ".$row_data['name'];
	}
}