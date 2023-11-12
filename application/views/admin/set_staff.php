<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid text-end mb-3">
  <a href="<?= base_url('pull/staff'); ?>" class="btn btn-yfarms " data-bs-target="#mModal" data-bs-toggle="modal" data-title="Add a Staff ">
    <i class="bi-plus-lg"></i> New Staff </a>
</div>
<div class="container-fluid table-responsive" style="min-height: 240px">
  <table class="table table-hovers">
    <thead>
      <tr>
        <th width="10px" class="text-center">#</th>
        <th>Staff ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Role</th>
        <th width="40px"></th>
      </tr>
    </thead>
    <tbody>
<?php
  $staff = $this->rgm_model->find_all('admin', ['role !='=>'admin']);
  $c = 1;
  foreach ($staff as $row) {
?>
      <tr>
        <td class="text-end"><?= $c; ?></td>
        <td><?= $row['username']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['phone']; ?></td>
        <td><?= $row['role']; ?></td>
        <td class="dropstart py-1">
          <button class="btn btn-sm " type="button"data-bs-toggle="dropdown"> <i class="bi-three-dots-vertical"></i> </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="<?= base_url('pull/staff/'.$row['id']); ?>" class="dropdown-item " data-bs-target="#mModal" data-bs-toggle="modal">
              <i class="bi-pencil-square"></i> Edit Staff
              <span class="d-none" data-title="Update Staff Details "></span>
            </a>
            <a href="<?= base_url('sys/password/'.$row['id']); ?>" class=" dropdown-item" data-bs-target="#mModalX" data-bs-toggle="modal">
              <i class="bi-person-lock"></i> Reset Password
              <span class="d-none msg">This operation will reset <b><?= $row['name']; ?></b>'s login password and they will no longer be able to login with their current credentials. <br />Sure to Continue?</span>
            </a>
            <a href="<?= base_url('drop/admin/'.$row['id']); ?>" class=" dropdown-item" data-bs-target="#mModalX" data-bs-toggle="modal">
              <i class="bi-trash3-fill text-danger"></i> Delete
              <span class="d-none msg">You are about to delete '<b><?= $row['name']; ?></b>'</span>
            </a>
          </div>
        </td>
      </tr>
<?php 
    $c++;
  }
?>
<?php if (count($staff) < 1) { ?>
      <tr><td colspan="6" class="p-5 text-danger text-center">No data available</td></tr>
<?php } ?>
    </tbody>
  </table>
</div>
