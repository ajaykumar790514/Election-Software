<script>
  $(document).ready(function() {
    $(".needs-validation").validate({
      rules: {
        level: {
          required: true,
          remote: "<?=$remote;?>null/level"
        },
      },
      messages: {
        level: {
          required: "Please Enter Level",
          remote: "Level Already Exists!"
        },
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label  required">Enter Level :</label>
				<input type="text" class="form-control form-control" name="level" placeholder="Enter  Level">
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>



  