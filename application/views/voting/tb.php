<style>
    .vote-rank {
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    margin-right: 5px;
    border: 1px solid #ccc;
    cursor: pointer;
    border-radius: 10px;
}

.vote-rank.selected {
    background-color: green;
    color: white;
}

</style>
<div class="card-body card-dashboard">
    <div class="row">
        <div class="info-container">
            <div class="info-box">
                <h6>Country</h6>
                <p><?=$data->country_name;?></p>
            </div>
            <div class="info-box">
                <h6>State</h6>
                <p><?=$data->state_name;?></p>
            </div>
            <div class="info-box">
                <h6>Commissionaires</h6>
                <p><?=$data->commissionaires_name;?></p>
            </div>
            <div class="info-box">
                <h6>District</h6>
                <p><?=$data->district_name;?></p>
            </div>
            <div class="info-box">
                <h6>Tehsil Zone</h6>
                <p><?=$data->tehsil_name;?></p>
            </div>
            <div class="info-box">
                <h6>Ward Block</h6>
                <p><?=$data->ward_block_name;?></p>
            </div>
            <div class="info-box">
                <h6>Block Nyay</h6>
                <p><?=$data->block_nyay_name;?></p>
            </div>
            <div class="info-box">
                <h6>Panchayat Village</h6>
                <p><?=$data->panchayat_village;?></p>
            </div>
            <div class="info-box">
                <h6>Pincode</h6>
                <p><?=$pincodes;?></p>
            </div>
        </div>
       
        <div class="col-sm-12 col-md-12">
        <form id="votingForm" method="post">
            <div class="table-responsive ">
                <table class="table table-bordered base-style" id="mytable">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Member Name</th>
                            <th>D.O.B</th>
                            <th>Gender</th>
                            <th>Member Aadhaar</th>
                            <th>Vote (1 to 10)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $CheckElectionLevelLetest = $this->voting_model->CheckElectionLevelLetest(substr($pincodes, 0, 13));
                        $CheckElectionLevel = $this->voting_model->CheckElectionLevel($enrollments);
                        if(@$CheckElectionLevelLetest->level > 2)
                        {
                           
                            $group_id= $CheckElectionLevelLetest->group_id;
                            $pincode= $CheckElectionLevelLetest->pincode;
                            $election_id= $CheckElectionLevelLetest->id;
                            $ElectionID=null;
                            $FindMember = $this->voting_model->FindMemberNew($user->id,$election_id,$pincode,$group_id);
                            $n=1;
                            $count=0;
                            $getVoteByElectionCount=$TotalCount=0;
                            $isElectionOpen = false;
                            $isLevelCheck = false;
                            $isValidityExpired = false;
                            $isVotingAllowed = false;
                            $isElectionDate = false;
                            $showRow = 0;
                            $checkActiveExist=false; 
                            $memberCheck=false; 
                            // prx($FindMember);
                            if(!empty($FindMember)){
                                if(count($FindMember) >=2){
                            foreach($FindMember as $mem):
                                $memberCheck=true;
                               $checkActive = $this->voting_model->checkActiveElection($election_id);
                               if(!empty($checkActive)){
                               $checkActiveExist=true;
                               $getVoteByElection = $this->voting_model->getVoteByElection($user->id,$mem->id,$checkActive->id);
                               $getVoteByElectionCount = $this->voting_model->getVoteByElectionCount2($user->id,$mem->id,$mem->member_enrollment_id,$checkActive->id);
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
                                   $isSameDate = (date('Y-m-d') == date('Y-m-d', @strtotime(@$ElectionDate)));
                               } else {
                                   $Validity = null;
                                   $Active = '0';
                                   $ElectionDate = null;
                                   $Level = null;
                                   $Type = null;
                                   $Time = null;
                                   $isValid = false; 
                                   $ElectionID = null;
                                   $isSameDate=null;
                               }
                               if($isSameDate){
                                   $isElectionDate = true;
                               if ($Active == '1') {
                                   $isElectionOpen = true;
                                   if ($Level == $mem->level && $member->level==$Level) {
                                       $isLevelCheck = true;
                                       if (!$isValid) {
                                           $isValidityExpired = true;
                                       } else {
                                           $isVotingAllowed = true;
                                           $count++;
                                     if(empty($getVoteByElectionCount)){  $showRow = 0;?>
                            <tr>
                            <td><?= $n; ?><input type="hidden" name="sr_no" value="<?= $n; ?>">
                           <input type="hidden" value="<?=$ElectionID;?>" name="ElectionID">
                           <input type="hidden" name="member_enrollment_id" value="<?=$mem->member_enrollment_id;?>">
                           <input type="hidden" name="self_level" value="<?=$mem->level;?>">
                           <input type="hidden" name="election_level" value="<?=$checkActive->level;?>">
                           
                           <input type="hidden" name="self_id" value="<?=$user->id;?>"></td>
                            <td><?= $mem->fname . ' ' . $mem->mname . ' ' . $mem->lname; ?>
                                <input type="hidden" value="<?= $mem->id; ?>" name="member_id[]">
                            </td>
                            <td><?= date('d-m-Y',strtotime($mem->dob)); ?></td>
                            <td><?= $mem->gender; ?></td>
                            <td><?= $mem->aadhaar_no; ?></td>
                            <td>
                            <div class="vote-rank-selector">
                                <?php for ($rank = 1; $rank <= 10; $rank++): ?>
                                    <div class="vote-rank <?= (@$getVoteByElection->vote_rank == $rank) ? 'selected' : ''; ?>" data-rank="<?= $rank; ?>"><?= $rank; ?></div>
                                <?php endfor; ?>
                                <input type="hidden" id="votes" name="votes[]">
                            </div>
                        </td>
                        </tr>
                          <?php 
                               }else{
                                   $showRow = 1;
                                 }
                               }
                           }
                       }
                   }
                       $n++;
                    }
                   endforeach;
                  }
                  if($memberCheck){
                   if($checkActiveExist){
                       if(!$isElectionDate){?>
                            <tr>
                               <td colspan="6" class="text-center"><p class="text-danger">Election Not Open Today.</p></td>
                           </tr>
                       <?php }elseif (!$isElectionOpen) { ?>
                           <tr>
                               <td colspan="6" class="text-center"><p class="text-danger">Election Not Open </p></td>
                           </tr>
                       <?php } elseif ($isElectionOpen && !$isLevelCheck) { ?>
                           <tr>
                               <td colspan="6" class="text-center"><p class="text-danger">No Schedule Found.</p></td>
                           </tr>
                       <?php } elseif ($isElectionOpen && $isValidityExpired) { ?>
                           <tr>
                               <td colspan="6" class="text-center"><p class="text-danger">Election Hours Expired</p></td>
                           </tr>
                       <?php } ?>
                       <?php if($showRow==1):?>
                           <tr>
                               <td colspan="6"><div class="text-success text-center">Already Voted.</div></td>
                           </tr>
   
                       <?php elseif ($isVotingAllowed): ?>
                           <tr>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td>
                                 <?php if($TotalCount==$count){?>
                                 <?php }else{?>
                                 <button type="submit" class="btn btn-sm btn-danger">Vote </button>
                               <?php };?>
                               </td>
                           </tr>
                       <?php endif; }else{?>
                           <tr>
                               <td colspan="6" class="text-center"><p class="text-danger">Election Not Scheduled</p></td>
                           </tr>
                       <?php }
                             }else{
                                echo '<tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Not enough members to proceed with the election.</p></td>
                        </tr>';
                             }
                        } else{
                           echo '<tr>
                               <td colspan="6" class="text-center"><p class="text-danger">Not any other member your group so not vote permission</p></td>
                           </tr>' ;
                        }
                        }else
                        if(@$CheckElectionLevel->level == 2){
                         $group_id= $CheckElectionLevel->group_id;
                         $pincode= $CheckElectionLevel->pincode;
                         $election_id= $CheckElectionLevel->id;
                         $ElectionID=null;
                         $FindMember = $this->voting_model->FindMember($user->id,$group_id,$election_id,$pincode);
                         $n=1;
                         $count=0;
                         $getVoteByElectionCount=$TotalCount=0;
                         $isElectionOpen = false;
                         $isLevelCheck = false;
                         $isValidityExpired = false;
                         $isVotingAllowed = false;
                         $isElectionDate = false;
                         $showRow = 0;
                         $checkActiveExist=false; 
                         if(!empty($FindMember)){
                            if(count($FindMember) >=2){
                         foreach($FindMember as $mem):
                            $checkActive = $this->voting_model->checkActiveElection($election_id);
                            if(!empty($checkActive)){
                            $checkActiveExist=true;
                            $getVoteByElection = $this->voting_model->getVoteByElection($user->id,$mem->id,$checkActive->id);
                            $getVoteByElectionCount = $this->voting_model->getVoteByElectionCount2($user->id,$mem->id,$mem->member_enrollment_id,$checkActive->id);
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
                                $isSameDate = (date('Y-m-d') == date('Y-m-d', @strtotime(@$ElectionDate)));
                            } else {
                                $Validity = null;
                                $Active = '0';
                                $ElectionDate = null;
                                $Level = null;
                                $Type = null;
                                $Time = null;
                                $isValid = false; 
                                $ElectionID = null;
                                $isSameDate=null;
                            }
                            if($isSameDate){
                                $isElectionDate = true;
                            if ($Active == '1') {
                                $isElectionOpen = true;
                                if ($Level == $mem->level && $member->level==$Level) {
                                    $isLevelCheck = true;
                                    if (!$isValid) {
                                        $isValidityExpired = true;
                                    } else {
                                        $isVotingAllowed = true;
                                        $count++;
                            if (empty($getVoteByElectionCount)) {
                           $showRow = 0; ?>
                         <tr>
                         <td><?= $n; ?><input type="hidden" name="sr_no" value="<?= $n; ?>">
                        <input type="hidden" value="<?=$ElectionID;?>" name="ElectionID">
                        <input type="hidden" name="member_enrollment_id" value="<?=$mem->member_enrollment_id;?>">
                        <input type="hidden" name="self_level" value="<?=$mem->level;?>">
                        <input type="hidden" name="election_level" value="<?=$checkActive->level;?>">
                        
                        <input type="hidden" name="self_id" value="<?=$user->id;?>"></td>
                         <td><?= $mem->fname . ' ' . $mem->mname . ' ' . $mem->lname; ?>
                             <input type="hidden" value="<?= $mem->id; ?>" name="member_id[]">
                         </td>
                         <td><?= date('d-m-Y',strtotime($mem->dob)); ?></td>
                         <td><?= $mem->gender; ?></td>
                         <td><?= $mem->aadhaar_no; ?></td>
                         <td>
                         <div class="vote-rank-selector">
                             <?php for ($rank = 1; $rank <= 10; $rank++): ?>
                                 <div class="vote-rank <?= (@$getVoteByElection->vote_rank == $rank) ? 'selected' : ''; ?>" data-rank="<?= $rank; ?>"><?= $rank; ?></div>
                             <?php endfor; ?>
                             <input type="hidden" id="votes" name="votes[]">
                         </div>
                     </td>
                     </tr>
                       <?php 
                            }else{
                                $showRow = 1;
                              }
                            }
                        }
                    }
                }
                    $n++;
                 }
                endforeach;
                if($checkActiveExist){
                    if(!$isElectionDate){?>
                         <tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Election Not Open Today.</p></td>
                        </tr>
                    <?php }elseif (!$isElectionOpen) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Election Not Open </p></td>
                        </tr>
                    <?php } elseif ($isElectionOpen && !$isLevelCheck) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><p class="text-danger">No Schedule Found.</p></td>
                        </tr>
                    <?php } elseif ($isElectionOpen && $isValidityExpired) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Election Hours Expired</p></td>
                        </tr>
                    <?php } ?>
                    <?php if($showRow==1):?>
                        <tr>
                            <td colspan="6"><div class="text-success text-center">Already Voted.</div></td>
                        </tr>

                    <?php elseif ($isVotingAllowed): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                              <?php if($TotalCount==$count){?>
                              <?php }else{?>
                              <button type="submit" class="btn btn-sm btn-danger">Vote </button>
                            <?php };?>
                            </td>
                        </tr>
                    <?php endif; }else{ ?>
                        <tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Election Not Scheduled</p></td>
                        </tr>
                    <?php }
                        }else{
                            echo '<tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Not enough members to proceed with the election.</p></td>
                        </tr>';
                        }
                     } else{
                        echo '<tr>
                            <td colspan="6" class="text-center"><p class="text-danger">Not any other member your group so not vote permission</p></td>
                        </tr>' ;
                     } 
                      }else{
                        $i = 1;
                        $count=0;
                        $getVoteByElectionCount=$TotalCount=0;
                        $isElectionOpen = false;
                        $isLevelCheck = false;
                        $isValidityExpired = false;
                        $isVotingAllowed = false;
                        $isElectionDate = false;
                        $showRow = 0;
                        $checkActiveExist=false;
                        if(count($rows) >=2){
                        foreach ($rows as $row):
                            $checkActive = $this->voting_model->checkActive($row->member_enrollment_id);
                            if(!empty($checkActive)){
                            $checkActiveExist=true;
                            $getVoteByElection = $this->voting_model->getVoteByElection($user->id,$row->id,$checkActive->id);
                            $getVoteByElectionCount = $this->voting_model->getVoteByElectionCount($user->id,$row->id,$row->member_enrollment_id,$checkActive->id);
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
                                $isSameDate = (date('Y-m-d') == date('Y-m-d', @strtotime(@$ElectionDate)));
                            } else {
                                $Validity = null;
                                $Active = '0';
                                $ElectionDate = null;
                                $Level = null;
                                $Type = null;
                                $Time = null;
                                $isValid = false; 
                                $ElectionID = null;
                                $isSameDate=null;
                            }
                            if($isSameDate){
                                $isElectionDate = true;
                            if ($Active == '1') {
                                $isElectionOpen = true;
                                if ($Level == $row->level && $member->level==$Level) {
                                    $isLevelCheck = true;
                                    if (!$isValid) {
                                        $isValidityExpired = true;
                                    } else {
                                        $isVotingAllowed = true;
                                        $count++;
                                  if(empty($getVoteByElectionCount)){   $showRow = 0;?>
                                    <tr>
                                        <td><?= $i; ?><input type="hidden" name="sr_no" value="<?= $i; ?>">
                                       <input type="hidden" value="<?=$ElectionID;?>" name="ElectionID">
                                       <input type="hidden" name="member_enrollment_id" value="<?=$row->member_enrollment_id;?>">
                                       <input type="hidden" name="self_level" value="<?=$row->level;?>">
                                       <input type="hidden" name="election_level" value="<?=$checkActive->level;?>">
                                       <input type="hidden" name="self_id" value="<?=$user->id;?>"></td>
                                        <td><?= $row->fname . ' ' . $row->mname . ' ' . $row->lname; ?>
                                            <input type="hidden" value="<?= $row->id; ?>" name="member_id[]">
                                        </td>
                                        <td><?= date('d-m-Y',strtotime($row->dob)); ?></td>
                                        <td><?= $row->gender; ?></td>
                                        <td><?= $row->aadhaar_no; ?></td>
                                        <td>
                                        <div class="vote-rank-selector">
                                            <?php for ($rank = 1; $rank <= 10; $rank++): ?>
                                                <div class="vote-rank <?= (@$getVoteByElection->vote_rank == $rank) ? 'selected' : ''; ?>" data-rank="<?= $rank; ?>"><?= $rank; ?></div>
                                            <?php endfor; ?>
                                            <input type="hidden" id="votes" name="votes[]">
                                        </div>
                                    </td>
                                    </tr>
                                    <?php
                                      }else{
                                        $showRow = 1;
                                      }
                                    }
                                }
                            }
                        }
                            $i++;
                         }
                        endforeach;
                        if($checkActiveExist){
                        if(!$isElectionDate){?>
                             <tr>
                                <td colspan="6" class="text-center"><p class="text-danger">Election Not Open Today.</p></td>
                            </tr>
                        <?php }elseif (!$isElectionOpen) { ?>
                            <tr>
                                <td colspan="6" class="text-center"><p class="text-danger">Election Not Open </p></td>
                            </tr>
                        <?php } elseif ($isElectionOpen && !$isLevelCheck) { ?>
                            <tr>
                                <td colspan="6" class="text-center"><p class="text-danger">No Schedule Found.</p></td>
                            </tr>
                        <?php } elseif ($isElectionOpen && $isValidityExpired) { ?>
                            <tr>
                                <td colspan="6" class="text-center"><p class="text-danger">Election Hours Expired</p></td>
                            </tr>
                        <?php } ?>
                        <?php if($showRow==1):?>
                            <tr>
                                <td colspan="6"><div class="text-success text-center">Already Voted.</div></td>
                            </tr>

                        <?php elseif ($isVotingAllowed): ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                  <?php if($TotalCount==$count){?>
                                  <?php }else{?>
                                  <button type="submit" class="btn btn-sm btn-danger">Vote </button>
                                <?php };?>
                                </td>
                            </tr>
                        <?php endif; }else{?>
                            <tr>
                                <td colspan="6" class="text-center"><p class="text-danger">Election Not Scheduled</p></td>
                            </tr>
                        <?php } ?>
                        <?php }else{
                            echo '<tr>
                             <td colspan="6" class="text-center"><p class="text-danger">Not enough members to proceed with the election.</p></td>
                         </tr>';
                        } }?>
                    </tbody>
                </table>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.vote-rank').click(function() {
        var rank = $(this).data('rank');
        $(this).siblings('.vote-rank').removeClass('selected');
        $(this).addClass('selected');
        
        $(this).closest('.vote-rank-selector').find('input[name="votes[]"]').val(rank);
    });
});


    $(document).ready(function() {
        function checkForDuplicates() {
            let votes = [];
            let hasDuplicate = false;
            $('input[name="votes[]"]').each(function() {
                if ($(this).val() !== '') {
                    if (votes.includes($(this).val())) {
                        hasDuplicate = true;
                        return false;
                    }
                    votes.push($(this).val());
                }
            });
            return hasDuplicate;
        }

        $('#votingForm').on('submit', function(e) {
            e.preventDefault();

            if (checkForDuplicates()) {
                Swal.fire({
                    toast: true,
                    type: 'error',
                    title: 'Error',
                    text: 'Duplicate vote ranks are not allowed. Please ensure each rank is unique.'
                });
                return;
            }

            Swal.fire({
                toast: true,
                type: 'warning',
                title: 'Do you want to submit your vote?',
                timer: 3000,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    var formData = $(this).serialize();
                    $.ajax({
                        type: 'POST',
                        url: '<?=base_url();?>voting/vote_submit',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.res == 'success') {
                                Swal.fire({
                                    toast: true,
                                    type: 'success',
                                    title: 'Success',
                                    text: response.msg
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                Swal.fire({
                                    toast: true,
                                    type: 'error',
                                    title: 'Error',
                                    text: response.msg
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                toast: true,
                                type: 'error',
                                title: 'Error',
                                text: 'An error occurred while processing your request.'
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
     // Handle the reset vote button click event
     $('#reset-vote').on('click', function() {
            Swal.fire({
                toast: true,
                type: 'warning',
                title: 'Do you want to reset your votes?',
                timer: 3000,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '<?=base_url();?>voting/reset_vote',
                        data: {
                            user_id: '<?=$user->id;?>',
                            election_id: '<?=$ElectionID;?>'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.res == 'success') {
                                Swal.fire({
                                    toast: true,
                                    type: 'success',
                                    title: 'Success',
                                    text: response.msg
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                Swal.fire({
                                    toast: true,
                                    type: 'error',
                                    title: 'Error',
                                    text: response.msg
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                toast: true,
                                type: 'error',
                                title: 'Error',
                                text: 'An error occurred while processing your request.'
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
        // Disable submit button if there are duplicate vote ranks
        $('input[name="votes[]"]').on('input', function() {
            if (checkForDuplicates()) {
                $('button[type="submit"]').prop('disabled', true);
            } else {
                $('button[type="submit"]').prop('disabled', false);
            }
        });
    });
</script>
