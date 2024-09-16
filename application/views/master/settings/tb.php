<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
           <tr class="text-center">
          <th><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-sm">Delete Selected</button></th>
          <th style="width:50px">S.No.</th>
          <th>Type</th>
          <th>Value</th>
          <th>Days Type</th>
          <th>Status</th>
          <th>Actions</th>
           </tr>
           </thead>
           <tbody class="text-nowrap">
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr class="text-center">
               <td style="width:50px">
               <center><input type="checkbox" class="delete_checkbox" value="<?= $row->id; ?>" id="multiple_delete<?= $row->id; ?>" />
                   <label for="multiple_delete<?= $row->id; ?>"></label></center>  
                      </td>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=$row->type?></td>
                    <td><?=$row->value?></td>
                    <td><?=$row->day_type?></td>
                    <td class="text-center">
                       <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,settings,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Settings  (<?=$row->type?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
                           <i class="la la-pencil-square"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete Settings" >
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
        var table = 'settings';
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
