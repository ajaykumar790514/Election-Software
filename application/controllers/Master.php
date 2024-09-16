<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Master extends Main {
	

	public function remote($type,$id=null,$column='name')
    {
        if ($type=='countries') {
            $tb = 'countries';
        }elseif($type=='states')
		{
			$tb = 'states';
		}elseif($type=='commissionaires')
		{
			$tb = 'commissionaires';
		}elseif($type=='district'){
			$tb = 'district';	
		}elseif($type=='tehsil'){
			$tb = 'tehsil-zone';	
		}elseif($type=='ward-block'){
			$tb = 'ward-block';	
		}elseif($type=='block-nyay')
		{
			$tb='block-nyay';
		}elseif($type=='panchayat')
		{
			$tb='panchayat-village';
		}elseif($type=='level')
		{
			$tb='level_master';
		}elseif($type=='income')
		{
			$tb='income_master';
		}
		elseif($type=='settings')
		{
          $tb='settings';
		}
		elseif($type=='users')
		{
          $tb='tb_admin';
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
	public function countries($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/countries/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Countries';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['search']	 	= $this->input->post('search');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."countries/tb";
					$config["total_rows"]  	= count($this->master_model->countries());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('countries/create/');
					$data['delete_url']		= base_url('countries/delete/');
					$data['rows']    		= $this->master_model->countries($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Countries';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/countries/';
				$data['action_url']	  = base_url('countries/save');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('countries',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/countries/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('countries',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Countries');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('countries',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Countries');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('countries',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Countries');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}

	public function income_master($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/income_master/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Income';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['search']	 	= $this->input->post('search');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."income-master/tb";
					$config["total_rows"]  	= count($this->master_model->income_master());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('income-master/create/');
					$data['delete_url']		= base_url('income-master/delete/');
					$data['rows']    		= $this->master_model->income_master($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Countries';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/income/';
				$data['action_url']	  = base_url('income-master/save');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('income_master',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/income/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('seq', 'Seq', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->master_model->Update('income_master',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Income');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->master_model->Save('income_master',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Income');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->master_model->_delete('income_master',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Income');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}

	

	public function states($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/states/';
		switch ($action) {
			case null:
				$data['title'] 		= 'States';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['countries']     = $this->master_model->getData('countries',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."states/tb";
					$config["total_rows"]  	= count($this->master_model->states());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('states/create/');
					$data['delete_url']		= base_url('states/delete/');
					$data['rows']    		= $this->master_model->states($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New States';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/states/';
				$data['action_url']	  = base_url('states/save');
				$data['countries']     = $this->master_model->getData('countries',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('states',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/states/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('states',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit States');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('states',$_POST)){
								logs($user->id,$insert_id,'ADD','Add States');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('states',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete States');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}


	public function commissionaires($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/commissionaires/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Commissionaires';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['states']     = $this->master_model->getData('states',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."commissionaires/tb";
					$config["total_rows"]  	= count($this->master_model->commissionaires());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('commissionaires/create/');
					$data['delete_url']		= base_url('commissionaires/delete/');
					$data['rows']    		= $this->master_model->commissionaires($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Commissionaires';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/commissionaires/';
				$data['action_url']	  = base_url('commissionaires/save');
				$data['states']     = $this->master_model->getData('states',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('commissionaires',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/commissionaires/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('commissionaires',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Commissionaires');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('commissionaires',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Commissionaires');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('commissionaires',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Commissionaires');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}



	public function district($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/district/';
		switch ($action) {
			case null:
				$data['title'] 		= 'District';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['commissionaires']     = $this->master_model->getData('commissionaires',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."district/tb";
					$config["total_rows"]  	= count($this->master_model->district());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('district/create/');
					$data['delete_url']		= base_url('district/delete/');
					$data['rows']    		= $this->master_model->district($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New District';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/district/';
				$data['action_url']	  = base_url('district/save');
				$data['commissionaires']     = $this->master_model->getData('commissionaires',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('district',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/district/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('district',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit District');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('district',$_POST)){
								logs($user->id,$insert_id,'ADD','Add District');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('district',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete District');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}
	

	public function tehsil_zone($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/tehsil_zone/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Tehsil Zone';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['districts']     = $this->master_model->getData('district',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."tehsil-zone/tb";
					$config["total_rows"]  	= count($this->master_model->tehsil_zone());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('tehsil-zone/create/');
					$data['delete_url']		= base_url('tehsil-zone/delete/');
					$data['rows']    		= $this->master_model->tehsil_zone($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Tehsil Zone';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/tehsil/';
				$data['action_url']	  = base_url('tehsil-zone/save');
				$data['districts']     = $this->master_model->getData('district',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('tehsil-zone',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/tehsil/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('tehsil-zone',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Tehsil Zone ');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('tehsil-zone',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Tehsil Zone ');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('tehsil-zone',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Tehsil Zone ');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}


	public function ward_block($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/ward_block/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Ward Block';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['tehsils']     = $this->master_model->getData('tehsil-zone',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."ward-block/tb";
					$config["total_rows"]  	= count($this->master_model->ward_block());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('ward-block/create/');
					$data['delete_url']		= base_url('ward-block/delete/');
					$data['rows']    		= $this->master_model->ward_block($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Ward Block';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/ward-block/';
				$data['action_url']	  = base_url('ward-block/save');
				$data['tehsils']     = $this->master_model->getData('tehsil-zone',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('ward-block',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/ward-block/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('ward-block',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Ward Block ');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('ward-block',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Ward Block ');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('ward-block',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Ward Block ');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}
	
	
	public function block_nyay($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/block_nyay/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Block Nyay';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['wards']     = $this->master_model->getData('ward-block',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."block-nyay/tb";
					$config["total_rows"]  	= count($this->master_model->block_nyay());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('block-nyay/create/');
					$data['delete_url']		= base_url('block-nyay/delete/');
					$data['rows']    		= $this->master_model->block_nyay($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Ward Block';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/block-nyay/';
				$data['action_url']	  = base_url('block-nyay/save');
				$data['wards']     = $this->master_model->getData('ward-block',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('block-nyay',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/block-nyay/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('block-nyay',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Block Nyay');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('block-nyay',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Block Nyay ');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('block-nyay',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Block Nyay');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}

	public function panchayat($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/panchayat/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Panchayat';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$data['blocks']     = $this->master_model->getData('block-nyay',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."panchayat/tb";
					$config["total_rows"]  	= count($this->master_model->panchayat());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('panchayat/create/');
					$data['delete_url']		= base_url('panchayat/delete/');
					$data['rows']    		= $this->master_model->panchayat($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Panchayat';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/panchayat/';
				$data['action_url']	  = base_url('panchayat/save');
				$data['blocks']     = $this->master_model->getData('block-nyay',['is_deleted'=>'NOT_DELETED','active'=>'1'],'asc','seq');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('panchayat-village',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/panchayat/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('code', 'Code', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('panchayat-village',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Panchayat');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('panchayat-village',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Panchayat');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('panchayat-village',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Panchayat ');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}
	
	
	public function level_master($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/level_master/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Level Master';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."level-master/tb";
					$config["total_rows"]  	= count($this->master_model->level_master());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('level-master/create/');
					$data['delete_url']		= base_url('level-master/delete/');
					$data['rows']    		= $this->master_model->level_master($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Level Master';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/level/';
				$data['action_url']	  = base_url('level-master/save');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('level_master',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/level/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('level', 'Level', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('level_master',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Level Master');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('level_master',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Level Master');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('level_master',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Level Master');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}


	
	public function settings($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'master/settings/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Settings';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$this->template($data);
				break;

			    case 'tb':
					$this->load->library('pagination');
					$data['contant'] 		= $view_dir.'tb';
					$config = array();
					$config["base_url"] 	= base_url()."settings/tb";
					$config["total_rows"]  	= count($this->master_model->settings());
					$data['total_rows']    	= $config["total_rows"];
					$config["per_page"]    	= 10;
					$config["uri_segment"]      = $this->uri->total_segments();
					$config['attributes']  	= array('class' => 'pag-link ');
					$this->pagination->initialize($config);
					$data['links']   		= $this->pagination->create_links();
					$data['page']    		= $page = ($id!=null) ? $id : 0;
					$data['search']	 		= $this->input->post('search');
					$data['update_url']		= base_url('settings/create/');
					$data['delete_url']		= base_url('settings/delete/');
					$data['rows']    		= $this->master_model->settings($config["per_page"],$page);
					load_view($data['contant'],$data);
				break;

			    case 'create':
				$data['title'] 		  = 'New Level Master';
				$data['contant']      = $view_dir.'create';
				$data['remote']     = base_url().'master-data/remote/settings/';
				$data['action_url']	  = base_url('settings/save');
				if ($id!=null) {
					$data['action_url']	  .=  '/'.$id;
					$data['value'] = $this->master_model->getRow('settings',['id'=>$id]);
					$data['remote']         = base_url().'master-data/remote/settings/'.$id;
					$data['contant']      = $view_dir.'update';
				}
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$this->form_validation->set_rules('type', 'Type', 'required');
					$this->form_validation->set_rules('value', 'Value', 'required');
					if ($this->form_validation->run() !== FALSE)
	                {
	                    if ($id!=null) {
							if($this->model->Update('settings',$_POST,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Settings Master');
								$saved = 1;
							}
						}
						else{
							
							if($insert_id=$this->model->Save('settings',$_POST)){
								logs($user->id,$insert_id,'ADD','Add Settings Master');
								$saved = 1;
							}
						}

						if ($saved == 1 ) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
	                }
	                else
	                {
						$return['res'] = 'error';
						$return['msg'] =  $this->form_validation->error_array();
	                    $return['errors'] = $this->form_validation->error_array();
	                }	
				}
				echo json_encode($return);
				break;
			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('settings',['id'=>$id])){
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
						logs($user->id,$id,'DELETE','Delete Settings Master');
					}
				}
				echo json_encode($return);
				break;

			
			default:
				// code...
				break;
		}
		
	}
}