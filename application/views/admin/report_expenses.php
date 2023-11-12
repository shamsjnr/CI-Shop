<?php defined('BASEPATH') OR exit('No direct script access allowed');
  require('report_head.php');
  if ($xdate != '' OR $ydate != '') {
    $cats = [];
    $temp = $this->rgm_model->find_alls('categories');
    foreach ($temp as $row) $cats[$row['id']] = $row['name'];

    $this->db->select('category, SUM(amount) AS amount');
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $this->db->group_by('category');
    $sums = $this->rgm_model->find_all('expenses');
    $dater = 'Expenses Report for: &nbsp; '.$dater;
?>
<div class="banner pb-3 align-items-end d-print-none">
  <?php require('report_date.php'); ?>
  <div class="dropdown">
    <button class="btn dropdown-toggle btn-outline-yfarms py-2" data-bs-toggle="dropdown">Download</button>
    <div class="dropdown-menu dropdown-menu-end">
      <a href="javascript:void(0)" class="dropdown-item" onclick="window.print()">Print PDF</a>
      <a href="javascript:void(0)" onclick="toExcel('excel', '<?= $dater ?>')" class="dropdown-item">Excel</a>
    </div>
  </div>
</div>
<div class="container border pb-3 mb-3">
  <div class="row g-0">
    <div class="col-12"><h5 class="mb-0 py-2">Summary</h5></div>
  <?php foreach ($sums as $row): ?>
    <div class="col-md-6 banner p-2 border"><?= $cats[$row['category']]; ?> <b class="money"><?= number_format($row['amount']); ?></b></div>
  <?php endforeach ?>
  </div>
</div>
<div class="container px-0">
  <table class="table table-bordered" id="excel">
    <thead>
      <tr class="d-none d-print-table-row text-center">
        <th colspan="6" style="font-family: monospace;"><?= $dater; ?></th>
      </tr>
      <tr>
        <th width="10px" class="text-center">#</th>
        <th>Date</th>
        <th>Category</th>
        <th>Details</th>
        <th class="text-center">Amount</th>
        <th class="text-center">Balance</th>
      </tr>
    </thead>
    <tbody>
  <?php
    $this->db->select('category, date, more, amount');
    $this->db->order_by('date');
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $data = $this->rgm_model->find_all('expenses');
    $total = $c = 0;
    foreach ($data as $row) { $c++;
      $total += $row['amount'];
  ?>
      <tr>
        <td><?= $c; ?></td>
        <td class="text-nowrap"><?= date('d M, Y', strtotime($row['date'])); ?></td>
        <td><?= $cats[$row['category']]; ?></td>
        <td><?= nl2br($row['more']); ?></td>
        <td class="text-end"><span class="money"><?= number_format($row['amount']); ?></span></td>
        <td class="text-end"><span class="money"><?= number_format($total); ?></span></td>
      </tr>
  <?php } ?>
  <?php if (count($data) < 1) { ?>
      <tr><td colspan="6" class="p-5 text-danger text-center">No data available</td></tr>
  <?php } else { ?>
      <tr><td colspan="6" class="p-3 text-center"><h5 class="mb-0">Total: &nbsp; <b class="money"><?= number_format($total); ?></b></h5></td></tr>
  <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>
