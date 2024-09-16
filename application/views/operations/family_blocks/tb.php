<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
           <tr class="text-center">
          <th>S.No.</th>
          <th>Blocks</th>
          <th>Pincode</th>
          <th>Total Enrollment / Family</th>
          <th>Election Status</th>
          <th>Actions</th>
           </tr>
           </thead>
           <tbody class="text-nowrap">
                <?php $i=$page;
                    foreach ($rows as $row) {
                    ?>
               <tr class="text-center">
                    <td class="sr_no"><?=++$i?></td>
                    <th>Block <?=$row->groups;?></th>
                    <td><?=$row->pincode?></td>
                    <td><a href="<?=base_url('family-details/'.$row->group_id.'/details');?>" title="Show family Details" class=" btn btn-primary"><?=$row->total_enrollment?></a></td>
                    <td>
                        <?php if($row->active==1){?>
                        <i class="fa-solid fa-circle-check" style="font-size:2rem;color:green"></i>
                        <?php }else{?>
                            <i class="fa-solid fa-circle-xmark"  style="font-size:2rem;color:red"></i>
                        <?php };?>
                    </td>
                    <td><a href="<?=base_url('family-details/'.$row->group_id.'/details');?>" class="btn  btn-primary">Details</a></td>
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
  