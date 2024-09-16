<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class voting extends Main {
	

	public function remote($type,$id=null,$column='name')
    {
        if ($type=='countries') {
            $tb = 'countries';
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


	
	public function votes($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		$view_dir = 'voting/';
		switch ($action) {
			case null:
				$data['title'] 		= 'Members Voting';
				$data['contant'] 	= $view_dir.'index';
				$data['tb_url']	  	=  current_url().'/tb';
				$data['new_url']	=  current_url().'/create';
				$this->template($data);
				break;

			    case 'tb':
					$data['contant'] 		= $view_dir.'tb';
					$data['rows']    		= $this->voting_model->Voting($user->id);
                    $data['member']    		= $this->voting_model->VotingMember($user->id);
                    $data['enrollments']    		= $this->voting_model->Votingenrollments($user->id);
                    $data['data']    		= $this->voting_model->getEnrollmentRow($data['enrollments']);
                    $data['pincodes']    		= $this->voting_model->VotingPincode($user->id);
					load_view($data['contant'],$data);
				break;

                case 'vote_submit':
                    $return['res'] = 'error';
                    $return['msg'] = 'Vote Not Saved!';
                    
                    if ($this->input->server('REQUEST_METHOD') == 'POST') {
                        
                        $election_level = $this->input->post('election_level');
                        if($election_level > 1)
                        {
                            $memberIds = $this->input->post('member_id');
                            $votes = $this->input->post('votes');
                            $electionId = $this->input->post('ElectionID'); 
                            $self_id = $this->input->post('self_id');
                            $self_level = $this->input->post('self_level');
                            $member_enrollment_id = $this->input->post('member_enrollment_id'); 
                            $checkActive = $this->voting_model->checkActiveElection($electionId);
                            if (!empty($checkActive)) {
                                $Validity = $checkActive->validity; 
                                $Active = $checkActive->active;
                                $ElectionDate = $checkActive->election_date;
                                $Level = $checkActive->level-1;
                                $Type = $checkActive->type;
                                $Time = $checkActive->election_start_time;
                                $ElectionID = $checkActive->id;
                                
                                $currentDate = date('Y-m-d');
                                $startTime = $currentDate . ' ' . $Time;
                                $validityTime = strtotime($startTime) + ($Validity * 3600);
                                $isValid = $validityTime > time();
                                $isSameDate = (date('Y-m-d') == date('Y-m-d', strtotime($ElectionDate)));
                                
                                // Check if election is active
                                if ($Active != '1') {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Election Not Open!';
                                    echo json_encode($return);
                                    break;
                                }
                    
                                // Check if the election date matches
                                if (!$isSameDate) {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Date Mismatch!';
                                    echo json_encode($return);
                                    break;
                                }
                    
                                // Check if the election time is valid
                                if (!$isValid) {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Election Hours Expired!';
                                    echo json_encode($return);
                                    break;
                                }
                    
                                // Check if the election level matches
                                if ($Level != $self_level) {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Election Not Your Level!';
                                    echo json_encode($return);
                                    break;
                                }
                    
                                // Check for duplicate vote ranks
                                $alreadyVoted = false;
                                $voteRanks = [];
                                foreach ($votes as $vote) {
                                    if (in_array($vote, $voteRanks)) {
                                        $alreadyVoted = true;
                                        break;
                                    }
                                    $voteRanks[] = $vote;
                                }
                                
                                if ($alreadyVoted) {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Duplicate vote ranks are not allowed.';
                                    echo json_encode($return);
                                    break;
                                }
                    
                                // Check if any vote rank is missing
                                if (in_array(null, $votes, true) || in_array('', $votes, true)) {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Please select vote rank for all members.';
                                    echo json_encode($return);
                                    break;
                                }
                    
                                // Save the votes
                                foreach ($memberIds as $index => $memberId) {
                                    $getVoteByElectionCount = $this->voting_model->getVoteByElectionCount($self_id, $memberId, $member_enrollment_id,$ElectionID);
                                    if (empty($getVoteByElectionCount)) {
                                        $vote = $votes[$index];
                                        $data = [
                                            'vote_for' => $memberId,
                                            'member_id' => $self_id,
                                            'vote_rank' => $vote,
                                            'election_id' => $electionId,
                                            'enrollment_id' => $member_enrollment_id
                                        ];
                                        $count = $this->voting_model->Counter('members-voting', ['vote_for' => $memberId, 'member_id' => $self_id]);
                                        // print_r($data);die();
                                        if ($count == 0) {
                                            $this->voting_model->Save('members-voting', $data);
                                        } else {
                                            $this->voting_model->Update('members-voting', $data, ['vote_for' => $memberId, 'member_id' => $self_id]);
                                        }
                                    } else {
                                        $return['res'] = 'error';
                                        $return['msg'] = 'Already Voted!';
                                        echo json_encode($return);
                                        die();
                                    }
                                }
                                
                                $return['res'] = 'success';
                                $return['msg'] = 'Vote Saved Successfully!';
                            }
                            else{
                                $return['res'] = 'error';
                                $return['msg'] = 'Sorry election not scheduled.';
                            }
                        }else{
                        $memberIds = $this->input->post('member_id');
                        $votes = $this->input->post('votes');
                        $electionId = $this->input->post('ElectionID'); 
                        $self_id = $this->input->post('self_id');
                        $self_level = $this->input->post('self_level');
                        $member_enrollment_id = $this->input->post('member_enrollment_id'); 
                        $checkActive = $this->voting_model->checkActive($member_enrollment_id);
                        if (!empty($checkActive)) {
                            $Validity = $checkActive->validity; 
                            $Active = $checkActive->active;
                            $ElectionDate = $checkActive->election_date;
                            $Level = $checkActive->level-1;
                            $Type = $checkActive->type;
                            $Time = $checkActive->election_start_time;
                            $ElectionID = $checkActive->id;
                            
                            $currentDate = date('Y-m-d');
                            $startTime = $currentDate . ' ' . $Time;
                            $validityTime = strtotime($startTime) + ($Validity * 3600);
                            $isValid = $validityTime > time();
                            $isSameDate = (date('Y-m-d') == date('Y-m-d', strtotime($ElectionDate)));
                            
                            // Check if election is active
                            if ($Active != '1') {
                                $return['res'] = 'error';
                                $return['msg'] = 'Election Not Open!';
                                echo json_encode($return);
                                break;
                            }
                
                            // Check if the election date matches
                            if (!$isSameDate) {
                                $return['res'] = 'error';
                                $return['msg'] = 'Date Mismatch!';
                                echo json_encode($return);
                                break;
                            }
                
                            // Check if the election time is valid
                            if (!$isValid) {
                                $return['res'] = 'error';
                                $return['msg'] = 'Election Hours Expired!';
                                echo json_encode($return);
                                break;
                            }
                
                            // Check if the election level matches
                            if ($Level != $self_level) {
                                $return['res'] = 'error';
                                $return['msg'] = 'Election Not Your Level!';
                                echo json_encode($return);
                                break;
                            }
                
                            // Check for duplicate vote ranks
                            $alreadyVoted = false;
                            $voteRanks = [];
                            foreach ($votes as $vote) {
                                if (in_array($vote, $voteRanks)) {
                                    $alreadyVoted = true;
                                    break;
                                }
                                $voteRanks[] = $vote;
                            }
                            
                            if ($alreadyVoted) {
                                $return['res'] = 'error';
                                $return['msg'] = 'Duplicate vote ranks are not allowed.';
                                echo json_encode($return);
                                break;
                            }
                
                            // Check if any vote rank is missing
                            if (in_array(null, $votes, true) || in_array('', $votes, true)) {
                                $return['res'] = 'error';
                                $return['msg'] = 'Please select vote rank for all members.';
                                echo json_encode($return);
                                break;
                            }
                
                            // Save the votes
                            foreach ($memberIds as $index => $memberId) {
                                $getVoteByElectionCount = $this->voting_model->getVoteByElectionCount($self_id, $memberId, $member_enrollment_id,$ElectionID);
                                if (empty($getVoteByElectionCount)) {
                                    $vote = $votes[$index];
                                    $data = [
                                        'vote_for' => $memberId,
                                        'member_id' => $self_id,
                                        'vote_rank' => $vote,
                                        'election_id' => $electionId,
                                        'enrollment_id' => $member_enrollment_id
                                    ];
                                    $count = $this->voting_model->Counter('members-voting', ['vote_for' => $memberId, 'member_id' => $self_id]);
                                    if ($count == 0) {
                                        $this->voting_model->Save('members-voting', $data);
                                    } else {
                                        $this->voting_model->Update('members-voting', $data, ['vote_for' => $memberId, 'member_id' => $self_id]);
                                    }
                                } else {
                                    $return['res'] = 'error';
                                    $return['msg'] = 'Already Voted!';
                                    echo json_encode($return);
                                    die();
                                }
                            }
                            
                            $return['res'] = 'success';
                            $return['msg'] = 'Vote Saved Successfully!';
                        }else{
                            $return['res'] = 'error';
                            $return['msg'] = 'Sorry election not scheduled.';
                        }
                      }
                    }
                    
                    echo json_encode($return);
                    break;
                
                
                    case 'reset_vote':
                        $user_id = $this->input->post('user_id');
                        $election_id = $this->input->post('election_id');
                        $checkActive = $this->voting_model->getRow('elections-status', ['is_deleted'=>'NOT_DELETED','active'=>'1','id' => $election_id]);
                        
                        if (!empty($checkActive)) {
                            $Validity = $checkActive->validity; 
                            $Active = $checkActive->active;
                            $ElectionDate = $checkActive->election_date;
                            $Level = $checkActive->level;
                            $Type = $checkActive->type;
                            $DateTime = $checkActive->added;
                            $ElectionID = $checkActive->id;
                    
                            $validityTime = strtotime($DateTime) + ($Validity * 3600);
                            $isValid = $validityTime > time();
                            $isSameDate = (date('Y-m-d') == date('Y-m-d', strtotime($ElectionDate)));
                    
                            // Check if election is active
                            if ($Active != '1') {
                                $response = array('res' => 'error', 'msg' => 'Election is not active.');
                                echo json_encode($response);
                                break;
                            }
                    
                            // Check if the election date matches
                            if (!$isSameDate) {
                                $response = array('res' => 'error', 'msg' => 'Date mismatch.');
                                echo json_encode($response);
                                break;
                            }
                    
                            // Check if the election time is valid
                            if (!$isValid) {
                                $response = array('res' => 'error', 'msg' => 'Election time expired.');
                                echo json_encode($response);
                                break;
                            }
                    
                            // Reset the vote
                            $result = $this->voting_model->resetVote($user_id, $election_id);
                            if ($result) {
                                $response = array('res' => 'success', 'msg' => 'Votes reset successfully.');
                            } else {
                                $response = array('res' => 'error', 'msg' => 'Failed to reset votes.');
                            }
                        } else {
                            $response = array('res' => 'error', 'msg' => 'Invalid election.');
                        }
                    
                        echo json_encode($response);
                        break;
                    
			default:
				// code...
				break;
		}
		
	}


  
}