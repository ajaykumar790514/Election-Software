<?php
/**
 * 
 */
class Operations_model extends CI_Model
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
		
public function family_blocks($user,$limit = null, $start = null)
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
    // Select required columns and concatenate enrollment IDs
    $this->db->select("a.*,a.id as group_id, GROUP_CONCAT(b.id) as enrollment_ids, COUNT(DISTINCT b.id) as total_enrollment,c.active");
    $this->db->from('family_groups a');
    $this->db->join('members-enrollment b', 'b.group_id = a.id', 'left');
	$this->db->join('elections-status c', 'c.group_id = a.id', 'left');
    $this->db->where(['b.is_deleted' => 'NOT_DELETED', 'b.active' => '1']);
	$this->db->where(['c.is_deleted'=>'NOT_DELETED','c.active'=>'1']);
    // Apply filters if provided
    if (@$_POST['name']) {
        $this->db->group_start();
        $this->db->like('a.pincode', @$_POST['name']);
        $this->db->or_like('b.pincode', @$_POST['name']);
        $this->db->group_end();
    }
    if (@$_POST['state']) {
        $state_parts = explode(',', $_POST['state']);
        $this->db->where('b.state_id', $state_parts[0]);
    }
    if (@$_POST['commissionaires']) {
        $commissionaires_parts = explode(',', $_POST['commissionaires']);
        $this->db->where('b.commissionaires_id', $commissionaires_parts[0]);
    }
    if (@$_POST['district']) {
        $district_parts = explode(',', $_POST['district']);
        $this->db->where('b.district_id', $district_parts[0]);
    }
    if (@$_POST['ward']) {
        $ward_parts = explode(',', $_POST['ward']);
        $this->db->where('b.ward_block_id', $ward_parts[0]);
    }
    if (@$_POST['block']) {
        $block_parts = explode(',', $_POST['block']);
        $this->db->where('b.block_nyay_id', $block_parts[0]);
    }
    if (@$_POST['panchayat']) {
        $panchayat_parts = explode(',', $_POST['panchayat']);
        $this->db->where('b.panchayat_id', $panchayat_parts[0]);
    }

    // Group by family group columns
    $this->db->group_by('b.group_id');
	// Apply user-accessible filters
    if (!empty($accessible_states)) {
        $this->db->where_in('b.state_id', $accessible_states);
    }
    if (!empty($accessible_commissionaires)) {
        $this->db->where_in('b.commissionaires_id', $accessible_commissionaires);
    }
    if (!empty($accessible_districts)) {
        $this->db->where_in('b.district_id', $accessible_districts);
    }
    if (!empty($accessible_tehsils)) {
        $this->db->where_in('b.tehsil_id', $accessible_tehsils);
    }
    // Apply limit and offset for pagination
    if ($limit != null) {
        $this->db->limit($limit, $start);
    }

    // Execute query to fetch all rows
    $result = $this->db->get()->result();

    return $result;
}

	
	
	

	public function getNewPincodeEnroll($pincode,$groups)
	{
		$this->db->select('*');
		$this->db->from('members-enrollment a');
		$this->db->join('family_groups b', 'LEFT(a.pincode, 13) = b.pincode');
		$this->db->where('a.active', '1');	
		$this->db->where('a.is_deleted', 'NOT_DELETED');
		$this->db->where('b.groups', $groups);
		// $this->db->where("LEFT(a.pincode, 14) = '$pincode'", NULL, FALSE);
		$query = $this->db->get();
		$checkEnroll = $query->result_array();
		return $checkEnroll;  
	}

	public function family_details($group_id, $limit=null, $start=null)
	{
		$this->db->select('*');
		$this->db->from('members-enrollment');
		$this->db->where('active', '1');
		$this->db->where('is_deleted', 'NOT_DELETED');
		$this->db->where('group_id',$group_id);
		
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('pincode', @$_POST['name']);
			$this->db->group_end();
		}
		if ($limit != null) {
			$this->db->limit($limit, $start);
		}
		return $this->db->get()->result();
	}
	

	
	public function members_level($user,$limit=null,$start=null)
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
		$this->db->select("a.*,b.*,c.level,d.pincode");
        $this->db->from('members_level a');
        $this->db->join('members-details b','b.id=a.member_id','left');
		$this->db->join('level_master c','c.id=a.level_id','left');
		$this->db->join('members-enrollment d','d.id=b.member_enrollment_id','left');
        $this->db->where(['b.active'=>'1','d.is_deleted'=>'NOT_DELETED','d.active'=>'1']);
		if (@$_POST['name']) {
            $this->db->group_start();
			$this->db->like('b.fname',@$_POST['name']);
			$this->db->or_like('b.mobile',@$_POST['name']);
			$this->db->or_like('b.email',@$_POST['name']);
			$this->db->or_like('b.aadhaar_no',@$_POST['name']);
			$this->db->or_like('c.level',@$_POST['name']);
            $this->db->group_end();
		}
		if (@$_POST['state']) {
			$state_parts=explode(',', $_POST['state']);
			$this->db->where('d.state_id',$state_parts[0]);
		}
		if (@$_POST['commissionaires']) {
			$commissionaires_parts=explode(',', $_POST['commissionaires']);
			$this->db->where('d.commissionaires_id',$commissionaires_parts[0]);
		}
		if (@$_POST['district']) {
			$district_parts=explode(',', $_POST['district']);
			$this->db->where('d.district_id',$district_parts[0]);
		}
		if (@$_POST['ward']) {
			$ward_parts=explode(',', $_POST['ward']);
			$this->db->where('d.ward_block_id',$ward_parts[0]);
		}
		if (@$_POST['block']) {
			$block_parts=explode(',', $_POST['block']);
			$this->db->where('d.block_nyay_id',$block_parts[0]);
		}
		if (@$_POST['panchayat']) {
			$panchayat_parts=explode(',', $_POST['panchayat']);
			$this->db->where('d.panchayat_id',$panchayat_parts[0]);
		}
		if (@$_POST['level']) {
			$level = $_POST['level'];
			$this->db->where('c.id', $level);
		}
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		// Apply user-accessible filters
		if (!empty($accessible_states)) {
			$this->db->where_in('d.state_id', $accessible_states);
		}
		if (!empty($accessible_commissionaires)) {
			$this->db->where_in('d.commissionaires_id', $accessible_commissionaires);
		}
		if (!empty($accessible_districts)) {
			$this->db->where_in('d.district_id', $accessible_districts);
		}
		if (!empty($accessible_tehsils)) {
			$this->db->where_in('d.tehsil_id', $accessible_tehsils);
		}
		return $this->db->get()->result();
	}


	public function winner_candidates($user,$limit = null, $start = null)
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
		$this->db->select("a.*, b.*, e.level, d.pincode,f.groups,d.group_id");
		$this->db->from('members_position a');
		$this->db->join('members-details b', 'b.id = a.member_id', 'left');
		$this->db->join('members-enrollment c', 'c.id = b.member_enrollment_id', 'left');
		$this->db->join('elections-status d', 'd.id=a.election_id', 'left');
		$this->db->join('level_master e', 'e.id = d.level_id', 'left');
		$this->db->join('family_groups f', 'c.group_id=f.id', 'left');
		$this->db->order_by('e.level','DESC');
		$this->db->where(['b.active' => '1', 'c.is_deleted' => 'NOT_DELETED', 'c.active' => '1']);
	
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('b.fname', @$_POST['name']);
			$this->db->or_like('b.mobile', @$_POST['name']);
			$this->db->or_like('b.email', @$_POST['name']);
			$this->db->or_like('b.aadhaar_no', @$_POST['name']);
			$this->db->or_like('e.level', @$_POST['name']);
			$this->db->group_end();
		}
	
		if (@$_POST['state']) {
			$state_parts = explode(',', $_POST['state']);
			$this->db->where('c.state_id', $state_parts[0]);
		}
		if (@$_POST['commissionaires']) {
			$commissionaires_parts = explode(',', $_POST['commissionaires']);
			$this->db->where('c.commissionaires_id', $commissionaires_parts[0]);
		}
		if (@$_POST['district']) {
			$district_parts = explode(',', $_POST['district']);
			$this->db->where('c.district_id', $district_parts[0]);
		}
		if (@$_POST['ward']) {
			$ward_parts = explode(',', $_POST['ward']);
			$this->db->where('c.ward_block_id', $ward_parts[0]);
		}
		if (@$_POST['block']) {
			$block_parts = explode(',', $_POST['block']);
			$this->db->where('c.block_nyay_id', $block_parts[0]);
		}
		if (@$_POST['panchayat']) {
			$panchayat_parts = explode(',', $_POST['panchayat']);
			$this->db->where('c.panchayat_id', $panchayat_parts[0]);
		}
		if (@$_POST['level']) {
			$level = $_POST['level'];
			$this->db->where('d.level_id', $level);
		}
	
		if ($limit != null) {
			$this->db->limit($limit, $start);
		}
		// Apply user-accessible filters
		if (!empty($accessible_states)) {
			$this->db->where_in('c.state_id', $accessible_states);
		}
		if (!empty($accessible_commissionaires)) {
			$this->db->where_in('c.commissionaires_id', $accessible_commissionaires);
		}
		if (!empty($accessible_districts)) {
			$this->db->where_in('c.district_id', $accessible_districts);
		}
		if (!empty($accessible_tehsils)) {
			$this->db->where_in('c.tehsil_id', $accessible_tehsils);
		}
		$this->db->group_by('a.id');
	
		return $this->db->get()->result();
	}

	
	
	public function elections_status($user,$limit=null,$start=null)
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
		$this->db->select("a.*,b.groups,a.pincode,b.id as group_id,c.level");
        $this->db->from('elections-status a');
		$this->db->join('family_groups b','b.id=a.group_id','left');
		$this->db->join('level_master c','c.id=a.level_id','left');
		if (@$_POST['name']) {
            $this->db->group_start();
			$this->db->like('b.groups',@$_POST['name']);
			$this->db->or_like('b.pincode',@$_POST['name']);
            $this->db->group_end();
		}
		if (@$_POST['date']) {
			$this->db->where('a.election_date',$_POST['date']);
		}
		if (@$_POST['group_id']) {
			$this->db->where('a.group_id',$_POST['group_id']);
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
       
		return $this->db->get()->result();
	}

	
	public function CountVote($election_id, $enrollment_id)
	{
		$subquery = $this->db->select("a.vote_for, SUM(a.vote_rank) as total_votes")
							 ->from('members-voting a')
							 ->where('a.election_id', $election_id)
							 ->where('a.enrollment_id', $enrollment_id)
							 ->group_by('a.vote_for')
							 ->order_by('total_votes', 'DESC')
							 ->limit(1)
							 ->get_compiled_select();
	
		$this->db->select("b.id as member_id,b.enrollment_no, b.fname, b.mname, b.lname, b.father_name, b.email, b.mobile, b.aadhaar_no, subquery.total_votes, subquery.vote_for");
		$this->db->from("($subquery) as subquery");
		$this->db->join('members-details b', 'b.id = subquery.vote_for', 'left');
	
		return $this->db->get()->result();
	}
	public function CountBlockVote($election_id, $group_id)
	{
		$subquery = $this->db->select("a.vote_for, SUM(a.vote_rank) as total_votes")
							 ->from('members-voting a')
							 ->where('a.election_id', $election_id)
							//  ->where('a.enrollment_id', $enrollment_id)
							 ->group_by('a.vote_for')
							 ->order_by('total_votes', 'DESC')
							 ->limit(1)
							 ->get_compiled_select();
	
		$this->db->select("b.id as member_id,b.enrollment_no, b.fname, b.mname, b.lname, b.father_name, b.email, b.mobile, b.aadhaar_no, subquery.total_votes, subquery.vote_for");
		$this->db->from("($subquery) as subquery");
		$this->db->join('members-details b', 'b.id = subquery.vote_for', 'left');
	
		return $this->db->get()->result();
	}

	public function CountBlockVoteNew($election_id, $group_id)
	{
		// echo $group_id;die();
		// Subquery to get the total votes per member in the specified group and election
		$subquery = $this->db->select("a.vote_for, SUM(a.vote_rank) as total_votes")
							 ->from('members-voting a')
							 ->join('election_groups_members t1', 't1.member_id = a.vote_for', 'left')
							 ->where('a.election_id', $election_id)
							 ->where('t1.election_groups_id', $group_id)
							 ->group_by('a.vote_for')
							 ->order_by('total_votes', 'DESC')
							 ->limit(1)
							 ->get_compiled_select();
	
		// Main query to get the member details and total votes
		$this->db->select("b.id as member_id, b.enrollment_no, b.fname, b.mname, b.lname, b.father_name, b.email, b.mobile, b.aadhaar_no, subquery.total_votes, subquery.vote_for");
		$this->db->from("($subquery) as subquery");
		$this->db->join('members-details b', 'b.id = subquery.vote_for', 'left');
	
		return $this->db->get()->result();
	}
	
	public function memberVote($member_id, $election_id)
{
    $this->db->select("SUM(a.vote_rank) as total_votes");
    $this->db->from('members-voting a');
    $this->db->where('a.election_id', $election_id);
    $this->db->where('a.vote_for', $member_id);
    $query = $this->db->get();
    return $query->row()->total_votes;
}

	public function getDataEnrollment($id)
	{
		$this->db->select("b.*");
        $this->db->from('members-voting a');
		$this->db->join('members-enrollment b','b.id=a.enrollment_id','left');
		$this->db->where('a.election_id',$id);
		$this->db->group_by('a.enrollment_id');
		return $this->db->get()->result();
	}
	public function getMembers($pincode, $id)
	{
		$this->db->select("a.*");
		$this->db->from('members_position a');
		$this->db->join('members-details b', 'b.id = a.member_id', 'left');
		$this->db->join('members_level c', 'c.member_id = b.id', 'left');
		$this->db->join('members-enrollment d', 'd.id = b.member_enrollment_id', 'left');
		$this->db->join(
			'(SELECT member_id, MAX(updated) as max_updated FROM members_position GROUP BY member_id) as subquery', 
			'a.member_id = subquery.member_id AND a.updated = subquery.max_updated', 
			'inner'
		);
		$this->db->where('c.level_id', $id);
		$this->db->where('LEFT(d.pincode, 13) =', $pincode);
		return $this->db->get()->result();
	}

	public function getMembersScheduleElection($pincode, $id)
	{
		  // Remove trailing zeros from the right side of the pincode
		  $trimmedPincode = rtrim($pincode, '0');
		  // Get the length of the trimmed pincode
		  $length = strlen($trimmedPincode);
		$this->db->select("a.*");
		$this->db->from('members_position a');
		$this->db->join('members-details b', 'b.id = a.member_id', 'left');
		$this->db->join('members_level c', 'c.member_id = b.id', 'left');
		$this->db->join('members-enrollment d', 'd.id = b.member_enrollment_id', 'left');
		$this->db->join(
			'(SELECT member_id, MAX(updated) as max_updated FROM members_position GROUP BY member_id) as subquery', 
			'a.member_id = subquery.member_id AND a.updated = subquery.max_updated', 
			'inner'
		);
		$this->db->where('c.level_id', $id);
		$this->db->where('LEFT(d.pincode, ' . $length . ') =', $trimmedPincode);
		// $this->db->where('LEFT(d.pincode, 13) =', $pincode);
		return $this->db->get()->result();
	}
	
	
	// $this->db->join('family_groups b', 'LEFT(a.pincode, 13) = b.pincode');
	// public function getMembers($pincode,$id)
	// {
	// 	$this->db->select("b.*");
	// 	$this->db->from('members_position b');
	// 	$this->db->join('(SELECT member_id, MAX(updated) as max_updated FROM members_position GROUP BY member_id) as subquery', 'b.member_id = subquery.member_id AND b.updated = subquery.max_updated', 'inner');
	// 	$this->db->join('members_level a', 'b.member_id = a.member_id', 'left');
	// 	$this->db->where('a.level_id', $id);
	// 	return $this->db->get()->result();
	// }
	
	public function getAllMembersByPincode($election_id, $pincode) {
		$this->db->select('b.id as member_id, b.enrollment_no, b.fname, b.mname, b.lname, b.father_name, b.mobile, b.email, b.aadhaar_no');
		$this->db->from('members-enrollment a');
		$this->db->join('members-details b', 'b.member_enrollment_id = a.id', 'left');
		$this->db->join('elections-status c', 'c.pincode = LEFT(a.pincode, 13)', 'left');
		$this->db->where('c.id', $election_id);
		$this->db->where('a.pincode', $pincode);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAllMembersByBlock($election_id, $block_id) {
		$this->db->select('b.id as member_id, b.enrollment_no, b.fname, b.mname, b.lname, b.father_name, b.mobile, b.email, b.aadhaar_no');
		$this->db->from('members-enrollment a');
		$this->db->join('members-details b', 'b.member_enrollment_id = a.id', 'left');
		$this->db->join('elections-status c', 'IFNULL(c.group_id, 0) = 0 AND c.pincode = LEFT(a.pincode, 13) OR c.group_id = a.group_id', 'left');
		// $this->db->join('members-voting d', 'd.vote_for = b.id', 'inner'); 
		$this->db->where('c.id', $election_id);
		$this->db->where('a.group_id', $block_id);
		// $this->db->where('d.election_id', $election_id); 
		
		// Additional subquery to check existence in members_position
		$this->db->where('EXISTS (
			SELECT 1 
			FROM members_position mp 
			WHERE mp.member_id = b.id 
			AND mp.block_id = a.group_id
		)');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	public function getAllMembersByGroup($election_id, $group_id)
	{
		$this->db->select("b.id as member_id, b.enrollment_no, b.fname, b.mname, b.lname, b.father_name, b.email, b.mobile, b.aadhaar_no");
		$this->db->from('election_groups_members egm');
		$this->db->join('members-details b', 'b.id = egm.member_id', 'left');
		$this->db->join('members-voting mv', 'mv.vote_for = b.id', 'inner'); 
		$this->db->where('egm.election_groups_id', $group_id);
		$this->db->where('mv.election_id', $election_id); 
		return $this->db->get()->result();
	}
	

	public function check_election_date_exists($check_id,$pincode, $election_date,$level) {
		$this->db->where('pincode', $pincode);
		$this->db->where('election_date', $election_date);
		$this->db->where('level_id', $level);
		$this->db->where(['is_deleted'=>'NOT_DELETED','active'=>'1']);
		if(!empty($check_id)){
			$this->db->where('id !=', $check_id);
		}
		$query = $this->db->get('elections-status');
	
		return $query->num_rows() > 0;
	}
	

	
	public function AssignMemberPosition($member_id, $election_id, $group_id)
	{
		
		if (!$this->operations_model->checkMemberPositionExists($member_id, $election_id, $group_id)) {
			
			$this->store_member_position($member_id, $election_id, $group_id);
			
		}
		
		$this->db->select("a.*");
		$this->db->from('members_position a');
		if(!empty($group_id) && $group_id !=0){
		$this->db->where('a.block_id', $group_id);
	    }
		$this->db->where('a.member_id', $member_id);
		$this->db->where('a.election_id', $election_id);
		return $this->db->get()->row();
	}
	

	public function store_member_position($member_id, $election_id, $group_id)
	{
		
		if ($member_id && $election_id) {
			// Prepare data to insert
			
			$data = array(
				'member_id' => $member_id,
				'election_id' => $election_id,
				'block_id' => $group_id,
			);
			
			$self_level = $this->operations_model->checkMemberLevel($member_id);
			$level_master = $this->operations_model->checkLevelTitle($self_level + 1);
			
			if (!$this->operations_model->checkMemberPositionExists($member_id, $election_id, $group_id)) {
				
				$this->operations_model->insertMemberPosition($data);
				if ($level_master) {
					$this->operations_model->Update('members_level', ['active'=>'1','level_id' => $level_master->id], ['member_id' => $member_id]);
					$this->operations_model->Update('elections-status', ['active'=>'0'], ['id' => $election_id]);
				}
			}
		}
	}
	
	public function checkMemberLevel($member_id)
	{
		$this->db->select("b.level");
		$this->db->from('members_level a');
		$this->db->join('level_master b', 'b.id = a.level_id', 'left');
		$this->db->where('a.member_id', $member_id); 
		$level = $this->db->get()->row();
		return $level ? $level->level : null;
	}
	
	public function checkLevelTitle($level)
	{
		$this->db->select("a.id");
		$this->db->from('level_master a');
		$this->db->where('a.level', $level);
		$level_master = $this->db->get()->row();
		return $level_master;
	}
	
	
	public function getRowElections($id)
	{
		$this->db->select("a.*,b.groups,c.name as state_name,d.name as commissionaires_name,e.name as district_name,f.name as tehsil_name,g.name as ward_block_name,h.name as block_nyay_name,i.name as panchayat_name");
        $this->db->from('elections-status a');
		$this->db->join('family_groups b','b.id=a.group_id','left');
		$this->db->join('states c','c.id=a.state_id','left');
		$this->db->join('commissionaires d','d.id=a.commissionaires_id','left');
		$this->db->join('district e','e.id=a.district_id','left');
		$this->db->join('tehsil-zone f','f.id=a.tehsil_id','left');
		$this->db->join('ward-block g','g.id=a.ward_block_id','left');
		$this->db->join('block-nyay h','h.id=a.block_nyay_id','left');
		$this->db->join('panchayat-village i','i.id=a.panchayat_id','left');
		$this->db->where('a.id',$id);
		$this->db->where(['a.is_deleted'=>'NOT_DELETED','a.active'=>'1']);
		return $this->db->get()->row();
	}
	
	public function fetch_group($pincode)
	{
		$data = $this->db->get_where('family_groups',['pincode'=>$pincode])->result();
		echo "<option value=''>Select Blocks</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id  . "'> Block " . $val->groups . "</option>";
		}
	}
public function insertMemberPosition($data)
{
    $this->db->insert('members_position', $data);
	return $this->db->insert_id();
}
public function checkMemberPositionExists($member_id, $election_id, $group_id)
{
    $this->db->where('member_id', $member_id);
    $this->db->where('election_id', $election_id);
	if(!empty($group_id) && $group_id !=0){
    $this->db->where('block_id', $group_id);
	}
    $query = $this->db->get('members_position');

    return $query->num_rows() > 0;
}
public function checkAlreadyPosition($election_id, $group_id)
{
    $this->db->where('election_id', $election_id);
	if(!empty($group_id) && $group_id !=0){
    $this->db->where('block_id', $group_id);
	}
    $query = $this->db->get('members_position');

    return $query->row();
}


public function PincodeMember($pincode)
{
	$this->db->select("b.*");
	$this->db->from('members-enrollment a');
	$this->db->join('members-details b','b.member_enrollment_id=a.id','left');
	$this->db->where('LEFT(a.pincode, 13) = ',$pincode);
	return $this->db->get()->result();
}




    

}