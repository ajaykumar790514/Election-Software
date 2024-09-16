<?php
/**
 * 
 */
class Voting_model extends CI_Model
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
	public function VotingPincode($id)
    {
        $this->db->select('b.pincode');
		$this->db->from('members-details a');
		$this->db->join('members-enrollment b','b.id=a.member_enrollment_id','left');
		$this->db->where('a.id', $id);
		$query = $this->db->get();
		$userRow =  $query->row()->pincode;
		return $userRow;
    }

    public function Voting($id)
    {
        $this->db->select('*');
		$this->db->from('members-details a');
		$this->db->where('a.id', $id);
		$query = $this->db->get();
		$userRow =  $query->row();

        $this->db->select('a.*,c.level');
		$this->db->from('members-details a');
        $this->db->join('members_level b','b.member_id=a.id','left');
        $this->db->join('level_master c','c.id=b.level_id','left');
        $this->db->where('a.id !=', $id);
		$this->db->where('a.member_enrollment_id', $userRow->member_enrollment_id);
		$query = $this->db->get();
		$checkEnroll = $query->result();
		return $checkEnroll;
    }
	public function VotingMember($id)
    {
        $this->db->select('*,c.level');
		$this->db->from('members-details a');
		$this->db->join('members_level b','b.member_id=a.id','left');
		$this->db->join('level_master c','c.id=b.level_id','left');
		$this->db->where('a.id', $id);
		$query = $this->db->get();
		$userRow =  $query->row();
		return $userRow;
    }
	public function FindMember($user_id,$group_id,$election_id,$pincode)
    {
        $this->db->select('b.*,d.level');
		$this->db->from('members_position a');
        $this->db->join('members-details b','b.id=a.member_id','left');
		$this->db->join('members-enrollment mem','mem.id=b.member_enrollment_id','left');
		$this->db->join('members_level c','c.member_id=b.id','left');
        $this->db->join('level_master d','d.id=c.level_id','left');
		if($group_id!=0 && !empty($group_id)){
		$this->db->where('a.block_id', $group_id);
		}else{
			$this->db->where('LEFT(mem.pincode, 13) =', $pincode);
		}
		$this->db->where('b.id !=', $user_id);
		$query = $this->db->get();
		$checkEnroll = $query->result();
		// echo $this->db->last_query();die();
		return $checkEnroll;
    }
	public function FindMemberNew($user_id,$election_id,$pincode,$group_id)
    {
		// Remove trailing zeros from the right side of the pincode
		 $trimmedPincode = rtrim($pincode, '0');
		 // Get the length of the trimmed pincode
		 $length = strlen($trimmedPincode);
        $this->db->select('c.*,e.level');
		$this->db->from('election_groups a');
		$this->db->join('election_groups_members b','b.election_groups_id=a.id','left');
        $this->db->join('members-details c','c.id=b.member_id','left');
		$this->db->join('members_level d','d.member_id=c.id','left');
        $this->db->join('level_master e','e.id=d.level_id','left');
		$this->db->join('members-enrollment f','f.id=c.member_enrollment_id','left');
		// $this->db->where('LEFT(f.pincode, 13) =', $pincode);
		$this->db->where('LEFT(f.pincode, ' . $length . ') =', $trimmedPincode);
		$this->db->where('a.election_id', $election_id);
		$this->db->where('c.id !=', $user_id);
		$query = $this->db->get();
		$checkEnroll = $query->result();
		return $checkEnroll;
    }

	
	public function Votingenrollments($id)
    {
        $this->db->select('*');
		$this->db->from('members-details a');
		$this->db->where('a.id', $id);
		$query = $this->db->get();
		$userRow =  $query->row()->member_enrollment_id;
		return $userRow;
    }
	
	public function checkActive($id)
	{
		$this->db->select('b.*, c.level');
		$this->db->from('members-enrollment a');
		$this->db->join('elections-status b', 'IFNULL(b.group_id, 0) = 0 AND b.pincode = LEFT(a.pincode, 13) OR b.group_id = a.group_id', 'left');
		$this->db->join('level_master c', 'c.id = b.level_id', 'left');
		$this->db->where('a.id', $id);
		$this->db->where(['b.is_deleted' => 'NOT_DELETED', 'b.active' => '1']);
		$query = $this->db->get();
		$checkEnroll = $query->row();
		// echo $this->db->last_query();die();
		return $checkEnroll;
	}
	
	public function checkActiveElection($id)
    {
        $this->db->select('a.*,c.level');
		$this->db->from('elections-status a');
        $this->db->join('members-enrollment b','a.pincode = LEFT(b.pincode, 13)','left');
		$this->db->join('level_master c','c.id=a.level_id','left');
		$this->db->where('a.id', $id);
		$this->db->where(['a.is_deleted'=>'NOT_DELETED','a.active'=>'1']);
		$query = $this->db->get();
		$checkEnroll = $query->row();
		return $checkEnroll;
    }
	
	// public function CheckElectionLevel($id)
    // {
    //     $this->db->select('b.*,c.level');
	// 	$this->db->from('members-enrollment a');
    //     $this->db->join('elections-status b','b.group_id=a.group_id','left');
	// 	$this->db->join('level_master c','c.id=b.level_id','left');
	// 	$this->db->where('a.id', $id);
	// 	$this->db->limit(1);
	// 	$this->db->order_by('id','DESC');
	// 	$query = $this->db->get();
	// 	$checkEnroll = $query->row();
	// 	return $checkEnroll;
    // }
	public function CheckElectionLevel($id)
	{
		$this->db->select('b.*, c.level');
		$this->db->from('members-enrollment a');
		$this->db->join('elections-status b', 'IFNULL(b.group_id, 0) = 0 AND b.pincode = LEFT(a.pincode, 13) OR b.group_id = a.group_id', 'left');
		$this->db->join('level_master c', 'c.id = b.level_id', 'left');
		$this->db->where('a.id', $id);
		$this->db->where(['b.is_deleted' => 'NOT_DELETED', 'b.active' => '1']);
		$this->db->limit(1);
		$this->db->order_by('b.id', 'DESC');
		$query = $this->db->get();
		$checkEnroll = $query->row();
		return $checkEnroll;
	}
	

	public function CheckElectionLevelLetest($pincode)
    {
		
        $this->db->select('a.*,c.level');
		$this->db->from('elections-status a');
		$this->db->join('level_master c','c.id=a.level_id','left');
		$this->db->where(['a.is_deleted'=>'NOT_DELETED','a.active'=>'1']);
		$this->db->limit(1);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		$checkEnroll = $query->row();
		// Remove trailing zeros from the right side of the pincode
		$trimmedPincode = @rtrim($pincode, '0');
		// Get the length of the trimmed pincode
		$length = strlen($trimmedPincode);
		$this->db->select('a.*,c.level');
		$this->db->from('elections-status a');
		$this->db->join('level_master c','c.id=a.level_id','left');
		// $this->db->where('a.pincode', $pincode);
		$this->db->where('LEFT(a.pincode, ' . $length . ') =', $trimmedPincode);
		$this->db->where(['a.is_deleted'=>'NOT_DELETED','a.active'=>'1']);
		$this->db->limit(1);
		$this->db->order_by('id','DESC');
		$query1 = $this->db->get();
		$checkEnroll1 = $query1->row();
		return $checkEnroll1;
    }
	

    public function getVote($self_id, $memberId, $electionId) {
        $this->db->select('*');
        $this->db->from('members-voting');
        $this->db->where('member_id', $self_id);
        $this->db->where('vote_for', $memberId);
        $this->db->where('election_id', $electionId);
        $query = $this->db->get();
        
        return $query->row();
    }
    public function getVoteByElection($user_id, $memberId,$election_id) {
        $this->db->where('member_id', $user_id);
        $this->db->where('election_id', $election_id);
        $this->db->where('vote_for', $memberId);
        $query = $this->db->get('members-voting'); 
        return $query->row();
    }
    public function getVoteByElectionCount($user_id, $memberId,$enrollment_id,$election_id) {
        $this->db->where('member_id', $user_id);
        $this->db->where('enrollment_id', $enrollment_id);
		$this->db->where('election_id', $election_id);
        $this->db->where('vote_for', $memberId);
        $query = $this->db->get('members-voting'); 
        return $query->result();
    }
	public function getVoteByElectionCount2($user_id, $memberId,$enrollment_id,$election_id) {
        $this->db->where('member_id', $user_id);
        // $this->db->where('enrollment_id', $enrollment_id);
		$this->db->where('election_id', $election_id);
        $this->db->where('vote_for', $memberId);
        $query = $this->db->get('members-voting'); 
        return $query->result();
    }
    // Voting Model

    public function resetVote($user_id, $election_id) {
        $this->db->where('member_id', $user_id);
        $this->db->where('election_id', $election_id);
        return $this->db->delete('members-voting');
    }
    

    public function getResult($id)
    {
        $this->db->select('b.*,SUM(a.vote_rank) as total_vote');
		$this->db->from('members-voting a');
        $this->db->join('members-details b','b.id=a.vote_for','left');
		$this->db->where('a.election_id', $id);
        $this->db->group_by('a.vote_for');
        $this->db->order_by('total_vote', 'DESC'); 
		$query = $this->db->get();
		$checkEnroll = $query->result();
		return $checkEnroll;
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
	














}