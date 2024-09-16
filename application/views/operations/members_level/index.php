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
                                 All Members Level Status
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
                                                <select name="state" id="state" class="select2 form-select form-control input-sm form-control-sm" onchange="fetch_commissionaires(this.value)">
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
                                                <select name="commissionaires" id="commissionaires" class="select2 form-select form-control input-sm" onchange="fetch_district(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> District</label>
                                                <select name="district" id="district" class="select2 form-select form-control input-sm" onchange="fetch_tehsil(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> Tehsil Zone</label>
                                                <select name="tehsil" id="tehsil" class="select2 form-select form-control input-sm" onchange="fetch_ward(this.value)" ></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> Ward Block</label>
                                                <select name="ward" id="ward" class="select2 form-select form-control input-sm" onchange="fetch_block(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" > Block Nyay</label>
                                                <select name="block" id="block" class="select2 form-select form-control input-sm" onchange="fetch_panchayat(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" > Panchayat Village</label>
                                                <select name="panchayat" id="panchayat" class="select2 form-select form-control input-sm"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-sm-12">
                                            <div class="form-group">
                                                <label for="" class="required"> levels</label>
                                                <select name="level" id="level" class="select2 form-select form-control input-sm form-control-sm">
                                                    <option value="">--Select--</option>
                                                    <?php foreach($levels as $level):?>
                                                    <option value="<?=$level->id;?>"><?=$level->level;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label for="name">Search</label>
                                                    <input type="text" class="form-control input-sm" name="name" id="name" placeholder="Search  Name / Mobile / Email / Aadhaar / Level..." />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-5 col-sm-12"></div>
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
<!-- END: Content-->
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
</script>
