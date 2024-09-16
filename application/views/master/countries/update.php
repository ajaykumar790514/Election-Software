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
          exactlength: 3,
          digits: true
        },
      },
      messages: {
        name: {
          required: "Please Enter Country Name",
          remote: "Country Name Already Exists!"
        },
        code: {
          required: "Please Enter Country Code!",
          exactlength: "Country Code Must Be Exactly 3 Digits",
          digits: "Country Code Must be a Number"
        },
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
     <div class="col-lg-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="form-check-label required">Code :</label>
				<input type="number" class="form-control form-control" value="<?=$value->code;?>" name="code" placeholder="Enter  code">
            </div>
        </div>
		<div class="col-lg-9 col-sm-9 col-md-9">
            <div class="form-group">
                <label class="form-check-label  required">Country Name :</label>
				<input type="text" class="form-control form-control" value="<?=$value->name;?>" name="name" placeholder="Enter  name">
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>



  