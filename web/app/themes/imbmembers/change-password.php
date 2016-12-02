<?php
/**
 * Template name: Change Password
 */

$user = wp_get_current_user();
?>

<h1>Change account password</h1>

<form class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-2 control-label">Email Address</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $user->user_email; ?></p>
      <span id="helpBlock" class="help-block">Please contact IMB Secretariat to change your registered email address.</span>
    </div>
  </div>
  <div class="form-group">
    <label for="new_password" class="col-sm-2 control-label">New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="new_password">
      <span id="helpBlock" class="help-block">Enter a new password for your account.</span>
    </div>
  </div>
  <div class="form-group">
    <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="confirm_password">
      <span id="helpBlock" class="help-block">Please re-type your new password to confirm.</span>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Change password</button>
      <a href="<?= home_url(); ?>" class="btn btn-default">Cancel</a>
    </div>
  </div>
</form>
