<script>
  $(document).ready(function() {
    $.validator.addMethod("exactlength", function(value, element, param) {
      return this.optional(element) || value.length == param;
    }, "Please enter exactly {0} digits.");

    $(".needs-validation").validate({
      rules: {
        name: {
          required: true,
          remote: "<?=$remote;?>null/name"
        },
        code: {
          required: true,
          exactlength: 2,
          digits: true
        },
        country_id:"required"
      },
      messages: {
        name: {
          required: "Please Enter State Name",
          remote: "State Name Already Exists!"
        },
        code: {
          required: "Please Enter State Code!",
          exactlength: "State Code Cannot Exceed 2 Digits",
          digits: "State Code Must be a Number"
        },
           country_id:"Please Select  Country"
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">Country :</label>
				<select class="form-select form-control " name="country_id">
          <option value="">--Select--</option>
          <?php foreach($countries as $country):?>
          <option value="<?=$country->id;?>"><?='( '.$country->code.' )';?> <?=$country->name;?></option>
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
		<div class="col-lg-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">State Name :</label>
				<input type="text" class="form-control" name="name" placeholder="Enter  name">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label  required">Sequence:</label>
				<input type="number" class="form-control" min="0" value="0" name="seq" >
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>



  