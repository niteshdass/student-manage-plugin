<div class="student-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src="https://placeimg.com/640/480/arch/any" alt="">
            <h3><?php echo $user->data->user_nicename ?></h3>
          </div>
          <div class="card-body">
            <p id="upregidtop"  class="mb-0"><strong class="pr-1">Registration ID:</strong><?php echo $student->registration ?></p>
            <p style="margin-bottom: 10px;"class="mb-0"><strong class="pr-1">Depeartment:</strong><?php echo $student->dept ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
          <a style="width: 150px;" class="buttons" href="#demo-modal">Edit information</a>
          <div>hello</div>

            <h3 style="margin-top: 10px;" class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Name</th>
                <td width="2%">:</td>
                <td id="upnameid"><?php echo $student->name ?></td>
              </tr>
              <tr>
                <th width="30%">Registration</th>
                <td width="2%">:</td>
                <td id="upregid" ><?php echo $student->registration ?></td>
              </tr>
              <tr>
                <th width="30%">Depeartment	</th>
                <td width="2%">:</td>
                <td><?php echo $student->dept ?></td>
              </tr>
              <tr>
                <th width="30%">Subject</th>
                <td width="2%">:</td>
                <td id="upsubid"><?php echo $student->subject ?></td>
              </tr>
              <tr>
                <th width="30%">Gmail</th>
                <td width="2%">:</td>
                <td><?php echo $student->gmail ?></td>
              </tr>
              <tr>
                <th width="30%">Phone</th>
                <td width="2%">:</td>
                <td id="upphoneid"><?php echo $student->phone ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>