<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
  function rgb($a='.4')
  {
    $r = md5(rand());
    $g = md5(rand());
    $b = md5(rand());
    $rnd = 'rgba('.hexdec(substr($r,0,2)).','.hexdec(substr($g,4,2)).','.hexdec(substr($b,8,2)).", $a)";
    return $rnd;
  }

  if ($this->session->userdata('yf_role') !== 'Personnel') {
    $this->db->where('deleted_at IS NULL')->group_by('voucher');
    $tasks = $this->rgm_model->find_count('tasks');
    $this->db->select('SUM(`price` * `quantity`) AS total');
    $services = $this->rgm_model->find('tasks', ['price >'=>0])->total ?? 0;
    $this->db->select('SUM(`amount`) AS amount');
    $payments = $this->rgm_model->find('payments', ['amount >'=>0])->amount ?? 0;
    $this->db->select('SUM(`amount`) AS amount');
    $expenses = $this->rgm_model->find('expenses', ['amount >'=>0])->amount ?? 0;
  }
?>
<div class="container">
  <?php if ($this->session->userdata('yf_role') !== 'Personnel') { ?>
  <div class="row">
    <div class="col-md-6">
      <div class="carded" style="background: linear-gradient(45deg, white, <?= rgb() ?>);">
        <div class="amount"><span class="money"><?= number_format($payments - $expenses); ?></span></div>
        <div class="background" style="color: <?= rgb('.8') ?>"><i class="bi-currency-exchange"></i></div>
        <div class="line-text">Total Estimated Revenue</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="carded" style="background: linear-gradient(45deg, white, <?= rgb() ?>);">
        <div class="amount"><span class="money"><?= number_format($payments); ?></span></div>
        <div class="background" style="color: <?= rgb('.8') ?>"><i class="bi-cash-coin"></i></div>
        <div class="line-text">Total Payments Received</div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="carded" style="background: linear-gradient(45deg, white, <?= rgb() ?>);">
        <div class="amount"><span class="money"><?= number_format($expenses); ?></span></div>
        <div class="background" style="color: <?= rgb('.8') ?>"><i class="bi-wallet2"></i></div>
        <div class="line-text">Total Expenses Incurred</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="carded" style="background: linear-gradient(45deg, white, <?= rgb() ?>);">
        <div class="amount"><?= number_format($tasks); ?></div>
        <div class="background" style="color: <?= rgb('.8') ?>"><i class="bi-database-fill-gear"></i></div>
        <div class="line-text">Total Services Recorded</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="carded" style="background: linear-gradient(45deg, white, <?= rgb() ?>);">
        <div class="amount"><span class="money"><?= number_format($services - $payments); ?></span></div>
        <div class="background" style="color: <?= rgb('.8') ?>"><i class="bi-person-fill-lock"></i></div>
        <div class="line-text">Total Customer Debt</div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="pt-4 pb-2">
    <h5>Pending Services</h5>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <th width="10px" class="text-center">#</th>
        <th class="text-nowrap">Service ID</th>
        <th>Customer</th>
        <th>Remark</th>
        <th>Date</th>
      </thead>
      <tbody>
    <?php 
      $c = 0;
      $this->db->group_by('voucher')->order_by('date ASC');
      $tasks = $this->rgm_model->find_all('tasks', ['date >='=>date('Y-m-d')]);
      foreach ($tasks as $row) { $c++;
    ?>
        <tr>
          <td class="text-end"><?= $c; ?></td>
          <td><?= $row['voucher']; ?></td>
          <td><?= $row['name']; ?>&nbsp; &middot; &nbsp;<?= $row['phone'] ?></td>
          <td><?= substr($row['remark'], 0, 64); ?></td>
          <td><?= date('d M, Y', strtotime($row['date'])); ?></td>
        </tr>
    <?php
      }
    ?>
      </tbody>
    </table>
  </div>
</div>
