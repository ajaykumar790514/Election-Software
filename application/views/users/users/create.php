<script>
  $(document).ready(function() {
    // Initialize validation
    $(".needs-validation").validate({
      rules: {
        username: {
          required: true,
          remote: "<?=$remote;?>null/username"
        },
        email: "required",
        name: "required",
        password: "required",
        user_role: "required",
        mobile: "required",
        
      },
      messages: {
        username: {
          required: "Please enter user name!.",
          remote: "Username already exists!."
        },
        email: "Please enter email address!.",
        name: "Please enter name!.",
        password: "Please enter password!.",
        user_role: "Please select user role!.",
        mobile: "Please enter mobile!.",
      },
    });

   
  });
</script>

<!-- Form -->
<div class="card-content collapse show">
    <div class="card-body">
    <form class="form ajaxsubmit reload-tb needs-validation" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
        <div class="form-body w-100">
            <div class="row">
                <div class="form-group col-lg-12">
                    <label for="Name" class="required">Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" value="<?=(@$row->name) ? $row->name : '' ?>" >
                </div>
                <div class="form-group col-lg-6">
                    <label for="email" class="required">Mobile</label>
                    <input type="number" class="form-control" placeholder="Mobile" name="mobile" value="<?=(@$row->mobile) ? $row->mobile : '' ?>" >            
                </div>
                <div class="form-group col-lg-6">
                    <label for="email" class="required">Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?=(@$row->email) ? $row->email : '' ?>" >            
                </div>

                <div class="form-group col-lg-6">
                    <label for="username" class="required">Username</label>
                    <input type="text" class="form-control" placeholder="Username" name="username" value="<?=(@$row->username) ? $row->username : '' ?>" >            
                </div>

                <div class="form-group col-lg-6">
                    <label for="password" class="required">Password</label>
                    <input type="text" class="form-control" placeholder="Password" name="password" value="<?=(@$row->password) ? $this->encryption->decrypt(@$row->password) : '' ?>" >            
                </div>

                <div class="form-group col-lg-6">
                    <label for="work" class="required">User Role</label>
                    <select class="form-control" id="user_role" name="user_role">
                    <?php 
                    echo optionStatus('','-- Select --',1);
                    foreach ($user_role as $urrow) { 
                        $selected = '';
                        if ( $urrow->id!=2) {
                            if (@$row->user_role == $urrow->id) {
                            $selected = 'selected';
                        }
                        echo optionStatus($urrow->id,$urrow->name,$urrow->status,$selected);
                        }
                    } ?>
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label for="photo">Photo</label>
                    <input type="file" class="form-control" placeholder="photo" name="photo" >  
                    <?php if (!empty(@$row->photo)) { ?>
                        <img src="<?=$row->photo?>">
                    <?php } ?>          
                </div>

            </div>
        </div>

        <div class="form-actions text-right">
            <button type="reset" data-dismiss="modal" class="btn btn-danger mr-1">
                <i class="ft-x"></i> Cancel
            </button>
            <button type="submit" class="btn btn-primary mr-1">
                <i class="ft-check"></i> Save
            </button>
        </div>
    </form>
    <!-- End: form -->
    </div>
</div>
