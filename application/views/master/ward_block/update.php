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
          maxlength: 2,
          digits: true
        },
        tehsil_id:"required"
      },
      messages: {
        name: {
          required: "Please Enter Ward Block Name",
          remote: "Ward Block Name Already Exists!"
        },
        code: {
          required: "Please Enter Ward Block Code!",
          maxlength: "Ward Block Code Cannot Exceed 2 Digits",
          digits: "Ward Block Code Must be a Number"
        },
        tehsil_id:"Please Select  Tehsil Zone"
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">Tehsil :</label>
				<select class="form-select form-control " name="tehsil_id">
          <option value="">--Select--</option>
          <?php foreach($tehsils as $tehsil):?>
          <option value="<?=$tehsil->id;?>"  <?php if($value->tehsil_id==$tehsil->id){ echo "selected";} ;?> ><?='( '.$tehsil->code.' )';?> <?=$tehsil->name;?></option>
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
                <label class="form-check-label  required">Ward Block Name :</label>
				<input type="text" class="form-control" name="name" value="<?=$value->name;?>" placeholder="Enter  name">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label  required">Sequence:</label>
				<input type="number" class="form-control" min="0"  value="<?=$value->seq;?>" name="seq" >
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>



  