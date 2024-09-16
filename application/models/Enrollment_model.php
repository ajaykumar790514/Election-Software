<?php
/**
 * 
 */
class Enrollment_model extends CI_Model
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





	public function admin_mobile_exist($mobile)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('clinics mtb')
		->where(['mtb.contact'=>$mobile]);
	
		return $this->db->get()->num_rows();
		
	}

	public function admin_otp_exist($otp)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('tb_admin_otp mtb')
		->where(['mtb.otp'=>$otp]);
	
		return $this->db->get()->num_rows();
		
	}
	function adminupdateRow($mobile,$data ){
		if($this->db->insert('tb_admin_otp',$data)){
			return $this->db->insert_id();
		}
		return false; 
	}
	public function admin_update_password($mobile,$data)
	{
		return $this->db->where('contact', $mobile)->update('clinics', $data);
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
	function getDataNew($tb, $data = 0, $order = null, $order_by = null, $limit = null, $start = null) {
		if ($order != null) {
			if ($order_by != null) {
				$this->db->order_by($order_by, $order);
			} else {
				$this->db->order_by('id', $order);
			}
		}
	
		if ($limit != null) {
			$this->db->limit($limit, $start);
		}
	
		if ($data == 0 || $data == null) {
			return $this->db->get($tb)->result();
		}
	
		// Process search parameter if present
		if (isset($data['search'])) {
			$search = $data['search'];
			unset($data['search']);
		}
	
		// Handle array conditions separately
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$this->db->where_in($key, $value);
			} else {
				$this->db->where($key, $value);
			}
		}
	
		return $this->db->get($tb)->result();
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

	

	public function delete_member($id)
	{
			$this->db->where('id ',$id);
			if($this->db->delete('members-details')){
				return true;
			}
		return false;
	}
	public function fetch_commissionaires($state)
	{
		$data = $this->db->get_where('commissionaires',['state_id'=>$state, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->result();
		echo "<option value=''>Select Commissionaires</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "," . $val->code . "'>" . $val->name . "</option>";
		}
	}
    public function fetch_district($commissionaires)
	{
		$data = $this->db->get_where('district',['commissionaires_id'=>$commissionaires, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->result();
		echo "<option value=''>Select District</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "," . $val->code . "'>" . $val->name . "</option>";
		}
	}
    public function fetch_tehsil($district)
	{
		$data = $this->db->order_by('seq','ASC')->get_where('tehsil-zone',['district_id'=>$district, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->result();
		echo "<option value=''>Select Tehsil Zone</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "," . $val->code . "'>" . $val->name . "</option>";
		}
	}

    public function fetch_ward($tehsil)
	{
		$data = $this->db->order_by('seq','ASC')->get_where('ward-block',['tehsil_id'=>$tehsil, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->result();
		echo "<option value=''>Select Ward Block</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "," . $val->code . "'>" . $val->name . "</option>";
		}
	
    }

    public function fetch_block($ward)
	{
		$data = $this->db->order_by('seq','ASC')->get_where('block-nyay',['ward_block_id'=>$ward, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->result();
		echo "<option value=''>Select Block Nyay</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "," . $val->code . "'>" . $val->name . "</option>";
		}
	
    }


    public function fetch_panchayat($block)
	{
		$data = $this->db->order_by('seq','ASC')->get_where('panchayat-village',['block_nyay_id'=>$block, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->result();
		echo "<option value=''>Select Panchayat</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "," . $val->code . "'>" . $val->name . "</option>";
		}
	
    }
    public function fetch_village($id)
	{
		$data = $this->db->order_by('seq','ASC')->get_where('panchayat-village',['id'=>$id, 'is_deleted' => 'NOT_DELETED','active'=>'1'])->row();
		echo $data->village;
	
    }

	
	public function members_enrollment($user,$limit=null,$start=null)
	{
		 // Retrieve accessible states and other filters based on the user's role
		 $accessible_states = [];
		 $accessible_commissionaires = [];
		 $accessible_districts = [];
		 $accessible_tehsils = [];
		 
		 if ($user->user_role > 1) {
			 $admin_id = $user->id;
			 $accessible_states = $this->enrollment_model->getAccessibleStates($admin_id);
			 $accessible_commissionaires = $this->enrollment_model->getAccessibleCommissionaires($admin_id);
			 $accessible_districts = $this->enrollment_model->getAccessibleDistricts($admin_id);
			 $accessible_tehsils = $this->enrollment_model->getAccessibleTehsils($admin_id);
		 }
		$this->db->select("a.*,b.name as country_name,b.code as country_code,c.name as state_name,c.code as state_code,d.name as commissionaires_name ,d.code as commissionaires_code,e.name as district_name,e.code as district_code");
		$this->db->from('members-enrollment a');
		$this->db->join('countries b','b.id=a.country_id','left');
		$this->db->join('states c','c.id=a.state_id','left');
		$this->db->join('commissionaires d','d.id=a.commissionaires_id','left');
		$this->db->join('district e','e.id=a.district_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->like('a.pincode',$_POST['name']);
		}
		if (@$_POST['state']) {
			$state_parts=explode(',', $_POST['state']);
			$this->db->where('a.state_id',$state_parts[0]);
		}
		if (@$_POST['commissionaires']) {
			$commissionaires_parts=explode(',', $_POST['commissionaires']);
			$this->db->where('a.commissionaires_id',$commissionaires_parts[0]);
		}
		if (@$_POST['district']) {
			$district_parts=explode(',', $_POST['district']);
			$this->db->where('a.district_id',$district_parts[0]);
		}
		if (@$_POST['tehsil']) {
			$tehsil_id=explode(',', $_POST['tehsil_id']);
			$this->db->where('a.tehsil_id',$tehsil_id[0]);
		}
		if (@$_POST['ward']) {
			$ward_parts=explode(',', $_POST['ward']);
			$this->db->where('a.ward_block_id',$ward_parts[0]);
		}
		if (@$_POST['block']) {
			$block_parts=explode(',', $_POST['block']);
			$this->db->where('a.block_nyay_id',$block_parts[0]);
		}
		if (@$_POST['panchayat']) {
			$panchayat_parts=explode(',', $_POST['panchayat']);
			$this->db->where('a.panchayat_id',$panchayat_parts[0]);
		}
		
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		// Apply user-accessible filters
		if (!empty($accessible_states)) {
			$this->db->where_in('a.state_id', $accessible_states);
		}
		if (!empty($accessible_commissionaires)) {
			$this->db->where_in('a.commissionaires_id', $accessible_commissionaires);
		}
		if (!empty($accessible_districts)) {
			$this->db->where_in('a.district_id', $accessible_districts);
		}
		if (!empty($accessible_tehsils)) {
			$this->db->where_in('a.tehsil_id', $accessible_tehsils);
		}
		$this->db->order_by('a.added','DESC');
		return $this->db->get()->result();
	}


public function getAccessibleStates($admin_id)
{
    $this->db->select('state_id');
    $this->db->from('admin_locality_access');
    $this->db->where('admin_id', $admin_id);
    $this->db->where('state_id !=', null);
    $query = $this->db->get();
    $result = $query->result_array();
    return array_column($result, 'state_id');
}
// Additional methods to get accessible commissionaires, districts, and tehsils
public function getAccessibleCommissionaires($admin_id)
{
    $this->db->select('commissionaires_id');
    $this->db->from('admin_locality_access');
    $this->db->where('admin_id', $admin_id);
    $this->db->where('commissionaires_id !=', null);
    $query = $this->db->get();
    $result = $query->result_array();
    return array_column($result, 'commissionaires_id');
}

public function getAccessibleDistricts($admin_id)
{
    $this->db->select('district_id');
    $this->db->from('admin_locality_access');
    $this->db->where('admin_id', $admin_id);
    $this->db->where('district_id !=', null);
    $query = $this->db->get();
    $result = $query->result_array();
    return array_column($result, 'district_id');
}

public function getAccessibleTehsils($admin_id)
{
    $this->db->select('tehsil_id');
    $this->db->from('admin_locality_access');
    $this->db->where('admin_id', $admin_id);
    $this->db->where('tehsil_id !=', null);
    $query = $this->db->get();
    $result = $query->result_array();
    return array_column($result, 'tehsil_id');
}
	
	public function getEnrollmentRow($id)
	{
		$this->db->select("a.*,b.name as country_name,b.code as country_code,c.name as state_name,c.code as state_code,d.name as commissionaires_name ,d.code as commissionaires_code,e.name as district_name,e.code as district_code,f.name as tehsil_name,f.code as tehsil_code,g.name as ward_block_name,g.code as ward_block_code,h.name as block_nyay_name,h.code as block_nyay_code,i.name as panchayat_name,i.code as panchayat_code,i.village as panchayat_village");
		$this->db->from('members-enrollment a');
		$this->db->join('countries b','b.id=a.country_id','left');
		$this->db->join('states c','c.id=a.state_id','left');
		$this->db->join('commissionaires d','d.id=a.commissionaires_id','left');
		$this->db->join('district e','e.id=a.district_id','left');
		$this->db->join('tehsil-zone f','f.id=a.tehsil_id','left');
		$this->db->join('ward-block g','g.id=a.ward_block_id','left');
		$this->db->join('block-nyay h','h.id=a.block_nyay_id','left');
		$this->db->join('panchayat-village i','i.id=a.panchayat_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		$this->db->where('a.id',$id);
		return $this->db->get()->row();
	}

	public function checkMember($id) {

		$this->db->where(['id'=>$id]);
	
		$query = $this->db->get('members-details');
	
		if ($query->num_rows() > 0) {
	
			return true;
	
		} else {
	
			return false;
	
		}
	
	}
	public function getLastEntry($table, $conditions) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($conditions);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    

}