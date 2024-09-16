<div class="card-body card-dashboard text-center">
    <div class="table-responsive pt-1">
        <table class="table table-bordered base-style text-center" id="mytable">
            <thead>
                <tr class="text-center">
                    <th>S.No.</th>
                    <?php if($level > 2){ ?>
                        <th>Election Groups</th>
                    <?php } elseif($level == 2){ ?>
                        <th>Block</th>
                    <?php } else { ?>
                        <th>Family Pincode</th>
                    <?php } ?>
                    <th>Member Details</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <?php if($level > 2) { ?>
                <?php $i = 1; foreach($election_groups as $el): ?>
                    <tr class="justify-content-center">
                        <td class="sr_no"><?=$i++;?></td>
                        <td style="place-content: center">Block <?=$el->groups;?></td>
                        <td>
                            <?php  
                            $voting = $this->operations_model->CountBlockVoteNew($election_id, $el->id);
                            $winner = null;
                            $all_members = $this->operations_model->getAllMembersByGroup($election_id, $el->id); // Get all members in the group

                            if (!empty($voting)) {
                                $winner = $voting[0];
                            }
                            ?>
                            <table class="table table-bordered mb-0 justify-content-center">
                                <thead>
                                    <tr>
                                    <th>Sr.No.</th>
                                        <th>Enrollment</th>
                                        <th>Name</th>
                                        <th>Father's</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Aadhar</th>
                                        <th>Total Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i1=1;foreach($all_members as $member):
                                        $totalVotes = $this->operations_model->memberVote($member->member_id, $election_id); ?>
                                        <tr class="<?= ($winner && $member->member_id == $winner->member_id) ? 'text-success' : 'text-muted'; ?>">
                                        <td><?=$i1++;?></td>
                                            <td><?=$member->enrollment_no;?></td>
                                            <td><?=$member->fname . ' ' . $member->mname . ' ' . $member->lname;?></td>
                                            <td><?=$member->father_name;?></td>
                                            <td><?=$member->mobile;?></td>
                                            <td><?=$member->email;?></td>
                                            <td><?=$member->aadhaar_no;?></td>
                                            <td><?=$totalVotes;?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } elseif($level == 2) { ?>
                <?php $i = 1; foreach ($blocks as $block):  ?>
                    <tr class="justify-content-center">
                        <td class="sr_no"><?=$i++;?></td>
                        <td style="place-content: center">Block <?=$block->groups;?></td>
                        <td>
                            <?php  
                            $voting = $this->operations_model->CountBlockVote($election_id, $block->id);
                            $winner = null;
                            $all_members = $this->operations_model->getAllMembersByBlock($election_id, $block->id); // Get all members in the block

                            if (!empty($voting)) {
                                $winner = $voting[0];
                            }
                            ?>
                            <table class="table table-bordered mb-0 justify-content-center">
                                <thead>
                                    <tr>
                                    <th>Sr.No.</th>
                                        <th>Enrollment</th>
                                        <th>Name</th>
                                        <th>Father's</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Aadhar</th>
                                        <th>Total Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i2=1;foreach($all_members as $member): 
                                        $totalVotes = $this->operations_model->memberVote($member->member_id, $election_id);?>
                                        <tr class="<?= ($winner && $member->member_id == $winner->member_id) ? 'text-success' : 'text-muted'; ?>">
                                        <td><?=$i2++;?></td>
                                            <td><?=$member->enrollment_no;?></td>
                                            <td><?=$member->fname . ' ' . $member->mname . ' ' . $member->lname;?></td>
                                            <td><?=$member->father_name;?></td>
                                            <td><?=$member->mobile;?></td>
                                            <td><?=$member->email;?></td>
                                            <td><?=$member->aadhaar_no;?></td>
                                            <td><?=$totalVotes;?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } else { ?>
                <?php $i = 1; foreach ($enrollment as $enroll): ?>
                    <tr class="justify-content-center">
                        <td class="sr_no"><?=$i++;?></td>
                        <td style="place-content: center"><?=$enroll->pincode;?></td>
                        <td>
                            <?php  
                            $voting = $this->operations_model->CountVote($election_id, $enroll->id);
                            $winner = null;
                            $all_members = $this->operations_model->getAllMembersByPincode($election_id, $enroll->pincode); // Get all members in the pincode

                            if (!empty($voting)) {
                                $winner = $voting[0];
                            }
                            ?>
                            <table class="table table-bordered mb-0 justify-content-center">
                                <thead>
                                    <tr>
                                    <th>Sr.No.</th>
                                        <th>Enrollment</th>
                                        <th>Name</th>
                                        <th>Father's</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Aadhar</th>
                                        <th>Total Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i3=1;foreach($all_members as $member): 
                                         $totalVotes = $this->operations_model->memberVote($member->member_id, $election_id);?>
                                        <tr class="<?= ($winner && $member->member_id == $winner->member_id) ? 'text-success' : 'text-muted'; ?>">
                                        <td><?=$i3++;?></td>
                                            <td><?=$member->enrollment_no;?></td>
                                            <td><?=$member->fname . ' ' . $member->mname . ' ' . $member->lname;?></td>
                                            <td><?=$member->father_name;?></td>
                                            <td><?=$member->mobile;?></td>
                                            <td><?=$member->email;?></td>
                                            <td><?=$member->aadhaar_no;?></td>
                                            <td><?=$totalVotes;?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
