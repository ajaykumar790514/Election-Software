<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
           <tr class="text-center">
          <th>S.No.</th>
          <th>Pincode</th>
          <th>Block</th>
          <th>Full Name</th>
          <th>father's Name</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>D.O.B</th>
          <th>Aadhaar No</th>
          <th>Profession</th>
          <th>Election Schedule Level</th>
           </tr>
           </thead>
           <tbody class="text-nowrap">
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr class="text-center">
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=$row->pincode?></td>
                    <td>Block <?=$row->groups?></td>
                    <td><?=$row->fname.' '.$row->mname.' '.$row->lname?></td>
                    <td><?=$row->father_name?></td>
                    <td><?=$row->mobile?></td>
                    <td><?=$row->email?></td>
                    <td><?=$row->dob?></td>
                    <td><?=$row->aadhaar_no?></td>
                    <td><?=$row->profession?></td>
                    <td><label class="text-success" style="font-weight:600;font-size:1.3rem"><?=$row->level?></label></td>
            </td>

               </tr> 
  
               <?php  }?>               
               
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
  