<style>
    .custom-checkbox {
    position: relative;
    display: inline-block;
    width: 20px;
    height: 20px;
}

.custom-checkbox input {
    opacity: 0;
    width: 0;
    height: 0;
}

.checkmark {
    position: absolute;
    top: 0px;
    left: 0px;
    height: 23px;
    width: 23px;
    background-color: #ccc;
    border-radius: 50%;
}

.custom-checkbox input:checked ~ .checkmark {
    background-color: red;
}

.custom-checkbox .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.custom-checkbox input:checked ~ .checkmark:after {
    display: block;
}

.custom-checkbox .checkmark:after {
    left: 8px;
    top: 3px;
    width: 7px;
    height: 13px;
    border: solid white;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
}

</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?=$title?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?=$title?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                               <h4><?=$title;?></h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                               </div>
                            
                                 <div class="card-content collapse show">
                                 <form class="ajaxsubmitMember members-enrollment needs-validation" action="<?=$action_url?>" method="post" enctype= multipart/form-data> 
                                 <div class="card-body card-dashboard">
                                 <h4 class="text-black">Pincode Details</h4>
                                 <div class="row">
                                    <input type="hidden" value="<?=@$country->code;?>" id="country" >
                                    <input type="hidden" value="<?=@$country->id;?>" id="country_id" name="country_id">
                                   
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">State</label>
                                        <select name="state" id="state" class="select2 form-select input-sm form-control select-sm" onchange="fetch_commissionaires(this.value)">
                                            <option value="">--Select--</option>
                                            <?php foreach($states as $state):?>
                                            <option value="<?=$state->id;?>,<?=$state->code;?>"><?=$state->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Commissionaires</label>
                                        <select name="commissionaires" id="commissionaires" class="select2 form-select form-control" onchange="fetch_district(this.value)"></select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">District</label>
                                        <select name="district" id="district" class="select2 form-select form-control" onchange="fetch_tehsil(this.value)"></select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Tehsil Zone</label>
                                        <select name="tehsil" id="tehsil" class="select2 form-select form-control" onchange="fetch_ward(this.value)" ></select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Ward Block</label>
                                        <select name="ward" id="ward" class="select2 form-select form-control" onchange="fetch_block(this.value)"></select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" >Block Nyay</label>
                                        <select name="block" id="block" class="select2 form-select form-control" onchange="fetch_panchayat(this.value)"></select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" >Panchayat Village</label>
                                        <select name="panchayat" id="panchayat" class="select2 form-select form-control" onchange="fetch_village(this.value)"></select>
                                    </div>
                                   </div>
                                   <div class="col-lg-2 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" >Village</label>
                                        <input type="text" name="village" id="village" class=" form-control input-sm" readonly>
                                    </div>
                                   </div>
                                   <div class="col-lg-3 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Pincode</label>
                                        <input type="text" name="pincode" id="pincode" class=" form-control  input-sm" readonly>
                                    </div>
                                   </div>
                                   <div class="col-lg-5 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="" >Permanent Address</label>
                                        <input type="text" name="address" id="address" class=" form-control  input-sm" placeholder="Enter Your Permanent Address">
                                    </div>
                                   </div>
                                   <div class="col-lg-4 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Street / House No/ Flat</label>
                                        <input type="text" name="street_house" id="street_house" class=" form-control  input-sm" placeholder="Enter Street / House No/ Flat" minlength="1" maxlength="3" >
                                    </div>
                                   </div>
                                   <div class="col-lg-4 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Family No (1-9)</label>
                                        <input type="number" name="family_no" id="family_no" class=" form-control  input-sm" placeholder="Enter Family No (1-9)" minlength="1" maxlength="1" >
                                    </div>
                                   </div>
                                   <div class="col-lg-4 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Members No (A-Z)</label>
                                        <input type="text" name="members_no" id="members_no" class=" form-control  input-sm" placeholder="Enter Members oN (A-Z)"  minlength="1" maxlength="1">
                                    </div>
                                   </div>
                                 </div>
                                
                                 <div class="row">
                                 <div class="col-lg-4">
                                    <h4 class="text-black mt-2">Members Details (<span class="text-danger" style="font-size:14px"> Scroll and fill all details </span>)</h4>
                                    </div>
                                    <div class="col-lg-8">
                                        <h4 class="text-danger float-right mt-2">
                                            If not any member than Check this Checkbox
                                            &nbsp;  
                                            <label class="custom-checkbox">
                                                <input type="checkbox" id="no_member" name="not_member" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </h4>
                                    </div>
                                  <div class="col-lg-12">
                                  <div class="table-responsive pt-1">
                                  <table class="table table-bordered base-style">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"><label class="required">First Name</label></th>
                                        <th scope="col"><label>Middle Name</label></th>
                                        <th scope="col"><label class="required">Last Name</label></th>
                                        <th scope="col"><label class="required">Father's Name</label></th>
                                        <th scope="col"><label class="required">D.O.B</label></th>
                                        <th scope="col"><label class="required">Gender</label></th>
                                        <th scope="col"><label class="required">Mobile</label></th>
                                        <th scope="col"><label >Email</label></th>
                                        <th scope="col"><label class="required">Profession</label></th>
                                        <th scope="col"><label class="required">Income/Day</label></th>
                                        <th scope="col"><label class="required">Aadhaar No</label></th>
                                        <th scope="col"><label>Pan No</label> </th>
                                        <th scope="col"><label>Voter ID</label></th>
                                        <th scope="col"><label>Head of the house </label></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <tr>
                                        <th scope="row"><input type="hidden" value="1" name="sr_no[]">1</th>
                                        <td><input type="text" class="form-control input-sm"  name="fname[]" placeholder="Enter First Name" style="width:150px"></td>
                                        <td><input type="text" class="form-control input-sm" name="mname[]" placeholder="Enter Middle Name"   style="width:150px"></td>
                                        <td><input type="text" class="form-control input-sm"  name="lname[]" placeholder="Enter Last Name"  style="width:150px"></td>
                                        <td><input type="text" class="form-control input-sm"  name="father_name[]"  placeholder="Enter Father's Name"   style="width:150px"></td>
                                        <td><input type="date" class="form-control input-sm"  name="dob[]"  style="width:150px"></td>
                                        <td><select  class="form-control input-sm"  name="gender[]"  style="width:150px">
                                            <option value="">--select--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control input-sm"  name="mobile[]" placeholder="Enter Mobile No"  style="width:150px"></td>
                                        <td><input type="text" class="form-control input-sm"  name="email[]" placeholder="Enter Email"  style="width:250px"></td>
                                        <td><input type="text" class="form-control input-sm"  name="profesion[]" placeholder="Enter Profession"  style="width:150px"></td>
                                        <td><select  class="form-control input-sm"  name="income[]"  style="width:150px">
                                            <option value="">--select income--</option>
                                            <?php foreach($income_master as $income):?>
                                            <option value="<?=$income->id;?>"><?=$income->title;?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control input-sm" name="aadhaar_no[]" placeholder="Enter Aadhaar No" style="width:150px"></td>
                                        <td><input type="text" class="form-control input-sm" name="pan_no[]" placeholder="Enter Pan Card No" style="width:150px"></td>
                                        <td><input type="text" class="form-control input-sm" name="voter_id[]" placeholder="Enter Voter ID" style="width:150px"></td>
                                        <td><input type="checkbox" class="form-control input-sm head_house_checkbox" value="1" name="head_house[]" ></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                  </div>
                                  </div>
                                 </div>
                               </div>
                               <div class="card-footer pb-5">
                               <div class="col-lg-3 float-right">
                               <a href="<?=base_url();?>members-enrollment" class="btn btn-primary"> Cancel</a>
                                    <button id="btnsubmit"  type="submit"class="btn btn-danger"> Submit</button>
                                   </div>
                               </div>
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
function fetch_commissionaires(stateValue) {
    var stateId = stateValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_commissionaires",
        method: "POST",
        data: {
            state: stateId,
        },
        success: function(data) {
            $("#commissionaires").html(data);
        },
    });
}

