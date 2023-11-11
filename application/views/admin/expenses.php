<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid text-end mb-3">
  <a href="<?= base_url('pull/expense'); ?>" class="btn btn-yfarms " data-bs-target="#mModal" data-bs-toggle="modal" data-title="Add an Expense ">
    <i class="bi-plus-lg"></i> New Expense </a>
</div>
<div class="container-fluid table-responsive" style="min-height: 240px;">
  <table class="table table-hovers">
    <thead>
      <tr>
        <th width="10px" class="text-center">#</th>
        <th>Category</th>
        <th>Details</th>
        <th>Amount</th>
        <th>Date</th>
        <th>By</th>
        <th width="40px"></th>
      </tr>
    </thead>
    <tbody>
<?php
  $cat = $staff = [];
  $cats = $this->rgm_model->find_alls('categories');
  foreach ($cats as $key) $cat[$key['id']] = [$key['name'], $key['deleted_at']];
  $staffs = $this->rgm_model->find_alls('admin');
  foreach ($staffs as $key) $staff[$key['id']] = [$key['name'], $key['deleted_at']];
  $expenses = $this->rgm_model->find_all('expenses');
  $c = 1;
  foreach ($expenses as $row) {
?>
      <tr>
        <td class="text-end"><?= $c; ?></td>
        <td<?= ($cat[$row['category']][1] != null) ? ' class="bg-light text-secondary"' : ''; ?>><?= $cat[$row['category']][0]; ?></td>
      <?php if (strlen($row['more']) > 36): ?>
        <td data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $row['more'] ?>"><?= substr($row['more'], 0, 36); ?>...</td>
      <?php else: ?>
        <td><?= $row['more']; ?></td>
      <?php endif ?>
        <td><span class="money"><?= number_format($row['amount']); ?></span></td>
        <td><?= $row['date'] ? date('d M, Y', strtotime($row['date'])) : '-'; ?></td>
        <td<?= ($staff[$row['staff']][1] != null) ? ' class="bg-light text-secondary"' : ''; ?>><?= $staff[$row['staff']][0]; ?></td>
        <td class="dropstart py-1">
          <button class="btn btn-sm " type="button"data-bs-toggle="dropdown"> <i class="bi-three-dots-vertical"></i> </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="<?= base_url('pull/expense/'.$row['id']); ?>" class="dropdown-item " data-bs-target="#mModal" data-bs-toggle="modal">
              <i class="bi-pencil-square"></i> Edit Expense
              <span class="d-none" data-title="Update Expense "></span>
            </a>
            <a href="<?= base_url('drop/expenses/'.$row['id'].'?k=voucher'); ?>" class=" dropdown-item" data-bs-target="#mModalX" data-bs-toggle="modal">
              <i class="bi-trash3-fill text-danger"></i> Delete
              <span class="d-none msg">You are about to delete Expense data at row: '<b><?= $c; ?></b>'</span>
            </a>
          </div>
        </td>
      </tr>
<?php 
    $c++;
  }
  if (count($expenses) < 1) {
    echo '<tr><td colspan="8" class="p-5 text-danger text-center">No data available</td></tr>';
  } 
?>
    </tbody>
  </table>
</div>
