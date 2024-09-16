<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
           <tr class="text-center">
          <th><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-sm">Delete Selected</button></th>
          <th>S.No.</th>
          <th>District Name</th>
          <th>Tehsil Zone Name</th>
          <th>Tehsil Zone Code</th>
          <th>Status</th>
          <th>Sequence</th>
          <th>Actions</th>
           </tr>
           </thead>
           <tbody class="text-nowrap">
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr class="text-center">
               <td width="50px">
               <center><input type="checkbox" class="delete_checkbox" value="<?= $row->id; ?>" id="multiple_delete<?= $row->id; ?>" />
                   <label for="multiple_delete<?= $row->id; ?>"></label></center>  
                      </td>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=" ( ".$row->district_code .' ) '. $row->district_name?></td>
                    <td><?=$row->name?></td>
                    <td><?=$row->code?></td>
                    <td class="text-center">
                       <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,tehsil-zone,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>
                   <td class="text-center">
                   <input type="number" value="<?=$row->seq;?>" data="<?=$row->id;?>,ward-block,id,seq" class="change-indexing" min="0" style="text-align:center;width:80px">
                   </td>
                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Tehsil Zone Name  (<?=$row->name?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update Tehsil Zone Name">
                           <i class="la la-pencil-square"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete Tehsil Zone Name" >
                           <i class="la la-trash"></i>
                       </a>
                    </td>
               </tr> 
  
               <?php  }?>               
               
           </tbody>
           
       </table>

   </div>

   <div class="row">
        <div class="col-md-6 text-left">
            <span>Showing <?= (@$rows) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
    <script>
 $('.delete_checkbox').click(function(){
    if($(this).is(':checked'))
    {
        $(this).closest('tr').addClass('removeRow');
    }
    else
    {
        $(this).closest('tr').removeClass('removeRow');
    }
    });
   $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        var table = 'tehsil-zone';
        if(checkbox.length > 0)
        {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>Main/multiple_delete",
                method:"POST",
                data:{checkbox_value:checkbox_value,table:table},
                success:function(data)
                {
                    $('.removeRow').fadeOut(1500);
                    alert_toastr('success','Delete successfully');
                }
            })
        }
        else
        {
            alert_toastr('error','Select atleast one record');
        }
   })
</script>
