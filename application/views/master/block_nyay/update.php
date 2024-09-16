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
        ward_block_id:"required"
      },
      messages: {
        name: {
          required: "Please Enter Block Nyay Name",
          remote: "Block Nyay Name Already Exists!"
        },
        code: {
          required: "Please Enter Block Nyay Code!",
          maxlength: "Block Nyay Code Cannot Exceed 1 Digits",
          digits: "Block Nyay Code Must be a Number"
        },
        ward_block_id:"Please Select Ward Block"
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">Ward Block :</label>
				<select class="form-select form-control " name="ward_block_id">
          <option value="">--Select--</option>
          <?php foreach($wards as $ward):?>
          <option value="<?=$ward->id;?>"  <?php if($value->ward_block_id==$ward->id){ echo "selected";} ;?> ><?='( '.$ward->code.' )';?> <?=$ward->name;?></option>
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
		<div class="col-lg-6 col-sm-6 col-md-6">
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
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>



  