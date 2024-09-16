<?php
/**
 * 
 */
class Model extends CI_Model
{
	
	public function admin_menus($parent_menu=00)
	{
		$this->db->order_by('indexing','asc');
		if ($parent_menu!=00) {
			$this->db->where('parent',$parent_menu);
		}
		return $this->db->get('tb_admin_menu')->result();
	}
	  // BY AJAY KUMAR
      /*
     *  Select Records From Table
     */
    public function Select($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);

        /*
         * Fetch Records
         */

        return $query->result();
    }
   /*
     * Count No Rows in Table
     */
    public function Counter($Table, $Where = 1)
    {
        $rows = $this->Select($Table, '*', $Where);

        return count($rows);
    }


	public function mobile_exist($mobile)
	{
		$this->db->select("mtb.*")
		->from('members-details mtb')
		->where(['mtb.mobile'=>$mobile, 'mtb.active'=>'1']);
	
		return $this->db->get()->num_rows();
		
	}

	function updateRow($mobile,$data ){
		if($this->db->insert('all_otp',$data)){
			return $this->db->insert_id();
		}
		return false; 
	}

	
	public function otp_exist($otp)
	{
		$this->db->select("mtb.*")
		->from('all_otp mtb')
		->where(['mtb.otp'=>$otp]);
	
		return $this->db->get()->num_rows();
		
	}
	public function update_password($mobile,$data)
	{
		return $this->db->where('mobile', $mobile)->update('members-details', $data);
	}
	public function mobile_check($mobile)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('members-details mtb')
		->where(['mtb.mobile'=>$mobile, 'mtb.active'=>'1']);
	
		return $this->db->get()->num_rows();
		
	}

	public function admin_mobile_exist($mobile)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('tb_admin mtb')
		->where(['mtb.mobile'=>$mobile]);
	
		return $this->db->get()->num_rows();
		
	}

	public function admin_otp_exist($otp)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('all_otp mtb')
		->where(['mtb.otp'=>$otp]);
	
		return $this->db->get()->num_rows();
		
	}
	function adminupdateRow($mobile,$data ){
		if($this->db->insert('all_otp',$data)){
			return $this->db->insert_id();
		}
		return false; 
	}
	public function admin_update_password($mobile,$data)
	{
		return $this->db->where('mobile', $mobile)->update('tb_admin', $data);
	}
	


	

	

	function dashboard_content(){
		
	} 

 


	// main functions

 	function Save($tb,$data){
		if($this->db->insert($tb,$data)){
			return $this->db->insert_id();
		}
		return false; 
	}

	function SaveGetId($tb,$data){
	 	if($this->db->insert($tb,$data)){
	 		return $this->db->insert_id();
	 	}
	 	return false;
	}



	function getData($tb,$data=0,$order=null,$order_by=null,$limit=null,$start=null) {

		if ($order!=null) {
			if ($order_by!=null) {
				$this->db->order_by($order_by,$order);
			}
			else{
				$this->db->order_by('id',$order);
			}
		}

		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}

		if ($data==0 or $data==null) {
			return $this->db->get($tb)->result();
		}
		if (@$data['search']) {
			$search = $data['search'];
			unset($data['search']);
		}
		return $this->db->get_where($tb,$data)->result();
	}



	function getRow($tb,$data=0) {
		if ($data==0) {
			if($data=$this->db->get($tb)->row()){
				return $data;
			}
			else {
				return false;
			}
		}
		elseif(is_array($data)) {
			if($data=$this->db->get_where($tb, $data)){
				return $data->row();
			}
			else {
				return false;
			}
		}
		else {
			if($data=$this->db->get_where($tb,array('id'=>$data))){
				return $data->row();
			}
			else {
				return false;
			}
		}
	}

	function Update($tb,$data,$cond) {
		$this->db->where($cond);
	 	if($this->db->update($tb,$data)) {

	 		return true;
	 	}

	 	echo $this->db->last_query();die();
	 	return false;
	}
