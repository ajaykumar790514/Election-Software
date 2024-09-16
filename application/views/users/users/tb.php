<div class="card-body card-dashboard">
   <p class="card-text">............</p>
   <div class="row">
        <div class="col-sm-12 col-md-6">
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>
                    <input type="search" class="form-control form-control-sm" id="tb-search" placeholder="Search" aria-controls="DataTables_Table_0" >
                </label>
            </div>
        </div>
    </div>
   <!-- <div class="row"> -->
   <div class="table-responsive pt-1">
       <table class="table table-striped table-bordered base-style" id="mytable">
           <thead>
               <tr>
                   <th>Sr. no.</th>
                   <th>Name</th>
                   <th>User Role</th>
                   <th>Username</th>
                   <th>Email</th>
                   <th class="text-center">Status</th>
                   <th style="width: 180px;">Action</th>
               </tr>
           </thead>
           <tbody>
               <?php $i=0;
               foreach ($rows as $row) { ?>
               <tr>
                   <td><?=++$i?></td>
                   <td><?=$row->name?></td>
                   <td><?=title('tb_user_role',$row->user_role)?></td>
                   <td><?=$row->username?></td>
                   <td><?=$row->email?></td>
                   
                   <td class="text-center">
                        <?php if ($row->user_role!=2) { ?>
                        <span class="changeStatus" data-toggle="change-status" value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,tb_admin,id,status" ><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                        <?php } ?>
                   </td>
                  
                   <td>
                      <?php if ($row->user_role!=2) { ?>
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Host - <?=$row->name?>" data-url="<?=$update_url?><?=$row->id?>" title="Update">
                           <i class="la la-pencil-square"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
                           <i class="la la-trash"></i>
                       </a>
                       <?php if ($row->user_role!=1) { ?>
                       <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showModal-xl" data-whatever="Location Access  - <?=$row->name?>" data-url="<?=$location_url?><?=$row->id?>" title="Location Access">
                         Location Access
                       </a>

                        <?php } } ?>
                   </td>
               </tr> 
               <?php
               }
               ?>
               
               
           </tbody>
           
       </table>

   </div>

 
<!-- </div> -->

<script type="text/javascript">
    if ('<?=@$search?>'!='') {
        $('#tb-search').val('<?=@$search?>').focus();
    }
</script>