function fetch_district(commissionairesValue) {
    var commissionairesId = commissionairesValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_district",
        method: "POST",
        data: {
            commissionaires: commissionairesId,
        },
        success: function(data) {
            $("#district").html(data);
        },
    });
}

function fetch_tehsil(districtValue) {
    var districtId = districtValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_tehsil",
        method: "POST",
        data: {
            district: districtId,
        },
        success: function(data) {
            $("#tehsil").html(data);
        },
    });
}

function fetch_ward(tehsilValue) {
    var tehsilId = tehsilValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_ward",
        method: "POST",
        data: {
            tehsil: tehsilId,
        },
        success: function(data) {
            $("#ward").html(data);
        },
    });
}

function fetch_block(wardValue) {
    var wardId = wardValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_block",
        method: "POST",
        data: {
            ward: wardId,
        },
        success: function(data) {
            $("#block").html(data);
        },
    });
}

function fetch_panchayat(blockValue) {
    var blockId = blockValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_panchayat",
        method: "POST",
        data: {
            block: blockId,
        },
        success: function(data) {
            $("#panchayat").html(data);
        },
    });
}
function fetch_village(panchayatValue) {
    var panchayatId = panchayatValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_village",
        method: "POST",
        data: {
            panchayatId: panchayatId,
        },
        success: function(data) {
            $("#village").val(data);
        },
    });
}

