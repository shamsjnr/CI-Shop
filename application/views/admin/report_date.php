<div class="container">
  <form class="form kForm">
    <div class="row g-0">
      <div class="col-md-4 pe-md-3">
        <div class="group m-md-0">
          <label>Start Date</label>
          <input type="text" name="start_date" class="input py-2" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?= $xdate ?? ''; ?>" readonly="readonly" placeholder="Click to set" />
        </div>
      </div>
      <div class="col-md-4 pe-md-3">
        <div class="group m-md-0">
          <label>End Date</label>
          <input type="text" name="stop_date" class="input py-2" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="<?= $ydate ?? ''; ?>" readonly="readonly" placeholder="Click to set" />
        </div>
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-yfarms py-2 submit" data-ref="<?= base_url('sys/report/'.$page) ?>">Generate</button>
      </div>
    </div>
  </form>
</div>