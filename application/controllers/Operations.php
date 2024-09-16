<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Operations extends Main {
	

	public function remote($type,$id=null,$column='name')
    {
        if ($type=='elections_status') {
            $tb = 'elections-status';
        }
        else{
			
        }
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
	public function family_blocks($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'operations/family_blocks/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Family Blocks';
				$data['contant'] 	= $view_dir.'index';
                $data['tb_url']	  	=  current_url().'/tb';
				$data['search']	 	= $this->input->post('search');
				if ($user->user_role > 1) {
					$admin_id = $user->id;
					$accessible_states = $this->operations_model->getAccessibleStates($admin_id);
					if (!empty($accessible_states)) {
						$data['states'] = $this->operations_model->getDataNew('states', [
							'is_deleted' => 'NOT_DELETED',
							'active' => '1',
							'id' => $accessible_states
						], 'asc', 'seq');
					} else {
						$data['states'] = []; 
					}
				} else {
					$data['states'] = $this->operations_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				}
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."family-blocks/tb";
					$config["total_rows"]  	= count($this->operations_model->family_blocks($user));
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
                    $data['details_url']    = base_url('family-blocks/details_url/');
					$data['rows']    		= $this->operations_model->family_blocks($user,$config["per_page"],$page);
                    
					load_view($data['contant'],$data);
				break;
                case 'details_url':
					$data['title'] 		  = 'Show Enrollment Details';
				    $data['contant']      = $view_dir.'member-details';
					$data['value']        =$this->operations_model->getEnrollmentRow($id);
					$data['members']        =$this->operations_model->getData('members-details',['member_enrollment_id'=>$id]);
					load_view($data['contant'],$data);
				break;
                case 'change_permission':
                    $id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $update_result = $this->operations_model->Update('family-blocks',['permission'=>$status],['enrollment_id'=>$id]);
                    if ($update_result) {
                        echo json_encode(['status' => 'success', 'message' => 'Permission updated successfully']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to update permission']);
                    }
                break;    
			    default:
				// code...
				break;
		}
		
	}

	
	public function family_details($group_id=null,$action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'operations/family_details/';
		switch ($action) {
			case 'details':
				$data['title'] 		= 'Members Level  Status';
				$data['contant'] 	= $view_dir.'index';
                $data['tb_url']	  	=  base_url().'family-details/'.$group_id.'/tb/';
				$data['search']	 	= $this->input->post('search');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."family-details/".$group_id."/tb/";
					$config["total_rows"]  	= count($this->operations_model->family_details($group_id));
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['details_url']    = base_url()."family-details/".$group_id."/member-details/";
					$data['rows']    		= $this->operations_model->family_details($group_id,$config["per_page"],$page);
					load_view($data['contant'],$data);
				break;
				case 'member-details':
					$data['title'] 		  = 'Show Memberber Details';
				    $data['contant']      = $view_dir.'member-details';
					$data['members']        =$this->operations_model->getRow('members-details',['id'=>$id]);
					load_view($data['contant'],$data);
				break;   
			    default:
				// code...
				break;
		}
		
	}
	public function members_level($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'operations/members_level/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Members Level  Status';
				$data['contant'] 	= $view_dir.'index';
                $data['tb_url']	  	=  current_url().'/tb';
				$data['search']	 	= $this->input->post('search');
				if ($user->user_role > 1) {
					$admin_id = $user->id;
					$accessible_states = $this->operations_model->getAccessibleStates($admin_id);
					if (!empty($accessible_states)) {
						$data['states'] = $this->operations_model->getDataNew('states', [
							'is_deleted' => 'NOT_DELETED',
							'active' => '1',
							'id' => $accessible_states
						], 'asc', 'seq');
					} else {
						$data['states'] = []; 
					}
				} else {
					$data['states'] = $this->operations_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				}
				$data['levels']       = $this->operations_model->getData('level_master',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','id');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."members-level/tb";
					$config["total_rows"]  	= count($this->operations_model->members_level($user));
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['rows']    		= $this->operations_model->members_level($user,$config["per_page"],$page);
                    
					load_view($data['contant'],$data);
				break;   
			    default:
				// code...
				break;
		}
		
	}


	public function winner_candidates($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'operations/winner_candidates/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Winner Candidates';
				$data['contant'] 	= $view_dir.'index';
                $data['tb_url']	  	=  current_url().'/tb';
				$data['search']	 	= $this->input->post('search');
				if ($user->user_role > 1) {
					$admin_id = $user->id;
					$accessible_states = $this->operations_model->getAccessibleStates($admin_id);
					if (!empty($accessible_states)) {
						$data['states'] = $this->operations_model->getDataNew('states', [
							'is_deleted' => 'NOT_DELETED',
							'active' => '1',
							'id' => $accessible_states
						], 'asc', 'seq');
					} else {
						$data['states'] = []; 
					}
				} else {
					$data['states'] = $this->operations_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				}
				$data['levels']       = $this->operations_model->getData('level_master',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','id');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."winner-candidates/tb";
					$config["total_rows"]  	= count($this->operations_model->winner_candidates($user));
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['rows']    		= $this->operations_model->winner_candidates($user,$config["per_page"],$page);
                    
					load_view($data['contant'],$data);
				break;   
			    default:
				// code...
				break;
		}
		
	}
	
	
	public function elections_status($action=null,$id=null,$id2=null,$id3=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'operations/elections_status/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Schedule Election';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				if ($user->user_role > 1) {
					$admin_id = $user->id;
					$accessible_states = $this->operations_model->getAccessibleStates($admin_id);
					if (!empty($accessible_states)) {
						$data['states'] = $this->operations_model->getDataNew('states', [
							'is_deleted' => 'NOT_DELETED',
							'active' => '1',
							'id' => $accessible_states
						], 'asc', 'seq');
					} else {
						$data['states'] = []; 
					}
				} else {
					$data['states'] = $this->operations_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				}
				$data['country']       = $this->operations_model->getRow('countries',['is_deleted'=>'NOT_DELETED','active'=>'1','id'=>'1']);
				$data['groups']     = $this->operations_model->getData('family_groups',0);
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."elections-status/tb";
					$config["total_rows"]  	= count($this->operations_model->elections_status($user));
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('elections-status/create/');
					$data['delete_url']		= base_url('elections-status/delete/');
					$data['rows']    		= $this->operations_model->elections_status($user,$config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Election  Status';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'operations/remote/elections_status/';
				$data['action_url']	  = base_url('elections-status/save');
				if ($user->user_role > 1) {
					$admin_id = $user->id;
					$accessible_states = $this->operations_model->getAccessibleStates($admin_id);
					if (!empty($accessible_states)) {
						$data['states'] = $this->operations_model->getDataNew('states', [
							'is_deleted' => 'NOT_DELETED',
							'active' => '1',
							'id' => $accessible_states
						], 'asc', 'seq');
					} else {
						$data['states'] = []; 
					}
				} else {
					$data['states'] = $this->operations_model->getDataNew('states', ['is_deleted' => 'NOT_DELETED', 'active' => '1'], 'asc', 'seq');
				}
				$data['country']       = $this->operations_model->getRow('countries',['is_deleted'=>'NOT_DELETED','active'=>'1','id'=>'1']);
				$data['levels']       = $this->operations_model->getData('level_master',['id !='=>'1','is_deleted'=>'NOT_DELETED','active'=>'1']);
				if ($id!=null) {
					$data['id']=$id;
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->operations_model->getRowElections($id);
					$data['remote']         = base_url().'operations/remote/elections_status/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return = array('res' => 'error', 'msg' => 'Not Saved!');
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD') == 'POST') {
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
					$group_id = $this->input->post('group_id');
					$type = $this->input->post('type');
					$election_date = $this->input->post('election_date');
					$election_start_time = $this->input->post('election_start_time');
					$level = $this->input->post('level_id');
					$validity = $this->input->post('validity');
					$country_id=$this->input->post('country_id');
					$state_id = explode(',', $this->input->post('state'))[0];
					$commissionaires_id = @explode(',', $this->input->post('commissionaires'))[0];
					$district_id = @explode(',', $this->input->post('district'))[0];
					$tehsil_id = @explode(',', $this->input->post('tehsil'))[0];
					$ward_block_id = @explode(',', $this->input->post('ward'))[0];
					$block_nyay_id = @explode(',', $this->input->post('block'))[0];
					$panchayat_id = @explode(',', $this->input->post('panchayat'))[0];
					$pincode=$this->input->post('pincode');
					// Validate election date
					if (strtotime($election_date) < strtotime(date('Y-m-d'))) {
						$return['res'] = 'error';
						$return['msg'] = 'Date Should be a future Date';
						echo json_encode($return);
						return;
					}

					// Validate election start time
					if (strtotime($election_start_time) < strtotime(date('Y-m-d H:i:s'))) {
						$return['res'] = 'error';
						$return['msg'] = 'Time Should be a future Time';
						echo json_encode($return);
						return;
					}
					$endTimeOfDay = date('Y-m-d', strtotime($election_date)) . '23:59:59';
					$totalHours = $this->calculateTotalHours($election_date, $election_start_time);
					if ($validity <= $totalHours) {
						
						$existing_election = $this->db
						->order_by('election_date', 'DESC')
						->get_where('elections-status', ['pincode' => $pincode])
						->row();
					
					if ($existing_election) {
						$last_election_date = strtotime($existing_election->election_date);
						$current_date = strtotime(date('Y-m-d'));
					
						// Retrieve settings for tenure
						$settings = $this->db->select('*')
							->from('settings')
							->where('type', 'Tenure')
							->get()
							->row();
					
						if ($settings) {
							// Convert tenure to seconds
							$one_year_in_seconds = intval($settings->value) * 365 * 24 * 60 * 60;
					
							// Calculate remaining time
							$remaining_time = $one_year_in_seconds - ($current_date - $last_election_date);
					
							if ($remaining_time > 0) {
								// Calculate days, hours, minutes, and seconds
								$days = floor($remaining_time / (24 * 60 * 60));
								$hours = floor(($remaining_time % (24 * 60 * 60)) / (60 * 60));
								$minutes = floor(($remaining_time % (60 * 60)) / 60);
								$seconds = $remaining_time % 60;
					
								$return['res'] = 'error';
								$return['msg'] = 'An election has already been scheduled for this pincode within the last year. Next possible election can be scheduled in ' . $days . ' days, ' . $hours . ' hours, ' . $minutes . ' minutes, and ' . $seconds . ' seconds.';
								echo json_encode($return);
								return;
							}
						}
					}
					
					
						if($level > 3)
						{
							$data = array(
								'group_id' => $group_id,
								'type' => $type,
								'election_date' => $election_date,
								'election_start_time' => $election_start_time,
								'level_id' => $level,
								'validity' => $validity,
								'country_id'=>$country_id,
								'state_id'=>$state_id,
								'commissionaires_id'=>$commissionaires_id,
								'district_id'=>$district_id,
								'tehsil_id'=>$tehsil_id,
								'ward_block_id'=>$ward_block_id,
								'block_nyay_id'=>$block_nyay_id,
								'panchayat_id'=>$panchayat_id,
								'pincode'=>$pincode
							);		
							if ($id != null) {
								// $row=$this->operations_model->getRow('elections-status',['id' => $id]);
								// $showActions = strtotime($row->election_date) >= strtotime(date('Y-m-d'));
								// if ($showActions){
								// if ($this->operations_model->Update('elections-status', $data, ['id' => $id])) {
								// 	logs($user->id, $id, 'EDIT', 'Edit Election Status');
								// 	$return['res'] = 'success';
								// 	$return['msg'] = 'Edit Successfully.';
								// }
							// }else{
							// 	$return['res'] = 'error';
							// 	$return['msg'] = 'Past election schedule not update';
							// }

							} else {
							$level_id = $level - 1;
							$members = $this->operations_model->getMembersScheduleElection($pincode,$level_id);
							if(count($members) > 2){
								if ($insert_id = $this->operations_model->Save('elections-status', $data)) {
									// Create Election Group Logic
									if (!empty($members)) {
										$group_id = 1;
										$counter = 0;
										$members_chunked = array_chunk($members, 10);
							
										foreach ($members_chunked as $group_members) {
											$group_data = array(
												'groups' => $group_id,
												'election_id' => $insert_id,
												'added' => date('Y-m-d H:i:s'),
												'updated' => date('Y-m-d H:i:s'),
												'active' => '1',
											);
											$this->db->insert('election_groups', $group_data);
											$new_group_id = $this->db->insert_id();
											foreach ($group_members as $member) {
												$group_member_data = array(
													'election_groups_id' => $new_group_id,
													'member_id' => $member->member_id,
												);
												$this->db->insert('election_groups_members', $group_member_data);
											}
							
											$group_id++;
										}
									}
							
									logs($user->id, $insert_id, 'ADD', 'Add Election Status');
									$return['res'] = 'success';
									$return['msg'] = 'Saved.';
								} else {
									$return['res'] = 'error';
									$return['msg'] = 'Failed to save.';
								}
							   }else{
								$return['res'] = 'error';
								$return['msg'] = 'In Schedule Election time min 3 member mandatory!.';
							   }
							}
						}else{
						$data = array(
							'group_id' => $group_id,
							'type' => $type,
							'election_date' => $election_date,
							'election_start_time' => $election_start_time,
							'level_id' => $level,
							'validity' => $validity,
							'country_id'=>$country_id,
							'state_id'=>$state_id,
							'commissionaires_id'=>$commissionaires_id,
							'district_id'=>$district_id,
							'tehsil_id'=>$tehsil_id,
							'ward_block_id'=>$ward_block_id,
							'block_nyay_id'=>$block_nyay_id,
							'panchayat_id'=>$panchayat_id,
							'pincode'=>$pincode
						);
						if ($id != null) {
						// 	$row=$this->operations_model->getRow('elections-status',['id' => $id]);
						// 	$showActions = strtotime($row->election_date) >= strtotime(date('Y-m-d'));
						// 	if ($showActions){
						// 	if ($this->operations_model->Update('elections-status', $data, ['id' => $id])) {
						// 		logs($user->id, $id, 'EDIT', 'Edit Election Status');
						// 		$return['res'] = 'success';
						// 		$return['msg'] = 'Edit Successfully.';
						// 	}
						//   }else{
						// 	$return['res'] = 'error';
						// 	$return['msg'] = 'Past election schedule not update';
						//   }

						} else {
							if ($insert_id = $this->operations_model->Save('elections-status', $data)) {
								logs($user->id, $insert_id, 'ADD', 'Add Election Status');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						}
					   }
					} else {
						$return['res'] = 'error';
						$return['msg'] = 'Validity exceeds hours from start time to end of day';
					}
				   }else{
					$return['res'] = 'error';
					$return['msg'] = 'You do not have access to this locality or pincode. Please check your permissions or contact the administrator.';
				   }
				}
				echo json_encode($return);
				break;
			case 'winner':
				$data['title'] 		  = 'New Election  Status';
				$data['contant']      = $view_dir.'winner';
				$data['election_id']=$id;
				$data['group_id']=$id2;
				$data['level']=$id3;
				$elections = $this->operations_model->getRow('elections-status',['is_deleted'=>'NOT_DELETED','active'=>'1','id'=>$id]);
				$data['elections'] = $this->operations_model->getRow('elections-status',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				$data['value'] = $this->operations_model->getRowElections($id);
				if($id2==0)
				{
				$data['blocks'] = $this->operations_model->getData('family_groups',['pincode'=>$elections->pincode]);
				}else{
				$data['blocks'] = $this->operations_model->getData('family_groups',['id'=>$id2]);
				}
				$data['election_groups'] = $this->operations_model->getData('election_groups',['election_id'=>$id]);
				$data['enrollment'] = $this->operations_model->getDataEnrollment($id);
				load_view($data['contant'],$data);
			break;	
			case 'already_winner':
				$data['title'] 		  = 'New Election  Status';
				$data['contant']      = $view_dir.'already_winner';
				$data['election_id']=$id;
				$data['group_id']=$id2;
				$data['level']=$id3;
				$elections = $this->operations_model->getRow('elections-status',['is_deleted'=>'NOT_DELETED','id'=>$id]);
				$data['value'] = $this->operations_model->getRowElections($id);
				if($id2==0)
				{
				$data['blocks'] = $this->operations_model->getData('family_groups',['pincode'=>$elections->pincode]);
				}else{
				$data['blocks'] = $this->operations_model->getData('family_groups',['id'=>$id2]);
				}
				$data['enrollment'] = $this->operations_model->getDataEnrollment($id);
				$data['election_groups'] = $this->operations_model->getData('election_groups',['election_id'=>$id]);
				load_view($data['contant'],$data);
			break;
			
			case 'check_election_date':
				$check_id = $this->input->post('id');
				$pincode = $this->input->post('pincode');
				$election_date = $this->input->post('election_date');
				$level = $this->input->post('level_id');
				$exists = $this->operations_model->check_election_date_exists($check_id,$pincode, $election_date,$level);
				
			
				if ($exists) {
					echo 'false'; 
				} else {
					echo 'true'; 
				}
			break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					$row=$this->operations_model->getRow('elections-status',['is_deleted'=>'NOT_DELETED','active'=>'1','id' => $id]);
					$showActions = strtotime($row->election_date) >= strtotime(date('Y-m-d'));
					if ($showActions){
					if($this->operations_model->_delete('elections-status',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Election Status');
					}
				   }else{
					$return['res'] = 'error';
					$return['msg'] = 'Past election schedule not deleted.';
				  }
				}
				echo json_encode($return);
				break;
			    default:
				// code...
				break;
		}
		
	}

  // Function to calculate total hours from start time to end of day
  private function calculateTotalHours($date, $startTime) {
	$startDateTime = new DateTime("$date $startTime");
	$endDateTime = new DateTime("$date 23:59:59");
	$interval = $startDateTime->diff($endDateTime);
	$totalHours = $interval->h + ($interval->days * 24);
	return $totalHours;
}


public function fetch_group()
{
	if($this->input->post('pincode'))
	{
		$pincode= $this->input->post('pincode');
		$this->operations_model->fetch_group($pincode);
	}
}


}