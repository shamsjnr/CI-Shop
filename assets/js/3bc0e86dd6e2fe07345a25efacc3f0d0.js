$('#select').change(function() {
  $('#price').val($(this).val());
});

let mod_base = $('#base').text() + 'ipanel/put/supply?target=';
$('#drop-off').on('click', '.mod', function(e) {
  e.preventDefault();

  let ref = $(this).data('ref');
  $('#send').data('ref', mod_base + ref);
  $('#send').removeClass('submit').addClass('update');
  $('#send i').removeClass('bi-download').addClass('bi-arrow-repeat');
  $('#send span').text('Update');
  let item = $(this).data('item');
  $('#select').val(item);
  $('#price').val(item);
  $('#qty').val($(this).data('count'));
});

$('.kForm').on('click', '.update', function(e){
  e.preventDefault();
  let me = $(this);
  let content = $('#drop-off');
  let form = me.parents('form');
  let url = me.data('ref');
  me.prop('disabled', true);
  $('#loader').removeClass('out');
  $.post(url, form.serialize(), function(res){
    me.prop('disabled', false);
    res = JSON.parse(res);
    if (!res.hasOwnProperty('status') || !res.hasOwnProperty('message')) return;
    else if (res.status == 'error') toast(res.status, res.status, res.message);
    if (res.status == 'success') {
      let msg = 'Record Updated';
      if (res.hasOwnProperty('extra')) {
        msg = res.extra;
        location.reload();
      }
      toast('success', 'Success', msg);
      $(content).html(res.message);
      form[0].reset();
      me.addClass('submit').removeClass('update');
      $(me).data('ref', mod_base.replace('put', 'post'));
      $('i', me).addClass('bi-download submit').removeClass('bi-arrow-repeat update');
      $('span', me).text('Add Entry');
    }
    $('#loader').addClass('out');
  }).fail(function(r, s, x) {
    toast('error', s, r);
    $('#loader').addClass('out');
  });
});