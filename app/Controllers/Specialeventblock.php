<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Specialeventblock extends BaseController
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

	// public function index()
	// {
	// 	$data = $this->db->table('booked_session_block')->get()->getRowArray();
	// 	//var_dump($data);
	// 	//exit;
	// 	echo view('template/header');
	// 	echo view('template/sidebar');
	// 	echo view('sessionblock/index', $data);
	// 	echo view('template/footer');
	// }

	public function index()
	{
		$builder = $this->db->table('temple_session_spl_event');

		$builder->select('temple_session_spl_event.id, temple_session_spl_event.date, temple_session_spl_event.event_type as event, 
						temple_session_spl_event.booking_slot_id as session, temple_session_spl_event.description, 
						booking_slot_new.slot_name as session');
		$builder->join('booking_slot_new', 'temple_session_spl_event.booking_slot_id = booking_slot_new.id', 'left');
		$builder->orderBy('temple_session_spl_event.date', 'ASC');  // Sort by date in ascending order

		$data['bookings'] = $builder->get()->getResultArray();

		// var_dump($data);
		// exit;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('specialeventblock/index', $data); 
		echo view('template/footer');
	}
	public function special_event()
	{
		$builder = $this->db->table('temple_session_spl_event');

		$builder->select('temple_session_spl_event.id, temple_session_spl_event.date, temple_session_spl_event.event_type as event, 
						temple_session_spl_event.booking_slot_id as session, temple_session_spl_event.description, 
						booking_slot_new.slot_name as session');
		$builder->join('booking_slot_new', 'temple_session_spl_event.booking_slot_id = booking_slot_new.id', 'left');
		$builder->orderBy('temple_session_spl_event.date', 'ASC');  // Sort by date in ascending order

		$data['bookings'] = $builder->get()->getResultArray();

		// var_dump($data);
		// exit;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('specialeventblock/index', $data); 
		echo view('template/footer');
	}


	public function add()
	{
		$data['slot_details'] = $this->db->table('booking_slot_type_new')
										 ->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
										 ->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
										 ->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('specialeventblock/special_event', $data); 
		echo view('template/footer');
	}
	public function add_special_event()
	{
		$data['slot_details'] = $this->db->table('booking_slot_type_new')
										 ->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
										 ->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
										 ->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('sessionblock/session_block_event', $data); 
		echo view('template/footer');
	}

	public function edit($id)
	{
		$data['data'] = $this->db->table('temple_session_spl_event')
								->where('id', $id)
								->get()->getRowArray();

		// $data['data'] = $this->db->table('booked_session_block')
		// 						->select('booked_session_block.*, booking_slot_new.slot_name as event_type')
		// 						->join('booking_slot_new', 'booked_session_block.booking_slot_id = booking_slot_new.id', 'left')
		// 						->where('booked_session_block.id', $id)
		// 												->get()
		// 												->getRowArray();

		$data['slot_details'] = $this->db->table('booking_slot_type_new')
										->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
										->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
										->get()->getResultArray();
		// var_dump($data);
		// exit;
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('specialeventblock/special_event', $data); 
		echo view('template/footer');
	}

	public function view($id)
	{

		$data['data'] = $this->db->table('temple_session_spl_event')
								->where('id', $id)
								->get()->getRowArray();

		$data['slot_details'] = $this->db->table('booking_slot_type_new')
										->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
										->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
										->get()->getResultArray();

		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('specialeventblock/special_event', $data); 
		echo view('template/footer');
	}

	// public function save()
	// {
	// 	$id = $this->request->getPost('id'); 
	// 	$data = [
	// 		'date' => $this->request->getPost('sessionblock_date'),
	// 		'event_type' => $this->request->getPost('sessionblock_type'),
	// 		'booking_slot_id' => $this->request->getPost('slot_selection'),
	// 		'description' => $this->request->getPost('sessionblock_desc'),
	// 		'all_slot' => $this->request->getPost('all_slots_data'),
	// 	];
	// 	var_dump($data);
	// 	exit;
	// 	if (!empty($id)) {

	// 		$exists = $this->db->table('temple_session_block')
	// 						->where('date', $data['date'])
	// 						->where('event_type', $data['event_type'])
	// 						->where('booking_slot_id', $data['booking_slot_id'])
	// 						->countAllResults();
	// 		if ($exists) {
	// 			session()->setFlashdata('fail', 'The modified session is already blocked.');
	// 		} else {

	// 			$data['updated'] = date('Y-m-d H:i:s');
	// 			$updated = $this->db->table('temple_session_block')
	// 								->where('id', $id)
	// 								->update($data);

	// 			if ($updated) {
	// 				session()->setFlashdata('succ', 'Sessionblock updated successfully.');
	// 			} else {
	// 				session()->setFlashdata('fail', 'Failed to update data. Please try again.');
	// 			}
	// 		}
	// 	} else {
	// 		$exists = $this->db->table('temple_session_block')
	// 						->where('date', $data['date'])
	// 						->where('event_type', $data['event_type'])
	// 						->where('booking_slot_id', $data['booking_slot_id'])
	// 						->countAllResults();
	// 		if ($exists) {
	// 			session()->setFlashdata('fail', 'The provided session is already blocked.');
	// 		} else {
	
	// 			$data['created'] = date('Y-m-d H:i:s');
	// 			$inserted = $this->db->table('temple_session_block')->insert($data);

	// 			if ($inserted) {
	// 				session()->setFlashdata('succ', 'Sessionblock saved successfully.');
	// 			} else {
	// 				session()->setFlashdata('fail', 'Failed to save data. Please try again.');
	// 			}
	// 		}
	// 	}
	// 	return redirect()->to(base_url('/sessionblock'));
	// }

	public function save()
	{
		$id = $this->request->getPost('id'); 
		$all_slots = $this->request->getPost('all_slots_data');
		$data = [
			'date' => $this->request->getPost('sessionblock_date'),
			'event_type' => $this->request->getPost('sessionblock_type'),
			'booking_slot_id' => $this->request->getPost('slot_selection'),
			'description' => $this->request->getPost('sessionblock_desc'),
		];
		// var_dump($all_slots);
		// exit;

		if ($data['booking_slot_id'] === null && !empty($all_slots)) {
			$allSlots = json_decode($all_slots, true);
	
			if (is_array($allSlots)) {
				foreach ($allSlots as $slot) {
					$slotData = [
						'date' => $data['date'],
						'event_type' => $slot['event_type'],
						'booking_slot_id' => $slot['booking_slot_id'],
						'description' => $data['description'],
						'created' => date('Y-m-d H:i:s')
					];
	
					$exists = $this->db->table('temple_session_spl_event')
									->where('date', $slotData['date'])
									->where('event_type', $slotData['event_type'])
									->where('booking_slot_id', $slotData['booking_slot_id'])
									->countAllResults();
	
					if ($exists) {
						session()->setFlashdata('fail', 'One or more Sessions are already blocked.');
						return redirect()->to(base_url('/specialeventblock'));
					} else {
						$inserted = $this->db->table('temple_session_spl_event')->insert($slotData);
	
						if (!$inserted) {
							session()->setFlashdata('fail', 'Failed to save one or more Sessions. Please try again.');
							return redirect()->to(base_url('/specialeventblock'));
						}
					}
				}
				session()->setFlashdata('succ', 'Special Event Block saved successfully.');
				return redirect()->to(base_url('/specialeventblock'));
			} else {
				session()->setFlashdata('fail', 'Invalid Session data received.');
				return redirect()->to(base_url('/specialeventblock'));
			}
		} else {
			// Process single slot data
			if (!empty($id)) {
				$exists = $this->db->table('temple_session_spl_event')
								->where('date', $data['date'])
								->where('event_type', $data['event_type'])
								->where('booking_slot_id', $data['booking_slot_id'])
								->where('description', $data['description'])
								->countAllResults();
				if ($exists) {
					session()->setFlashdata('fail', 'The modified Session is already blocked.');
				} else {
					$data['updated'] = date('Y-m-d H:i:s');
					$updated = $this->db->table('temple_session_spl_event')
										->where('id', $id)
										->update($data);
	
					if ($updated) {
						session()->setFlashdata('succ', 'Special Event Block updated successfully.');
					} else {
						session()->setFlashdata('fail', 'Failed to update data. Please try again.');
					}
				}
			} else {
				$exists = $this->db->table('temple_session_spl_event')
								->where('date', $data['date'])
								->where('event_type', $data['event_type'])
								->where('booking_slot_id', $data['booking_slot_id'])
								->countAllResults();
				if ($exists) {
					session()->setFlashdata('fail', 'The provided session is already blocked.');
				} else {
					$data['created'] = date('Y-m-d H:i:s');
					$inserted = $this->db->table('temple_session_spl_event')->insert($data);
	
					if ($inserted) {
						session()->setFlashdata('succ', 'Special Event Block saved successfully.');
					} else {
						session()->setFlashdata('fail', 'Failed to save data. Please try again.');
					}
				}
			}
			return redirect()->to(base_url('/specialeventblock'));
		}
	}
	

	public function delete($id)
	{

		$res=$this->db->table('temple_session_spl_event')->delete(['id' => $id]);
		if ($res) {
			session()->setFlashdata('succ', 'Session block deleted successfully.');
		} else {
			session()->setFlashdata('fail', 'Please try again.');
		}
		
		return redirect()->to(base_url('/specialeventblock'));
	}

}