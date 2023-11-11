<?= form_open(base_url('rgm/profile'), array('class'=>'form myForm', 'autocomplete'=>'off'));?>
  <div class="group">
    <label for="username">Old Password:</label>
    <input type="password" name="oldpass" class="input" />
  </div>
  <div class="group">
    <label for="username">New Password:</label>
    <input type="password" name="newpass" class="input" />
  </div>
  <div class="group">
    <label for="username">Confirm New Password:</label>
    <input type="password" name="conpass" class="input" />
  </div>
  <div class="group">
    <button type="submit" class="btn btn-yfarms hover-cast p-2 submit">
      <i class="fa fa-refresh"></i> Change
      <span class="d-none" data-target="<?= base_url('password') ?>"></span>
    </button>
  </div>
<?= form_close(); ?>