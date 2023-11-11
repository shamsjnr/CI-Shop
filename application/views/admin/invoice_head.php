<div class="container-fluid text-center pb-1 pt-3 d-none d-print-block">
  <div class="row text-center">
    <div class="col-2">
      <div class="float-end">
        <img src="<?=base_url('assets/images/logo.jpg')?>" width="120px" height="120px" />
      </div>
    </div>
    <div class="col-10">
      <h2 class="pb-0 mb-0"><b>Y Farms</b></h2>
      <div class="container-fluid  px-0" style="line-height: 1.2; font-size: 1rem; font-family: arial narrow">
        <p class="my-0 py-0"><b>MOTTO:</b> Demo Motto. </p>
        <p class="my-0 py-0"><b>HEAD OFFICE:</b> Demo Head Office </p>
        <p class="my-0 py-0"><b>TEL:</b> 08012345678, 08087654321, 09098765431 &nbsp;&nbsp;
      </div>
    </div>
  </div>
  <div class="container-fluid pl-0">
    <h5 class="pt-3"><b><u>PURCHASE INVOICE</u></b></h5>
    <?php $cust = $this->rgm_model->find('customers', ['customer_id'=>$sale->customer]); ?>
    <div class="row pt-2 pb-3" style="font-weight: bold;">
      <div class="col-md-7 text-start">
        Customer ID: #<?= $cust->uid; ?><br />
        Phone Number: <?= $cust->phone ?><br />
      </div>
    </div>
    <h6 class="text-start"><b>DATE: <?=strtoupper(date('d F, Y', strtotime($sale->date)))?></b></h6>
  </div>
</div>