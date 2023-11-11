<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form action="#" onsubmit="return false" id="adder" autocomplete="off">
  <?php $uuid = (strlen($last) < 3) ? str_repeat('0', 3 - strlen($last)) . $last : $last; ?>
  <div class="group">
    <input type="text" value="<?= $data->username ?? "PSC/$uuid"; ?>" class="input text-center" readonly disabled />
  </div>
  <div class="group">
    <input type="text" class="input" value="<?= $data->name ?? '' ?>" name="name" required />
    <label>Name</label>
  </div>
  <div class="group">
    <input type="text" class="input" value="<?= $data->phone ?? '' ?>" name="phone" required />
    <label>Phone Number</label>
  </div>
  <div class="group">
    Designation: &nbsp; &nbsp; <p class="d-block d-md-none" />
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="type" id="t1" value="1" <?= $data && $data->type == '2' ? '' : 'checked'; ?>>
      <label class="form-check-label" for="t1" onclick="$('.warehouse').show(); $('.outlet').hide(); $('#select').val('');">Warehouse</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="type" id="t2" value="2" <?= $data && $data->type == '2' ? 'checked' : ''; ?>>
      <label class="form-check-label" for="t2" onclick="$('.outlet').show(); $('.warehouse').hide(); $('#select').val('');">Outlet</label>
    </div>
  </div>
  <div class="group">
    <select class="input" id="select" name="outlet" required>
      <option value="" class="d-none">Select Station...</option>
  <?php $select = (!$data OR ($data && $data->type != '2')) ? '' : ' style="display: none"'; ?>
  <?php foreach ($outlets as $row): ?>
    <?php if ($row['type'] == 0): ?>
        <option value="<?= $row['token'] ?>" class="warehouse" <?= $select . ($data && $data->warehouse == $row['token'] ? 'selected' : ''); ?>><?= $row['name'] ?></option>
    <?php endif ?>
  <?php endforeach ?>
  <?php $select = ($data && $data->type == '2') ? '' : ' style="display: none"'; ?>
  <?php foreach ($outlets as $row): ?>
    <?php if ($row['type'] == 1): ?>
        <option value="<?= $row['token'] ?>" class="outlet" <?= $select . ($data && $data->warehouse == $row['token'] ? 'selected' : ''); ?>><?= $row['name'] ?></option>
    <?php endif ?>
  <?php endforeach ?>
    </select>
  </div>
  <div class="group">
    <select class="input" name="state" required>
      <option value="" class="d-none">Select State...</option>
  <?php foreach ($states as $row): ?>
      <option value="<?= $row['token'] ?>" <?= $data && $data->location == $row['token'] ? 'selected' : ''; ?>><?= $row['name'] ?></option>
  <?php endforeach ?>
    </select>
  </div>
  <?php $ref = (is_object($data)) ? 'put/users?target='.$data->token : 'post/users'; ?>
  <button class="btn submit" data-content="#drop-off" data-form="#adder" data-ref="<?= base_url('upanel/'.$ref); ?>"><i class="bi-check2"></i> Submit</button>
</form>