$('body').on('change keyup', '[name="state"], [name="commissionaires"], [name="district"], [name="tehsil"], [name="ward"], [name="block"], [name="panchayat"], [name="street_house"], [name="family_no"], [name="members_no"]', function(e) {
    let _this = $(this);
    let countryCode = '000';
    let stateCode = '00';
    let commissionairesCode = '00';
    let districtCode = '0';
    let tehsilCode = '0';
    let wardCode = '00';
    let blockCode = '0';
    let panchayatCode = '0';
    let street_houseCode = '000';
    let family_noCode = '0';
    let members_noCode = '0';
    
    countryCode = $('#country').val() || countryCode;
    let stateValue =$('#state').val();
    stateCode = stateValue.split(',')[1] || stateCode;

    if($('#street_house').val())
    {
    street_houseCode = $('#street_house').val();
    }
    if($('#family_no').val())
    {
    family_noCode = $('#family_no').val();
    }
    if($('#members_no').val())
    {
    members_noCode = $('#members_no').val();
    }

    if($('#commissionaires').val()){
   let commissionairesValue =$('#commissionaires').val();
   commissionairesCode = commissionairesValue.split(',')[1] || commissionairesCode;
    }

    if( $('#district').val()){
   let districtValue = $('#district').val();
   districtCode = districtValue.split(',')[1] || districtCode;
    }

    if($('#tehsil').val()){
   let tehsilValue = $('#tehsil').val();
   tehsilCode = tehsilValue.split(',')[1] || tehsilCode;
    }


   if($('#ward').val()){
   let wardValue = $('#ward').val();
   wardCode = wardValue.split(',')[1] || wardCode;
   }

   if($('#block').val()){
   let blockValue = $('#block').val();
   blockCode = blockValue.split(',')[1] || blockCode;
   }
 
   if($('#panchayat').val()){
   let panchayatValue =$('#panchayat').val();
   panchayatCode = panchayatValue.split(',')[1] || panchayatCode;
   }
    
    let pincode = countryCode + stateCode + commissionairesCode + districtCode + tehsilCode + wardCode + blockCode + panchayatCode + street_houseCode + family_noCode + members_noCode;
    $('#pincode').val(pincode);
});



  
</script>
<script>


