<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $item = $this->rgm_model->find('services', ['id'=>$this_id]);
  echo form_open(base_url('service'), ['class'=>'form myForm']);
?>
  <div class="group">
    <input type="text" class="input" name="title" value="<?= $item->name ?? '' ?>" required />
    <label>Name:</label>
  </div>
  <div class="group">
    <textarea class="input" name="description" required><?= $item->more ?? '' ?></textarea>
    <label>Description:</label>
  </div>
  <div class="group">
    <label>Price:</label>
    <input type="number" class="input" name="price" value="<?= $item->price ?? '' ?>" required />
  </div>
  <button type="submit" class="btn btn-yfarms submit" data-ref="<?= base_url('sys/service/'.$this_id) ?>"><?= $item ? 'Update' : 'Save' ?></button>
<?= form_close(); ?>
