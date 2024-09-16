<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Users extends Main {

	public function user($action=null,$id=null,$id2=null)
	{
		$data['user']    = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'Users';
				$data['contant'] = 'users/users/index';
				$data['tb_url']	  =  base_url().'users/tb';
				$data['new_url']	  =  base_url().'users/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/users/tb';
				$data['update_url']	  =  base_url().'users/create/';
				$data['delete_url']	  =  base_url().'users/delete/';
				$data['location_url']  =  base_url().'users/location_url/';
				$data['rows'] = $this->model->getData('tb_admin',['is_deleted'=>'NOT_DELETED'],'asc','name');
				load_view($data['contant'],$data);
				break;

			case 'location_url':
				$data['user_id']=$id;
				$data['contant'] = 'users/users/location_create';
				$data['action_url']	  =  base_url().'users/location_save/'.$id;
				$data['country']       = $this->model->getRow('countries',['is_deleted'=>'NOT_DELETED','active'=>'1','id'=>'1']);
                $data['states']       = $this->model->getData('states',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				$data['locations']       = $this->model->getDataLocations($id);
				if ($id2!=null) {
					$data['action_url']	  =  base_url().'users/location_save/'.$id.'/'.$id2;
					$data['row'] = $this->model->getRow('admin_locality_access',['id'=>$id2]);
				}
				load_view($data['contant'],$data);
				break;
				case 'load_table':
					$user_id = $this->input->get('user_id');
					$data['locations'] = $this->model->get_all_locations($user_id);
					$this->load->view('users/users/location_table', $data);
				break;
				case 'location_save':
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
					
					if ($this->input->server('REQUEST_METHOD') == 'POST') {
						$admin_id = $id;
						$pincode = $this->input->post('pincode');
						$state_id = explode(',', $this->input->post('state'))[0];
						$commissionaires_id = explode(',', $this->input->post('commissionaires'))[0];
						$district_id = explode(',', $this->input->post('district'))[0];
						$tehsil_id = explode(',', $this->input->post('tehsil'))[0];
						
						$existingRecord = $this->db->get_where('admin_locality_access', [
							'admin_id' => $admin_id,
							'pincode' => $pincode
						])->row();
						if ($existingRecord) {
							if ($id2 != null) {
								if ($existingRecord->id != $id2) {
									$return['msg'] = 'This pincode already exists for this admin!';
									echo json_encode($return);
									return;
								}
							} else {
								$return['msg'] = 'This pincode already exists for this admin!';
								echo json_encode($return);
								return;
							}
						}
				
						$dataMap = array(
							'admin_id' => $admin_id,
							'country_id' => $this->input->post('country_id'),
							'state_id' => $state_id,
							'commissionaires_id' => $commissionaires_id,
							'district_id' => $district_id,
							'tehsil_id' => $tehsil_id,
							'pincode' => $pincode,
						);
				
						if ($id2 != null) {
							if ($this->model->Update('admin_locality_access', $dataMap, ['id' => $id2])) {
								$return['res'] = 'success';
								$return['msg'] = 'Location Assign Updated Successfully!';
							}
						} else {
							if ($this->model->SaveGetId('admin_locality_access', $dataMap)) {
								$return['res'] = 'success';
								$return['msg'] = 'Location Assign Successfully!';
							}
						}
					}
					echo json_encode($return);
					break;
				case 'delete_location':
					$response = array('res' => 'error', 'msg' => 'Location not deleted.');
					$id = $this->input->post('id');
					if($this->model->delete_location($id))
					{
						$response = array('res' => 'success', 'msg' => 'Location deleted successfully.');
					}
					echo json_encode($response);
			       break;	
				   case 'get_location_by_id':
					$response = array('res' => 'error', 'msg' => 'Location not fetched.');
					$id = $this->input->post('id');
					$location = $this->model->get_location($id);
					$states = $this->model->getData('states',['active'=>'1','is_deleted'=>'NOT_DELETED'],'ASC','name');
					$commissionaires = $this->model->getData('commissionaires',['active'=>'1','is_deleted'=>'NOT_DELETED'],'ASC','name');
					$districts = $this->model->getData('district',['active'=>'1','is_deleted'=>'NOT_DELETED'],'ASC','name');
					$tehsils =$this->model->getData('tehsil-zone',['active'=>'1','is_deleted'=>'NOT_DELETED'],'ASC','name');
				
					if (!empty($location)) {
						$response = array(
							'res' => 'success',
							'msg' => 'Location fetched successfully.',
							'data' => $location,
							'states' => $states,
							'commissionaires' => $commissionaires,
							'districts' => $districts,
							'tehsils' => $tehsils
						);
					}
					
					echo json_encode($response);
					break;
				
				case 'create':
					$data['contant'] = 'users/users/create';
					$data['action_url']	  =  base_url().'users/save';
					$data['user_role']  = $this->model->getData('tb_user_role',0,'asc','name');
					$data['remote']     = base_url().'master-data/remote/users/';
					if ($id!=null) {
						$data['action_url']	  =  base_url().'users/save/'.$id;
						$data['row'] = $this->model->getRow('tb_admin',['id'=>$id]);
						$data['remote']     = base_url().'master-data/remote/users/'.$id;
					}
					load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {

					if ($id!=null) {
						$row = $this->model->getRow('tb_admin',['id'=>$id]);
						$data=array(
                         'password'=>$this->encryption->encrypt($this->input->post('password')),
						 'username'=>$this->input->post('username'),
						 'name'=>$this->input->post('name'),
						 'email'=>$this->input->post('email'),
						 'mobile'=>$this->input->post('mobile'),
						 'user_role'=>$this->input->post('user_role'),
						);
						if($this->model->Update('tb_admin',$data,['id'=>$id])){
							$saved = 1;
							
						}
					}
					else{
						$data=array(
							'password'=>$this->encryption->encrypt($this->input->post('password')),
							'username'=>$this->input->post('username'),
							'name'=>$this->input->post('name'),
							'email'=>$this->input->post('email'),
							'mobile'=>$this->input->post('mobile'),
							'user_role'=>$this->input->post('user_role'),
						   );
						if($id = $this->model->SaveGetId('tb_admin',$data)){
							$saved = 1;
						}
					}

					if ($saved == 1 ) {
						$file_name = 'photo';
						if (@$_FILES[$file_name]['name']) {
						$directory = '../../public/uploads/user-images/';
						if (base_url()=='http://localhost/mrs/') {
							$directory = 'public/uploads/user-images/';
						}
						$config['upload_path']          = $directory;
               			$config['allowed_types'] 		= '*';
		                $config['remove_spaces']        = TRUE;
			            $config['encrypt_name']         = TRUE;
			            $config['max_filename']         = 20;
						$config['max_size']    			= '100';
			            $this->load->library('upload', $config);
			            if($this->upload->do_upload($file_name)){
			            	$upload_data = $this->upload->data();
			            	$img['photo']  = img_base_url().'public/uploads/user-images/'.$upload_data['file_name'];
			            	if($this->model->Update('tb_admin',$img,['id'=>$id])){
				            	if (@$row) {
				            		if(@$row->pic!=''){
				            			if (base_url()=='http://localhost/mrs/') {
										unlink($row->pic);
										}
										else{
											unlink('../../'.$row->pic);
										}
				            		}
								}
							}
			            }
						else
							{
						$fileerror =  "File upload error".$this->upload->display_errors();
						$return['res'] = 'error';
				        $return['msg'] = $fileerror;
						echo json_encode($return);
						die();
							}
					}
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);
				break;

				case 'delete':
					$return['res'] = 'error';
					$return['msg'] = 'Not Deleted!';
					if ($id!=null) {
					if($this->model->_delete('tb_admin',['id'=>$id])){
							$saved = 1;
							$return['res'] = 'success';
							$return['msg'] = 'Successfully deleted.';
						}
					}
					echo json_encode($return);
				break;

			}
	}

	public function admin_menu($action=null,$id=null)
	{
		$data['user'] 		= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'Admin Menu';
				$data['contant'] = 'users/admin_menu/index';
				$data['tb_url']	  =  base_url().'admin-menu/tb';
				$data['new_url']	  =  base_url().'admin-menu/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/admin_menu/tb';
				$data['update_url']	  =  base_url().'admin-menu/create/';
				$data['delete_url']	  =  base_url().'admin-menu/delete/';
				$data['rows']		= $this->model->admin_menus();
				// $this->pr($data);
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['title'] 		  = 'New Admin Menu';
				$data['contant']      = 'users/admin_menu/create';
				$data['action_url']	  =  base_url().'admin-menu/save';
				if ($id!=null) {
					$data['action_url']	  =  base_url().'admin-menu/save/'.$id;
					$data['row'] = $this->model->getRow('tb_admin_menu',['id'=>$id]);
				}
				$data['menus']   = $this->model->admin_menus('');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('tb_admin_menu',$_POST,['id'=>$id])){
							$saved = 1;
						}
					}
					else{
						if($this->model->Save('tb_admin_menu',$_POST)){
							$saved = 1;
						}
					}

					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);
				break;
				case 'delete':
					$return['res'] = 'error';
					$return['msg'] = 'Not Deleted!';
					if ($id!=null) {
					if($this->model->Delete('tb_admin_menu',['id'=>$id])){
							$saved = 1;
							$return['res'] = 'success';
							$return['msg'] = 'Successfully deleted.';
						}
					}
					echo json_encode($return);
					break;
			
			default:
				// code...
				break;
		}
		

		// $this->pr($data);
		// $this->template($data);
	}


	public function user_role($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'User Role';
				$data['contant'] = 'users/user_role/index';
				$data['tb_url']	  =  base_url().'user-role/tb';
				$data['new_url']	  =  base_url().'user-role/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/user_role/tb';
				$data['update_url']	  =  base_url().'user-role/create/';
				$data['delete_url']	  =  base_url().'user-role/delete/';
				$data['m_access_url'] =  base_url().'user-role/menu_access/';
				$data['rows']		  = $this->model->getData('tb_user_role');
				// $this->pr($data);
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['title'] 		  = 'User Role';
				$data['contant']      = 'users/user_role/create';
				$data['action_url']	  =  base_url().'user-role/save';
				if ($id!=null) {
					$data['action_url']	  =  base_url().'user-role/save/'.$id;
					$data['row'] = $this->model->getRow('tb_user_role',['id'=>$id]);
				}
				$data['menus']   = $this->model->admin_menus('');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('tb_user_role',$_POST,['id'=>$id])){
							$saved = 1;
						}
					}
					else{
						if($this->model->Save('tb_user_role',$_POST)){
							$saved = 1;
						}
					}

					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);
				break;

			case 'menu_access':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					// $this->pr($_POST);

					$menu_id    = $_POST['m_id'];
					$type   	= $_POST['type'];
					$role_id    = $id;
					$row = $this->model->getRow('tb_admin_menu',['id'=>$menu_id]);
					if($row){
						$check['role_id']   = $role_id;
						$check['menu_id'] 	= $menu_id;
						$value = 0;
						if ($type=='set'){
							$value = 1;
						}
						// $update['propmasterid'] 	= $p_id;

						if ($type=='set' && $_POST['name']=='') {
							
							if($this->model->getRow('tb_role_menus',$check)){
								if ($this->model->Update('tb_role_menus',$update,$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
							else{
								if ($this->model->Save('tb_role_menus',$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
						}
						else if($_POST['name']!=''){
							$update[$_POST['name']] = $value;
							if($this->model->getRow('tb_role_menus',$check)){
								if ($this->model->Update('tb_role_menus',$update,$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Menu Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('tb_role_menus',$check)) {
								logs($user->id,$role_id,'EDIT','Assign User Role');
								$saved = 1;
							}
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}

					echo json_encode($return);
					
				}
				else{
					$page     = 'users/user_role/menu_access';
					$data['m_access_url'] =  base_url().'user-role/menu_access/';

					$menus   = $this->model->admin_menus('');
					$data['role_id'] = $role_id = $id;
					if ($menus) {
						foreach ($menus as $row) {
							$row->checked = '';
							$row->c_checked = '';
							$row->u_checked = '';
							$row->d_checked = '';
							if ($t = $this->model->getRow('tb_role_menus',['menu_id'=>$row->id,'role_id'=>$role_id])) {
								$row->checked = 'checked';
							}
							if (@$t->add==1) {
								$row->c_checked = 'checked';
							}
							if (@$t->update==1) {
								$row->u_checked = 'checked';
							}
							if (@$t->delete==1) {
								$row->d_checked = 'checked';
							}
						}
					}

					// $this->pr($menus);
					$data['menus']  = $menus;
					load_view($page,$data);
				}
				break;

			
			default:
				// code...
				break;
		}
		

		// $this->pr($data);
		// $this->template($data);
	}



}
