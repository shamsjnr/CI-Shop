<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid text-end mb-3">
  <a href="<?= base_url('pull/category'); ?>" class="btn btn-yfarms " data-bs-target="#mModal" data-bs-toggle="modal" data-title="New Expense Category">
    <i class="bi-plus-lg"></i> New Category </a>
</div>
<div class="container-fluid table-responsive">
  <table class="table table-hovers">
    <thead>
      <tr>
        <th width="10px" class="text-center">#</th>
        <th>Name</th>
        <th>Description</th>
        <th width="40px"></th>
      </tr>
    </thead>
    <tbody>
<?php
  $category = $this->rgm_model->find_all('categories');
  $c = 1;
  foreach ($category as $row) {
?>
      <tr>
        <td class="text-end"><?= $c; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= substr($row['more'], 0, 50); ?></td>
        <td class="dropstart py-1">
          <button class="btn btn-sm " type="button"data-bs-toggle="dropdown"> <i class="bi-three-dots-vertical"></i> </button>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="<?= base_url('pull/category/'.$row['id']); ?>" class="dropdown-item " data-title="Update Expense Category " data-bs-target="#mModal" data-bs-toggle="modal"><i class="bi-pencil-square"></i> Edit Category</a>
            <a href="<?= base_url('drop/categories/'.$row['id']); ?>" class=" dropdown-item" data-bs-target="#mModalX" data-bs-toggle="modal">
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
<?php if (count($category) < 1) { ?>
      <tr><td colspan="4" class="p-5 text-danger text-center">No data available</td></tr>
<?php } ?>
    </tbody>
  </table>
</div>
