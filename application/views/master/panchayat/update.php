<script>
  $(document).ready(function() {
    $(".needs-validation").validate({
      rules: {
        name: {
          required: true,
          remote: "<?=$remote;?>null/name"
        },
        code: {
          required: true,
          maxlength: 1,
          digits: true
        },
        block_nyay_id:"required",
        village:"required",
      },
      messages: {
        name: {
          required: "Please Enter Panchayat Name",
          remote: "Panchayat Name Already Exists!"
        },
        code: {
          required: "Please Enter Panchayat Code!",
          maxlength: "Panchayat Code Cannot Exceed 1 Digits",
          digits: "Panchayat Code Must be a Number"
        },
        block_nyay_id:"Please Select Block Nyay",
        village:"Please Enter Village Name",
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">Block Nyay:</label>
				<select class="form-select form-control " name="block_nyay_id">
          <option value="">--Select--</option>
          <?php foreach($blocks as $block):?>
          <option value="<?=$block->id;?>" <?php if($value->block_nyay_id==$block->id){ echo "selected";} ;?>  ><?='( '.$block->code.' )';?> <?=$block->name;?></option>
          <?php  endforeach;?>
        </select>
            </div>
        </div>
     <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label required">Code :</label>
				<input type="number" class="form-control" name="code" value="<?=$value->code;?>" placeholder="Enter  code">
            </div>
        </div>
		<div class="col-lg-9 col-sm-9 col-md-9">
            <div class="form-group">
                <label class="form-check-label  required"> Name :</label>
				<input type="text" class="form-control" name="name" value="<?=$value->name;?>" placeholder="Enter name">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label  required">Sequence:</label>
				<input type="number" class="form-control" min="0" value="<?=$value->seq;?>" name="seq" >
            </div>
        </div>
        <div class="col-lg-9 col-sm-9 col-md-9">
            <div class="form-group">
                <label class="form-check-label  required"> Village :</label>
				<input type="text" class="form-control" name="village" value="<?=$value->village;?>" placeholder="Enter village name">
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>



  