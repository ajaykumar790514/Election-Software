<script>
  $(document).ready(function() {
    $.validator.addMethod("exactlength", function(value, element, param) {
      return this.optional(element) || value.length == param;
    }, "Please enter exactly {0} digits.");

    $(".needs-validation").validate({
      rules: {
        title: {
          required: true,
          remote: "<?=$remote;?>null/title"
        },
        seq: {
          required: true,
          digits: true
        },
      },
      messages: {
        title: {
          required: "Please Enter Income Title",
          remote: "Income Title Already Exists!"
        },
        seq: {
          required: "Please Enter Income SEQ!",
          digits: "Income SEQ  Must be a Number"
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
                <label class="form-check-label required">Seq :</label>
				<input type="number" class="form-control form-control" name="seq" placeholder="Enter  Seq">
            </div>
        </div>
		<div class="col-lg-9 col-sm-9 col-md-9">
            <div class="form-group">
                <label class="form-check-label  required">Income Title :</label>
				<input type="text" class="form-control form-control" name="title" placeholder="Enter  Title">
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>



  