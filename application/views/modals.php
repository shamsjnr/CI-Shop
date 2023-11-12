<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal fade" id="mModal">  
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 24px;">
      <div id="loader" class="out"></div>
      <div class="modal-header border-0 text-success">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border-top border-warning rounded" style="padding: 36px 24px;" id="modal-drop">
        <div class="container-fluid text-center"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade px-2" id="mModalX" style="z-index: 99999; margin-top: -80px;">  
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 overflow-hidden" style="border-radius: 12px; box-shadow: 0 0 12px -1px rgba(0,0,0,.2);">
      <div class="modal-header pb-2 pt-3 border-0">
        <h5 class="mb-0"><i class="bi-exclamation-octagon-fill text-danger"></i> Warning</h5>
      </div>
      <div class="modal-body rounded text-center px-0">
        <div class="container-fluid p-3 mb-3" id="alert-text"></div>
        <div class="container text-end">
          <a href="javascript:void(0)" class="btn btn-outline-success hover-cast mx-3" id="ok" data-bs-dismiss="modal">Continue</a>
          <a href="javascript:void(0)" class="btn btn-outline-danger hover-cast" data-bs-dismiss="modal" aria-label="close">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>