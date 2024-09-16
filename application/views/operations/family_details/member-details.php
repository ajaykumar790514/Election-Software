<div class="container-fluid pt-2 pb-2">
<div class="row">
    <div class="col-lg-12">
      <div class="table-responsive pt-1">
         <table class="table table-bordered base-style">
          <thead>
          <tr>
           <th scope="col">Enrollment No</th>
           <td scope="col"><?= !empty($members->enrollment_no) ? $members->enrollment_no : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Head Of the House</th>
           <td scope="col"><?= ($members->head_of_the_house == '1') ? 'YES' : 'NO'; ?></td>
           </tr>
          <tr>
           <th scope="col">Full Name</th>
           <td scope="col"><?= !empty($members->fname) ? $members->fname . ' ' . $members->mname . ' ' . $members->lname : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Father's Name</th>
           <td scope="col"><?= !empty($members->father_name) ? $members->father_name : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Mobile</th>
           <td scope="col"><?= !empty($members->mobile) ? $members->mobile : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Email</th>
           <td scope="col"><?= !empty($members->email) ? $members->email : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">D.O.B</th>
           <td scope="col"><?= !empty($members->dob) ? $members->dob : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Gender</th>
           <td scope="col"><?= !empty($members->gender) ? $members->gender : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Profession</th>
           <td scope="col"><?= !empty($members->profession) ? $members->profession : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Income / Day</th>
           <td scope="col"><?= title('income_master',$member->income_per_day, 'id', 'title') ?></td>
           </tr>
           <tr>
           <th scope="col">Aadhaar No</th>
           <td scope="col"><?= !empty($members->aadhaar_no) ? $members->aadhaar_no : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Pan No</th>
           <td scope="col"><?= !empty($members->pan_no) ? $members->pan_no : 'N/A'; ?></td>
           </tr>
           <tr>
           <th scope="col">Voter ID</th>
           <td scope="col"><?= !empty($members->voter_id) ? $members->voter_id : 'N/A'; ?></td>
           </tr>
          </thead>
       </table>
    </div>
</div>
</div>
</div>
<div class="modal-footer text-center">
    <button type="reset" class="btn btn-danger waves-effect" class="close" data-dismiss="modal">Close</button>
</div>
