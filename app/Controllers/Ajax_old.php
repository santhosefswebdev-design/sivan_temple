<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;


class Ajax extends BaseController
{
	function __construct(){
		parent::__construct();
		helper('url');
		helper('common_helper');
	}
	public function save_booking(){
		$resp = array('success' => true, 'data' => array('status' => true));
		if(!empty($_REQUEST['save_booking'])) $request_all_data = $_REQUEST;
		else $request_all_data = json_decode(file_get_contents('php://input'), true);
		// $request = \Config\Services::request();
		// $request_all_data = array_merge($request->getPost(), $request->getGet());
		// print_r($request_all_data);
		// die;
		if(!empty($request_all_data['save_booking'])){
			$this->db->transStart();
			try{
				if(!empty($this->session->get('log_id')) || !empty($request_all_data['user_id'])){
					$user_id = !empty($this->session->get('log_id')) ? $this->session->get('log_id') : $request_all_data['user_id'];
					if(!empty($request_all_data['booking_slot']) && !empty($request_all_data['booking_date']) && !empty($request_all_data['booking_type']) && !empty($request_all_data['name']) && !empty($request_all_data['mobile_code']) && !empty($request_all_data['mobile_no']) && !empty($request_all_data['packages']) && !empty($request_all_data['payment_type'])){
						$payment_type = trim($request_all_data['payment_type']);
						if($payment_type == 'partial'){
							if(!empty($request_all_data['payment_details'])) $payment_details = $request_all_data['payment_details'];
							else{
								$resp['success'] = true;
								$resp['data']['status'] = false;
								$resp['data']['message'] = 'Please Fill Payment details.';
								$resp['data']['message_type'] = 'error';
								header('Content-Type: application/json; charset=utf-8');
								echo json_encode($resp);
								exit;
							}
						}elseif($payment_type == 'full'){
							if(!empty($request_all_data['payment_mode'])) $payment_mode = $request_all_data['payment_mode'];
							else{
								$resp['success'] = true;
								$resp['data']['status'] = false;
								$resp['data']['message'] = 'Please Fill Payment details.';
								$resp['data']['message_type'] = 'error';
								header('Content-Type: application/json; charset=utf-8');
								echo json_encode($resp);
								exit;
							}
						}else{
							$resp['success'] = true;
							$resp['data']['status'] = false;
							$resp['data']['message'] = 'Invalid Payment Type.';
							$resp['data']['message_type'] = 'error';
							header('Content-Type: application/json; charset=utf-8');
							echo json_encode($resp);
							exit;
						}
						$booking_ins_data = array();
						$booking_ins_data['booking_type'] = $booking_type = trim($request_all_data['booking_type']);
						$booking_ins_data['booking_date'] = trim($request_all_data['booking_date']);
						$booking_ins_data['name'] = trim($request_all_data['name']);
						$booking_ins_data['mobile_code'] = trim($request_all_data['mobile_code']);
						$booking_ins_data['mobile_no'] = trim($request_all_data['mobile_no']);
						$booking_ins_data['payment_type'] = $payment_type;
						$booking_ins_data['entry_date'] = !empty($request_all_data['entry_date']) ? trim($request_all_data['entry_date']) : date('Y-m-d');
						$booking_ins_data['booking_through'] = !empty($request_all_data['booking_through']) ? trim($request_all_data['booking_through']) : 'DIRECT';
						$booking_ins_data['booking_status'] = 0;
						$booking_ins_data['payment_status'] = 0;
						if(!empty($request_all_data['brideName'])) $booking_brides_data['brideName'] = trim($request_all_data['brideName']);
						if(!empty($request_all_data['brideDOB'])) $booking_brides_data['brideDOB'] = trim($request_all_data['brideDOB']);
						if(!empty($request_all_data['brideIC'])) $booking_brides_data['brideIC'] = trim($request_all_data['brideIC']);
						if(!empty($request_all_data['groomName'])) $booking_brides_data['groomName'] = trim($request_all_data['groomName']);
						if(!empty($request_all_data['groomDOB'])) $booking_brides_data['groomDOB'] = trim($request_all_data['groomDOB']);
						if(!empty($request_all_data['groomIC'])) $booking_brides_data['groomIC'] = trim($request_all_data['groomIC']);
						if(!empty($request_all_data['address'])) $booking_ins_data['address'] = trim($request_all_data['address']);
						if(!empty($request_all_data['email'])) $booking_ins_data['email'] = trim($request_all_data['email']);
						if(!empty($request_all_data['ic_number'])) $booking_ins_data['ic_number'] = trim($request_all_data['ic_number']);
						if(!empty($request_all_data['description'])) $booking_ins_data['description'] = trim($request_all_data['description']);
						if($booking_ins_data['entry_date'] <= $booking_ins_data['booking_date']){
							if(in_array($booking_ins_data['booking_through'], array('DIRECT', 'COUNTER', 'KIOSK', 'APP'))){
								$this->requestmodel = new RequestModel();
								$ip = $this->requestmodel->getIpAddress();
								$booking_ins_data['ip'] = $ip;
								if ($ip != 'unknown') {
									$ip_details = $this->requestmodel->getLocation($ip);
									$booking_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
									$booking_ins_data['ip_details'] = json_encode($ip_details);
								} 
								$booking_ins_data['created_by'] = $user_id;
								$booking_ins_data['modified_by'] = $user_id;
								$res = $this->db->table("templebooking")->insert($booking_ins_data);
								//$whatsapp_resp = whatsapp_aisensy($data['mobile_number'], [], 'success_message1');
								if ($res) {
									$booking_id = $this->db->insertID();
									$this->total_amount = 0;
									$this->paid_amount = 0;
									if($booking_ins_data['booking_type'] == 1) $ref_no = 'HALL';
									elseif($booking_ins_data['booking_type'] == 2) $ref_no = 'UBAY';
									elseif($booking_ins_data['booking_type'] == 3) $ref_no = 'SANN';
									else $ref_no = 'TEMP';
									$ref_no .= str_pad($booking_id, 16, 0, STR_PAD_LEFT);
									$booking_ref_data = array();
									$booking_ref_data['ref_no'] = $ref_no;
									$this->db->table("templebooking")->where('id', $booking_id)->update($booking_ref_data);
									/* if($payment_type == 'partial'){
										$booking_ins_data['booking_status'] = 0;
										$booking_ins_data['payment_status'] = 0;
									}else{
										$booking_ins_data['booking_status'] = 1;
										$booking_ins_data['payment_status'] = 2;
									} */
									if(!$this->save_booking_slot($booking_id, $request_all_data['booking_slot'])){
										$this->db->transRollback();
										$resp['success'] = true;
										$resp['data']['status'] = false;
										$resp['data']['message'] = 'Invalid Slot';
										// $resp['data']['message_type'] = 'error';
										header('Content-Type: application/json; charset=utf-8');
										echo json_encode($resp);
										exit;
									}
									if(!empty($request_all_data['add_on'])){
										if(!$this->save_booking_addon($booking_id, $request_all_data['add_on'])){
											$this->db->transRollback();
											$resp['success'] = true;
											$resp['data']['status'] = false;
											$resp['data']['message'] = 'Invalid Add on';
											// $resp['data']['message_type'] = 'error';
											header('Content-Type: application/json; charset=utf-8');
											echo json_encode($resp);
											exit;
										}
									}
									if(!$this->save_booking_packages($booking_id, $request_all_data['packages'], $booking_ins_data['booking_type'])){
										$this->db->transRollback();
										$resp['success'] = true;
										$resp['data']['status'] = false;
										$resp['data']['message'] = 'Invalid Package';
										// $resp['data']['message_type'] = 'error';
										header('Content-Type: application/json; charset=utf-8');
										echo json_encode($resp);
										exit;
									}
									if($payment_type == 'partial'){
										if(!$this->save_booking_payment($booking_id, $payment_type, $payment_details, $booking_ins_data['booking_type'], $ref_no, $booking_ins_data['booking_through'])){
											$this->db->transRollback();
											$resp['success'] = true;
											$resp['data']['status'] = false;
											$resp['data']['message'] = 'Invalid Payment';
											// $resp['data']['message_type'] = 'error';
											header('Content-Type: application/json; charset=utf-8');
											echo json_encode($resp);
											exit;
										}
									}elseif($payment_type == 'full'){
										if(!$this->save_booking_payment($booking_id, $payment_type, array(), $booking_ins_data['booking_type'], $ref_no, $booking_ins_data['booking_through'], $payment_mode)){
											$this->db->transRollback();
											$resp['success'] = true;
											$resp['data']['status'] = false;
											$resp['data']['message'] = 'Invalid Payment in full';
											// $resp['data']['message_type'] = 'error';
											header('Content-Type: application/json; charset=utf-8');
											echo json_encode($resp);
											exit;
										}
									}else{
										$this->db->transRollback();
										$resp['success'] = true;
										$resp['data']['status'] = false;
										$resp['data']['message'] = 'Invalid Payment';
										// $resp['data']['message_type'] = 'error';
										header('Content-Type: application/json; charset=utf-8');
										echo json_encode($resp);
										exit;
									}
									if(!empty($this->total_amount) && !empty($this->paid_amount)){
										$booking_ref_data = array();
										$booking_ref_data['amount'] = $this->total_amount;
										$booking_ref_data['paid_amount'] = $this->paid_amount;
										if($this->total_amount <= $this->paid_amount) $booking_ref_data['payment_status'] = 2;
										else $booking_ref_data['payment_status'] = 1;
										$booking_ref_data['booking_status'] = 1;
										$this->db->table("templebooking")->where('id', $booking_id)->update($booking_ref_data);
										unset($this->total_amount);
										unset($this->paid_amount);
									}else{
										$this->db->transRollback();
										$resp['success'] = true;
										$resp['data']['status'] = false;
										$resp['data']['message'] = 'Invalid Package or Payment';
										// $resp['data']['message_type'] = 'error';
										header('Content-Type: application/json; charset=utf-8');
										echo json_encode($resp);
										exit;
									}
									if(!$this->account_migration($booking_id)){
										$this->db->transRollback();
										$resp['success'] = true;
										$resp['data']['status'] = false;
										$resp['data']['message'] = 'Invalid Account Migration';
										// $resp['data']['message_type'] = 'error';
										header('Content-Type: application/json; charset=utf-8');
										echo json_encode($resp);
										exit;
									}
									$this->db->table('booked_bride_details')->delete(['booking_id' => $booking_id]);
									if(!empty($booking_brides_data['brideName']) && !empty($booking_brides_data['brideDOB']) && !empty($booking_brides_data['brideIC'])){
										$booking_brides_ins_data = array();
										$booking_brides_ins_data['booking_id'] = $booking_id;
										$booking_brides_ins_data['booking_type'] = $booking_ins_data['booking_type'];
										$booking_brides_ins_data['bride_type'] = 'bride';
										$booking_brides_ins_data['name'] = $booking_brides_data['brideName'];
										$booking_brides_ins_data['nric'] = $booking_brides_data['brideIC'];
										$booking_brides_ins_data['dob'] = $booking_brides_data['brideDOB'];
										$this->db->table("booked_bride_details")->insert($booking_brides_ins_data);

									}
									if(!empty($booking_brides_data['groomName']) && !empty($booking_brides_data['groomDOB']) && !empty($booking_brides_data['groomIC'])){
										$booking_brides_ins_data = array();
										$booking_brides_ins_data['booking_id'] = $booking_id;
										$booking_brides_ins_data['booking_type'] = $booking_ins_data['booking_type'];
										$booking_brides_ins_data['bride_type'] = 'groom';
										$booking_brides_ins_data['name'] = $booking_brides_data['groomName'];
										$booking_brides_ins_data['nric'] = $booking_brides_data['groomIC'];
										$booking_brides_ins_data['dob'] = $booking_brides_data['groomDOB'];
										$this->db->table("booked_bride_details")->insert($booking_brides_ins_data);
									}

									
									$familyNames = $request_all_data['family_name'] ?? [];
									$rasiIds = $request_all_data['rasi_id'] ?? [];
									$natchathraIds = $request_all_data['natchathra_id'] ?? [];

									$this->db->table('booked_family_details')->delete(['booking_id' => $booking_id]);

									if (!empty($familyNames) && is_array($familyNames)) {
										foreach ($familyNames as $key => $name) {
											// Ensure that all required data is available before saving
											if (!empty($name) && !empty($rasiIds[$key]) && !empty($natchathraIds[$key])) {
												$familyData = array();
												$familyData['booking_id'] = $booking_id;
												$familyData['booking_type'] = $booking_ins_data['booking_type'];
												$familyData['name'] = trim($name);
												$familyData['rasi_id'] = trim($rasiIds[$key]);
												$familyData['natchathram_id'] = trim($natchathraIds[$key]);

												// Insert family member data into the database
												$this->db->table('booked_family_details')->insert($familyData);
											}
										}
									}
									
									$resp['success'] = true;
									$resp['data']['status'] = true;
									$resp['data']['message'] = 'Your Booking confirmed.';
									$resp['data']['booking_id'] = $booking_id;
								}else{
									$resp['success'] = true;
									$resp['data']['status'] = false;
									$resp['data']['message'] = 'Please contact Administrator.';
									// $resp['data']['message_type'] = 'error';
									header('Content-Type: application/json; charset=utf-8');
									echo json_encode($resp);
									exit;
								}
							}else{
								$resp['success'] = true;
								$resp['data']['status'] = false;
								$resp['data']['message'] = 'Booking only allowed in DIRECT, COUNTER, KIOSK, APP';
								// $resp['data']['message_type'] = 'error';
								header('Content-Type: application/json; charset=utf-8');
								echo json_encode($resp);
								exit;
							}
						}else{
							$resp['success'] = true;
							$resp['data']['status'] = false;
							$resp['data']['message'] = 'Can\'t book the previous day';
							// $resp['data']['message_type'] = 'error';
							header('Content-Type: application/json; charset=utf-8');
							echo json_encode($resp);
							exit;
						}
					}else{
						$resp['success'] = true;
						$resp['data']['status'] = false;
						$resp['data']['message'] = 'Please Fill All Required fields';
						// $resp['data']['message_type'] = 'error';
						header('Content-Type: application/json; charset=utf-8');
						echo json_encode($resp);
						exit;
					}
				}else{
					$resp['success'] = true;
					$resp['data']['status'] = false;
					$resp['data']['message'] = 'Please Login or Pass Auth id';
					// $resp['data']['message_type'] = 'error';
					header('Content-Type: application/json; charset=utf-8');
					echo json_encode($resp);
					exit;
				}
				$this->db->transComplete();
				if(!empty($booking_id) && !empty($booking_type)) $this->send_whatsapp_msg_booking($booking_id, $booking_type);
			} catch (Exception $e) {
				$this->db->transRollback(); // Rollback the transaction if an error occurs
				$resp['success'] = false;
				$resp['data']['status'] = false;
				$resp['data']['message'] = $e->getMessage();
				// $resp['data']['message_type'] = 'error';
				/* log_message('error', $e->getMessage());
				throw $e; */
			}
		}else{
			$resp['success'] = true;
			$resp['data']['status'] = false;
			$resp['data']['message'] = 'Please Fill All Required fields';
			// $resp['data']['message_type'] = 'error';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($resp);
			exit;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
		exit;
	}

	public function save_booking_slot($booking_id, $slots){
		$succ = true;
		if(count($slots) > 0){
			$this->db->table('booked_slot')->delete(['booking_id' => $booking_id]);
			foreach($slots as $slot){
				$count = $this->db->table("booking_slot_new")->where('id', $slot)->get()->getNumRows();
				if($count > 0){
					$booking_slot_details = $this->db->table('booking_slot_new')->where('id', $slot)->get()->getRowArray();
					$booking_slot_ins_data = array();
					$booking_slot_ins_data['booking_id'] = $booking_id;
					$booking_slot_ins_data['booking_slot_id'] = $slot;
					$booking_slot_ins_data['slot_name'] = $booking_slot_details['slot_name'];
					$res = $this->db->table("booked_slot")->insert($booking_slot_ins_data);
					if(!$res){
						$succ = false;
						break;
					}
				}else{
					$succ = false;
					break;
				}
			}
		}
		return $succ;
	}
	public function save_booking_addon($booking_id, $addons){
		$succ = true;
		if(count($addons) > 0){
			$this->db->table('booked_addon')->delete(['booking_id' => $booking_id]);
			foreach($addons as $addon){
				if(!empty($addon['id'])){
					$count = $this->db->table("temple_services")->where('id', $addon['id'])->get()->getNumRows();
					if($count > 0){
						$booking_addon_details = $this->db->table('temple_services')->where('id',  $addon['id'])->get()->getRowArray();
						$booking_addon_ins_data = array();
						$booking_addon_ins_data['booking_id'] = $booking_id;
						$booking_addon_ins_data['service_id'] = $addon['id'];
						$booking_addon_ins_data['name'] = $booking_addon_details['name'];
						$booking_addon_ins_data['description'] = $booking_addon_details['description'];
						$booking_addon_ins_data['service_type'] = $booking_addon_details['service_type'];
						$booking_addon_ins_data['ledger_id'] = $booking_addon_details['ledger_id'];
						$booking_addon_ins_data['quantity'] = !empty($addon['quantity']) ? $addon['quantity'] : 1;
						$booking_addon_ins_data['amount'] = $booking_addon_details['amount'];
						$this->total_amount += $booking_addon_ins_data['quantity'] * $booking_addon_ins_data['amount'];
						$res = $this->db->table("booked_addon")->insert($booking_addon_ins_data);
						if(!$res){
							$succ = false;
							break;
						}
					}else{
						$succ = false;
						break;
					}
				}else{
					$succ = false;
					break;
				}
			}
		}else $succ = false;
		return $succ;
	}
	public function save_booking_packages($booking_id, $packages, $booking_type){
		$succ = true;
		if(count($packages) > 0){
			$this->db->table('booked_packages')->delete(['booking_id' => $booking_id]);
			foreach($packages as $package){
				if(!empty($package['id'])){
					$count = $this->db->table("temple_packages")->where('id', $package['id'])->get()->getNumRows();
					$serv_count = $this->db->table("temple_package_services")->where('package_id', $package['id'])->get()->getNumRows();
					if($count > 0 && $serv_count > 0){
						$booking_package_details = $this->db->table('temple_packages')->where('id',  $package['id'])->get()->getRowArray();
						if($booking_type == $booking_package_details['package_type']){
							$booking_package_ins_data = array();
							$booking_package_ins_data['booking_id'] = $booking_id;
							$booking_package_ins_data['package_id'] = $package['id'];
							$booking_package_ins_data['booking_type'] = $booking_type;
							$booking_package_ins_data['name'] = $booking_package_details['name'];
							$booking_package_ins_data['description'] = $booking_package_details['description'];
							$booking_package_ins_data['package_type'] = $booking_package_details['package_type'];
							$booking_package_ins_data['package_mode'] = $booking_package_details['package_mode'];
							$booking_package_ins_data['pack_date'] = $booking_package_details['pack_date'];
							$booking_package_ins_data['ledger_id'] = $booking_package_details['ledger_id'];
							$booking_package_ins_data['quantity'] = !empty($package['quantity']) ? $package['quantity'] : 1;
							$booking_package_ins_data['amount'] = $booking_package_details['amount'];
							$this->total_amount += $booking_package_ins_data['quantity'] * $booking_package_ins_data['amount'];
							$res = $this->db->table("booked_packages")->insert($booking_package_ins_data);
							if($res){
								$package_id = $this->db->insertID();
								$booking_pack_service_rows = $this->db->table('temple_package_services')->where('package_id',  $package['id'])->get()->getNumRows();
								if($booking_pack_service_rows > 0){
									$this->db->table('booked_services')->delete(['booking_id' => $booking_id]);
									$booking_pack_service_details = $this->db->table('temple_package_services')->where('package_id',  $package['id'])->get()->getResultArray();
									foreach($booking_pack_service_details as $booking_pack_service_detail){
										$sd_count = $this->db->table('temple_services')->where('id',  $booking_pack_service_detail['service_id'])->get()->getNumRows();
										if($sd_count > 0){
											$booking_service_details = $this->db->table('temple_services')->where('id',  $booking_pack_service_detail['service_id'])->get()->getRowArray();
											$booking_service_ins_data = array();
											$booking_service_ins_data['booking_id'] = $booking_id;
											$booking_service_ins_data['booked_package_id'] = $package_id;
											$booking_service_ins_data['service_id'] = $booking_pack_service_detail['service_id'];
											$booking_service_ins_data['quantity'] = $booking_pack_service_detail['quantity'];
											$booking_service_ins_data['amount'] = $booking_pack_service_detail['amount'];
											$booking_service_ins_data['name'] = $booking_service_details['name'];
											$booking_service_ins_data['description'] = $booking_service_details['description'];
											$booking_service_ins_data['ledger_id'] = $booking_service_details['ledger_id'];
											$booking_service_ins_data['service_type'] = $booking_service_details['service_type'];
											$res_new = $this->db->table("booked_services")->insert($booking_service_ins_data);
											if(!$res_new){
												$succ = false;
												break;
											}
											
										}else{
											$succ = false;
											break;
										}
									}
								}else{
									$succ = false;
									break;
								}
							}else{
								$succ = false;
								break;
							}
						}else{
							$succ = false;
							break;
						}
					}else{
						$succ = false;
						break;
					}
				}else{
					$succ = false;
					break;
				}
			}
		}
		return $succ;
	}
	public function save_booking_payment($booking_id, $payment_type, $payments = array(), $booking_type, $booking_ref_no, $paid_through, $payment_mode = ''){
		$succ = true;
		if($payment_type == 'full'){
			if(!empty($payment_mode)){
				$this->db->table('booked_pay_details')->delete(['booking_id' => $booking_id]);
				$count = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getNumRows();
				if($count > 0){
					$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['booking_id'] = $booking_id;
					$booking_payment_ins_data['booking_type'] = $booking_type;
					$booking_payment_ins_data['booking_ref_no'] = $booking_ref_no;
					$booking_payment_ins_data['payment_mode_id'] = $payment_mode;
					$booking_payment_ins_data['paid_date'] = date('Y-m-d');
					$booking_payment_ins_data['amount'] = $this->total_amount;
					$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
					if($paid_through != 'DIRECT' && $paid_through != 'COUNTER') $booking_payment_ins_data['payment_ref_no'] = $booking_ref_no;
					$booking_payment_ins_data['paid_through'] = $paid_through;
					$booking_payment_ins_data['pay_status'] = ($paid_through == 'DIRECT' || $paid_through == 'COUNTER') ? 2 : 1;
					$this->requestmodel = new RequestModel();
					$ip = $this->requestmodel->getIpAddress();
					$booking_payment_ins_data['ip'] = $ip;
					if ($ip != 'unknown') {
						$ip_details = $this->requestmodel->getLocation($ip);
						$booking_payment_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
						$booking_payment_ins_data['ip_details'] = json_encode($ip_details);
					} 
					$this->paid_amount += $booking_payment_ins_data['amount'];

					$res = $this->db->table("booked_pay_details")->insert($booking_payment_ins_data);
					if(!$res){
						$succ = false;
					}
				}else{
					$succ = false;
				}
			}else{
				$succ = false;
			}
		}elseif($payment_type == 'partial'){
			if(count($payments) > 0){
				$this->db->table('booked_pay_details')->delete(['booking_id' => $booking_id]);
				foreach($payments as $payment){
					if(!empty($payment['payment_mode']) && !empty($payment['amount'])){
						$count = $this->db->table("payment_mode")->where('id', $payment['payment_mode'])->get()->getNumRows();
						if($count > 0){
							$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment['payment_mode'])->get()->getRowArray();
							$booking_payment_ins_data = array();
							$booking_payment_ins_data['booking_id'] = $booking_id;
							$booking_payment_ins_data['booking_type'] = $booking_type;
							$booking_payment_ins_data['booking_ref_no'] = $booking_ref_no;
							$booking_payment_ins_data['payment_mode_id'] = $payment['payment_mode'];
							$booking_payment_ins_data['paid_date'] = !empty($payment['paid_date']) ? $payment['paid_date'] : date('Y-m-d');
							$booking_payment_ins_data['amount'] = $payment['amount'];
							$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
							if($paid_through != 'DIRECT' && $paid_through != 'COUNTER') $booking_payment_ins_data['payment_ref_no'] = $booking_ref_no;
							$booking_payment_ins_data['paid_through'] = $paid_through;
							$booking_payment_ins_data['pay_status'] = ($paid_through == 'DIRECT' || $paid_through == 'COUNTER') ? 2 : 1;
							$this->requestmodel = new RequestModel();
							$ip = $this->requestmodel->getIpAddress();
							$booking_payment_ins_data['ip'] = $ip;
							if ($ip != 'unknown') {
								$ip_details = $this->requestmodel->getLocation($ip);
								$booking_payment_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
								$booking_payment_ins_data['ip_details'] = json_encode($ip_details);
							} 
							$this->paid_amount += $booking_payment_ins_data['amount'];
							if($this->paid_amount > $this->total_amount){
								$succ = false;
								break;
							}
							$res = $this->db->table("booked_pay_details")->insert($booking_payment_ins_data);
							if(!$res){
								$succ = false;
								break;
							}
						}else{
							$succ = false;
							break;
						}
					}else{
						$succ = false;
						break;
					}
				}
			}else{
				$succ = false;
			}
			
		}
		return $succ;
	}
	public function account_migration($booking_id){
		$succ = true;
		$templeubayam = $this->db->table("templebooking")->where("id", $booking_id)->get()->getRowArray();
		$entry_date = date('Y-m-d', strtotime($templeubayam['entry_date']));
		$date = explode('-', $entry_date);
		$yr = $date[0];
		$mon = $date[1];
		$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '1200')->get()->getRowArray();
		if (!empty($td_ledger)) {
		  $cr_id1 = $td_ledger['id'];
		} else {
		  $cled1['group_id'] = 3;
		  $cled1['name'] = 'TRADE RECEIVABLE';
		  $cled1['code'] = '1200/005';
		  $cled1['op_balance'] = '0';
		  $cled1['op_balance_dc'] = 'D';
		  $cled1['left_code'] = '1200';
		  $cled1['right_code'] = '005';
		  $this->db->table('ledgers')->insert($cled1);
		  $cr_id1 = $this->db->insertID();
		}
		$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
			if (!empty($incomes_group)) {
				$sls_id = $incomes_group['id'];
			} else {
				$sls1['parent_id'] = 0;
				$sls1['name'] = 'Incomes';
				$sls1['code'] = '8000';
				$sls1['added_by'] = $this->session->get('log_id');
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
		$booked_packages_cnt = $this->db->table("booked_packages")->where("booking_id", $booking_id)->get()->getNumRows();	
		$booked_addon_cnt = $this->db->table("booked_addon")->where("booking_id", $booking_id)->get()->getNumRows();
		if ($booked_packages_cnt > 0) {
			$booked_packages_details = $this->db->table("booked_packages")->where("booking_id", $booking_id)->get()->getResultArray();
			$booked_addon_details = $this->db->table("booked_addon")->join('temple_services', 'temple_services.id = booked_addon.service_id')->select('temple_services.*, booked_addon.quantity')->where("booked_addon.booking_id", $booking_id)->get()->getResultArray();
			$over_all_tot_amt = 0;
			foreach ($booked_packages_details as $row) $over_all_tot_amt += (float) $row['amount'];
			if($booked_addon_cnt > 0){
				foreach ($booked_addon_details as $row) $over_all_tot_amt += (float) $row['amount'] * (int) $row['quantity'];
			}
			  $number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
			  if (empty($number1))
				$num1 = 1;
			  else
				$num1 = $number1['number'] + 1;
			  // Get Entry Code
			  $qry1 = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();

			  $entries1['entry_code'] = 'JOR' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry1['entry_code'], -5)) + 1)));
			  $entries1['entrytype_id'] = '4';
			  $entries1['number'] = $num1;
			  $entries1['date'] = $entry_date;
			  $entries1['dr_total'] = $over_all_tot_amt;
			  $entries1['cr_total'] = $over_all_tot_amt;
			  $entries1['narration'] = 'Ubayam(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'NRIC:' . $templeubayam['ic_number'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
			  $entries1['inv_id'] = $booking_id;
			  $entries1['type'] = 1;
			  //Insert Entries
			  $ent = $this->db->table('entries')->insert($entries1);
			  $en_id1 = $this->db->insertID();
			  if (!empty($en_id1)) {
				foreach ($booked_packages_details as $row) {
					if(!empty($row['ledger_id'])){
						$led_book_id = $row['ledger_id'];
					}else{
						$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
						if(!empty($ledger1)){
							$led_book_id = $ledger1['id'];
						}else{
							$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
							$set_right_code = (int) $right_code['right_code'] + 1;
							$set_right_code = sprintf("%04d", $set_right_code);
							$led1['group_id'] = $sls_id;
							$led1['name'] = 'All Incomes';
							$led1['left_code'] = '8913';
							$led1['right_code'] = $set_right_code;
							$led1['op_balance'] = '0';
							$led1['op_balance_dc'] = 'D';
							$led_ins1 = $this->db->table('ledgers')->insert($led1);
							$led_book_id = $this->db->insertID();
						}
					}
					// Hall Booking => Credit
					$eitems_hall_book['entry_id'] = $en_id1;
					$eitems_hall_book['ledger_id'] = $led_book_id;
					$eitems_hall_book['amount'] = $row['amount'];
					$eitems_hall_book['dc'] = 'C';
					$eitems_hall_book['details'] = 'Amount for' . $row['name'];
					$this->db->table('entryitems')->insert($eitems_hall_book);
					//  Trade Debtors => Debit 
					$eitems_cash_led['entry_id'] = $en_id1;
					$eitems_cash_led['ledger_id'] = $cr_id1;
					$eitems_cash_led['amount'] = $row['amount'];
					$eitems_cash_led['dc'] = 'D';
					$eitems_cash_led['details'] = 'Amount for' . $row['name'];
					$this->db->table('entryitems')->insert($eitems_cash_led);
				}
			}else{
				$succ = false;
				return $succ;
			}
		}else{
			$succ = false;
			return $succ;
		}
		if($booked_addon_cnt > 0){
			$booked_addon_details = $this->db->table("booked_addon")->join('temple_services', 'temple_services.id = booked_addon.service_id')->select('temple_services.*, booked_addon.quantity')->where("booked_addon.booking_id", $booking_id)->get()->getResultArray();
			foreach ($booked_addon_details as $row) {
				if(!empty($row['ledger_id'])){
					$led_book_id = $row['ledger_id'];
				}else{
					$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
					if(!empty($ledger1)){
						$led_book_id = $ledger1['id'];
					}else{
						$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
						$set_right_code = (int) $right_code['right_code'] + 1;
						$set_right_code = sprintf("%04d", $set_right_code);
						$led1['group_id'] = $sls_id;
						$led1['name'] = 'All Incomes';
						$led1['left_code'] = '8913';
						$led1['right_code'] = $set_right_code;
						$led1['op_balance'] = '0';
						$led1['op_balance_dc'] = 'D';
						$led_ins1 = $this->db->table('ledgers')->insert($led1);
						$led_book_id = $this->db->insertID();
					}
				}
				$amount = (float) $row['amount'] * $row['quantity'];
				// Hall Booking => Credit
				$eitems_hall_book['entry_id'] = $en_id1;
				$eitems_hall_book['ledger_id'] = $led_book_id;
				$eitems_hall_book['amount'] = $amount;
				$eitems_hall_book['dc'] = 'C';
				$eitems_hall_book['details'] = 'Amount for' . $row['name'];
				$this->db->table('entryitems')->insert($eitems_hall_book);
				//  Trade Debtors => Debit 
				$eitems_cash_led['entry_id'] = $en_id1;
				$eitems_cash_led['ledger_id'] = $cr_id1;
				$eitems_cash_led['amount'] = $amount;
				$eitems_cash_led['dc'] = 'D';
				$eitems_cash_led['details'] = 'Amount for' . $row['name'];
				$this->db->table('entryitems')->insert($eitems_cash_led);
			}
		}
		$booked_pay_details_cnt = $this->db->table("booked_pay_details")->where("booking_id", $booking_id)->get()->getNumRows();	
		// $booked_pay_details_cnt = $this->db->table("booked_pay_details")->where("booking_id", $booking_id)->where("booking_type", 2)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("booked_pay_details")->where("booking_id", $booking_id)->get()->getResultArray();
			// $booked_pay_details = $this->db->table("booked_pay_details")->where("booking_id", $booking_id)->where("booking_type", 2)->get()->getResultArray();
			foreach ($booked_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode_id'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'REC' . date('y', strtotime($row['paid_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $row['paid_date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'NRIC:' . $templeubayam['ic_number'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 8;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						// Trade Debtors => Credit
						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $cr_id1;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Hall Booking Amount';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Hall Booking Amount';
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}else{
					$succ = false;
					return $succ;
				}
			}
		}else{
			$succ = false;
			return $succ;
		}
		return $succ;
	}
	public function get_packages_list_old(){
		$resp = array('success' => true, 'data' => array('status' => true));
		try{
			if(!empty($_REQUEST['booking_date'])) $request_all_data = $_REQUEST;
			else $request_all_data = json_decode(file_get_contents('php://input'), true);
			if($request_all_data['booking_date'] && $request_all_data['slot_id'] && $request_all_data['package_type']){
				$booking_date = trim($request_all_data['booking_date']);
				$slot_id = trim($request_all_data['slot_id']);
				$package_type = trim($request_all_data['package_type']);
				$pack_rows = $this->db->query("SELECT max(bp.package_id) as package_id, max(tp.package_type) as package_type, max(tp.package_mode) as package_mode, max(tp.pack_date) as pack_date FROM `templebooking` tb left join booked_packages bp on bp.booking_id = tb.id left join temple_packages tp on tp.id = bp.package_id left join booked_slot bs on bs.booking_id = tb.id  WHERE `booking_date` = '$booking_date' and bs.booking_slot_id = $slot_id and tp.package_type = $package_type and tb.booking_status not in (3) GROUP by bp.package_id")->getNumRows();
				if($pack_rows > 1){
					$resp['data']['packages'] = array();
					$resp['data']['addons'] = array();
					
				}elseif($pack_rows == 1){
					$packages_result = $this->db->query("SELECT max(bp.package_id) as package_id, max(tp.package_type) as package_type, max(tp.package_mode) as package_mode, max(tp.pack_date) as pack_date FROM `templebooking` tb left join booked_packages bp on bp.booking_id = tb.id left join temple_packages tp on tp.id = bp.package_id left join booked_slot bs on bs.booking_id = tb.id  WHERE `booking_date` = '$booking_date' and bs.booking_slot_id = $slot_id and tp.package_type = $package_type and tb.booking_status not in (3) GROUP by bp.package_id")->getRowArray();
					if($packages_result['package_mode'] == 2){
						$act_pack_cnt = $this->db->table("temple_packages")->where("id", $packages_result['package_id'])->where("package_type", $package_type)->where("status", 1)->get()->getNumRows();
						if($act_pack_cnt > 0){
							$resp['data']['packages'] = $this->db->table("temple_packages")->where("id", $packages_result['package_id'])->where("package_type", $package_type)->where("status", 1)->get()->getResultArray();
							$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id = '" . $packages_result['package_id'] . "')")->getResultArray();
						}else{
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}else{
						$resp['data']['packages'] = array();
						$resp['data']['addons'] = array();
					}
				}else{
					$spl_pack_cnt = $this->db->table("temple_packages")->where("pack_date", $booking_date)->where("package_type", $package_type)->where("status", 1)->get()->getNumRows();
					if($spl_pack_cnt > 0){
						$resp['data']['packages'] = $this->db->table("temple_packages")->where("pack_date", $booking_date)->where("package_type", $package_type)->where("status", 1)->get()->getResultArray();
						$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in(select id from temple_packages where pack_date = '$booking_date' and package_type = '$package_type' and status = 1))")->getResultArray();
					}else{
						$tot_pack_cnt = $this->db->table("temple_packages")->where("package_type", $package_type)->where("(pack_date IS NULL OR pack_date = '')")->where("status", 1)->get()->getNumRows();
						if($tot_pack_cnt > 0){
							$resp['data']['packages'] = $this->db->table("temple_packages")->where("package_type", $package_type)->where("(pack_date IS NULL OR pack_date = '')")->where("status", 1)->get()->getResultArray();
							$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in (select id from temple_packages where (pack_date IS NULL OR pack_date = '') and package_type = '$package_type' and status = 1))")->getResultArray();
						}else{
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}
				}
			}else $resp['data']['packages'] = array();
		} catch (Exception $e) {
			$resp['success'] = false;
			$resp['data']['status'] = false;
			$resp['data']['message'] = $e->getMessage();
			// $resp['data']['message_type'] = 'error';
			/* log_message('error', $e->getMessage());
			throw $e; */
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
		exit;
	}

	public function get_packages_list(){
		$resp = array('success' => true, 'data' => array('status' => true));
		try{
			if(!empty($_REQUEST['booking_date'])) $request_all_data = $_REQUEST;
			else $request_all_data = json_decode(file_get_contents('php://input'), true);
			if($request_all_data['booking_date'] && $request_all_data['slot_id'] && $request_all_data['package_type']){
				$booking_date = trim($request_all_data['booking_date']);
				$slot_id = trim($request_all_data['slot_id']);
				$package_type = trim($request_all_data['package_type']);
				$query = $this->db->query("
							SELECT COUNT(*) as count FROM (
								SELECT bp.package_id 
								FROM templebooking tb
								LEFT JOIN booked_packages bp ON bp.booking_id = tb.id
								LEFT JOIN temple_packages tp ON tp.id = bp.package_id
								LEFT JOIN booked_slot bs ON bs.booking_id = tb.id
								WHERE tb.booking_date = '$booking_date'
								AND bs.booking_slot_id = $slot_id
								AND tp.package_type = $package_type
								AND tb.booking_status NOT IN (3)
								GROUP BY bp.package_id
							) AS subquery
						");

				$result = $query->getRowArray();
				$pack_rows = isset($result->count) ? $result->count : 0;

				// echo $pack_rows;
				// exit;
				if($pack_rows > 1){
					$resp['data']['packages'] = array();
					$resp['data']['addons'] = array();
					
				}elseif($pack_rows == 1){
					$packages_result = $this->db->query("
										SELECT 
											MAX(bp.package_id) AS package_id, 
											MAX(tp.package_type) AS package_type, 
											MAX(tp.package_mode) AS package_mode
										FROM 
											templebooking tb
										LEFT JOIN 
											booked_packages bp ON bp.booking_id = tb.id
										LEFT JOIN 
											temple_packages tp ON tp.id = bp.package_id
										LEFT JOIN 
											booked_slot bs ON bs.booking_id = tb.id
										WHERE 
											tb.booking_date = '$booking_date'
											AND bs.booking_slot_id = $slot_id
											AND tp.package_type = $package_type
											AND tb.booking_status NOT IN (3)
										GROUP BY 
											bp.package_id
									")->getRowArray();

					// 	echo $packages_result;
					// exit;

					if($packages_result['package_mode'] == 2){
						$sql = "
						SELECT COUNT(*) as count
						FROM temple_packages
						WHERE id = ? 
						AND package_type = ?
						AND status = 1
					";

					$query = $this->db->query($sql, [$packages_result['package_id'], $package_type]);
					$result = $query->getRow();

					$act_pack_cnt = $result->count;
						if($act_pack_cnt > 0){
							$sql = "
									SELECT * 
									FROM temple_packages
									WHERE id = (
										SELECT package_id
										FROM temple_package_date
										WHERE package_type = ? 
										AND pack_date = ?
										LIMIT 1
									)
									AND package_type = ?
									AND status = 1
								";

							$packages = $this->db->query($sql, [$package_type, $booking_date, $package_type])
												->getResultArray();

							$resp['data']['packages'] = $packages;
							$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id = '" . $packages_result['package_id'] . "')")->getResultArray();
						}else{
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}else{
						// echo "packages_result";
						// exit;
						
						$resp['data']['packages'] = array();
						$resp['data']['addons'] = array();
					}
				}else{
					
					
					$spl_pack_query = $this->db->query("
												SELECT *
												FROM temple_packages
												WHERE package_type = ?
												AND status = 1
												AND id IN (
													SELECT package_id
													FROM temple_package_date
													WHERE package_type = ?
													AND pack_date = ?
												)
												AND id IN (
													SELECT package_id
													FROM temple_package_slots
													WHERE slot_id = ?
												)
											", [$package_type, $package_type, $booking_date, $slot_id])->getResultArray();

								$spl_pack_cnt = count($spl_pack_query);
											// 			echo $spl_pack_cnt;
											// exit;
					if($spl_pack_cnt > 0){
						$resp['data']['packages'] = $this->db->query("
													SELECT *
													FROM temple_packages
													WHERE package_type = ?
													AND status = 1
													AND id IN (
														SELECT package_id
														FROM temple_package_date
														WHERE package_type = ?
														AND pack_date = ?
													)
													AND id IN (
														SELECT package_id
														FROM temple_package_slots
														WHERE slot_id = ?
													)
												", [$package_type, $package_type, $booking_date, $slot_id])->getResultArray();
						$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in(select id from temple_packages where pack_date = '$booking_date' and package_type = '$package_type' and status = 1))")->getResultArray();
					}else{
						$tot_pack_cnt = $this->db->query("
										SELECT COUNT(*) as count
										FROM temple_packages
										WHERE package_type = ?
										AND id NOT IN (
											SELECT DISTINCT package_id
											FROM temple_package_date
											WHERE package_type = ?
											AND pack_date IS NOT NULL
											AND pack_date != '0000-00-00'
										)
										AND id IN (
											SELECT package_id
											FROM temple_package_slots
											WHERE slot_id = ?
										)
									", [$package_type, $package_type, $slot_id])->getRow()->count;
						// echo $tot_pack_cnt;
						// 						exit;
						if($tot_pack_cnt > 0){
							// echo $tot_pack_cnt;
						// exit;
						$resp['data']['packages'] = $this->db->query("
						SELECT *
						FROM temple_packages
						WHERE package_type = ?
						AND id NOT IN (
							SELECT DISTINCT package_id
							FROM temple_package_date
							WHERE package_type = ?
							AND pack_date IS NOT NULL
							AND pack_date != '0000-00-00'
						)
						AND id IN (
							SELECT package_id
							FROM temple_package_slots
							WHERE slot_id = ?
						)
					", [$package_type, $package_type, $slot_id])->getResultArray();
							$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in (select id from temple_packages where (pack_date IS NULL OR pack_date = '') and package_type = '$package_type' and status = 1))")->getResultArray();
						}else{
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}
				}
			}else $resp['data']['packages'] = array();
			// if (empty($resp['data']['packages'])) {
			// 	$resp['data']['message'] = "No packages available for the selected slot and date.";
			// }
		} catch (Exception $e) {
			$resp['success'] = false;
			$resp['data']['status'] = false;
			$resp['data']['message'] = $e->getMessage();
			// $resp['data']['message_type'] = 'error';
			/* log_message('error', $e->getMessage());
			throw $e; */
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
		exit;
	}
	
	public function get_hallpackages_list(){
		$resp = array('success' => true, 'data' => array('status' => true));
		try{
			if(!empty($_REQUEST['booking_date'])) $request_all_data = $_REQUEST;
			else $request_all_data = json_decode(file_get_contents('php://input'), true);
			if($request_all_data['booking_date'] && $request_all_data['slot_id'] && $request_all_data['package_type']){
				$booking_date = trim($request_all_data['booking_date']);
				$slot_id = trim($request_all_data['slot_id']);
				$package_type = trim($request_all_data['package_type']);
				$pack_rows = $this->db->query("SELECT max(bp.package_id) as package_id, max(tp.package_type) as package_type, max(tp.package_mode) as package_mode, max(tp.pack_date) as pack_date FROM `templebooking` tb left join booked_packages bp on bp.booking_id = tb.id left join temple_packages tp on tp.id = bp.package_id left join booked_slot bs on bs.booking_id = tb.id  WHERE `booking_date` = '$booking_date' and bs.booking_slot_id = $slot_id and tp.package_type = $package_type and tb.booking_status not in (3) GROUP by bp.package_id")->getNumRows();
				if($pack_rows > 1){
					$resp['data']['packages'] = array();
					$resp['data']['addons'] = array();
					
				}elseif($pack_rows == 1){
					$packages_result = $this->db->query("SELECT max(bp.package_id) as package_id, max(tp.package_type) as package_type, max(tp.package_mode) as package_mode, max(tp.pack_date) as pack_date FROM `templebooking` tb left join booked_packages bp on bp.booking_id = tb.id left join temple_packages tp on tp.id = bp.package_id left join booked_slot bs on bs.booking_id = tb.id  WHERE `booking_date` = '$booking_date' and bs.booking_slot_id = $slot_id and tp.package_type = $package_type and tb.booking_status not in (3) GROUP by bp.package_id")->getRowArray();
					if($packages_result['package_mode'] == 2){
						$act_pack_cnt = $this->db->table("temple_packages")->where("id", $packages_result['package_id'])->where("package_type", $package_type)->where("status", 1)->get()->getNumRows();
						if($act_pack_cnt > 0){
							$resp['data']['packages'] = $this->db->table("temple_packages")->where("id", $packages_result['package_id'])->where("package_type", $package_type)->where("status", 1)->get()->getResultArray();
							$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id = '" . $packages_result['package_id'] . "')")->getResultArray();
						}else{
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}else{
						$resp['data']['packages'] = array();
						$resp['data']['addons'] = array();
					}
				}else{
					$spl_pack_cnt = $this->db->table("temple_packages")->where("pack_date", $booking_date)->where("package_type", $package_type)->where("status", 1)->get()->getNumRows();
					if($spl_pack_cnt > 0){
						$resp['data']['packages'] = $this->db->table("temple_packages")->where("pack_date", $booking_date)->where("package_type", $package_type)->where("status", 1)->get()->getResultArray();
						$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in(select id from temple_packages where pack_date = '$booking_date' and package_type = '$package_type' and status = 1))")->getResultArray();
					}else{
						$tot_pack_cnt = $this->db->table("temple_packages")->where("package_type", $package_type)->where("(pack_date IS NULL OR pack_date = '')")->where("status", 1)->get()->getNumRows();
						if($tot_pack_cnt > 0){
							$resp['data']['packages'] = $this->db->table("temple_packages")->where("package_type", $package_type)->where("(pack_date IS NULL OR pack_date = '')")->where("status", 1)->get()->getResultArray();
							$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in (select id from temple_packages where (pack_date IS NULL OR pack_date = '') and package_type = '$package_type' and status = 1))")->getResultArray();
						}else{
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}
				}
			}else $resp['data']['packages'] = array();
		} catch (Exception $e) {
			$resp['success'] = false;
			$resp['data']['status'] = false;
			$resp['data']['message'] = $e->getMessage();
			// $resp['data']['message_type'] = 'error';
			/* log_message('error', $e->getMessage());
			throw $e; */
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
		exit;
	}
	public function send_whatsapp_msg_booking($booking_id, $booking_type)
	{
		$booking_data = $this->db->table('templebooking')
			->where('id', $booking_id)
			->where('booking_type', $booking_type)
			->get()->getRowArray();
		$booked_slot = $this->db->table('booked_slot')->where('booking_id', $booking_id)->get()->getResultArray();
		$booked_slot_name = array();
		foreach($booked_slot as $bs){
			$booked_slot_name[] = $bs['slot_name'];
		}
		// $tmpid = 1;
		// $data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		// $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		// $data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
		if (!empty($booking_data['mobile_code']) && !empty($booking_data['mobile_no'])) {
			// $html = view('ubayam/pdf', $data);
			// $options = new Options();
			// $options->set('isHtml5ParserEnabled', true);
			// $options->set(array('isRemoteEnabled' => true));
			// $options->set('isPhpEnabled', true);
			// $dompdf = new Dompdf($options);
			// $dompdf->loadHtml($html);
			// $dompdf->setPaper('A4', 'portrait');
			// $dompdf->render();
			// $filePath = FCPATH . 'uploads/documents/invoice_ubayam_' . $id . '.pdf';

			// file_put_contents($filePath, $dompdf->output());
			$mobile_code = $booking_data['mobile_code'];
			$mobile_no = $booking_data['mobile_no'];
			$mobile_number = $mobile_code . $mobile_no;
			$message_params = array();
			$media=array();
			$api_camp = 'ubayam_live';
			if($booking_type == 2){
				$message_params[] = date('d M, Y', strtotime($booking_data['booking_date']));
				$message_params[] = implode(', ', $booked_slot_name);
				// $message_params[] = number_format($booking_data['amount'], 2);
				$message_params[] = number_format($booking_data['paid_amount'], 2);
				$api_camp = 'ubayam_live';
			}elseif($booking_type == 1){
				$booked_packages = $this->db->table('booked_packages')->where('booking_id', $booking_id)->get()->getResultArray();
				$booked_pack_name = array();
				foreach($booked_packages as $bp){
					$booked_pack_name[] = $bp['name'];
				}
				$message_params[] = implode(', ', $booked_pack_name);
				$message_params[] = date('d M, Y', strtotime($booking_data['booking_date']));
				$message_params[] = implode(', ', $booked_slot_name);
				// $message_params[] = number_format($booking_data['amount'], 2);
				$message_params[] = number_format($booking_data['paid_amount'], 2);
				$api_camp = 'hall_booking';
			}
			// $message_params[] = $ubayam['balanceamount'];
			// $media['url'] = base_url() . '/uploads/documents/invoice_ubayam_' . $id . '.pdf';
			// $media['filename'] = 'ubayam_invoice.pdf';
			//$mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, $api_camp, $media);
			// print_r($whatsapp_resp);
			//echo $whatsapp_resp['success'];
			// if($whatsapp_resp['success']) 
		}
	}
	public function partial_account_migration($booked_pay_id){
		$succ = true;
		$booked_pay_details_cnt = $this->db->table("booked_pay_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("booked_pay_details")->where("id", $booked_pay_id)->get()->getResultArray();
			foreach ($booked_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode_id'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'REC' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $entry_date;
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'NRIC:' . $templeubayam['ic_number'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 8;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						// Trade Debtors => Credit
						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $cr_id1;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Hall Booking Amount';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Hall Booking Amount';
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}else{
					$succ = false;
					return $succ;
				}
			}
		}else{
			$succ = false;
			return $succ;
		}
	}
}
