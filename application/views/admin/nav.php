<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<li class="nav-item">
  <a href="<?= ($page=='dashboard') ? 'javascript:void(0)' : base_url('upanel/dashboard'); ?>" class="nav-link <?= ($page=='dashboard') ? 'active' : 'linking'; ?>">
    <i class="bi-speedometer"></i> <span>Dashboard</span>
  </a>
</li>
<li class="nav-item">
  <a href="<?= ($page=='services') ? 'javascript:void(0)' : base_url('upanel/services'); ?>" class="nav-link <?= ($page=='services') ? 'active' : 'linking'; ?>">
    <i class="bi-cart"></i> <span>Services</span>
  </a>
</li>
<li class="nav-item">
  <a href="<?= ($page=='expenses') ? 'javascript:void(0)' : base_url('upanel/expenses'); ?>" class="nav-link <?= ($page=='expenses') ? 'active' : 'linking'; ?>">
    <i class="bi-cash"></i> <span>Expenses</span>
  </a>
</li>
<li class="nav-item drop">
  <a href="javascript:void(0)" onclick="this.classList.toggle('active')" class="nav-link drop-toggle <?= (substr($page, 0, 4) == 'set_') ? 'active' : ''; ?>">
    <i class="bi-gear"></i> <span>Settings</span>
  </a>
  <div class="drop-menu">
    <a href="<?= base_url('upanel/set_staff') ?>" class="nav-link <?= ($page=='set_staff') ? 'active' : 'linking'; ?>">Manage Staff</a>
    <a href="<?= base_url('upanel/set_services') ?>" class="nav-link <?= ($page=='set_services') ? 'active' : 'linking'; ?>">Service Categories</a>
    <a href="<?= base_url('upanel/set_categories') ?>" class="nav-link <?= ($page=='set_categories') ? 'active' : 'linking'; ?>">Expense Categories</a>
  </div>
</li>
<li class="nav-item">
  <a href="<?= ($page=='report') ? 'javascript:void(0)' : base_url('upanel/report'); ?>" class="nav-link <?= ($page=='report') ? 'active' : 'linking'; ?>">
    <i class="bi-file-ruled-fill"></i> <span>Report</span>
  </a>
</li>