function Update_data($tb,$cond,$data) {
		$this->db->where('id',$cond);
	 	if($this->db->update($tb,$data)) {
	 		return true;
	 	}
	 	return false;
	}



	function _delete($tb,$data) {
		if (is_array($data)){
			$this->db->where($data);
			if($this->db->update($tb,['is_deleted'=>'DELETED'])){
				return true;
			}
		}
		else{
			$this->db->where('id',$data);
			if($this->db->update($tb,['is_deleted'=>'DELETED'])){
				return true;
			}
		}
		return false;
	}

	function Delete($tb,$data) {
		if (is_array($data)){
			$this->db->where($data);
			if($this->db->delete($tb)){
				return true;
			}
		}
		else{
			$this->db->where('id ',$data);
			if($this->db->delete($tb)){
				return true;
			}
		}
		return false;
	}


	// Masters

	public function getDataLocations($id)
	{
		$this->db->select("a.*,,b.name as country_name,b.code as country_code,c.name as state_name,c.code as state_code,d.name as commissionaires_name ,d.code as commissionaires_code,e.name as district_name,e.code as district_code,f.name as tehsil_name,f.code as tehsil_code,g.name as admin_name,g.mobile,h.name as role_name");
		$this->db->from('admin_locality_access a');
		$this->db->join('countries b','b.id=a.country_id','left');
		$this->db->join('states c','c.id=a.state_id','left');
		$this->db->join('commissionaires d','d.id=a.commissionaires_id','left');
		$this->db->join('district e','e.id=a.district_id','left');
		$this->db->join('tehsil-zone f','f.id=a.tehsil_id','left');
		$this->db->join('tb_admin g','g.id=a.admin_id','left');
		$this->db->join('tb_user_role h','h.id=g.user_role','left');
		$this->db->where('a.admin_id',$id);
		return $this->db->get()->result();
	}
    public function get_all_locations($id) {
		$this->db->select("a.*,,b.name as country_name,b.code as country_code,c.name as state_name,c.code as state_code,d.name as commissionaires_name ,d.code as commissionaires_code,e.name as district_name,e.code as district_code,f.name as tehsil_name,f.code as tehsil_code,g.name as admin_name,g.mobile,h.name as role_name");
		$this->db->from('admin_locality_access a');
		$this->db->join('countries b','b.id=a.country_id','left');
		$this->db->join('states c','c.id=a.state_id','left');
		$this->db->join('commissionaires d','d.id=a.commissionaires_id','left');
		$this->db->join('district e','e.id=a.district_id','left');
		$this->db->join('tehsil-zone f','f.id=a.tehsil_id','left');
		$this->db->join('tb_admin g','g.id=a.admin_id','left');
		$this->db->join('tb_user_role h','h.id=g.user_role','left');
		$this->db->where('a.admin_id',$id);
		return $this->db->get()->result();
    }
	public function delete_location($id) {
        $this->db->where('id', $id);
        if($this->db->delete('admin_locality_access'))
		{
			return true;
		}else{
			return false;
		}
    }
	public function get_location($id) {
		$this->db->select("a.*,,b.name as country_name,b.code as country_code,c.name as state_name,c.code as state_code,d.name as commissionaires_name ,d.code as commissionaires_code,e.name as district_name,e.code as district_code,f.name as tehsil_name,f.code as tehsil_code,g.name as admin_name,g.mobile,h.name as role_name");
		$this->db->from('admin_locality_access a');
		$this->db->join('countries b','b.id=a.country_id','left');
		$this->db->join('states c','c.id=a.state_id','left');
		$this->db->join('commissionaires d','d.id=a.commissionaires_id','left');
		$this->db->join('district e','e.id=a.district_id','left');
		$this->db->join('tehsil-zone f','f.id=a.tehsil_id','left');
		$this->db->join('tb_admin g','g.id=a.admin_id','left');
		$this->db->join('tb_user_role h','h.id=g.user_role','left');
		$this->db->where('a.id',$id);
        return $this->db->get()->row();
    }

}
