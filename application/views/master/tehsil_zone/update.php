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
        district_id:"required"
      },
      messages: {
        name: {
          required: "Please Enter Tehsil Zone Name",
          remote: "Tehsil Zone Name Already Exists!"
        },
        code: {
          required: "Please Enter Tehsil Zone Code!",
          maxlength: "Tehsil Zone Code Cannot Exceed 1 Digits",
          digits: "Tehsil Zone Code Must be a Number"
        },
        district_id:"Please Select  District"
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">District :</label>
				<select class="form-select form-control " name="district_id">
          <option value="">--Select--</option>
          <?php foreach($districts as $district):?>
           <option value="<?=$district->id;?>"  <?php if($value->district_id==$district->id){ echo "selected";} ;?> ><?='( '.$district->code.' )';?> <?=$district->name;?></option>
           <?php  endforeach;?>
        </select>
            </div>
        </div>
     <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label required">Code  :</label>
				<input type="number" class="form-control" name="code"  value="<?=$value->code;?>" placeholder="Enter code">
            </div>
        </div>
		<div class="col-lg-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">Tehsil Zone Name :</label>
				<input type="text" class="form-control" name="name" value="<?=$value->name;?>" placeholder="Enter  name">
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



  