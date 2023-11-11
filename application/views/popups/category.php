<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $item = $this->rgm_model->find('categories', ['id'=>$this_id]);
  echo form_open(base_url('category'), ['class'=>'form myForm']);
?>
  <div class="group">
    <input type="text" class="input" name="title" value="<?= $item->name ?? '' ?>" required />
    <label>Name:</label>
  </div>
  <div class="group">
    <textarea class="input" name="description" required><?= $item->more ?? '' ?></textarea>
    <label>Description:</label>
  </div>
  <button type="submit" class="btn btn-yfarms submit" data-ref="<?= base_url('sys/category/'.$this_id) ?>">Save</button>
<?= form_close(); ?>
