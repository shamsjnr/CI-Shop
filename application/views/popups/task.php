<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
  $item = $this->rgm_model->find('tasks', ['voucher'=>$this_id]);
  $this->db->group_by('voucher');
  $uid = $this->rgm_model->find_count('tasks') + 10001;
  $uuid = $item->voucher ?? $uid;
  echo form_open(base_url('service'), ['class'=>'form myForm', 'id'=>'mainForm']);
?>
  <div class="row">
    <div class="col-lg-8">
      <div class="d-flex justify-content-between">
        <div class="group pe-1">
          <label>Service ID:</label>
          <input type="text" class="input" disabled readonly value="<?= $uuid ?>" required />
        </div>
        <div class="group ps-1">
          <label>Name:</label>
          <input type="text" class="input" name="name" value="<?= $item->name ?? '' ?>" required />
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <div class="group pe-1">
          <label>Collection Date:</label>
          <input type="text" name="date" class="input" data-provide="datepicker" data-date-format="yyyy-mm-dd" 
          data-date-autoclose="true" value="<?= $item->date ?? date('Y-m-d'); ?>" readonly="readonly" />
        </div>
        <div class="group ps-1">
          <label>Phone Number:</label>
          <input type="text" class="input" name="phone" value="<?= $item->phone ?? '' ?>" required />
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="group">
        <textarea class="input" rows="6" name="remark" required><?= $item->remark ?? '' ?></textarea>
        <label>Remark:</label>
      </div>
    </div>
  </div>
<?= form_close(); ?>
<?php
  $services = $this->rgm_model->find_all('services');
?>
<div>
  <div class="border p-3 rounded">
    <?= form_open(base_url('task'), ['class'=>'form myForm', 'id'=>'subForm']); ?>
    <div class="d-flex justify-content-between group mb-0">
      <input type="text" name="code" class="input me-2" placeholder="Item Code" />
      <select name="item" class="input">
        <option value="" class="d-none">- Select a Category -</option>
      <?php foreach ($services as $row): ?>
        <option value="<?= $row['id'] ?>" data-amount=<?= intval($row['price']); ?>><?= $row['name']; ?></option>
      <?php endforeach ?>
      </select>
      <input type="number" name="quantity" class="input ms-2" placeholder="Quantity" />
    </div>
    <div class="text-center pt-3">
      <button class="btn btn-outline-info subm w-50" data-form="subForm"
      data-ref="<?= base_url('sys/tasks/add?voucher='.($item->voucher ?? $uuid)) ?>">Add to list</button>
    </div>
    <?= form_close(); ?>
  </div>
  <div class="table-responsive pt-2">
    <table class="table">
      <thead>
        <tr>
          <th>Item Code</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Total</th>
          <th width="40px"></th>
        </tr>
      </thead>
      <tbody id="tasks"><?php include('tasks.php'); ?></tbody>
    </table>
  </div>
  <div class="row g-0">
    <div class="col-md-4 px-3"></div>
    <div class="col-md-5 offset-md-3 px-3">
    </div>
  </div>
  <button type="submit" class="btn btn-yfarms w-100 subm" id="sumx" data-form="mainForm" <?= ( ! $item) ? 'disabled' : ''; ?> 
  data-ref="<?= base_url('sys/tasks/save?target='.$uuid) ?>">Save</button>
</div>
<script type="text/javascript">
  $('#mModal .modal-dialog').addClass('modal-lg');
  $('.subm').click(function(e) {
    e.preventDefault();

    let me = $(this);
    me.prop('disabled', true);
    let form = $(`#${$(this).data('form')}`);
    $.post(me.data('ref'), form.serialize(), function(res) {
      me.prop('disabled', false);
      res = JSON.parse(res);
      if (!res.hasOwnProperty('status') || !res.hasOwnProperty('message')) return;
      else if (res.status == 'error') toast(res.status, res.status, res.message);
      else if (res.status == 'success') {
        if (me.hasClass('w-100')) {
          location.reload();
        } else {
          toast('success', 'Success', 'Service Added');
          $('#tasks').html(res.message);
          $('#sumx').prop('disabled', false);
          form[0].reset();
        }
      }
    });
  });
  $('#tasks').on('click', '.pop', function(e) {
    e.preventDefault();

    let me = $(this);
    $.get(me.data('ref'), function(res) {
      res = JSON.parse(res);
      if ( ! res.hasOwnProperty('status')) return;
      else if (res.status == 'error') toast(res.status, res.status, res.message);
      else if (res.status == 'success') {
        toast('success', 'Success', 'Service Removed');
        me.parents('tr').hide();
        let tot = 0;
        $('.tot:visible').each(function() {
          tot += Number($(this).data('total'));
        });
        $('#subtotal').text(tot.toLocaleString());
      }
    });
  });
</script>