$(document).ready(function() {

    document.getElementById('members_no').addEventListener('input', function(e) {
        var value = e.target.value;
        var letter = value.replace(/[^a-zA-Z]/g, '').toUpperCase();
        e.target.value = letter;

        var numberOfRows = letter.charCodeAt(0) - 64;
        var tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';

        for (var i = 1; i <= numberOfRows; i++) {
            var row = document.createElement('tr');

            row.innerHTML = `
                <th scope="row"><input type="hidden" value="${i}" name="sr_no[]">${i}</th>
                <td><input type="text" class="form-control input-sm" name="fname[]" placeholder="Enter First Name" style="width:150px"></td>
                <td><input type="text" class="form-control input-sm" name="mname[]" placeholder="Enter Middle Name" style="width:150px"></td>
                <td><input type="text" class="form-control input-sm" name="lname[]" placeholder="Enter Last Name" style="width:150px"></td>
                <td><input type="text" class="form-control input-sm" name="father_name[]" placeholder="Enter Father's Name" style="width:150px"></td>
                <td><input type="date" class="form-control input-sm" name="dob[]" style="width:150px"></td>
                <td>
                    <select class="form-control input-sm" name="gender[]" style="width:150px">
                        <option value="">--select--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </td>
                <td><input type="text" class="form-control input-sm" name="mobile[]" placeholder="Enter Mobile No" style="width:150px"></td>
                <td><input type="text" class="form-control input-sm" name="email[]" placeholder="Enter Email" style="width:250px"></td>
                <td><input type="text" class="form-control input-sm" name="profesion[]" placeholder="Enter Profession" style="width:150px"></td>
                <td><select  class="form-control input-sm"  name="income[]"  style="width:150px">
                <option value="">--select income--</option>
                <!-- Populate income options dynamically -->
                <?php foreach($income_master as $income):?>
                <option value="<?=$income->id;?>"><?=$income->title;?></option>
                <?php endforeach;?>
                </select>
                </td>
                <td><input type="number" class="form-control input-sm" name="aadhaar_no[]" placeholder="Enter Aadhaar No" style="width:150px"></td>
                <td><input type="text" class="form-control input-sm" name="pan_no[]" placeholder="Enter Pan Card No" style="width:150px"></td>
                <td><input type="text" class="form-control input-sm" name="voter_id[]" placeholder="Enter Voter ID" style="width:150px"></td>
                <td><input type="checkbox" class="form-control input-sm head_house_checkbox" value="1" name="head_house[]"></td>
            `;

            tableBody.appendChild(row);
        }

        var checkboxes = document.querySelectorAll('.head_house_checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(function(otherCheckbox) {
                        if (otherCheckbox !== checkbox) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });

    
    });
});



