<div id="demo-modal" class="modal">
    <div class="modal__content">
      <form class="label-text new-student-form" id="new-student-form" name="registrationn" action="" method="post">
        <fieldset>
            <div class="message"></div>
          <legend><span class="number">1</span> Student Basic Info</legend>
        
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" value="<?php echo $student->name ?>">

          <label for="registration">Registration no:</label>
          <input type="number" id="registration" name="registration" value="<?php echo $student->registration ?>">

          <label for="phone">Phone:</label>
          <input type="number" id="phone" name="phone" value="<?php echo $student->phone ?>">
          <input type="number" id="id" hidden name="id" value="<?php echo $student->id ?>">
          <input type="gmail" id="gmail" hidden name="gmail" value="<?php echo $student->gmail ?>">
            
          <input type="text" id="dept" hidden name="dept" value="<?php echo $student->dept ?>">



          <label>Subjects:</label>
            <?php 
            $sub = explode(",",$student->subject);
            $sub_inc_id = 1;

            // vdd();
            foreach ($subjects as $subject) { 
            if(in_array($subject->name, $sub)){
                ?>
                    <input
                        subject-length="<?php echo count($subjects) ?>" 
                        type="checkbox"
                        class="subject-<?php echo $sub_inc_id ?>"
                        id="subject"
                        checked value="<?php echo $subject->name ?>"
                        name="<?php echo $subject->name ?>"
                    ><label style="margin-bottom: -100px" class="light" for="development"><?php echo $subject->name ?></label><br>

                <?php
            }  else {
                ?>
                    <input
                        subject-length="<?php echo count($subjects) ?>"
                        type="checkbox"
                        id="subject"
                        class="subject-<?php echo $sub_inc_id ?>"
                        value="<?php echo $subject->name ?>"
                        name="<?php echo $subject->name ?>"
                    ><label style="margin-bottom: -100px" class="light" for="development"><?php echo $subject->name ?></label><br>

                <?php
            }
            ?>
          <?php $sub_inc_id ++; } ?>
          
        </fieldset>
        <div class="message"></div>
        <!-- <button type="submit">Add student</button> -->
        <!-- <button id="add-student" data-spinning-button type="submit" class="btn btn-primary">Submit</button> -->
        <button id="add-student" type="submit">Update</button>


        
       </form>


        <a href="#" class="modal__close">&times;</a>
    </div>
</div>