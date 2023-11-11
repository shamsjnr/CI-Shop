<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $item = $this->rgm_model->find('admin', ['id'=>$this_id]);
  $uid = $this->rgm_model->find_count('admin') + 1001;
  $uid = substr($uid, 1);
  echo form_open(base_url('staff'), ['class'=>'form myForm']);
?>
  <div class="group">
    <label>Staff ID</label>
    <input type="text" class="text-center input" style="font-weight: bold; letter-spacing: 2px" readonly disabled value="<?= $item->username ?? "JR{$uid}" ?>" required />
  </div>
  <div class="group">
    <input type="text" class="input" name="title" value="<?= $item->name ?? '' ?>" required />
    <label>Full Name:</label>
  </div>
  <div class="group">
    <label>Role:</label>
    <select name="role" class="input" value="<?= $item->role ?? '' ?>" required>
      <option value="" class="d-none">- Select Role -</option>
      <option value="Manager">Manager</option>
      <option value="Personnel">Sales Personnel</option>
    </select>
  </div>
  <div class="group">
    <input type="text" class="input" name="phone" value="<?= $item->phone ?? '' ?>" required />
    <label>Phone Number:</label>
  </div>
  <button type="submit" class="btn btn-yfarms submit" data-ref="<?= base_url('sys/staff/'.$this_id) ?>"><?= $item ? 'Update' : 'Save' ?></button>
<?= form_close(); ?>
