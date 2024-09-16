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
        state_id:"required"
      },
      messages: {
        name: {
          required: "Please Enter Commissionaires Name",
          remote: "Commissionaires Name Already Exists!"
        },
        code: {
          required: "Please Enter Commissionaires Code!",
          maxlength: "Commissionaires Code Cannot Exceed 2 Digits",
          digits: "Commissionaires Code Must be a Number"
        },
        state_id:"Please Select  State"
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">State :</label>
				<select class="form-select form-control " name="state_id">
          <option value="">--Select--</option>
          <?php foreach($states as $state):?>
          <option value="<?=$state->id;?>"><?='( '.$state->code.' )';?> <?=$state->name;?></option>
          <?php  endforeach;?>
        </select>
            </div>
        </div>
     <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label required">Code :</label>
				<input type="number" class="form-control" name="code" placeholder="Enter  code">
            </div>
        </div>
		<div class="col-lg-9 col-sm-9 col-md-9">
            <div class="form-group">
                <label class="form-check-label  required">Commissionaires Name :</label>
				<input type="text" class="form-control" name="name" placeholder="Enter  name">
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>



  