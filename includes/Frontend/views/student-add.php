                                             
<?php if(is_user_logged_in(  )) {
  if($user->data->user_login === 'admin') {

    return true;
  } else {
    require( __DIR__ . '/student-update-modal.php');
  }
}  ?>
<div class="row">
  
  <?php if(is_user_logged_in(  )) {
      if($user->data->user_email === 'admin') {
        return true;
      } else {
        require( __DIR__ . '/student-information.php');
      }
  } else {?>
    <?php require( __DIR__ . '/new-student-application.php'); ?>
        
</div>
<?php } ?>
