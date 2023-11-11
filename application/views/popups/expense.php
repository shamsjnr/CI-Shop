<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $item = $this->rgm_model->find('expenses', ['id'=>$this_id]);
  echo form_open(base_url('expenses'), ['class'=>'form myForm']); 
?>
  <div class="group">
    <label>Date of Expense:</label>
    <input type="text" name="dated" class="input" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?= date('Y-m-d'); ?>" readonly="readonly" />
  </div>
  <div class="group">
    <label>Expense Category:</label>
    <select name="category" class="input">
      <option value="" class="d-none">- Select a Category -</option>
    <?php $cats = $this->rgm_model->find_all('categories'); ?>
    <?php foreach ($cats as $row): ?>
      <option value="<?= $row['id'] ?>" <?= $item && $item->category == $row['id'] ? 'selected' : '' ?>><?= $row['name']; ?></option>
    <?php endforeach ?>
    </select>
  </div>
  <div class="group">
    <label>Payment Amount</label>
    <input type="text" class="input" min="100" value="<?= $item->amount ?? 100 ?>" name="amount" required />
  </div>
  <div class="group">
    <label>Description (<span class="text-danger">optional</span>):</label>
    <textarea class="input" name="description" rows="5" placeholder="Extra details on how or why we made this expense?" required><?= $item->more ?? '' ?></textarea>
  </div>
  <button type="submit" class="btn btn-yfarms submit" data-ref="<?= base_url('sys/expenses/'.$this_id) ?>">Save</button>
<?= form_close(); ?>
<link rel="stylesheet" href="<?= base_url().'assets/datepicker/bootstrap-datepicker3.standalone.min.css'?>" />
<script type="text/javascript" src="<?= base_url().'assets/datepicker/bootstrap-datepicker.min.js'?>"></script>