$(document).ready(function() {
    // Initialize the form validation
    var form = $(".needs-validation");

    form.validate({
        rules: {
            "state": "required",
            "commissionaires": "required",
            "district": "required",
            "tehsil": "required",
            "ward": "required",
            "street_house": {
                required: true,
                maxlength: 3,
                minlength: 3
            },
            "family_no": {
                required: true,
                maxlength: 1,
                minlength: 1,
                digits: true
            },
            "members_no": {
                required: true,
                maxlength: 1,
                minlength: 1
            },
            "pincode": "required",
        },
        messages: {
            state: "Please Select State",
            commissionaires: "Please Select Commissionaires",
            district: "Please Select District",
            tehsil: "Please Select Tehsil Zone",
            ward: "Please Select Ward Block",
            street_house: {
                required: "Please Enter Street / House No/ Flat",
                maxlength: "Street / House No/ Flat Cannot Exceed 3 Characters",
                minlength: "Street / House No/ Flat Must Be Exactly 3 Characters"
            },
            family_no: {
                required: "Please Enter Family No (1-9)",
                maxlength: "Family No (1-9) Cannot Exceed 1 Digit",
                minlength: "Family No (1-9) Must Be Exactly 1 Digit",
                digits: "Family No (1-9) Must Be a Number"
            },
            members_no: {
                required: "Please Enter Members No (A-Z)",
                maxlength: "Members No (A-Z) Cannot Exceed 1 Character",
                minlength: "Members No (A-Z) Must Be Exactly 1 Character"
            },
            pincode: "Please Enter Pincode",
        },
        submitHandler: function(form) {
            // Validate all rows before submitting
            var allRowsValid = true;

            $('#table-body tr').each(function() {
                var $row = $(this);
                if (!validateRow($row)) {
                    allRowsValid = false;
                }
            });

            if (allRowsValid) {
                event.preventDefault(); // Submit the form only if all rows are valid
            } else {
                // alert_toastr("error", "Please fix the errors in the members' details section.");
            }
        },
        invalidHandler: function(event, validator) {
            event.preventDefault(); 
        }
    });

    function validateRow($row) {
        var isValid = true;
        $row.find('.error-message').remove();
        $row.find('input, select').removeClass('input-error select-error').removeClass('is-valid');
        // Check if the "not_member" checkbox is checked
        if ($('#no_member').is(':checked')) {
                // Skip validation for this row
                return isValid;
            }
        var fname = $row.find('input[name="fname[]"]');
        var lname = $row.find('input[name="lname[]"]');
        var fatherName = $row.find('input[name="father_name[]"]');
        var dob = $row.find('input[name="dob[]"]');
        var gender = $row.find('select[name="gender[]"]');
        var mobile = $row.find('input[name="mobile[]"]');
        var profession = $row.find('input[name="profesion[]"]');
        var aadhaarNo = $row.find('input[name="aadhaar_no[]"]');
        var panNo = $row.find('input[name="pan_no[]"]');
        var voterId = $row.find('input[name="voter_id[]"]');
        var income = $row.find('select[name="income[]"]');
        var headHouse = $row.find('input[name="head_house[]"]').is(':checked');

        // Validate required fields
        if (!fname.val()) {
            isValid = false;
            fname.addClass('input-error').after('<span class="error-message">Please Enter First Name</span>');
        } else {
            fname.addClass('is-valid');
        }

        if (!lname.val()) {
            isValid = false;
            lname.addClass('input-error').after('<span class="error-message">Please Enter Last Name</span>');
        } else {
            lname.addClass('is-valid');
        }

        if (!fatherName.val()) {
            isValid = false;
            fatherName.addClass('input-error').after('<span class="error-message">Please Enter Father\'s Name</span>');
        } else {
            fatherName.addClass('is-valid');
        }

        if (!dob.val()) {
            isValid = false;
            dob.addClass('input-error').after('<span class="error-message">Please Enter Date of Birth</span>');
        } else if (!isAtLeastOneHour(dob.val())) {
            isValid = false;
            dob.addClass('input-error').after('<span class="error-message">Date of birth must be at least one hour before the current time.</span>');
        } else {
            dob.addClass('is-valid');
        }

        if (!gender.val()) {
            isValid = false;
            gender.addClass('select-error').after('<span class="error-message">Please Select Gender</span>');
        } else {
            gender.addClass('is-valid');
        }

        if (!mobile.val()) {
            isValid = false;
            mobile.addClass('input-error').after('<span class="error-message">Please Enter Mobile No</span>');
        } else {
            mobile.addClass('is-valid');
        }

        if (!profession.val()) {
            isValid = false;
            profession.addClass('input-error').after('<span class="error-message">Please Enter Profession</span>');
        } else {
            profession.addClass('is-valid');
        }

        if (!income.val()) {
            isValid = false;
            income.addClass('select-error').after('<span class="error-message">Please select income</span>');
        } else {
            income.addClass('is-valid');
        }

        // Aadhaar validation
        if (!aadhaarNo.val()) {
            isValid = false;
            aadhaarNo.addClass('input-error').after('<span class="error-message">Please Enter Aadhaar No</span>');
        } else if (!/^\d{12}$/.test(aadhaarNo.val())) {
            isValid = false;
            aadhaarNo.addClass('input-error').after('<span class="error-message">Please Enter a Valid 12-Digit Aadhaar No</span>');
        } else if (isDuplicate(aadhaarNo.val(), 'aadhaar_no[]', $row)) {
            isValid = false;
            aadhaarNo.addClass('input-error').after('<span class="error-message">Duplicate Aadhaar Number found !</span>');
        } else {
            aadhaarNo.addClass('is-valid');
            $.ajax({
                    url: "<?=base_url();?>members-enrollment/validate_unique",
                    type: "post",
                    data: { 
                        field: 'aadhaar_no',
                        value: aadhaarNo.val()
                     },
                    async: false,
                    success: function(response) {
                        if (response === "false") {
                            isValid = false;
                            aadhaarNo.addClass('input-error').after('<span class="error-message">Duplicate Aadhaar Number found !</span>');
                            aadhaarNo.removeClass('is-valid');
                        } else {
                            isValid = true;
                            aadhaarNo.addClass('is-valid');
                        }
                    }
                });
        }

        // PAN validation
        if (panNo.val() && isDuplicate(panNo.val(), 'pan_no[]', $row)) {
            isValid = false;
            panNo.addClass('input-error').after('<span class="error-message">Duplicate PAN found!</span>');
        } else if (panNo.val()) {
            panNo.addClass('is-valid');
            $.ajax({
                    url: "<?=base_url();?>members-enrollment/validate_unique",
                    type: "post",
                    data: {
                        field: 'pan_no',
                        value: panNo.val() 
                    },
                    success: function(response) {
                        if (response === "false") {
                            isValid = false;
                            panNo.addClass('input-error').after('<span class="error-message">Duplicate PAN found!</span>');
                            panNo.removeClass('is-valid');
                        } else {
                            isValid = true;
                            panNo.addClass('is-valid');
                        }
                    }
                });
        }

        // Voter ID validation
        if (voterId.val() && isDuplicate(voterId.val(), 'voter_id[]', $row)) {
            isValid = false;
            voterId.addClass('input-error').after('<span class="error-message">Duplicate Voter ID found!</span>');
        } else if (voterId.val()) {
            voterId.addClass('is-valid');
            $.ajax({
                    url: "<?=base_url();?>members-enrollment/validate_unique",
                    type: "post",
                    data: {
                        field: 'voter_id',
                        value: voterId.val() 
                    },
                    async: false,
                    success: function(response) {
                        if (response === "false") {
                            isValid = false;
                            voterId.addClass('input-error').after('<span class="error-message">Duplicate Voter ID found!</span>');
                            voterId.removeClass('is-valid');
                        } else {
                            isValid = true;
                            voterId.addClass('is-valid');
                        }
                    }
                });
        }

        return isValid;
    }

    $('#table-body').on('input change', 'input, select', function() {
        var $row = $(this).closest('tr');
        validateRow($row);
    });
    function isAtLeastOneHour(dob) {
    var birthDate = new Date(dob);
    var oneHourAgo = new Date(new Date().getTime() - 60 * 60 * 1000); // Current time minus 1 hour
    return birthDate <= oneHourAgo;
}
    // function isAtLeast18(dob) {
    //     var birthDate = new Date(dob);
    //     var today = new Date();
    //     var age = today.getFullYear() - birthDate.getFullYear();
    //     var m = today.getMonth() - birthDate.getMonth();
    //     if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    //         age--;
    //     }
    //     return age >= 18;
    // }

    function isDuplicate(value, name, currentRow) {
        var isDuplicate = false;
        $('input[name="' + name + '"]').each(function() {
            if ($(this).val() === value && $(this).closest('tr').get(0) !== currentRow.get(0)) {
                isDuplicate = true;
            }
        });
        return isDuplicate;
    }

    $('.ajaxsubmitMember').on('submit', function(event) {
        event.preventDefault();
        var $this = $(this);
        var form_data = new FormData(this);
        var form_valid = true;

        // Validate all rows
        $('#table-body tr').each(function() {
            var $row = $(this);
          
            form_valid = validateRow($row) && form_valid;
        });
        var notMemberChecked = $('#no_member').is(':checked');
        form_data.append('not_member', notMemberChecked ? 1 : 0);
        if (!notMemberChecked) {
        var headHouse = $('input[name="head_house[]"]').is(':checked');
        if (!headHouse) {
            form_valid = false; // Set form_valid to false if no head of house is checked
            alert_toastr("error", "Please check at least one head of house checkbox");
        }
    }

        if (form_valid && $this.valid()) {
            setTimeout(function() {
                $.ajax({
                    url: $this.attr("action"),
                    type: $this.attr("method"),
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        data = JSON.parse(data);
                        if (data.res === 'success') {
                            if($this.hasClass("members-enrollment")) {
                                setTimeout(function(){
                                    window.location=data.redirect_url;
                                },1000);
                            }
                        }
                        if (data.errors) {
                            $.each(data.errors, function(key, value) {
                                $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                            });
                        }
                        alert_toastr(data.res, data.msg);
                    }
                });
            }, 100);
        } else {
            alert_toastr("error", "Please fix the errors in the members' details section.");
        }
        return false;
    });
});


</script>
