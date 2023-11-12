<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?= form_open(base_url('rgm/profile'), array('class'=>'form myForm', 'autocomplete'=>'off'));?>
  <div class="group">
    <input type="password" name="oldpass" class="input" required />
    <label>Current Password:</label>
  </div>
  <div class="group">
    <input type="password" name="newpass" class="input" required />
    <label>New Password:</label>
  </div>
  <div class="group">
    <input type="password" name="conpass" class="input" required />
    <label>Confirm New Password:</label>
  </div>
  <button type="submit" class="btn btn-yfarms submit" data-ref="<?= base_url('password'); ?>">Save</button>
<?= form_close(); ?>
