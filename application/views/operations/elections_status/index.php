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
                                <h4 class="card-title">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever=" <?=$title;?>" data-url="<?=$new_url?>" class="btn btn-primary btn-sm" class="btn btn-primary btn-sm add-btn"> 
                                        <i class="ft-plus"></i>  <?=$title;?>
                                    </a>
                                </h4>
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

                            <div class="card-header p-1">
                                <form autocomplete="off" class="form dynamic-tb-search" action="<?=$tb_url?>" method="POST" enctype="multipart/form-data" tagret-tb="#tb">
                                        <div class="row justify-content-center">
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> State</label>
                                                <select name="state" id="state2" class="select2 form-select form-control input-sm form-control-sm" onchange="fetch_commissionaires2(this.value)">
                                                    <option value="">--Select--</option>
                                                    <?php foreach($states as $state):?>
                                                    <option value="<?=$state->id;?>,<?=$state->code;?>"><?=$state->name;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> Commissionaires</label>
                                                <select name="commissionaires" id="commissionaires2" class="select2 form-select form-control input-sm" onchange="fetch_district2(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> District</label>
                                                <select name="district" id="district2" class="select2 form-select form-control input-sm" onchange="fetch_tehsil2(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> Tehsil Zone</label>
                                                <select name="tehsil" id="tehsil2" class="select2 form-select form-control input-sm" onchange="fetch_ward2(this.value)" ></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> Ward Block</label>
                                                <select name="ward" id="ward2" class="select2 form-select form-control input-sm" onchange="fetch_block2(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" > Block Nyay</label>
                                                <select name="block" id="block2" class="select2 form-select form-control input-sm" onchange="fetch_panchayat2(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" > Panchayat Village</label>
                                                <select name="panchayat" id="panchayat2" class="select2 form-select form-control input-sm"></select>
                                            </div>
                                        </div>
                                           <div class="col-md-3 col-lg-2 col-sm-12">
                                                <div class="form-group mb-0">
                                                    <label for="name"> Blocks</label>
                                                    <select name="group_id" id="group_id2" class="form-control input-sm select2" >
                                                      <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                            </div>
                                           
                                           <div class="col-md-3 col-lg-2 col-sm-12">
                                                <div class="form-group mb-0">
                                                    <label for="name">Election Date</label>
                                                    <input type="date" autocomplete="false" name="date" id="name" class="form-control input-sm"  />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-4 col-sm-12">
                                                <div class="form-group mb-0">
                                                    <label for="name">Search</label>
                                                    <input autocomplete="false" name="name" id="name" class="form-control input-sm " placeholder="Search Pincode / Blocks ..." />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-2 col-sm-12"></div>
                                        </div>
                                    </form>
                                   </div>
                            
                                 <div class="card-content collapse show" id="tb">
                                

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Base style table -->

        </div>
    </div>
</div>
<input type="hidden" id="pincode2">
<input type="hidden" value="<?=@$country->code;?>" id="country" >
<input type="hidden" value="<?=@$country->id;?>" id="country_id" name="country_id">
<!-- END: Content-->
<script>
    function fetch_commissionaires2(stateValue) {
    var stateId = stateValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_commissionaires",
        method: "POST",
        data: {
            state: stateId,
        },
        success: function(data) {
            $("#commissionaires2").html(data);
        },
    });
}

function fetch_district2(commissionairesValue) {
    var commissionairesId = commissionairesValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_district",
        method: "POST",
        data: {
            commissionaires: commissionairesId,
        },
        success: function(data) {
            $("#district2").html(data);
        },
    });
}

function fetch_tehsil2(districtValue) {
    var districtId = districtValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_tehsil",
        method: "POST",
        data: {
            district: districtId,
        },
        success: function(data) {
            $("#tehsil2").html(data);
        },
    });
}

function fetch_ward2(tehsilValue) {
    var tehsilId = tehsilValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_ward",
        method: "POST",
        data: {
            tehsil: tehsilId,
        },
        success: function(data) {
            $("#ward2").html(data);
        },
    });
}

function fetch_block2(wardValue) {
    var wardId = wardValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_block",
        method: "POST",
        data: {
            ward: wardId,
        },
        success: function(data) {
            $("#block2").html(data);
        },
    });
}

function fetch_panchayat2(blockValue) {
    var blockId = blockValue.split(',')[0];
    $.ajax({
        url: "<?=base_url();?>Enrollment/fetch_panchayat",
        method: "POST",
        data: {
            block: blockId,
        },
        success: function(data) {
            $("#panchayat2").html(data);
        },
    });
}


$('body').on('change keyup', '#state2,#commissionaires2,#district2,#tehsil2,#ward2,#block2,#panchayat2', function(e) {
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
    let stateValue =$('#state2').val();
    stateCode = stateValue.split(',')[1] || stateCode;

  

    if($('#commissionaires2').val()){
   let commissionairesValue =$('#commissionaires2').val();
   commissionairesCode = commissionairesValue.split(',')[1] || commissionairesCode;
    }

    if( $('#district2').val()){
   let districtValue = $('#district2').val();
   districtCode = districtValue.split(',')[1] || districtCode;
    }

    if($('#tehsil2').val()){
   let tehsilValue = $('#tehsil2').val();
   tehsilCode = tehsilValue.split(',')[1] || tehsilCode;
    }


   if($('#ward2').val()){
   let wardValue = $('#ward2').val();
   wardCode = wardValue.split(',')[1] || wardCode;
   }

   if($('#block2').val()){
   let blockValue = $('#block2').val();
   blockCode = blockValue.split(',')[1] || blockCode;
   }
 
   if($('#panchayat2').val()){
   let panchayatValue =$('#panchayat2').val();
   panchayatCode = panchayatValue.split(',')[1] || panchayatCode;
   }
    
    let pincode = countryCode + stateCode + commissionairesCode + districtCode + tehsilCode + wardCode + blockCode + panchayatCode;
    $('#pincode2').val(pincode);

    $.ajax({
        url: "<?=base_url();?>Operations/fetch_group",
        method: "POST",
        data: {
          pincode: pincode,
        },
        success: function(data) {
            $("#group_id2").html(data);
        },
    });
});


</script>
