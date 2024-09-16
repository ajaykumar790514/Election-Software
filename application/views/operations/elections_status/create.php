<script>
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            state: "required",
            commissionaires: "required",
            district: "required",
            tehsil: "required",
            ward: "required",
            election_date: {
                required: true,
                // remote: {
                //     url: "<?=base_url();?>elections-status/check_election_date",
                //     type: "post",
                //     data: {
                //         id:'',
                //         pincode: function() {
                //             return $("#pincode1").val();
                //         },
                //         election_date: function() {
                //             return $("input[name='election_date']").val();
                //         },
                //         level_id: function() {
                //             return $("select[name='level_id']").val();
                //         }
                //     }
                // }
            },
            level_id: "required",
            validity: "required",
            election_start_time: "required",
        },
        messages: {
            state: "Please Select State",
            commissionaires: "Please Select Commissionaires",
            district: "Please Select District",
            tehsil: "Please Select Tehsil Zone",
            ward: "Please Select Ward Block",
            election_date: {
                required: "Please select election date",
                remote: "Election date already exists for the selected block, please choose a different date."
            },
            level: "Please enter level",
            validity: "Please enter validity",
            election_start_time: "Please select start time"
        }
    });
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-2 pb-2">
<div class="row">
<input type="hidden" value="<?=@$country->code;?>" id="country" >
      <input type="hidden" value="<?=@$country->id;?>" id="country_id" name="country_id">
     
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" class="required">Select State</label>
          <select name="state" id="state1" class="select2 form-select form-control" onchange="fetch_commissionaires1(this.value)">
              <option value="">--Select--</option>
              <?php foreach($states as $state):?>
              <option value="<?=$state->id;?>,<?=$state->code;?>"><?=$state->name;?></option>
              <?php endforeach;?>
          </select>
      </div>
     </div>
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" class="required">Select Commissionaires</label>
          <select name="commissionaires" id="commissionaires1" class="select2 form-select form-control" onchange="fetch_district1(this.value)"></select>
      </div>
     </div>
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" class="required">Select District</label>
          <select name="district" id="district1" class="select2 form-select form-control" onchange="fetch_tehsil1(this.value)"></select>
      </div>
     </div>
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" class="required">Select Tehsil Zone</label>
          <select name="tehsil" id="tehsil1" class="select2 form-select form-control" onchange="fetch_ward1(this.value)" ></select>
      </div>
     </div>
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" class="required">Select Ward Block</label>
          <select name="ward" id="ward1" class="select2 form-select form-control" onchange="fetch_block1(this.value)"></select>
      </div>
     </div>
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" >Select Block Nyay</label>
          <select name="block" id="block1" class="select2 form-select form-control" onchange="fetch_panchayat1(this.value)"></select>
      </div>
     </div>
     <div class="col-lg-6 col-sm-12 col-md-6">
      <div class="form-group">
          <label for="" >Select Panchayat Village</label>
          <select name="panchayat" id="panchayat1" class="select2 form-select form-control"></select>
      </div>
     </div>
		<div class="col-lg-6 col-sm-12 col-md-6">
    <div class="form-group ">
       <label for="name">Select Blocks :</label>
       <select name="group_id" class="form-control group_id1"  id="group_id1">
        </select>
    </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-md-6">
    <div class="form-group mb-0">
       <label for="level_id" class="required">Level  :</label>
       <select name="level_id" class="form-control">
        <option value="">--Select--</option>
        <?php foreach($levels as $level):?>
            <option value="<?=$level->id;?>"><?=$level->level;?></option>
         <?php endforeach;?>   
       </select>
    </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-md-6">
    <div class="form-group mb-0">
       <label for="name" class="required">Election Date :</label>
       <input type="date" name="election_date" class="form-control" min="<?=date('Y-m-d');?>" >
    </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-md-6">
    <div class="form-group mb-0">
       <label for="name" class="required">Election Start Time :</label>
       <input type="time" name="election_start_time" class="form-control" >
    </div>
    </div>
 
    <div class="col-lg-6 col-sm-12 col-md-6">
    <div class="form-group mb-0">
       <label for="name" class="required">Validity : ( In  Hours )</label>
       <input type="number" name="validity"  placeholder="Enter Validity" class="form-control" min="1" >
    </div>
    <input type="hidden" name="pincode" id="pincode1">
    </div>
  
</div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>


<script>
function fetch_commissionaires1(stateValue) {
    var stateId = stateValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_commissionaires",
        method: "POST",
        data: {
            state: stateId,
        },
        success: function(data) {
            $("#commissionaires1").html(data);
        },
    });
}

function fetch_district1(commissionairesValue) {
    var commissionairesId = commissionairesValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_district",
        method: "POST",
        data: {
            commissionaires: commissionairesId,
        },
        success: function(data) {
            $("#district1").html(data);
        },
    });
}

function fetch_tehsil1(districtValue) {
    var districtId = districtValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_tehsil",
        method: "POST",
        data: {
            district: districtId,
        },
        success: function(data) {
            $("#tehsil1").html(data);
        },
    });
}

function fetch_ward1(tehsilValue) {
    var tehsilId = tehsilValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_ward",
        method: "POST",
        data: {
            tehsil: tehsilId,
        },
        success: function(data) {
            $("#ward1").html(data);
        },
    });
}

function fetch_block1(wardValue) {
    var wardId = wardValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_block",
        method: "POST",
        data: {
            ward: wardId,
        },
        success: function(data) {
            $("#block1").html(data);
        },
    });
}

function fetch_panchayat1(blockValue) {
    var blockId = blockValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_panchayat",
        method: "POST",
        data: {
            block: blockId,
        },
        success: function(data) {
            $("#panchayat1").html(data);
        },
    });
}


$('body').on('change keyup', '#state1,#commissionaires1,#district1,#tehsil1,#ward1,#block1,#panchayat1', function(e) {
    let _this = $(this);
    let countryCode = '000';
    let stateCode = '00';
    let commissionairesCode = '00';
    let districtCode = '0';
    let tehsilCode = '0';
    let wardCode = '00';
    let blockCode = '0';
    let panchayatCode = '0';
    
    countryCode = $('#country').val() || countryCode;
    let stateValue =$('#state1').val();
    stateCode = stateValue.split(',')[1] || stateCode;

  

    if($('#commissionaires1').val()){
   let commissionairesValue =$('#commissionaires1').val();
   commissionairesCode = commissionairesValue.split(',')[1] || commissionairesCode;
    }

    if( $('#district1').val()){
   let districtValue = $('#district1').val();
   districtCode = districtValue.split(',')[1] || districtCode;
    }

    if($('#tehsil1').val()){
   let tehsilValue = $('#tehsil1').val();
   tehsilCode = tehsilValue.split(',')[1] || tehsilCode;
    }


   if($('#ward1').val()){
   let wardValue = $('#ward1').val();
   wardCode = wardValue.split(',')[1] || wardCode;
   }

   if($('#block1').val()){
   let blockValue = $('#block1').val();
   blockCode = blockValue.split(',')[1] || blockCode;
   }
 
   if($('#panchayat1').val()){
   let panchayatValue =$('#panchayat1').val();
   panchayatCode = panchayatValue.split(',')[1] || panchayatCode;
   }
    
    let pincode = countryCode + stateCode + commissionairesCode + districtCode + tehsilCode + wardCode + blockCode + panchayatCode;
    $('#pincode1').val(pincode);

    $.ajax({
        url: "<?=base_url();?>Operations/fetch_group",
        method: "POST",
        data: {
          pincode: pincode,
        },
        success: function(data) {
            $("#group_id1").html(data);
        },
    });
});



  
</script>
  