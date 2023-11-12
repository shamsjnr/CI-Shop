<?php defined('BASEPATH') OR exit('No direct script access allowed');
  require('report_head.php');
  if ($xdate != '' OR $ydate != '') {
    $cats = $serv = [];
    $temp = $this->rgm_model->find_alls('services');
    foreach ($temp as $row) $serv[$row['id']] = $row['name'];
    $temp = $this->rgm_model->find_alls('categories');
    foreach ($temp as $row) $cats[$row['id']] = $row['name'];

    $dater = 'Analytics Report for: &nbsp; '.$dater;
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $this->db->select('SUM(amount) AS amount');
    $expenses = $this->rgm_model->find('expenses', ['amount >'=>0])->amount ?? 0;
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $this->db->select('service, SUM(`price` * `quantity`) AS amount');
    $services = $this->rgm_model->find('tasks', ['price >'=>0])->amount ?? 0;
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $this->db->select('SUM(amount) AS amount');
    $payments = $this->rgm_model->find('payments', ['amount >'=>0])->amount ?? 0;
    $this->db->select('service, SUM(`price` * `quantity`) AS amount');
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $this->db->group_by('service')->order_by('amount DESC');
    $sum_service = $this->rgm_model->find_all('tasks');
    $this->db->select('category, SUM(amount) AS amount');
    if ($xdate) $this->db->where('date >=', $xdate);
    if ($ydate) $this->db->where('date <=', $ydate);
    $this->db->group_by('category')->order_by('amount DESC');
    $sum_expense = $this->rgm_model->find_all('expenses');
    $this->db->select('service, SUM(quantity) AS quantity')->group_by('service')->order_by('quantity DESC');
    $mostservice = $this->rgm_model->find('tasks', ['quantity >'=>0]);
    $this->db->select('category, COUNT(*) AS quantity')->group_by('category')->order_by('quantity DESC');
    $mostexpense = $this->rgm_model->find('expenses', ['amount >'=>0]);
?>
<div class="container">
  <div class="banner pb-3 align-items-end d-print-none">
    <?php require('report_date.php'); ?>
    <a href="javascript:void(0)" class="btn btn-outline-yfarms py-2 text-nowrap" onclick="window.print()"><i class="bi-printer-fill"></i> &nbsp; Print</a>
  </div>
  <div class="container pb-3 mb-3 pe-0">
    <div class="row g-0">
      <div class="col-12"><h5 class="mb-0 py-2 text-success">Totals</h5></div>
      <div class="col-md-4 banner p-2 px-3 border">Services <b class="money"><?= number_format($services); ?></b></div>
      <div class="col-md-4 banner p-2 px-3 border">Payments <b class="money"><?= number_format($payments); ?></b></div>
      <div class="col-md-4 banner p-2 px-3 border">Expenses <b class="money"><?= number_format($expenses); ?></b></div>
    </div>
  </div>
  <div class="container pb-3 mb-3 pe-0">
    <div class="row g-0">
      <div class="col-12"><h5 class="mb-0 py-2 text-success">Summaries</h5></div>
      <div class="col-sm-6 border">
        <h6 class="m-0 p-3 text-center"><b>Services</b></h6>
    <?php foreach ($sum_service as $row): ?>
        <div class="border-top banner p-2 px-3"><?= $serv[$row['service']]; ?> <b class="money"><?= number_format($row['amount']); ?></b></div>
    <?php endforeach ?>
      </div>
      <div class="col-sm-6 border">
        <h6 class="m-0 p-3 text-center"><b>Expenses</b></h6>
    <?php foreach ($sum_expense as $row): ?>
        <div class="border-top banner p-2 px-3"><?= $cats[$row['category']]; ?> <b class="money"><?= number_format($row['amount']); ?></b></div>
    <?php endforeach ?>
      </div>
    </div>
  </div>
  <div class="container pb-3 mb-3 pe-0">
    <div class="row g-0">
      <div class="col-12"><h5 class="mb-0 py-2 text-success">Watch</h5></div>
      <div class="col-sm-6 border">
        <h6 class="m-0 p-3 text-center"><b>Most Patronized Service</b></h6>
        <div class="border-top banner p-2 px-3"><?= $serv[$mostservice->service]; ?> <b>x <?= number_format($mostservice->quantity); ?></b></div>
      </div>
      <div class="col-sm-6 border">
        <h6 class="m-0 p-3 text-center"><b>Most Frequent Expense</b></h6>
        <div class="border-top banner p-2 px-3"><?= $cats[$mostexpense->category]; ?> <b>x <?= number_format($mostexpense->quantity); ?></b></div>
      </div>
      <div class="col-12 border border-top-0">
        <div class="banner p-2 px-3">Total Customer Debt <b class="money"><?= number_format($services - $payments); ?></b></div>
        <div class="border-top banner p-3" style="font-size: 1.5rem;">Estimated Profit: <b class="money"><?= number_format($payments - $expenses); ?></b></div>
      </div>
    </div>
    <div class="p-3 text-center"><span class="text-danger">Note:</span> 'Estimated Profit' is calculated based on money at hand (i.e. payments made by customers) against the net expenses recorded on the system for: <?= substr($dater, strpos($dater, ':') + 1); ?></div>
  </div>
</div>
<?php } ?>
