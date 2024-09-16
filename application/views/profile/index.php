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

                    <style type="text/css">
                        .profile-pic{
                            position: relative;
                            width: 150px;
                            height: 150px;
                            margin-bottom: 15px;
                            border-radius: 50%;
                            border: 2px solid blueviolet ;

                        }

                        .profile-pic input{
                            display: none;
                            
                        }
                        .profile-pic img{
                            position: absolute;
                            width: 100%;
                            max-width: 150px;
                            height: 100%;
                            max-height: 150px;
                            border-radius: 50%;
                            border: 2px solid blueviolet ;

                        }
                        .profile-pic label{
                                position: absolute;
                                bottom: 0;
                                margin: auto;
                                text-align: center;
                                height: 22%;
                                color: white;
                                /* background: #80808075; */
                                width: 100%;
                                cursor: pointer;
                                z-index: 0;
                        }
                    </style>

                     <?php if($user->user_role==1 || $user->user_role > 2){?> 
                    <div class="col-md-12">
                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>profile/update" method="POST" enctype="multipart/form-data">
                            <div class="profile-pic">
                                <div></div>
                                <input id="profile-pic" type="file" class="onchange-submit" accept="image/*" name="photo">
                                <img  src="<?=img_base_url()?><?=$user->photo?>" alt="<?=$user->name?>">
                                <label for="profile-pic">Change</label>
                            </div>

                        </form>
                       
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                           
                           
                            <div class="card-content collapse show" id="tb">
                                <div class="row justify-content-center p-1">
                                    <div class="col-md-12">
                                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>profile/update" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="duration">Name <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?=$user->name?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="duration">Email <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Email" name="email" value="<?=$user->email?>">
                                            </div>
                                             <?php if($user->user_role==1 || $user->user_role==2){?>
                                            <div class="form-group">
                                                <label for="duration">Username <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Username" name="username" value="<?=$user->username?>">
                                            </div>
                                        <?php }else{?>
                                                 <div class="form-group">
                                                <label for="duration">Username <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Username"  value="<?=$user->username?>" readonly>
                                            </div>

                                        <?php }?>

                                            <div class="form-group">
                                                <label for="duration"><br></label>
                                                <input type="submit" class="btn btn-primary btn-sm" placeholder="Duration" name="name" value="Update">
                                            </div>
                                        </form>
                                    </div>

                                    
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                           
                           
                            <div class="card-content collapse show" id="tb">
                                <div class="row justify-content-center p-1">
                                    

                                    <div class="col-md-12">

                                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>profile/change-password" method="POST" enctype="multipart/form-data">
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
                       <?php }else{?>
                        <div class="col-md-12">
                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>member-profile/update" method="POST" enctype="multipart/form-data">
                            <div class="profile-pic">
                                <div></div>
                                <input id="profile-pic" type="file" class="onchange-submit" accept="image/*" name="photo">
                                <img  src="<?=img_base_url()?><?=$user->photo?>" alt="<?=$user->name?>">
                                <label for="profile-pic">Change</label>
                            </div>

                        </form>
                       
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-content collapse show" id="tb">
                                <div class="row justify-content-center p-1">
                                    <div class="col-md-12">
                                        <form class="form ajaxsubmit needs-validation reload-page" action="<?=base_url()?>member-profile/update" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">First Name <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="First Name" name="fname" value="<?=$user->fname?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Middle Name</label>
                                                <input type="text" class="form-control" placeholder="Middle Name" name="mname" value="<?=$user->mname?>">
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Last Name <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Last Name" name="lname" value="<?=$user->lname?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Father's Name <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Father's Name" name="father_name" value="<?=$user->father_name?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">D.O.B <sup>*</sup></label>
                                                <input type="date" class="form-control"  name="dob" value="<?=$user->dob?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Gender <sup>*</sup></label>
                                                <select class="form-control" name="gender" required>
                                                  <option value="Male" <?php if($user->gender=='Male'){ echo "selected" ;} ;?> >Male</option>
                                                  <option value="Female" <?php if($user->gender=='Female'){ echo "selected" ;} ;?> >Female</option>
                                                  <option value="Other" <?php if($user->gender=='Other'){ echo "selected" ;} ;?> >Other</option>
                                                </select>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Mobile <sup>*</sup></label>
                                                <input type="number" class="form-control" placeholder="Mobile" name="mobile" value="<?=$user->mobile?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Email <sup>*</sup></label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" value="<?=$user->email?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Profession <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Profession" name="profession" value="<?=$user->profession?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Income / Day <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Income / Day " name="income_per_day" value="<?=$user->income_per_day?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Aadhaar <sup>*</sup></label>
                                                <input type="number" class="form-control" placeholder="Aadhaar" name="aadhaar_no" value="<?=$user->aadhaar_no?>" required>
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Pan No </label>
                                                <input type="text" class="form-control" placeholder="Pan No" name="pan_no" value="<?=$user->pan_no?>">
                                               </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="duration">Voter ID </label>
                                                <input type="text" class="form-control" placeholder="Voter ID" name="voter_id" value="<?=$user->voter_id?>">
                                               </div>
                                                </div>
                                                <div class="col-md-12">
                                                <div class="form-group">
                                                <label for="duration"><br></label>
                                                <input type="submit" id="btnsubmit" class="btn btn-primary btn-sm"  value="Update">
                                               </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    
                    <?php };?>
                </div>
            </section>
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->

<script>
      $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        //alert(a);
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);
            $('#profile-pic').removeClass('onchange-submit');
        }else{
            $('button[type=submit]').prop('disabled', false);
           // $('#profile-pic').removeClass('onchange-submit');
        }
    });
</script>