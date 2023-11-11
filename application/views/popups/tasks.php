<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
  $this->db->order_by('created_at DESC');
  $tasks = $this->rgm_model->find_all('tasks', ['voucher'=>$uuid]);
  $this->db->order_by('name');
  $services = $this->rgm_model->find_all('services');
  $cats = []; $total = 0;
  foreach ($services as $s) $cats[$s['id']] = $s['name'];
  foreach ($tasks as $row): 
    $total += $row['price'] * $row['quantity'];
?>
  <tr>
    <td class="d-none row-total"><?= $row['price'] * $row['quantity']; ?></td>
    <td><?= $row['task_id'] ?></td>
    <td><?= $cats[$row['service']] ?></td>
    <td><?= $row['quantity'] ?></td>
    <td><span class="money"><?= number_format($row['price']) ?></span></td>
    <td><span class="money tot" data-total="<?= $row['price'] * $row['quantity'] ?>"><?= number_format($row['price'] * $row['quantity']) ?></span></td>
    <td class="py-1"><button data-ref="<?= base_url('sys/tasks/drop?target='.$row['id']); ?>" 
      class="btn btn-sm pop"><i class="bi-trash3-fill text-danger"></i></button></td>
  </tr>
<?php endforeach ?>
<?php if (count($tasks) < 1): ?>
  <tr><td colspan="6" class="text-danger text-center p-5">No data</td></tr>
<?php else: ?>
  <tr><td colspan="6" class="text-center p-3">Total: <b class="money" id="subtotal"><?= number_format($total); ?></b></td></tr>
<?php endif ?>
