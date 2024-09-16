<?php
/**
 * 
 */
class Master_model extends CI_Model
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

	public function countries($limit=null,$start=null)
	{
		$this->db->select("a.*");
		$this->db->from('countries a');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
		}
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.added','DESC');
		return $this->db->get()->result();
	}
	public function income_master($limit=null,$start=null)
	{
		$this->db->select("a.*");
		$this->db->from('income_master a');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->like('a.title',@$_POST['name']);
		}
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.seq','ASC');
		return $this->db->get()->result();
	}
	

    public function states($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as country_name,b.code as country_code");
        $this->db->from('states a');
		$this->db->join('countries b','b.id=a.country_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['country_id'])
        {
            $this->db->where('a.country_id',$_POST['country_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.seq','ASC');
		return $this->db->get()->result();
	}

    public function commissionaires($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as state_name,b.code as state_code");
        $this->db->from('commissionaires a');
		$this->db->join('states b','b.id=a.state_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['state_id'])
        {
            $this->db->where('a.state_id',$_POST['state_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.added','DESC');
		return $this->db->get()->result();
	}
    
    public function district($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as commissionaires_name,b.code as commissionaires_code");
        $this->db->from('district a');
		$this->db->join('commissionaires b','b.id=a.commissionaires_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['commissionaires_id'])
        {
            $this->db->where('a.commissionaires_id',$_POST['commissionaires_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.added','DESC');
		return $this->db->get()->result();
	}


    public function tehsil_zone($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as district_name,b.code as district_code");
        $this->db->from('tehsil-zone a');
		$this->db->join('district b','b.id=a.district_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['district_id'])
        {
            $this->db->where('a.district_id',$_POST['district_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.seq','ASC');
		return $this->db->get()->result();
	}
    public function ward_block($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as tehsil_name,b.code as tehsil_code");
        $this->db->from('ward-block a');
		$this->db->join('tehsil-zone b','b.id=a.tehsil_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['tehsil_id'])
        {
            $this->db->where('a.tehsil_id',$_POST['tehsil_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.seq','ASC');
		return $this->db->get()->result();
	}
    
    public function block_nyay($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as ward_name,b.code as ward_code");
        $this->db->from('block-nyay a');
		$this->db->join('ward-block b','b.id=a.ward_block_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['ward_block_id'])
        {
            $this->db->where('a.ward_block_id',$_POST['ward_block_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.seq','ASC');
		return $this->db->get()->result();
	}

	public function panchayat($limit=null,$start=null)
	{
		$this->db->select("a.*,b.name as block_name,b.code as block_code");
        $this->db->from('panchayat-village a');
		$this->db->join('block-nyay b','b.id=a.block_nyay_id','left');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->group_start();
			$this->db->like('a.name',@$_POST['name']);
            $this->db->or_like('a.code',@$_POST['name']);
            $this->db->or_like('b.code',@$_POST['name']);
            $this->db->or_like('b.name',@$_POST['name']);
			$this->db->or_like('a.village',@$_POST['name']);
            $this->db->group_end();
		}
        if(@$_POST['block_nyay_id'])
        {
            $this->db->where('a.block_nyay_id',$_POST['block_nyay_id']);
        }
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.seq','ASC');
		return $this->db->get()->result();
	}
	public function level_master($limit=null,$start=null)
	{
		$this->db->select("a.*");
		$this->db->from('level_master a');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->like('a.level',$_POST['name']);
		}
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.added','ASC');
		return $this->db->get()->result();
	}
	public function settings($limit=null,$start=null)
	{
		$this->db->select("a.*");
		$this->db->from('settings a');
		$this->db->where('a.is_deleted','NOT_DELETED');
		if (@$_POST['name']) {
			$this->db->like('a.type',$_POST['name']);
			$this->db->or_like('a.value',$_POST['name']);
		}
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('a.added','ASC');
		return $this->db->get()->result();
	}
	
}
