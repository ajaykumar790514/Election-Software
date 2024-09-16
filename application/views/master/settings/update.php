<script>
  $(document).ready(function() {
    $(".needs-validation").validate({
      rules: {
        type: {
          required: true,
          remote: "<?=$remote;?>null/type"
        },
        value:"required",
        day_type:"required",
      },
      messages: {
        type: {
          required: "Please Select Setting Type",
          remote: "Type Already Exists!"
        },
        value:"Please Enter Settings Value",
        day_type:"Please Select Days Type",
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<div class="col-lg-4 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label  required">Enter Level :</label>
				    <select  class="form-control form-control" name="type" >
          <option value="">--Select--</option>
          <option value="Age" <?php if($value->type=='Age'){ echo "selected" ;};?> >Age</option>
          <option value="Tenure" <?php if($value->type=='Tenure'){ echo "selected" ;};?> >Tenure</option>
            </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label  required">Days Type :</label>
				    <select  class="form-control form-control" name="day_type" >
          <option value="">--Select--</option>
          <option value="Day" <?php if($value->day_type=='Day'){ echo "selected" ;};?> >Day</option>
          <option value="Month" <?php if($value->day_type=='Month'){ echo "selected" ;};?> >Month</option>
          <option value="Year" <?php if($value->day_type=='Year'){ echo "selected" ;};?> >Year</option>
            </select>
            </div>
        </div>
		<div class="col-lg-4 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label  required">Enter Value :</label>
				<input type="number" class="form-control form-control" value="<?=$value->value;?>" name="value" placeholder="Enter  Settings Value">
            </div>
        </div>
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>



  