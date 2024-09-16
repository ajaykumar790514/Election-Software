<div class="container-fluid pt-2 pb-2">
<div class="row">
    <div class="col-lg-12">
        <h5>Pincode Details</h5>
      <div class="table-responsive pt-1">
         <table class="table table-bordered base-style">
          <thead>
          <tr>
           <th scope="col">Family Total Member</th>
           <td scope="col"><?=count($members);?></td>
           <th scope="col">Country</th>
           <td scope="col">(<?=$value->country_code;?>) <?=$value->country_name;?></td>
           <th scope="col">State</th>
           <td scope="col">(<?=$value->state_code;?>) <?=$value->state_name;?></td>
           </tr>
           <tr>
           <th scope="col">Commissionaires</th>
           <td scope="col">(<?=$value->commissionaires_code;?>) <?=$value->commissionaires_name;?></td>
           <th scope="col">District</th>
           <td scope="col">(<?=$value->district_code;?>) <?=$value->district_name;?></td>
           <th scope="col">Tehsil Zone</th>
           <td scope="col">(<?=$value->tehsil_code;?>) <?=$value->tehsil_name;?></td>
           </tr>
           <tr>
           <th scope="col">Ward Block</th>
           <td scope="col">(<?=$value->ward_block_code;?>) <?=$value->ward_block_name;?></td>
           <th scope="col"> Block Nyay</th>
           <td scope="col">(<?=$value->block_nyay_code;?>) <?=$value->block_nyay_name;?></td>
           <th scope="col">Panchayat Village</th>
           <td scope="col">(<?=$value->panchayat_code;?>) <?=$value->panchayat_name;?></td>
           </tr>
           <tr>
           <th scope="col">Village</th>
           <td scope="col"><?=$value->panchayat_village;?></td>
           <th scope="col"> Pincode</th>
           <td scope="col"><?=$value->pincode;?></td>
           <th scope="col">Permanent Address</th>
           <td scope="col"> <?=$value->permanent_address;?></td>
           </tr>
           <tr>
           <th scope="col">Street / House No/ Flat</th>
           <td scope="col"><?=$value->street_house_flat;?></td>
           <th scope="col"> Family No (1-9)</th>
           <td scope="col"><?=$value->family_no;?></td>
           <th scope="col">Members oN (A-Z)</th>
           <td scope="col"> <?=$value->members_no;?></td>
           </tr>
          </thead>
       </table>
    </div>
</div>
</div>
        <h4 class="text-black mt-2">Members Details (<span class="text-danger" style="font-size:14px"> Scroll to show all details </span>)</h4>
        <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive pt-1">
             <table class="table table-bordered base-style">
           <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Enrollment</th>
            <th scope="col">First Name</th>
            <th scope="col">Middle Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Father's Name</th>
            <th scope="col">D.O.B</th>
            <th scope="col">Gender</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
            <th scope="col">Profession </th>
            <th scope="col">Income/Day  </th>
            <th scope="col">Aadhaar </th>
            <th scope="col">Pan</th>
            <th scope="col">Voter ID  </th>
            <th scope="col">Head of the house </th>
            </tr>
            </thead>
            <tbody id="table-body">
            <?php $i=1;foreach($members as $member):?>   
            <tr class="text-center">
            <th scope="row"><?=$i++;?></th>
            <td><?=$member->enrollment_no;?></td>
            <td><?=$member->fname;?></td>
            <td><?=$member->mname;?></td>
            <td><?=$member->lname;?></td>
            <td><?=$member->father_name;?></td>
            <td><?=$member->dob;?></td>
            <td><?=$member->gender;?></td>
            <td><?=$member->mobile;?></td>
            <td><?=$member->email;?></td>
            <td><?=$member->profession;?></td>
            <td><?= title('income_master',$member->income_per_day, 'id', 'title') ?></td>
            <td><?=$member->aadhaar_no;?></td>
            <td><?=$member->pan_no;?></td>
            <td><?=$member->voter_id;?></td>
            <td><?php if($member->head_of_the_house==1){ ?><input type="checkbox" class="form-control input-sm head_house_checkbox" <?php if($member->head_of_the_house==1){ echo "checked";} ;?> readonly><?php }?></td>
            </tr>
            <?php  endforeach;?>
           </tbody>
         </table>
       </div>
      </div>
    </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-danger waves-effect" class="close" data-dismiss="modal">Close</button>
</div>



  