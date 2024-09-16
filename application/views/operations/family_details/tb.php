<style>
    .btn-xm {
        height: 29px;
    padding: 5px;
    width: 74px;
}
</style>
<div class="card-body card-dashboard text-center">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style text-center" id="mytable">
           <thead>
               <tr class="text-center">
                   <th>S.No.</th>
                   <th>Family Pincode</th>
                   <th>Member Details</th>
               </tr>
           </thead>
           <tbody class="text-center">
               <?php $i = $page;
               foreach ($rows as $row) { 
                   $members = $this->operations_model->getData('members-details', ['member_enrollment_id' => $row->id]);
               ?>
               <tr class="justify-content-center">
                   <td class="sr_no"><?= ++$i ?></td>
                   <td style="place-content: center"><?= $row->pincode ?></td>
                   <td>
                       <table class="table table-bordered mb-0 justify-content-center">
                           <thead>
                               <tr>
                                   <th>Enrollment</th>
                                   <th>Name</th>
                                   <th>Father's</th>
                                   <th>Mobile</th>
                                   <th>Email</th>
                                   <th>Aadhar</th>
                                   <th>More Details</th>
                               </tr>
                           </thead>
                           <tbody>
                               <?php foreach ($members as $member) { ?>
                               <tr>
                                  <td><?= $member->enrollment_no ?></td>
                                   <td><?= $member->fname . ' ' . $member->mname . ' ' . $member->lname ?></td>
                                   <td><?= $member->father_name ?></td>
                                   <td><?= $member->mobile ?></td>
                                   <td><?= $member->email ?></td>
                                   <td><?= $member->aadhaar_no ?></td>
                                   <td><a   href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Show Member Details (<?=$member->enrollment_no?>)" data-url="<?=$details_url;?><?= $member->id?>" title="Show Member Details" class="btn btn-primary btn-xm">Details</a></td>
                               </tr>
                               <?php } ?>
                           </tbody>
                       </table>
                   </td>
               </tr>
               <?php } ?>
           </tbody>
       </table>
   </div>

   <div class="row mt-2">
        <div class="col-md-6 text-left">
            <span>Showing <?= (@$rows) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
</div>
