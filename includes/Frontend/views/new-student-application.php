<div class="col-md-12">
      <form class="label-text new-student-form" id="new-student-form" name="registrationn" action="" method="post">
        <fieldset>
            <div class="message"></div>
          <legend><span class="number">1</span> Student Basic Info</legend>
        
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" value="">

          <label for="name">Gmail:</label>
          <input type="gmail" id="gmail" name="name" value="">

          <label for="registration">Registration no:</label>
          <input type="number" id="registration" name="registration" value="">

          <label for="dept">Depeartment:</label>
          <select name="dept" id="dept">
              <option value="CSE">CSE</option>
              <option value="EEE">EEE</option>
              <option value="English">English</option>
              <option value="LLB">LLB</option>
              <option value="BBA">BBA</option>
          <select>

          <label for="phone">Phone:</label>
          <input type="number" id="phone" name="phone" value="">

          <?php 
            $sub_inc_id = 1;
            foreach ($subjects as $subject) { ?>
            <input type="checkbox" subject-length="<?php echo count($subjects) ?>" id="subject" class="subject-<?php echo $sub_inc_id ?>" value="<?php echo $subject->name ?>" name="<?php echo $subject->name ?>"><label class="light" for="development"><?php echo $subject->name ?></label><br>
            <?php
            $sub_inc_id ++;
            }
          ?>
          
        </fieldset>
        <div class="message"></div>
        <!-- <button type="submit">Add student</button> -->
        <!-- <button id="add-student" data-spinning-button type="submit" class="btn btn-primary">Submit</button> -->
        <button id="add-student" type="submit">Add student</button>


        
       </form>
    </div>