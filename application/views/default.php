<?php 
  defined('BASEPATH') OR exit('No direct script access allowed');
  $xuser = $this->session->userdata('yf_user');
  include ('head.php'); 
?>
<div id="overlay"></div>
<div class="container h-100" id="main-content">
  <div class="d-print-none" id="fakeNav">
    <div class="container">
      <div class="container-fluid text-center py-3" style="height: 120px; overflow: hidden;">
        <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Company Logo" style="max-height: 100%;" />
      </div>
      <ul class="nav overflow-hidden flex-column pb-3">
        <?php include('admin/nav.php');?>
        <li class="nav-item position-absolute fixed-bottom">
          <a href="<?= base_url('pull/password'); ?>" class="nav-link" data-bs-target="#mModal" data-bs-toggle="modal" data-title="Change Password">
            <i class="bi-unlock"></i> Change Password </a>
          <a href="<?= base_url('signout'); ?>" class="nav-link" data-bs-toggle="modal" data-bs-target="#mModalX">
            <i class="bi-power text-danger"></i> Log out
            <span class="msg d-none">Click <b class="text-success">continue</b> to confirm</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <div class="container-fluid  px-0 px-md-2 h-100" id="main">
    <div class="d-print-none d-flex justify-content-between align-items-center py-3" style="height: 54px;">
      <h5 id="title" class="text-cast m-0"></h5>
      <span class="d-none d-md-block px-2"><i class="bi-person-circle"></i> <?= $this->session->userdata('yf_name') ?></span>
      <button class="d-block d-md-none btn text-warning btn-lg t1 d-block d-md-none" style="text-shadow: .5px .5px .5px #333"><i class="bi-list"></i></button>
    </div>
    <div class="bgs py-3 position-relative" style="height: calc(100% - 54px);">
      <div id="main-container" class="position-absolute py-lg-4 px-lg-3 py-3" style="top: 0; left: 0; right: 0; bottom: 0; overflow-y: auto;">
        <?php include ('admin/'.$page.'.php'); ?>
      </div> 
      <div class="container text-center d-none d-print-block py-3" style="font-size: .9rem; opacity: .5;">
        <em>Powered By</em>&nbsp; <a href="https://ionicbitz.net" class="d-inline-block" style="text-decoration: none;">IonicBitz</a></div>
    </div>
  </div>
</div>
<?php include('modals.php'); ?>
<span class="d-none" id="notify"><?= $this->session->flashdata('notetext'); ?></span>
</body>
</html>
