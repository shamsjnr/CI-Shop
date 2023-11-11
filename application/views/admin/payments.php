<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $this->db->select('*, SUM(`price` * `quantity`) AS total');
  $sum = $this->rgm_model->find('tasks', ['voucher'=>$this->input->get('target')]);
  if ( ! $sum): 
?>
<div class="p-5 text-danger">Request Error!</div>
<?php else: 
  $this->db->select('*, SUM(`amount`) AS amount');
  $pay = $this->rgm_model->find('payments', ['service'=>$this->input->get('target')])->amount ?? 0; 
  $data = $this->rgm_model->find_all('payments', ['service'=>$this->input->get('target')]); 
?>
<div class="banner d-print-none">
  <a class="btn btn-secondary" onclick="history.back()"><i class="bi-reply-fill"></i> Back</a>
  <div class="pb-2 ms-auto">
    <a class="btn btn-outline-yfarms" id="download2x" onclick="window.print()"><i class="bi-printer"></i> Print</a>
    <a href="<?= base_url('pull/payment/'.$sum->voucher); ?>" class="btn btn-yfarms" data-bs-toggle="modal" data-bs-target="#mModal" 
     data-title="Add Payment"><i class="bi-plus-lg"></i> Add Payment</a>
  </div>
</div>
<div class="container-fluid pt-3">
  <div class="banner pb-3 my-2">
    <b>
      <div>Service ID: <?= $sum->voucher ?></div>
      <div class="text-secondary">DATE: <?= date('d M, Y', strtotime($sum->date)) ?></div>
    </b>
    <div class="text-secondary text-end">
      <div>Supply Charge: <b class="text-dark money"><?= number_format($sum->total) ?></b></div>
      <div>Amount Paid: <b class="text-dark money"><?= number_format($pay) ?></b></div>
      <div>Balance Due: <b class="text-dark money"><?= number_format($sum->total - $pay) ?></b></div>
    </div>
  </div>
  <div class="table-responsive text-nowrap mb-3" style="min-height: initial;">
    <table class="table<?= (count($data) > 0) ? ' table-hovers' : ''; ?>">
      <thead>
        <tr>
          <th>Payment Date</th>
          <th>Amount</th>
          <th class="text-center d-print-none" width="20px"></th>
        </tr>
      </thead>
      <tbody id="drop-off">
    <?php
      $c = 0;
      foreach ($data as $row) { 
        $c++;
    ?>
        <tr>
          <td><?= date('d M, Y', strtotime($row['date'])); ?></td>
          <td><span class="money"><?= number_format($row['amount']); ?></span></td>
          <td class="dropstart py-1 d-print-none">
            <button class="btn btn-sm" data-bs-toggle="dropdown"><i class="bi-three-dots-vertical"></i></button>
            <div class="dropdown-menu">
              <a href="<?= base_url('pull/payment/'. $row['service'] .'?target='.$row['id']); ?>" class="dropdown-item" 
                data-bs-toggle="modal" data-bs-target="#mModal" data-title="Update Payment"><i class="bi-pencil-square"></i> Edit</a>
              <a href="<?= base_url('drop/payments/'.$row['id']); ?>" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#mModalX">
                <i class="bi-trash3-fill"></i> Delete
                <span class="msg d-none">This operation will remove payment with details at row: <b><?= $c; ?></b> from the system<br />Sure to continue?</span>
              </a>
            </div>
          </td>
        </tr>
    <?php } ?>
    <?php if (count($data) == 0) { ?>
        <tr><td colspan="9" class="p-5 text-danger text-center">no data available</td></tr>
    <?php } ?>
      </tbody>
    </table>
  </div>
  <?php $cats = []; ?>
  <?php $cast = $this->rgm_model->find_all('services') ?: []; ?>
  <?php foreach ($cast as $key) $cats[$key['id']] = $key['name']; ?>
  <div class="container p-3 mt-3 border">
    <h5>Service Details</h5>
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th width="20px">#</th>
          <th>Item Code</th>
          <th>Category</th>
          <th>Quantity</th>
          <th width="60px">Amount Total</th>
        </tr>
      </thead>
      <tbody>
    <?php $c = $total = 0; 
      $task = $this->rgm_model->find_all('tasks', ['voucher'=>$this->input->get('target')]);
      foreach ($task as $row) { $c++;
        $total += $row['price'] * $row['quantity'];
    ?>
        <tr>
          <td><?= $c; ?></td>
          <td class="d-none row-total"><?= $row['price'] * $row['quantity']; ?></td>
          <td><?= $row['task_id'] ?></td>
          <td><?= $cats[$row['service']] ?></td>
          <td><?= $row['quantity'] ?></td>
          <td><span class="money"><?= number_format($row['price'] * $row['quantity']) ?></span></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif ?>
