<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $task = $this->rgm_model->find_all('tasks', ['voucher'=>$this->input->get('target')]);
  if ($task) {
?>
<div style="font-size: 1.2rem;">
  <div class="text-end pb-3 d-block d-print-none">
    <button type="button" class="btn btn-yfarms" onclick="window.print()"><i class="bi-printer-fill"></i> &nbsp; Print</button>
  </div>
  <div class="container">
    <div class="banner align-items-start pt-3">
      <div class="pb-4"><img src="<?= base_url('assets/images/logo.png'); ?>" width="160px" /></div>
      <h2 class="text-cast">INVOICE</h2>
    </div>
    <div class="banner mb-4 align-items-start">
      <div>
        <p class="mb-1"><b>BILLED TO:</b></p>
        <?= $task[0]['name'] ?><br />
        <?= $task[0]['phone'] ?>
      </div>
      <div class="text-end">
        Invoice No: <b><?= $task[0]['voucher'] ?></b><br />
        Date: <b><?= $task[0]['date'] ?></b>
      </div>
    </div>
  </div>
  <?php $cats = []; ?>
  <?php $cast = $this->rgm_model->find_all('services') ?: []; ?>
  <?php foreach ($cast as $key) $cats[$key['id']] = $key['name']; ?>
  <div class="container">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>Item Code</th>
          <th>Service</th>
          <th>Quantity</th>
          <th width="60px" class="text-center">Amount Total</th>
        </tr>
      </thead>
      <tbody>
      <?php $c = $total = 0; 
        foreach ($task as $row) { $c++;
          $total += $row['price'] * $row['quantity'];
      ?>
        <tr>
          <td><?= $row['task_id'] ?></td>
          <td><?= $cats[$row['service']] ?></td>
          <td><?= $row['quantity'] ?></td>
          <td class="text-end"><span class="money"><?= number_format($row['price'] * $row['quantity']) ?></span></td>
        </tr>
      <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">
            <h5 class="mb-0 py-3 text-end">Total &nbsp; <b class="money"><?= number_format($total); ?></b></h5>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<?php } else { ?>
<div class="text-danger p-5"><h5>Failed to open invoice</h5></div>
<?php } ?>