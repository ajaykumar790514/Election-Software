<script>
  $(document).ready(function() {
    $(".needs-validation").validate({
      rules: {
        state: "required",
        commissionaires: "required",
        district: "required",
        tehsil: "required",
        
      },
      messages: {
        state: "Please select state!",
        commissionaires: "Please select commissionaires!",
        district: "Please select district!",
        tehsil: "Please select tehsil!"
      },
    });
  });
</script>

<!-- Form -->
<div class="card-content collapse show">
    <div class="card-body">
        <div class="form-body w-100">
        <form class="form ajaxsubmitLocation load-tb needs-validation" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" value="<?=@$country->code;?>" id="country" >
                <input type="hidden" value="<?=@$country->id;?>" id="country_id" name="country_id">
                <div class="form-group col-lg-2">
                    <label for="" class="required">State</label>
                    <select name="state" id="state" class="input-sm form-select form-control select-sm" onchange="fetch_commissionaires(this.value)">
                       <option value="">--Select--</option>
                       <?php foreach($states as $state):?>
                       <option value="<?=$state->id;?>,<?=$state->code;?>"><?=$state->name;?></option>
                       <?php endforeach;?>
                       </select>
                </div>

                <div class="form-group col-lg-2">
                    <label for="" class="required">Commissionaires</label>
                    <select name="commissionaires" id="commissionaires" class="input-sm form-select form-control" onchange="fetch_district(this.value)"></select>
                </div>

                <div class="form-group col-lg-2">
                    <label for="" class="required">District</label>
                    <select name="district" id="district" class="input-sm form-select form-control" onchange="fetch_tehsil(this.value)"></select>
                </div>

                <div class="form-group col-lg-2">
                    <label for="" class="required">Tehsil Zone</label>
                    <select name="tehsil" id="tehsil" class=" form-select form-control input-sm"></select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="" class="required">Pincode</label>
                    <input type="text" name="pincode" id="pincode" class=" form-control  input-sm" readonly >
                </div>
                <div class="form-group col-lg-2" style="margin-top: 28px;">
                <button type="submit"id="saveBtn" class="btn btn-primary btn-sm mr-1">
                <i class="ft-check"></i> Save
               </button>
                </div>
            </div>
            </form>
            <div class="table-responsive pt-1">
            <table class="table table-striped table-bordered base-style" id="locationTable">
                <thead>
                    <tr>
                        <th>Sr. no.</th>
                        <th>Name</th>
                        <th>User Role</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>Commissionaires</th>
                        <th>District</th>
                        <th>Tehsil Zone</th>
                        <th>Pincode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;foreach($locations as $location):?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><?=$location->admin_name;?> ( <?=$location->mobile;?> )</td>
                        <td><?=$location->role_name;?></td>
                        <td><?=$location->country_name;?> ( <?=$location->country_code;?> )</td>
                        <td><?=$location->state_name;?> ( <?=$location->state_code;?> )</td>
                        <td><?=$location->commissionaires_name;?> ( <?=$location->commissionaires_code;?> )</td>
                        <td><?=$location->district_name;?> ( <?=$location->district_code;?> )</td>
                        <td><?=$location->tehsil_name;?> ( <?=$location->tehsil_code;?> )</td>
                        <td><?=$location->pincode;?></td>
                        <td>
                        <a href="javascript:void(0)" class="update-action" data-id="<?=$location->id;?>" title="Update">
                         <i class="la la-pencil-square"></i>
                        </a>
                         <a href="javascript:void(0)" class="delete-action" data-id="<?=$location->id;?>" title="Delete">
                           <i class="la la-trash"></i>
                         </a>
                        </td>
                    </tr>
                    <?php $i++; endforeach;?>
                </tbody>
               </table>
            </div>    
        </div>
        <div class="row">
            <div class="col-lg-11"></div>
            <div class="col-lg-1">
            <button type="reset" data-dismiss="modal" class="btn btn-sm btn-danger mr-1">
                Cancel
            </button>
            </div>
        </div>
    <!-- End: form -->
    </div>
</div>
<input type="hidden" value="<?=@$user_id;?>" id="user_id" name="user_id">

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

    // Update pincode based on selected values
    $('body').on('change', '[name="state"], [name="commissionaires"], [name="district"], [name="tehsil"]', function(e) {
      let countryCode = '000';
      let stateCode = '00';
      let commissionairesCode = '00';
      let districtCode = '0';
      let tehsilCode = '0';

      countryCode = $('#country').val() || countryCode;
      let stateValue = $('#state').val();
      stateCode = stateValue.split(',')[1] || stateCode;

      if ($('#commissionaires').val()) {
        let commissionairesValue = $('#commissionaires').val();
        commissionairesCode = commissionairesValue.split(',')[1] || commissionairesCode;
      }

      if ($('#district').val()) {
        let districtValue = $('#district').val();
        districtCode = districtValue.split(',')[1] || districtCode;
      }

      if ($('#tehsil').val()) {
        let tehsilValue = $('#tehsil').val();
        tehsilCode = tehsilValue.split(',')[1] || tehsilCode;
      }

      let pincode = countryCode + stateCode + commissionairesCode + districtCode + tehsilCode;
      $('#pincode').val(pincode);
    });
