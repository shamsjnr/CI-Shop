<?php
  $sale = $this->rgm_model->find('sales', ['token'=>$this->input->get('receipt')]);
  if ($sale === false) {
?>
<div class="text-cast text-danger py-3 mt-3 text-center">
  <i class="bi-frown-o fa-5x"></i> <br />
  <h3>An error occured while setting details, Please try again</h3>
</div>
<?php
  } else {
    $data = json_decode($sale->data, true);
    $total = 0;
?>
<div class="container-fluid py-3 d-print-none text-end">
  <h4>&nbsp;
    <a href="javascript:void(0)" class="btn btn-outline-success" onclick="window.print()">
      <i class="bi-print"></i> Print Invoice
    </a>
  </h4>
</div>
<?php $paper='INVOICE'; include('invoice_head.php') ?>
<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th width="10px">#</th>
        <th>Item</th>
        <th width="80px">Price</th>
        <th width="40px">Units</th>
        <th width="10px">Sub total</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      if (is_array($data) && count($data) > 0) { $c = 0;
        foreach ($data as $key=>$value) {
          $c++;
    ?>
      <tr>
        <td><?= $c; ?></td>
        <td><?= $this->rgm_model->find_named('items', ['token'=>$key]); ?></td>
        <td class="text-nowrap"><span class="money"><?= number_format($value['price'], 2); ?></span></td>
        <td><?= $value['qty']; ?></td>
        <td class="text-nowrap"><span class="money"><?= number_format(($value['price'] * $value['qty']), 2); ?></span></td>
      </tr>
    <?php
          $total += ($value['price'] * $value['qty']);
        }
      } else {
        echo '<tr><td colspan="6" class="text-center">No data available</td></tr>';
      }
    ?>
      <tr><td colspan="6"></td></tr>
      <tr class="text-end text-nowrap"><td colspan="4">Total</td><td colspan="2"><span class="money"><?= number_format($total, 2); ?></span></td></tr>
    </tbody>
  </table>
</div>
<div class="container-fluid text-end">
  <h6 style="font-size: 18px; padding-end: 16px;">
    Amount in words: 
    <b><i><span id="amount"><?=$total?></span></i></b>
  </h6>
</div>
<div class="container-fluid d-none d-print-block" style="margin-top: 4em; font-size: 16px">
  <div class="row">
    <div class="col-7">
      <b>Prepared By:</b><br />
      <?= $this->rgm_model->find_named('admin', ['token'=>$sale->done_by]); ?><br />
    </div>
    <div class="col-5">
      <b>Acknowledged By:</b>
      <hr width="70%" style="border: 1px solid #222; margin-top: 40px" />
    </div>
  </div>
</div>
<script type="text/javascript" src="<?=base_url('assets/jqnum2words/jquery.num2words.js')?>"></script>
<script type="text/javascript">
  $('#amount').num2words();
</script>
<?php } ?>