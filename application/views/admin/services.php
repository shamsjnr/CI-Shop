<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container text-end mb-3">
<?php if ($this->session->userdata('yf_admin') !== true): ?>
  <a href="<?= base_url('pull/task'); ?>" class="btn btn-yfarms " data-bs-target="#mModal" data-bs-toggle="modal" data-title="Add a Service ">
    <i class="bi-plus-lg"></i> New Service </a>
<?php endif ?>
</div>
<div class="container table-responsive" style="min-height: 240px;">
  <table class="table table-hovers">
    <thead>
      <tr>
        <th width="10px" class="text-center">#</th>
        <th class="text-nowrap">Service ID</th>
        <th>Customer</th>
        <th>Remark</th>
        <th>Date</th>
        <th>Cost</th>
        <th>Balance</th>
      <?php if ( ! isset($_SESSION['yf_admin'])): ?>
        <th width="40px"></th>
      <?php endif ?>
      </tr>
    </thead>
    <tbody>
<?php
  $this->db->group_by('voucher');
  $this->db->select('*, SUM(`price` * `quantity`) as total');
  $tasks = $this->rgm_model->find_all('tasks');
  $c = 1;
  foreach ($tasks as $row) {
    $this->db->select_sum('amount');
    $pay = $this->rgm_model->find('payments', ['service'=>$row['voucher']])->amount ?? 0;
?>
      <tr>
        <td class="text-end"><?= $c; ?></td>
        <td><?= $row['voucher']; ?></td>
        <td><?= $row['name']; ?>&nbsp; &middot; &nbsp;<?= $row['phone'] ?></td>
      <?php if (strlen($row['remark']) > 36): ?>
        <td data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $row['remark'] ?>"><?= substr($row['remark'], 0, 36); ?>...</td>
      <?php else: ?>
        <td><?= $row['remark']; ?></td>
      <?php endif ?>
        <td><?= $row['date'] ? date('d M, Y', strtotime($row['date'])) : '-'; ?></td>
        <td><span class="money"><?= number_format($row['total']); ?></span></td>
        <td><span class="money"><?= number_format($row['total'] - $pay); ?></span></td>
      <?php if ( ! isset($_SESSION['yf_admin'])): ?>
        <td class="dropstart py-1">
          <button class="btn btn-sm " type="button"data-bs-toggle="dropdown"> <i class="bi-three-dots-vertical"></i> </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="<?= base_url('pull/task/'.$row['voucher']); ?>" class="dropdown-item " data-bs-target="#mModal" data-bs-toggle="modal">
              <i class="bi-pencil-square"></i> Edit Service
              <span class="d-none" data-title="Update Service Details "></span>
            </a>
            <a href="<?= base_url('upanel/payments?target='.$row['voucher']); ?>" class="dropdown-item "><i class="bi-cash-coin"></i> Payment</a>
            <a href="<?= base_url('sys/tasks/delete?target='.$row['voucher']); ?>" class=" dropdown-item" data-bs-target="#mModalX" data-bs-toggle="modal">
              <i class="bi-trash3-fill text-danger"></i> Delete
              <span class="d-none msg">You are about to delete Service: '<b><?= $row['voucher']; ?></b>'</span>
            </a>
          </div>
        </td>
      <?php endif ?>
      </tr>
<?php 
    $c++;
  }
?>
<?php if (count($tasks) < 1) { ?>
      <tr><td colspan="8" class="p-5 text-danger text-center">No data available</td></tr>
<?php } ?>
    </tbody>
  </table>
</div>
