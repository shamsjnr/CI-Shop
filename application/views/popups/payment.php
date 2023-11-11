<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
  $this->db->select_sum('amount');
  $pay = $this->rgm_model->find('payments', ['service'=>$this_id])->amount ?? 0;
  $this->db->select('SUM(`price` * `quantity`) AS total');
  $sum = $this->rgm_model->find('tasks', ['voucher'=>$this_id])->total;
  $item = $this->rgm_model->find('payments', ['id'=>$this->input->get('target')]);
  echo form_open(base_url('payment'), ['class'=>'form myForm']);
?>
<form action="#" onsubmit="return false" id="adder" autocomplete="off">
  <div class="d-none">
    <input type="hidden" name="service" value="<?= $this_id; ?>">
  </div>
  <div class="group">
    <label>Outstanding Payment</label>
    <input type="text" class="input p-3 bg-secondary text-white text-center" disabled value="<?= number_format($sum - $pay); ?>" />
  </div>
  <div class="group">
    <label>Payment Date</label>
    <input type="date" class="input" value="<?= $item->date ?? date('Y-m-d') ?>" name="dated" required />
  </div>
  <div class="group">
    <label>Payment Amount</label>
    <input type="text" class="input" min="100" value="<?= $item->amount ?? 100 ?>" name="amount" required />
  </div>
  <button type="submit" class="btn btn-yfarms submit" data-ref="<?= base_url('sys/payment/'.$this->input->get('target')) ?>">Save</button>
<?= form_close(); ?>