$(document).on("submit", '.ajaxsubmitLocation', function(event) {
    event.preventDefault(); 
    $this = $(this);
    if ($this.hasClass("append")) {
        var append_data = $($this.attr('append-data')).val();
        $(this).append('<input type="hidden" name="append" value="'+append_data+'" /> ');

    }
    var form_data = new FormData(this);
    form_valid = true;
    if ($this.hasClass("validate-form")) {
        if ($this.valid()) {
            form_valid = true;
        }
        else{
            form_valid = true;
        }
    }
    setTimeout(function() {
        if (form_valid == true) {
            $.ajax({
                url: $this.attr("action"),
                type: $this.attr("method"),
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.res=='success') {
                        loadTable();
                        $this[0].reset();
                        $('#state').empty();
                        $('#commissionaires').empty();
                        $('#district').empty();
                        $('#tehsil').empty();
                        $('#saveBtn')
                            .text('Save')      // Reset the button text
                            .removeAttr('data-id')  // Remove data-id attribute
                            .prop('disabled', true);  // Disable the button 
                    }
                    if (data.errors) {
                        $.each(data.errors,function(key,value){
                            $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                        })
                    }
                    alert_toastr(data.res,data.msg);
                }
            })
        }
    }, 100);
    return false;
})
function loadTable() {
    $.ajax({
        url: "<?=base_url();?>users/load_table",
        method: "GET",
        data:{user_id:$('#user_id').val()},
        success: function(data) {
            $("#locationTable tbody").html(data);
        }
    });
}


$(document).on('click', '.update-action', function() {
    var id = $(this).data('id');
    $.ajax({
        url: "<?=base_url();?>users/get_location_by_id",
        method: "POST",
        data: { id: id },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.res === 'success') {
                var location = result.data;

                // Populate states dropdown with all states and select the correct one
                $('#state').empty().append('<option value="">--Select--</option>');
                $.each(result.states, function(index, state) {
                    var selected = (state.id === location.state_id) ? ' selected' : '';
                    $('#state').append('<option value="' + state.id + ',' + state.code + '"' + selected + '>' + state.name + '</option>');
                });

                // Populate commissionaires dropdown
                $('#commissionaires').empty().append('<option value="">--Select--</option>');
                $.each(result.commissionaires, function(index, commissionaire) {
                    var selected = (commissionaire.id === location.commissionaires_id) ? ' selected' : '';
                    $('#commissionaires').append('<option value="' + commissionaire.id + ',' + commissionaire.code + '"' + selected + '>' + commissionaire.name + '</option>');
                });

                // Populate districts dropdown
                $('#district').empty().append('<option value="">--Select--</option>');
                $.each(result.districts, function(index, district) {
                    var selected = (district.id === location.district_id) ? ' selected' : '';
                    $('#district').append('<option value="' + district.id + ',' + district.code + '"' + selected + '>' + district.name + '</option>');
                });

                // Populate tehsil dropdown
                $('#tehsil').empty().append('<option value="">--Select--</option>');
                $.each(result.tehsils, function(index, tehsil) {
                    var selected = (tehsil.id === location.tehsil_id) ? ' selected' : '';
                    $('#tehsil').append('<option value="' + tehsil.id + ',' + tehsil.code + '"' + selected + '>' + tehsil.name + '</option>');
                });

                $('#country').val(location.country_code);
                $('#country_id').val(location.country_id);
                $('#user_id').val(location.admin_id);
                $('#pincode').val(location.pincode);

              $('.ajaxsubmitLocation')
                    .attr('action', '<?=base_url();?>users/location_save/' + location.admin_id + '/' + id)
                    .find('#saveBtn')
                    .text('Update')
                    .attr('data-id', id)
                    .prop('disabled', false); 
            } else {
                alert_toastr(result.res, result.msg);
            }
        }
    });
});

    // Handle click event for delete button
    $(document).on('click', '.delete-action', function() {
      var id = $(this).data('id');
      if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
          url: "<?=base_url();?>users/delete_location",
          method: "POST",
          data: { id: id },
          success: function(data) {
            data = JSON.parse(data);
            if (data.res == 'success') {
              loadTable();
            }
            alert_toastr(data.res, data.msg);
          }
        });
      }
    });
// Reset form and enable the Save button on modal close
$(document).on('click', '[data-dismiss="modal"]', function() {
    $('.ajaxsubmitLocation')[0].reset();  // Reset the form
    $('#saveBtn').prop('disabled', false);  // Enable the Save button
});
</script>