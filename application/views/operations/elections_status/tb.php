<div class="card-body card-dashboard">
    <div class="table-responsive pt-1">
        <table class="table table-bordered base-style" id="mytable">
            <thead>
                <tr class="text-center">
                    <th>S.No.</th>
                    <th>Blocks</th>
                    <th>Blocks Pincode</th>
                    <th>Level</th>
                    <th>Election Date</th>
                    <th>Election Start Time</th>
                    <th>Validity ( In Hours )</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-nowrap">
                <?php $i = $page;
                foreach ($rows as $row) {
                    if(@$row->group_id)
                    {
                        $group_id =$row->group_id;
                    }else{
                        $group_id =0;
                    }
                    $checkAlreadyPosition=$this->operations_model->checkAlreadyPosition($row->id,$row->group_id);
                    // Check if election_date is current or future
                    $showActions = strtotime($row->election_date) >= strtotime(date('Y-m-d'));
                ?>
                    <tr class="text-center">
                        <td class="sr_no"><?= ++$i ?></td>
                        <td> <?php if(@$row->groups){echo  "Block ".$row->groups;} ?></td>
                        <td> <?= $row->pincode; ?></td>
                        <td><?= $row->level ?></td>
                        <td><?= $row->election_date ?></td>
                        <td><?php echo date('g:i A',strtotime($row->election_start_time))?></td>
                        <td><?= $row->validity ?></td>
                        <td class="text-center">
                        <?php if ($showActions) :
                            if(empty($checkAlreadyPosition)){  ?>
                            <span class="changeStatus" data-toggle="change-status" value="<?= ($row->active == 1) ? 0 : 1 ?>" data="<?= $row->id ?>,elections-status,id,active"><i class="<?= ($row->active == 1) ? 'la la-check-circle' : 'icon-close' ?>" title="Click to change status"></i></span>
                            <?php } endif; ?>
                        </td>
                        <td>
                            <?php 
                            
                             if ($showActions) :
                                if(empty($checkAlreadyPosition)){ ?>
                                <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Election Status  (<?= $row->level ?>)" data-url="<?= $update_url . $row->id ?>" title="Update">
                                    <i class="la la-pencil-square"></i>
                                </a> -->
                                <a href="javascript:void(0)" onclick="_delete(this)" url="<?= $delete_url . $row->id ?>" title="Delete Election Status">
                                    <i class="la la-trash"></i>
                                </a>
                            <?php } endif; ?>
                            <?php 
                            if(empty($checkAlreadyPosition)):?>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Winner Details  ( <?= $row->pincode; ?>-<?php if(@$row->groups){echo  "Block ".$row->groups;}else{ echo "Level ".$row->level;} ?> )" data-url="<?=base_url('elections-status/winner/'. $row->id.'/'.$group_id.'/'.$row->level);?>" class="btn btn-sm btn-primary " title="Winner Details">
                             Winner
                             </a>
                             <?php else:?>
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Winner Details ( <?= $row->pincode; ?>- <?php if(@$row->groups){echo  "Block ".$row->groups;}else{ echo "Level ".$row->level;} ?> )" data-url="<?=base_url('elections-status/already_winner/'. $row->id.'/'.$group_id.'/'.$row->level);?>" class="btn btn-sm btn-danger" title="Winner Details">
                             Winner Decided
                             </a>
                              <?php endif;?>  
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="row mt-2">
        <div class="col-md-6 text-left">
            <span>Showing <?= (@$rows) ? $page + 1 : 0 ?> to <?= $i ?> of <?= $total_rows ?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?= $links ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $(".winner-button").on("click", function() {
        setTimeout(function() {
            location.reload();
        }, 10);
    });
});
</script>
