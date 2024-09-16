<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Enrollment extends Main {
	

	public function remote($type, $id = null, $column = 'name') {
		if ($type == 'enrollment') {
			$tb = 'members-details';
		} else {
		}
		// $columnValue = $_GET[$column];
		// if (is_array($columnValue)) {
		// 	$columnValue = implode(',', $columnValue);
		// }
	
		$this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id);
        }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }
	}
	
	public function enrollment($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'enrollment/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Member Enrollment';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['search']	 	= $this->input->post('search');
				$data['country']       = $this->enrollment_model->getRow('countries',['is_deleted'=>'NOT_DELETED','active'=>'1','id'=>'1']);
				  // Fetch country
				  $data['country'] = $this->enrollment_model->getRow('countries', ['is_deleted' => 'NOT_DELETED', 'active' => '1', 'id' => '1']);
				  if ($user->user_role > 1) {
					  $admin_id = $user->id;
					  $accessible_states = $this->enrollment_model->getAccessibleStates($admin_id);
					  if (!empty($accessible_states)) {
						  $data['states'] = $this->enrollment_model->getDataNew('states', [
							  'is_deleted' => 'NOT_DELETED',
							  'active' => '1',
							  'id' => $accessible_states
						  ], 'asc', 'seq');
					  } else {
						  $data['states'] = []; 
					  }
				  } else {
					  $data['states'] = $this->enrollment_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				  }
				$this->template($data);
				break;

			    case 'tb':
					
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."members-enrollment/tb";
					$config["total_rows"]  	= count($this->enrollment_model->members_enrollment($user));
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('members-enrollment/create/');
					$data['delete_url']		= base_url('members-enrollment/delete/');
					$data['details_url']    = base_url('members-enrollment/details_url/');
					$data['rows']    		= $this->enrollment_model->members_enrollment($user,$config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Member  Enrollment';
				$data['contant']      = $view_dir.'create';
				$data['remote']       = base_url().'enrollment/remote/enrollment/';
				$data['action_url']	  = base_url('members-enrollment/save');
                $data['country']       = $this->enrollment_model->getRow('countries',['is_deleted'=>'NOT_DELETED','active'=>'1','id'=>'1']);
                if ($user->user_role > 1) {
					$admin_id = $user->id;
					$accessible_states = $this->enrollment_model->getAccessibleStates($admin_id);
					if (!empty($accessible_states)) {
						$data['states'] = $this->enrollment_model->getDataNew('states', [
							'is_deleted' => 'NOT_DELETED',
							'active' => '1',
							'id' => $accessible_states
						], 'asc', 'seq');
					} else {
						$data['states'] = []; 
					}
				} else {
					$data['states'] = $this->enrollment_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				}
				$data['income_master']       = $this->enrollment_model->getData('income_master',['is_deleted'=>'NOT_DELETED','active'=>'1'],'ASC','seq');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] =        $this->enrollment_model->getEnrollmentRow($id);
					$data['remote']         = base_url().'enrollment/remote/enrollment/'.$id;
					$data['title'] 		  = 'Update Member Enrollment';
					$data['contant']      = $view_dir.'update';
					$data['members']        =$this->enrollment_model->getData('members-details',['member_enrollment_id'=>$id]);
				}
                $this->template($data);
				break;
				case 'validate_unique':
					$field = $this->input->post('field');
					$value = $this->input->post('value');
					$memberId = $this->input->post('memberId');
					
					$table = 'members-details'; 
					$column = $field;
					$this->db->where($column, $value);
					if (!empty($memberId)) { 
						$this->db->where('id !=', $memberId);
					}
					$count = $this->db->count_all_results($table);
					if ($count > 0) {
						echo "false"; // Duplicate found
					} else {
						echo "true"; // No duplicate found
					}
				break;
			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$result=false;
					if($user->user_role>1){
					$admin_id = $user->id;
					$country_id=$this->input->post('country_id');
				    $state_id = explode(',', $this->input->post('state'))[0];
				    $commissionaires_id = explode(',', $this->input->post('commissionaires'))[0];
					$district_id = explode(',', $this->input->post('district'))[0];
					$tehsil_id = explode(',', $this->input->post('tehsil'))[0];
					$pincode_check = $this->input->post('pincode');
					$group_pincode_check = substr($pincode_check, 0, 9);
					$result=check_admin_locality_access($admin_id,$country_id,$state_id,$commissionaires_id,$district_id,$tehsil_id,$group_pincode_check);
					}else{
                     $result=true;
					}
					if($result){
	                    if ($id!=null) {
							$not_member = $this->input->post('not_member');
							$sr_no = $this->input->post('sr_no');
							$fname = $this->input->post('fname');
							$mname = $this->input->post('mname');
							$lname = $this->input->post('lname');
							$father_name = $this->input->post('father_name');
							$dob = $this->input->post('dob');
							$gender = $this->input->post('gender');
							$mobile = $this->input->post('mobile');
							$email = $this->input->post('email');
							$profesion = $this->input->post('profesion');
							$income = $this->input->post('income');
							$head_house = $this->input->post('head_house');
							$members_id = $this->input->post('members_id');
							$aadhaar_no = $this->input->post('aadhaar_no');
							$pan_no = $this->input->post('pan_no');
							$voter_id = $this->input->post('voter_id');
							if ($not_member !='1') {
							foreach ($sr_no as $key => $value) {
								if (empty($fname[$key]) ||empty($lname[$key])||empty($father_name[$key]) || empty($dob[$key]) || empty($gender[$key]) || empty($mobile[$key]) || empty($profesion[$key]) || empty($income[$key]) || empty($aadhaar_no[$key]) || empty($email[$key])) {
									$return['res'] = 'error';
									$return['msg'] = 'All mandatory fields fill  for each member.';
									echo json_encode($return);
									return;
								}
							}
						}
							$members_enrollment = array(
							'country_id'=>$this->input->post('country_id'),
							'state_id' => explode(',', $this->input->post('state'))[0],
							'commissionaires_id' => explode(',', $this->input->post('commissionaires'))[0],
							'district_id' => explode(',', $this->input->post('district'))[0],
							'tehsil_id' => explode(',', $this->input->post('tehsil'))[0],
							'ward_block_id' => explode(',', $this->input->post('ward'))[0],
							'block_nyay_id' => explode(',', $this->input->post('block'))[0],
							'panchayat_id' => explode(',', $this->input->post('panchayat'))[0],
							'village'=>$this->input->post('village'),
							'pincode'=>$this->input->post('pincode'),
							'permanent_address'=>$this->input->post('address'),
							'street_house_flat'=>$this->input->post('street_house'),
							'family_no'=>$this->input->post('family_no'),
							'members_no'=>$this->input->post('members_no'),
							);
							if($this->model->Update('members-enrollment',$members_enrollment,['id'=>$id])){
								// Logic of create group
								$family_groups_id = $this->enrollment_model->getRow('members-enrollment',['id'=>$id]);
								$pincode = $this->input->post('pincode');
								$group_pincode = substr($pincode, 0, 13);
								$family_groups = array(
									'country_id'=>$this->input->post('country_id'),
									'state_id' => explode(',', $this->input->post('state'))[0],
									'commissionaires_id' => explode(',', $this->input->post('commissionaires'))[0],
									'district_id' => explode(',', $this->input->post('district'))[0],
									'tehsil_id' => explode(',', $this->input->post('tehsil'))[0],
									'ward_block_id' => explode(',', $this->input->post('ward'))[0],
									'block_nyay_id' => explode(',', $this->input->post('block'))[0],
									'panchayat_id' => explode(',', $this->input->post('panchayat'))[0],
									'pincode' => $group_pincode,
									'family_no' => $this->input->post('family_no'),
								);
								$group_id = $this->enrollment_model->Update('family_groups', $family_groups,['id'=>@$family_groups_id->id]);
								if(!empty($members_id)){
									if ($not_member !='1') {
								foreach($sr_no as $key=>$value)
								{
								  if(@$members_id[$key]){	
								  $members_details = array(
									 'fname'=>$fname[$key],
									 'mname'=>$mname[$key],
									 'lname'=>$lname[$key],
									 'father_name'=>$father_name[$key],
									 'dob'=>$dob[$key],
									 'gender'=>$gender[$key],
									 'mobile'=>$mobile[$key],
									 'email'=>$email[$key],
									 'profession'=>$profesion[$key],
									 'income_per_day'=>$income[$key],
									 'head_of_the_house'=>@$head_house[$key] ? @$head_house[$key] : '0',
									 'aadhaar_no'=>$aadhaar_no[$key],
									 'pan_no'=>$pan_no[$key],
									 'voter_id'=>$voter_id[$key],
									);
									$this->model->Update('members-details',$members_details,['id'=>$members_id[$key]]);
								  }else{
									$member_password = $this->generateUniquePassword($fname[$key],$dob[$key]);
									$enrollment_no = $this->generateUniqueEnrollmentNo();
									$members_details = array(
										'enrollment_no'=>$enrollment_no,
										'member_enrollment_id'=>$id,
										'fname'=>$fname[$key],
										'mname'=>$mname[$key],
										'lname'=>$lname[$key],
										'father_name'=>$father_name[$key],
										'dob'=>$dob[$key],
										'gender'=>$gender[$key],
										'mobile'=>$mobile[$key],
										'email'=>$email[$key],
										'profession'=>$profesion[$key],
										'income_per_day'=>$income[$key],
										'head_of_the_house'=>@$head_house[$key] ? @$head_house[$key] : '0',
										'password'=>$member_password,
										'aadhaar_no'=>$aadhaar_no[$key],
										'pan_no'=>$pan_no[$key],
										'voter_id'=>$voter_id[$key],
									   );
									   $member_id=$this->model->Save('members-details',$members_details);
									   $levels = $this->enrollment_model->getRow('level_master',['is_deleted'=>'NOT_DELETED','active'=>'1','level'=>'0']);
									   $members_level = array(
										 'member_id'=>$member_id,
										 'level_id'=>@$levels->id ? @$levels->id : '1',
									   );
									   $this->model->Save('members_level',$members_level);
								  }
								}
							}
						}else{
							if ($not_member !='1') {
							foreach($sr_no as $key=>$value)
							{
							$enrollment_no = $this->generateUniqueEnrollmentNo();
							$member_password = $this->generateUniquePassword($fname[$key],$dob[$key]);
					        $members_details = array(
								 'enrollment_no'=>$enrollment_no,
								 'member_enrollment_id'=>$id,
                                 'fname'=>$fname[$key],
								 'mname'=>$mname[$key],
								 'lname'=>$lname[$key],
								 'father_name'=>$father_name[$key],
								 'dob'=>$dob[$key],
								 'gender'=>$gender[$key],
								 'mobile'=>$mobile[$key],
								 'email'=>$email[$key],
								 'profession'=>$profesion[$key],
								 'income_per_day'=>$income[$key],
								 'head_of_the_house'=>@$head_house[$key] ? @$head_house[$key] : '0',
								 'password'=>$member_password,
								 'aadhaar_no'=>$aadhaar_no[$key],
								 'pan_no'=>$pan_no[$key],
								 'voter_id'=>$voter_id[$key],
								);
								$member_id=$this->model->Save('members-details',$members_details);
								$levels = $this->enrollment_model->getRow('level_master',['is_deleted'=>'NOT_DELETED','active'=>'1','level'=>'0']);
								$members_level = array(
                                  'member_id'=>$member_id,
								  'level_id'=>@$levels->id ? @$levels->id : '1',
								);
								$this->model->Save('members_level',$members_level);
							}
							}
						}
								logs($user->id,$id,'EDIT','Edit Members Enrollment');
								$return['res'] = 'success';
							    $return['msg'] = 'Member Enrollment Updated  Successfully .';
								$return['redirect_url']=base_url().'members-enrollment';
							}
						}
						else{
							$not_member = $this->input->post('not_member');
							$sr_no = $this->input->post('sr_no');
							$fname = $this->input->post('fname');
							$mname = $this->input->post('mname');
							$lname = $this->input->post('lname');
							$father_name = $this->input->post('father_name');
							$dob = $this->input->post('dob');
							$gender = $this->input->post('gender');
							$mobile = $this->input->post('mobile');
							$email = $this->input->post('email');
							$profesion = $this->input->post('profesion');
							$income = $this->input->post('income');
							$head_house = $this->input->post('head_house');
							$aadhaar_no = $this->input->post('aadhaar_no');
							$pan_no = $this->input->post('pan_no');
							$voter_id = $this->input->post('voter_id');
							if ($not_member !='1') {
							foreach ($sr_no as $key => $value) {
								if (empty($fname[$key]) ||empty($lname[$key])||empty($father_name[$key]) || empty($dob[$key]) || empty($gender[$key]) || empty($mobile[$key]) || empty($profesion[$key]) || empty($income[$key]) || empty($aadhaar_no[$key]) || empty($email[$key])) {
									$return['res'] = 'error';
									$return['msg'] = 'All mandatory fields fill  for each member.';
									echo json_encode($return);
									return;
								}
							}
						   }
							$members_enrollment = array(
                            'country_id'=>$this->input->post('country_id'),
							'state_id' => explode(',', $this->input->post('state'))[0],
							'commissionaires_id' => explode(',', $this->input->post('commissionaires'))[0],
							'district_id' => explode(',', $this->input->post('district'))[0],
							'tehsil_id' => explode(',', $this->input->post('tehsil'))[0],
							'ward_block_id' => explode(',', $this->input->post('ward'))[0],
							'block_nyay_id' => @explode(',', $this->input->post('block'))[0],
							'panchayat_id' => @explode(',', $this->input->post('panchayat'))[0],
							'village'=>$this->input->post('village'),
							'pincode'=>$this->input->post('pincode'),
							'permanent_address'=>$this->input->post('address'),
							'street_house_flat'=>$this->input->post('street_house'),
							'family_no'=>$this->input->post('family_no'),
							'members_no'=>$this->input->post('members_no'),
							);
							if($insert_id=$this->model->Save('members-enrollment',$members_enrollment)){
								
							
							// Logic of create group
							$pincode = $this->input->post('pincode');
							$group_pincode = substr($pincode, 0, 13);

							$this->db->select('*');
							$this->db->from('members-enrollment');
							$this->db->where('active', '1');
							$this->db->where('is_deleted', 'NOT_DELETED');
							$this->db->where("LEFT(pincode, 13) = '$group_pincode'", NULL, FALSE);
							$query = $this->db->get();
							$checkEnroll = $query->result_array();

							$totalEnroll = count($checkEnroll);
							$group_count = intval(($totalEnroll - 1) / 10) + 1; 
							$last_group = $this->enrollment_model->getLastEntry('family_groups', ['pincode' => $group_pincode]);

							if (!$last_group || $group_count > $last_group['groups']) {
								$family_groups = array(
									'country_id'=>$this->input->post('country_id'),
									'state_id' => explode(',', $this->input->post('state'))[0],
									'commissionaires_id' => explode(',', $this->input->post('commissionaires'))[0],
									'district_id' => explode(',', $this->input->post('district'))[0],
									'tehsil_id' => explode(',', $this->input->post('tehsil'))[0],
									'ward_block_id' => explode(',', $this->input->post('ward'))[0],
									'block_nyay_id' => explode(',', $this->input->post('block'))[0],
									'panchayat_id' => explode(',', $this->input->post('panchayat'))[0],
									'pincode' => $group_pincode,
									'groups' => $group_count,
									'family_no' => $this->input->post('family_no'),
								);

								if ($group_id = $this->enrollment_model->Save('family_groups', $family_groups)) {
									$this->model->Update('members-enrollment', ['group_id' => $group_id], ['id' => $insert_id]);
								}
							}else {
								// Use the existing group ID
								$group_id = $last_group['id'];
								$this->model->Update('members-enrollment', ['group_id' => $group_id], ['id' => $insert_id]);
							}
							
							if ($not_member !='1') {
							foreach($sr_no as $key=>$value) 
							{
							$enrollment_no = $this->generateUniqueEnrollmentNo();
							$member_password = $this->generateUniquePassword($fname[$key],$dob[$key]);
					        $members_details = array(
								'enrollment_no'=>$enrollment_no,
								 'member_enrollment_id'=>$insert_id,
                                 'fname'=>$fname[$key],
								 'mname'=>$mname[$key],
								 'lname'=>$lname[$key],
								 'father_name'=>$father_name[$key],
								 'dob'=>$dob[$key],
								 'gender'=>$gender[$key],
								 'mobile'=>$mobile[$key],
								 'email'=>$email[$key],
								 'profession'=>$profesion[$key],
								 'income_per_day'=>$income[$key],
								 'head_of_the_house'=>@$head_house[$key] ? @$head_house[$key] : '0',
								 'password'=>$member_password,
								 'aadhaar_no'=>$aadhaar_no[$key],
								 'pan_no'=>$pan_no[$key],
								 'voter_id'=>$voter_id[$key],
								);
								$member_id=$this->model->Save('members-details',$members_details);
								$levels = $this->enrollment_model->getRow('level_master',['is_deleted'=>'NOT_DELETED','active'=>'1','level'=>'0']);
								$members_level = array(
                                  'member_id'=>$member_id,
								  'level_id'=>@$levels->id ? @$levels->id : '1',
								);
								$this->model->Save('members_level',$members_level);


								// Logic of Send SMS UserName , Password  Every Member
								//$userName = $enrollment_no;
								//$password = $this->encryption->decrypt($member_password);
								// $msg =$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
								// $conditions = array(
								// 	'returnType' => 'single',
								// 	'conditions' => array(
								// 		'id'=>'1'
								// 		)
								// );
								// $smsData = $this->ManageOrderOtpModel->getSmsRows($conditions);
								// $smsData['mobileNos'] = $mobile[$key];
								// $smsData["message"] = $msg;
								// $this->ManageOrderOtpModel->send_sms($smsData);

							}
						}
							logs($user->id,$insert_id,'ADD','Add  Members Enrollment');
							$return['res'] = 'success';
							$return['msg'] = 'Member Enrollment Successfully .';
							$return['redirect_url']=base_url().'members-enrollment';

					      }

						}
					}else{
						$return['res'] = 'error';
					    $return['msg'] = 'You do not have access to this locality or pincode. Please check your permissions or contact the administrator.';
					}
				}
				echo json_encode($return);
				break;
				case 'details_url':
					$data['title'] 		  = 'Show Enrollment Details';
				    $data['contant']      = $view_dir.'details';
					$data['value']        =$this->enrollment_model->getEnrollmentRow($id);
					$data['members']        =$this->enrollment_model->getData('members-details',['member_enrollment_id'=>$id]);
					load_view($data['contant'],$data);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('members-enrollment',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Members Enrollment');
					}
				}
				echo json_encode($return);
				break;
			case 'deleteMember':
			$memberId = $this->input->post('id');
			if ($this->enrollment_model->delete_member($memberId)) {
			echo json_encode(['status' => 'success']);
			} else {
			echo json_encode(['status' => 'error']);
			}
			break;
			case 'update_pincode':
				$newPincode = $this->input->post('newPincode');
				$newLetter = $this->input->post('newLetter');
				$enroll_id = $this->input->post('enroll_id');
				if ($this->enrollment_model->Update('members-enrollment',['members_no'=>$newLetter,'pincode'=>$newPincode],['id'=>$enroll_id])) {
				echo json_encode(['status' => 'success']);
				} else {
				echo json_encode(['status' => 'error']);
				}
			break;	
			default:
				// code...
				break;
		}
		
	}


	public function generateUniqueEnrollmentNo() {
		$this->db->select('enrollment_no');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('members-details');
	
		if ($query->num_rows() > 0) {
			$last_enrollment_no = $query->row()->enrollment_no;
			$last_number = intval(substr($last_enrollment_no, 6));
			$new_number = $last_number + 1;
			
			// Determine the length of the new number
			$new_length = strlen((string)$new_number);
			$required_length = max(7, $new_length);
	
			// Pad the new number with leading zeros to maintain the required format
			return 'ENROLL' . str_pad($new_number, $required_length, '0', STR_PAD_LEFT);
		} else {
			return 'ENROLL0000001';
		}
	}
	

	public function generateUniquePassword($name, $dob) {
		$namePart = strtolower(substr($name, 0, 4));
		$dobYear = date('Y', strtotime($dob));
		$password = $namePart . $dobYear;
		
		return $this->encryption->encrypt($password);
	}
	


    public function fetch_commissionaires()
    {
        if($this->input->post('state'))
        {
            $state= $this->input->post('state');
            $this->enrollment_model->fetch_commissionaires($state);
        }
    }
    public function fetch_district()
    {
        if($this->input->post('commissionaires'))
        {
            $commissionaires= $this->input->post('commissionaires');
            $this->enrollment_model->fetch_district($commissionaires);
        }
    }
    public function fetch_tehsil()
    {
        if($this->input->post('district'))
        {
            $district= $this->input->post('district');
            $this->enrollment_model->fetch_tehsil($district);
        }
    }

    public function fetch_ward()
    {
        if($this->input->post('tehsil'))
        {
            $tehsil= $this->input->post('tehsil');
            $this->enrollment_model->fetch_ward($tehsil);
        }
    }

    public function fetch_block()
    {
        if($this->input->post('ward'))
        {
            $ward= $this->input->post('ward');
            $this->enrollment_model->fetch_block($ward);
        }
    }

    public function fetch_panchayat()
    {
        if($this->input->post('block'))
        {
            $block= $this->input->post('block');
            $this->enrollment_model->fetch_panchayat($block);
        }
    }
    public function fetch_village()
    {
        if($this->input->post('panchayatId'))
        {
            $panchayatId= $this->input->post('panchayatId');
            $this->enrollment_model->fetch_village($panchayatId);
        }
    }
    

    
    
    
    










}