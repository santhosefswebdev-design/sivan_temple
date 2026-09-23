<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Customer_mybooking extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
    }
    public function index(){
     // var_dump($_SESSION);
      //exit;
      echo view('front_user/layout/header');
		  echo view('front_user/mybooking/index');
		  echo view('front_user/layout/footer');
    }
  public function get_archanai_booking()
  {
      $fdata = $_POST['fdt'];
      $tdata = $_POST['tdt'];
      $i = 1;
      $data = array();
      $login_id = $_SESSION['log_id_frend'];
      //echo '<pre>';
      $query1 = $this->db->query("select a.id,a.date, b.archanai_id, sum(b.quantity) as qunty, sum(b.total_amount) as amt, sum(b.total_commision) as comm from archanai_booking as a LEFT JOIN archanai_booking_details as b ON b.archanai_booking_id = a.id WHERE a.entry_by = '$login_id' and a.date >= '$fdata' and a.date <= '$tdata' group by b.archanai_booking_id");
      $res = $query1->getResultArray();
      if (!empty($res)) {
        foreach ($res as $row) {
          $ar_id = $row['id'];
          //print_r($row);
          $actions = "<a href='".base_url()."/customer_mybooking/print_booking_archanai/$ar_id' class='btn btn-primary' style='padding: 1px 10px;font-size: 12px;' target='_blank'>Print</a>&nbsp;<a href='".base_url()."/customer_mybooking/pdf_booking_archanai/$ar_id' class='btn btn-danger' style='padding: 1px 10px;font-size: 12px;' target='_blank'>PDF</a>";
          $total = $row['amt'] + $row['comm'];
          $aname = $this->db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
          $data[] = array(
            $i++,
            date("d-m-Y", strtotime($row['date'])),
            $aname['name_eng'],
            $aname['name_tamil'],
            $row['qunty'],
            number_format($total, '2', '.', ','),
            $actions
          );
        }
      }

      //die;
      $result = array(
        "draw" => 0,
        "recordsTotal" => $i - 1,
        "recordsFiltered" => $i - 1,
        "data" => $data,
      );
      echo json_encode($result);
      exit();
  }
  public function print_booking_archanai($id) {
		$data['qry1'] = $archanai_booking = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'frontend/archanai/print';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
					->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
					->where('archanai_booking_details.archanai_booking_id', $id )
					->select('archanai.*')
					->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
					->get()
					->getResultArray();
		$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
					->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
					->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
					->where('archanai_booking_rasi.archanai_booking_id', $id )
					->select('archanai_booking_rasi.*')
					->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
					->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
					->get()
					->getResultArray();
		$data['vehicles'] = $this->db->table('archanai_booking_vehicle')
					->where('archanai_booking_vehicle.archanai_booking_id', $id )
					->select('archanai_booking_vehicle.*')
					->get()
					->getResultArray();
		$url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		$data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
		echo view($view_file, $data);
	}
  public function pdf_booking_archanai($id) {
		$data['qry1'] = $archanai_booking = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'frontend/archanai/print';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
					->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
					->where('archanai_booking_details.archanai_booking_id', $id )
					->select('archanai.*')
					->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
					->get()
					->getResultArray();
		$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
					->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
					->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
					->where('archanai_booking_rasi.archanai_booking_id', $id )
					->select('archanai_booking_rasi.*')
					->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
					->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
					->get()
					->getResultArray();
		$data['vehicles'] = $this->db->table('archanai_booking_vehicle')
					->where('archanai_booking_vehicle.archanai_booking_id', $id )
					->select('archanai_booking_vehicle.*')
					->get()
					->getResultArray();
		$url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		$data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
    $file_name = "Online_Archanai_Booking" . $id;
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$dompdf->loadHtml(view($view_file, $data));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($file_name);
	}
  public function get_hall_booking()
	{
		$fdt = $_POST['fdt'];
		$tdt = $_POST['tdt'];
    $login_id = $_SESSION['log_id_frend'];
    $dat = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->where('entry_by',$login_id)->get()->getResultArray();
		$data = [];
		$i = 1;
		$sts = "";
		foreach ($dat as $row) {
      $pr_id = $row['id'];
      $actions = "<a href='".base_url()."/customer_mybooking/print_hall_booking/$pr_id' class='btn btn-primary' style='padding: 1px 10px;font-size: 12px;' target='_blank'>Print</a>&nbsp;<a href='".base_url()."/customer_mybooking/pdf_hall_booking/$pr_id' class='btn btn-danger' style='padding: 1px 10px;font-size: 12px;' target='_blank'>PDF</a>";
			if ($row['status'] == 1)
				$sts = "Booked";
			else if ($row['status'] == 2)
				$sts = "Completed";
			else if ($row['status'] == 3)
				$sts = "Cancelled";
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['booking_date'])),
				date('d-m-Y', strtotime($row['entry_date'])),
				$row['name'],
				$row['event_name'],
				$sts,
				$row['total_amount'],
				$row['paid_amount'],
				$row['balance_amount'],
        $actions
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
  public function print_hall_booking($id)
	{
		$data['qry1'] = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
		$data['hall_booking_details'] = $this->db->table("hall_booking_service_details")->select('hall_booking_service_details.*')->where("hall_booking_service_details.hall_booking_id", $id)->get()->getResultArray();
		//print_r($data['hall_booking_details']);
		$data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$view_file = 'frontend/booking/print_a4';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
    echo view($view_file, $data);
	}
  public function pdf_hall_booking($id)
	{
		$data['qry1'] = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
		$data['hall_booking_details'] = $this->db->table("hall_booking_service_details")->select('hall_booking_service_details.*')->where("hall_booking_service_details.hall_booking_id", $id)->get()->getResultArray();
		//print_r($data['hall_booking_details']);
		$data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$view_file = 'frontend/booking/print_a4';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$file_name = "Online_Hall_Booking" . $id;
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$dompdf->loadHtml(view($view_file, $data));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($file_name);
	}
    public function get_ubayam_booking()
	  {
          $fdt = date('Y-m-d', strtotime($_POST['fdt']));
          $tdt = date('Y-m-d', strtotime($_POST['tdt']));
          $login_id = $_SESSION['log_id_frend'];
          $data = [];
          $dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
                          ->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
                          ->select('ubayam_setting.name as pname')
                          ->select('ubayam.*')
                          ->where('ubayam.added_by',$login_id)
                          ->where('DATE_FORMAT(ubayam.dt, "%Y-%m-%d") >=', $fdt);
          $dat = $dat->where('DATE_FORMAT(ubayam.dt, "%Y-%m-%d") <=', $tdt);
          $dat = $dat->orderBy('ubayam.dt', 'asc');
          $dat = $dat->get()->getResultArray();

          $i = 1;
          foreach ($dat as $row) {
            $pr_id = $row['id'];
            $actions = "<a href='".base_url()."/customer_mybooking/print_ubayam_booking/$pr_id' class='btn btn-primary' style='padding: 1px 10px;font-size: 12px;' target='_blank'>Print</a>&nbsp;<a href='".base_url()."/customer_mybooking/pdf_ubayam_booking/$pr_id' class='btn btn-danger' style='padding: 1px 10px;font-size: 12px;' target='_blank'>PDF</a>";
            $balance_amount = (float) $row['amount'] - (float) $row['paidamount'];
            if ($balance_amount < 0)
              $balance_amount = 0;
            if (empty($balance_amount)) {
              $txt = '<span class="paid_text">Paid</span>';
            } else {
              $txt = '<span class="unpaid_text">Not Paid</span>';
            }

            $data[] = array(
              $i++,
              date('d-m-Y', strtotime($row['dt'])),
              $row['pname'],
              $row['name'],
              $row['amount'],
              $row['paidamount'],
              number_format($balance_amount, '2', '.', ','),
              $txt,
              $actions
            );
          }

          $result = array(
            "draw" => 0,
            "recordsTotal" => $i - 1,
            "recordsFiltered" => $i - 1,
            "data" => $data,
          );
          echo json_encode($result);
          exit();
	  }
    public function print_ubayam_booking($id) {
      $data['qry1'] = $ubayam = $this->db->table('ubayam')
              ->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
              ->select('ubayam_setting.name as uname')
              ->select('ubayam.*')
              ->where('ubayam.id', $id)
              ->get()->getRowArray();
      $view_file = 'front_user/ubayam/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
      $data['payment'] 	= $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      $data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
      echo view($view_file, $data);
    }
    public function pdf_ubayam_booking($id) {
      $data['qry1'] = $ubayam = $this->db->table('ubayam')
              ->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
              ->select('ubayam_setting.name as uname')
              ->select('ubayam.*')
              ->where('ubayam.id', $id)
              ->get()->getRowArray();
      $view_file = 'front_user/ubayam/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
      $data['payment'] 	= $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      $data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
      $file_name = "Online_Ubayam_Booking" . $id;
      $dompdf = new \Dompdf\Dompdf();
      $options = $dompdf->getOptions();
      $options->set(array('isRemoteEnabled' => true));
      $dompdf->setOptions($options);
      $dompdf->loadHtml(view($view_file, $data));
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($file_name);
    }
    public function get_prasadam_booking()
    {
        $fdt = date('Y-m-d', strtotime($_POST['fdt']));
        $tdt = date('Y-m-d', strtotime($_POST['tdt']));
        $login_id = $_SESSION['log_id_frend'];
        $data = [];
        $dat = $this->db->table('prasadam')
                        ->select('prasadam.id,prasadam.date,prasadam.customer_name,prasadam.collection_date,prasadam.amount')
                        ->where('prasadam.added_by',$login_id)
                        ->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") >=', $fdt);
        $dat = $dat->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") <=', $tdt);
        $dat = $dat->orderBy('prasadam.date', 'asc');
        $dat = $dat->get()->getResultArray();
        $i = 1;
        foreach ($dat as $row) {
          $pr_id = $row['id'];
          $actions = "<a href='".base_url()."/customer_mybooking/print_prasadam_booking/$pr_id' class='btn btn-primary' style='padding: 1px 10px;font-size: 12px;' target='_blank'>Print</a>&nbsp;<a href='".base_url()."/customer_mybooking/pdf_prasadam_booking/$pr_id' class='btn btn-danger' style='padding: 1px 10px;font-size: 12px;' target='_blank'>PDF</a>";

          $payfors = $this->db->table('prasadam_booking_details')->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')->select('prasadam_setting.name_eng,prasadam_setting.name_tamil')->where('prasadam_booking_details.prasadam_booking_id', $row['id'])->get()->getResultArray();
          $html = "";
          foreach ($payfors as $payfor) {
            $html .= "&#x2022; " . $payfor['name_eng'] . " / " . $payfor['name_tamil'] . "<br>";
          }
          if(!empty($row['collection_date'])){
            if($row['collection_date'] == "0000-00-00"){
              $collection_date = "";
            }
            else{
              $collection_date = date('d-m-Y', strtotime($row['collection_date']));
            }
            
          }
          else{
            $collection_date = "";
          }
          $data[] = array(
            $i++,
            date('d-m-Y', strtotime($row['date'])),
            $row['customer_name'],
            $collection_date,
            "<p style='text-align: left;'>" . $html . "</p>",
            number_format($row['amount'], '2', '.', ','),
            $actions
          );
        }

        $result = array(
          "draw" => 0,
          "recordsTotal" => $i - 1,
          "recordsFiltered" => $i - 1,
          "data" => $data,
        );
        echo json_encode($result);
        exit();
    }
    public function print_prasadam_booking($id) {
      $data['qry1'] = $prasadam = $this->db->table('prasadam')
                                        ->select('prasadam.*')
                                        ->where('prasadam.id', $id)
                                        ->get()->getRowArray();
      $data['qry1_payfor'] =  $this->db->table('prasadam_booking_details')
                                        ->join('prasadam_setting','prasadam_setting.id = prasadam_booking_details.prasadam_id')
                                        ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
                                        ->where('prasadam_booking_details.prasadam_booking_id', $id)
                                        ->get()->getResultArray();
      $view_file = 'front_user/prasadam/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		  $data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
      echo view($view_file, $data);
    }
    public function pdf_prasadam_booking($id) {
      $data['qry1'] = $prasadam = $this->db->table('prasadam')
                                        ->select('prasadam.*')
                                        ->where('prasadam.id', $id)
                                        ->get()->getRowArray();
      $data['qry1_payfor'] =  $this->db->table('prasadam_booking_details')
                                        ->join('prasadam_setting','prasadam_setting.id = prasadam_booking_details.prasadam_id')
                                        ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
                                        ->where('prasadam_booking_details.prasadam_booking_id', $id)
                                        ->get()->getResultArray();
      $view_file = 'front_user/prasadam/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		  $data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
      $file_name = "Online_Prasadam_Booking" . $id;
      $dompdf = new \Dompdf\Dompdf();
      $options = $dompdf->getOptions();
      $options->set(array('isRemoteEnabled' => true));
      $dompdf->setOptions($options);
      $dompdf->loadHtml(view($view_file, $data));
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($file_name);
    }
    public function get_cash_donation_booking()
    {
      $fdt = date('Y-m-d', strtotime($_POST['fdt']));
      $tdt = date('Y-m-d', strtotime($_POST['tdt']));
      $login_id = $_SESSION['log_id_frend'];
      $data = [];
      $dat = $this->db->table('donation', 'donation_setting.name as pname')
                      ->join('donation_setting', 'donation_setting.id = donation.pay_for')
                      ->select('donation_setting.name as pname')
                      ->select('donation.*')
                      ->where('donation.added_by', $login_id)
                      ->where('donation.date>=', $fdt);
      $dat = $dat->where('donation.date<=', $tdt);
      $dat = $dat->get()->getResultArray();
      $i = 1;
      foreach ($dat as $row) {
          $pr_id = $row['id'];
          $actions = "<a href='".base_url()."/customer_mybooking/print_cashdonation_booking/$pr_id' class='btn btn-primary' style='padding: 1px 10px;font-size: 12px;' target='_blank'>Print</a>&nbsp;<a href='".base_url()."/customer_mybooking/pdf_cashdonation_booking/$pr_id' class='btn btn-danger' style='padding: 1px 10px;font-size: 12px;' target='_blank'>PDF</a>";
          $data[] = array(
            $i++,
            date('d-m-Y', strtotime($row['date'])),
            $row['pname'],
            $row['name'],
            number_format($row['amount'], '2', '.', ','),
            $actions
          );
      }

      $result = array(
        "draw" => 0,
        "recordsTotal" => $i - 1,
        "recordsFiltered" => $i - 1,
        "data" => $data,
      );
      echo json_encode($result);
      exit();
    }
    public function print_cashdonation_booking($id) {
      $data['qry1'] = $donation = $this->db->table('donation')
                                          ->join('donation_setting', 'donation_setting.id = donation.pay_for')
                                          ->select('donation_setting.name as pname')
                                          ->select('donation.*')
                                          ->where('donation.id', $id)
                                          ->get()->getRowArray();
      $view_file = 'front_user/donation/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      echo view($view_file, $data);
    }
    public function pdf_cashdonation_booking($id) {
      $data['qry1'] = $donation = $this->db->table('donation')
                                          ->join('donation_setting', 'donation_setting.id = donation.pay_for')
                                          ->select('donation_setting.name as pname')
                                          ->select('donation.*')
                                          ->where('donation.id', $id)
                                          ->get()->getRowArray();
      $view_file = 'front_user/donation/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      $file_name = "Online_Cashdonation_Booking" . $id;
      $dompdf = new \Dompdf\Dompdf();
      $options = $dompdf->getOptions();
      $options->set(array('isRemoteEnabled' => true));
      $dompdf->setOptions($options);
      $dompdf->loadHtml(view($view_file, $data));
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream($file_name);
    }








}
