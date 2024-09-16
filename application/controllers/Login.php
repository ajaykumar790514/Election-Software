<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Login extends Main {
	
	public function index($type='admin')
	{
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			if (!$_POST['username'] or !$_POST['password']) {
				$return['res'] = 'error';
				$return['msg'] = 'Please Enter Username & Password !';
				echo json_encode($return); die();
			}
			$type = $_POST['type'];
			if (@$_POST['type']=='admin') {
				$check['username'] = $_POST['username'];
				$user = $this->model->getRow('tb_admin',$check);
				$password = $this->encryption->decrypt(@$user->password);
			}
			elseif(@$_POST['type']=='member') {
				$check['enrollment_no'] = $_POST['username'];
				$user = $this->model->getRow('members-details',$check);
				$password =  $this->encryption->decrypt(@$user->password);
			}
			else{
				$user = false;
			}

            if(@$_POST['type']=='admin'){
			if ($user) {
				if ($user->status==1) {
					if ($_POST['password']==(@$password) ){
						logs($user->id,$user->id,'LOGIN','Admin Login');
						$user = array_encryption($user);
						$type = value_encryption($type,'encrypt');
						set_cookie('63a490ed05b42',$user['id'],8000*24*30);
						set_cookie('63a490ed05b43',$user['username'],8000*24*30);
						set_cookie('63a490ed05b44',$type,8000*24*30);
						$return['res'] = 'success';
						$return['msg'] = 'Login Successful Please Wait Redirecting...';
						$return['redirect_url'] = base_url();
					}
					else {
						$return['res'] = 'error';
						$return['msg'] = 'Incorrect Password';
					}
				}
				else {
					$return['res'] = 'error';
					$return['msg'] = 'Account Temporarily Disabled!';
				}
			}
			else {
				$return['res'] = 'error';
				$return['msg'] = 'User Not Found!';
			}
		}elseif(@$_POST['type']=='member') {
			if ($user) {
				 // Perform age validation for member login
				 $age_setting = $this->db->select('*')
				 ->from('settings')
				 ->where(['type'=>'Age','active'=>'1','is_deleted'=>'NOT_DELETED'])
				 ->get()
				 ->row();
				 if ($age_setting) {
					$age_limit = $age_setting->value; 
					$dob = new DateTime($user->dob);
					$current_date = new DateTime();
					$age = $dob->diff($current_date)->y;
					if ($age < $age_limit) {
						$return['res'] = 'error';
						$return['msg'] = 'Member does not meet the age requirement. minimum age '.$age_limit.' years';
						echo json_encode($return);
						die();
					}
				}
			
				if ($user->active==1) {
					if ($_POST['password']==(@$password) ){
						logs($user->id,$user->id,'LOGIN','Member Login');
						$user = array_encryption($user);
						$type = value_encryption($type,'encrypt');
						set_cookie('63a490ed05b42',$user['id'],8000*24*30);
						set_cookie('63a490ed05b43',$user['enrollment_no'],8000*24*30);
						set_cookie('63a490ed05b44',$type,8000*24*30);
						$return['res'] = 'success';
						$return['msg'] = 'Login Successful Please Wait Redirecting...';
						$return['redirect_url'] = base_url();
					}
					else {
						$return['res'] = 'error';
						$return['msg'] = 'Incorrect Password';
					}
				}
				else {
					$return['res'] = 'error';
					$return['msg'] = 'Account Temporarily Disabled!';
				}
			}
			else {
				$return['res'] = 'error';
				$return['msg'] = 'User Not Found!';
			}
		}
			echo json_encode($return);

		}
		else{
			$admin_logo = $this->model->getRow('tb_admin',['id'=>'1']);
		if(!empty($admin_logo))
		{
			$data['logo'] = IMGS_URL.$admin_logo->photo;
			
		}else
		{
       $data['logo'] = base_url() . 'public/uploads/users/logo.png';
		}
			$data['title'] 	= 'Login';
			$data['type']	=	$type;
			$data['rs']     =  $this->db->select("a.*")->from('tb_admin a')->where('a.id','1')->get()->row();
			load_view('login',$data);
		}
	}
	public function admin_mobile_otp()
	{  
		 
		$mobile=$_POST['mobile'];
		
		$this->db->delete('all_otp', array('mobile' => $mobile));
		if(isset($_POST['mobile']) && $_POST['mobile']!==''){
			$check_existing_record = $this->model->admin_mobile_exist($_POST['mobile']);
		   
			if($check_existing_record){
			    $otp=mt_rand(100000, 999999);
				$_SESSION['otp']  = $otp;
				$data =array(
				      'otp'=>$otp,
					  'mobile'=>$_POST['mobile'],
				);

				if($this->model->adminupdateRow($mobile,$data))
				{
					if(TRUE)
					{
						$return['res'] = 'success';
						$return['msg'] = 'Otp Send Your Mobile Number';
						$msg =$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
                        $conditions = array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'id'=>'1'
                                )
                        );
                        $smsData = $this->ManageOrderOtpModel->getSmsRows($conditions);
                        $smsData['mobileNos'] = $mobile;
                        $smsData["message"] = $msg;
                        $this->ManageOrderOtpModel->send_sms($smsData);
					}
					else
					{
						$return['res'] = 'error';
						$return['msg'] = "Message could not be sent.";	
					}
				}
				else
				{
					$return['res'] = 'error';
						$return['msg'] = "Otp could not be generated.";	
				}
			}
			else
			{
				$return['res'] = 'error';
			    $return['msg'] =  "Mobile number does not exist.";
			}
		}
		else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
	}
	public function admin_check_otp()
	{
		$otp=$_POST['otp'];
		if(isset($_POST['otp']) && $_POST['otp']!==''){
			
			  $check_existing_otp = $this->model->admin_otp_exist($_POST['otp']); 
			  if($check_existing_otp)
			  {
				$return= 1;
			  }else{
				$return= 0;
			  }

		}else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
		
	}
	public function admin_update_pass()
	{
		$newpassword=$_POST['newpassword'];
		$cpassword=$_POST['cpassword'];
		$mobile=$_POST['mobile'];
		if(isset($_POST['newpassword']) && $_POST['newpassword']!==''){
			$data =array(
             'password'=>$this->encryption->encrypt($newpassword),
			);
			if($this->model->admin_update_password($mobile,$data))
			{
				$return['res'] = 'success';
	    	    $return['msg'] =  "Password forgot successfully";
				$this->db->delete('all_otp', array('mobile' => $mobile));
			}else
			{
				$return['res'] = 'error';
	    	    $return['msg'] =  "Failed";
			}

		}
	
		echo json_encode($return);
		return TRUE;
	}
	public function delete_otp() {
        $mobile=$_POST['mobile'];
		$deleted=$this->db->delete('all_otp', array('mobile' => $mobile));
        if ($deleted) {
            $response = array('success' => true, 'message' => 'OTP deleted successfully');
        } else {
            $response = array('success' => false, 'message' => 'Failed to delete OTP');
        }
        echo json_encode($response);
    }

	public function member_mobile_otp()
	{  
		 
		$mobile=$_POST['mobile'];
		$this->db->delete('all_otp', array('mobile' => $mobile));
		if(isset($_POST['mobile']) && $_POST['mobile']!==''){
			$check_existing_record = $this->model->mobile_exist($_POST['mobile']);
			if($check_existing_record){
			    $otp=mt_rand(100000, 999999);
				$_SESSION['otp']  = $otp;
				$data =array(
				      'otp'=>$otp,
					  'mobile'=>$_POST['mobile'],
				);

				if($this->model->updateRow($mobile,$data))
				{
					if(TRUE)
					{
						$return['res'] = 'success';
						$return['msg'] = 'Otp Send Your Mobile Number';
						$msg =$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
                        $conditions = array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'id'=>'1'
                                )
                        );
                        $smsData = $this->ManageOrderOtpModel->getSmsRows($conditions);
                        $smsData['mobileNos'] = $mobile;
                        $smsData["message"] = $msg;
                        $this->ManageOrderOtpModel->send_sms($smsData);
					}
					else
					{
						$return['res'] = 'error1';
						$return['msg'] = "Message could not be sent.";	
					}
				}
				else
				{
					$return['res'] = 'error2';
						$return['msg'] = "Otp could not be generated.";	
				}
			}
			else
			{
				$return['res'] = 'error3';
			    $return['msg'] =  "Mobile number does not exist.";
			}
		}
		else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
	}

	public function member_check_otp()
	{
		$otp=$_POST['otp'];
		if(isset($_POST['otp']) && $_POST['otp']!==''){
			
			  $check_existing_otp = $this->model->otp_exist($_POST['otp']); 
			  if($check_existing_otp)
			  {
				$return= 1;
			  }else{
				$return= 0;
			  }

		}else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
		
	}

	public function member_update_pass()
	{
		$newpassword=$_POST['newpassword'];
		$cpassword=$_POST['cpassword'];
		$mobile=$_POST['mobile'];
		if(isset($_POST['newpassword']) && $_POST['newpassword']!==''){
			$data =array(
             'password'=>$this->encryption->encrypt($newpassword),
			);
			if($this->model->update_password($mobile,$data))
			{
				$return['res'] = 'success';
	    	    $return['msg'] =  "Password forgot successfully";

			}else
			{
				$return['res'] = 'error';
	    	    $return['msg'] =  "Failed";
			}

		}
	
		echo json_encode($return);
		return TRUE;
	}
	public function logout()
	{
		$user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
		$user_type = value_encryption(get_cookie('63a490ed05b44'),'decrypt');
		delete_cookie('63a490ed05b42');	
		delete_cookie('63a490ed05b43');	
		delete_cookie('63a490ed05b44');	
		if($user_type=='admin')
		{
			logs($user_id,$user_id,'LOGOUT','Admin Logout');
			redirect(base_url());
		}else{
			logs($user_id,$user_id,'LOGOUT','Member Logout');
			redirect(base_url('member-login'));
		}
	
	}
}
