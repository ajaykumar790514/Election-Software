<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?=$title?></h3>
            </div>
        </div>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">
                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-content collapse show" id="tb">
                                <div class="row justify-content-center p-1">
                                    <div class="col-md-12">
                                        <form class="form ajaxsubmit members-enrollment reload-page" action="<?=base_url()?>member-profile/change-password" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="duration">Old Password <sup>*</sup></label>
                                                <input type="password" class="form-control" placeholder="Old Password" name="old_password" >
                                            </div>

                                            <div class="form-group">
                                                <label for="duration">New Password <sup>*</sup></label>
                                                <input type="password" class="form-control" placeholder="New Password" name="password" >
                                            </div>

                                            <div class="form-group">
                                                <label for="duration">Confirm password <sup>*</sup></label>
                                                <input type="password" class="form-control" placeholder="Confirm password" name="conf_password" >
                                            </div>

                                            <div class="form-group">
                                                <label for="duration"><br></label>
                                                <input type="submit" class="btn btn-primary btn-sm" placeholder="Duration" name="name" value="Change Password">
                                            </div>
                                        </form>
                                    </div>
                                </div>

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
