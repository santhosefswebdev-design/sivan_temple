<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;


class Memberrenewalpage extends BaseController
{
    function __construct()
    {
        parent::__construct();
        helper('url');
        helper('common_helper');
        $this->model = new PermissionModel();
        if (($this->session->get('log_id_frend')) == false) {
            $data['dn_msg'] = 'Please Login';
            header('Location: ' . base_url() . '/member_login');
            exit;
        }
    }
    public function index()
    {
        $currentDate = date("Y-m-d");

        // Deactivate members with end date below the current date
        $this->db->table('member')
            ->where('end_date <', $currentDate)
            ->where('status', 1)
            ->update(['status' => 0]);

        // Retrieve inactive members for display
        $query = $this->db->table('member')
            ->where('status', 2)
            ->get();
        $data['inactiveMembers'] = $query->getResultArray();

        echo view('frontend/layout/header');
        echo view('frontend/memberrenewalpage/index', $data);
        echo view('frontend/layout/footer');
    }
    // public function member_renewal()
    // {
    //     $currentDate = date("Y-m-d");

    //     // Deactivate members with end date below the current date
    //     $this->db->table('member')
    //         ->where('end_date <', $currentDate)
    //         ->where('status', 1)
    //         ->update(['status' => 0]);

    //     // Retrieve inactive members for display
    //     $query = $this->db->table('member')
    //         ->where('status', 2)
    //         ->get();
    //     $data['inactiveMembers'] = $query->getResultArray();

    //     echo view('frontend/layout/header');
    //     echo view('frontend/memberrenewal/member_renewal', $data);
    //     echo view('frontend/layout/footer');
    // }
    public function renewal_save()
    {
        $id = $_POST['id'];

        if (!empty($id)) {
            // Explicitly set the start date to April 4, 2024
            $data['start_date'] = date("Y-m-d");

            // Calculate the end date as one year minus one day from the start date
            $endDate = date("Y-m-d", strtotime("+1 year -1 day", strtotime($data['start_date'])));
            $data['end_date'] = $endDate;

            // Set other data as before
            $data['status'] = 1;
            $data['added_by'] = $this->session->get('log_id');
            $data['payment_status'] = 2;
            $data['payment_mode'] = trim($_POST['payment_mode']);
            $data['modified'] = date('Y-m-d H:i:s');

            // Update the member record in the database
            $res = $this->db->table('member')->where('id', $id)->update($data);

            if ($res) {
                // Prepare and insert the renewal data
                $renewal_data['member_id'] = $id;
                $renewal_data['renewal_start_date'] = $data['start_date'];
                $renewal_data['renewal_end_date'] = $endDate;
                $this->db->table('member_renewal')->insert($renewal_data);

                // Set success message and redirect
                $this->session->setFlashdata('succ', 'Member Renewal Successfully completed');
                header("Location: " . base_url() . "/memberrenewalpage/receipt_renewal_print/" . $id);
            } else {
                // Set failure message and redirect if the update failed
                $this->session->setFlashdata('fail', 'Please Try Again');
                header("Location: " . base_url() . "/memberrenewalpage");
            }
        }
    }

    public function receipt_renewal_print()
    {
        // if (!$this->model->permission_validate('member', 'print')) {
        //     header('Location: ' . base_url() . '/dashboard');
        // }
        $id = $this->request->uri->getSegment(3);
        $qry = $this->db->table('member', 'member_type.name as tname')
            ->join('member_type', 'member_type.id = member.member_type')
            ->select('member_type.name as tname')
            ->select('member.*')
            ->where("member.id", $id);

        $res = $qry->get()->getRowArray();

        $data['qry1'] = $res;
        echo view('/frontend/memberrenewalpage/receipt_renewal_print', $data);
    }
    public function cron()
    {
        // Load the database library
        $db = \Config\Database::connect();

        // Get the current date
        $currentDate = date("Y-m-d");

        // Query to retrieve active members whose end date is before the current date
        $query = $db->query("SELECT * FROM member WHERE end_date < '$currentDate' AND status = 1");

        // Deactivate members
        foreach ($query->getResultArray() as $row) {
            $memberId = $row['id']; // replace 'id' with your actual primary key field
            $db->table('member')->set('status', 2)->where('id', $memberId)->update();
        }

        echo "Cron job executed successfully.";
    }

}

