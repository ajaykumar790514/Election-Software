<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
          <th>S.No.</th>
          <th>Country</th>
          <th>State</th>
          <th>Commissionaires</th>
          <th>District</th>
          <th>Pincode</th>
          <th>Permanent Address</th>
          <th>Street / House / Flat</th>
          <th>Family No</th>
          <th>Members No</th>
          <th>Status</th>
          <th>Actions</th>
           </tr>
           </thead>
           <tbody class="text-nowrap">
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr class="text-center">
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=' ( '.$row->country_code.' ) '.$row->country_name?></td>
                    <td><?=' ( '.$row->state_code.' ) '.$row->state_name?></td>
                    <td><?=' ( '.$row->commissionaires_code.' ) '.$row->commissionaires_name?></td>
                    <td><?=' ( '.$row->district_code.' ) '.$row->district_name?></td>
                    <td><?=$row->pincode?></td>
                    <td><?=$row->permanent_address?></td>
                    <td><?=$row->street_house_flat?></td>
                    <td><?=$row->family_no?></td>
                    <td><?=$row->members_no?></td>
                    <td class="text-center">
                       <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,members-enrollment,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>
                    <td> 
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal-xl" data-whatever="Show Enrollment Details (<?=$row->pincode?>)" data-url="<?=$details_url?><?=$row->id?>" title="Show Enrollment Details">
                    <i class="la la-eye"></i></a>
                       <a href="<?=$update_url?><?=$row->id?>" >
                           <i class="la la-pencil-square"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete  Members Enrollment" >
                           <i class="la la-trash"></i>
                       </a>
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
   