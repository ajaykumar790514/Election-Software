<!-- BEGIN: Content-->
<div class="app-content content" id="page_content">
    
<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <?php if($user->user_role==2):?>
        <section id="minimal-statistics-bg">
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 >Member Profile</h4>
                </div>
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?=IMGS_URL.$user->photo;?>" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?=$user->fname.' '.$user->mname.' '. $user->lname;?></h4>
                      <span class="text-secondary"><?=$user->profession;?></span><br>
                      <span class="text-muted "><?=$user->mobile;?></span><br>
                      <span class="text-muted "><?=$user->email;?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Enrollment No</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->enrollment_no;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->fname.' '.$user->mname.' '. $user->lname;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Father's Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->father_name;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">D.O.B</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= date('d-m-Y',strtotime($user->dob)); ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->gender;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Income Per Day</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= title('income_master',$user->income_per_day, 'id', 'title') ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Aadhaar No</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->aadhaar_no;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Pan No</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->pan_no;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Voter ID</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?=$user->voter_id;?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Head of the house</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php if($user->head_of_the_house==1){ echo  "Yes";?>
                     
                     <?php }else{ echo "NO";}?>   
                    </div>
                  </div>
                </div>
              </div>
         </section>
         <?php endif;?>   
</div>
</div>
</div>
<!-- END: Content-->
