var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

function toast(type, title, message) {
  title = title[0].toUpperCase() + title.substring(1);
  $.Toast(title, message, type, {
    has_icon:true,
    has_close_btn:true,
    stack: true,
    timeout:10000,
    sticky:false,
    position_class: 'toast-top-right',
    has_progress:true,
    rtl:false
  });
}

$('#main-container').focus();
$('#overlay').addClass('out');

$('button.t1').click(function(){
  $('#fakeNav').toggleClass('in');
  $('i', $(this)).toggleClass('bi-list bi-x-lg');
});

$('#fakeNav').click(function(e){
  if (e.target === this) {
    $(this).removeClass('in');
    $('button.t1 i').toggleClass('bi-list bi-x-lg');
  }
});

$('#title').html($('#fakeNav .nav-link.active').html());
$('.linking').click(function(){$('#overlay').removeClass('out')});

var mod = '';
$('#main-container').on('click', '[data-bs-target="#mModal"]', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  let me = $(this);
  if (mod != url) {
    $('#mModal .modal-dialog').removeClass('modal-lg');
    $('#mModal .modal-dialog .modal-body').html('');
    $('#loader').removeClass('out');
    $('.modal-title').text('Please wait...');
    $('#modal-drop').load(url, function(result){
      $('.modal-title').text(me.data('title'));
      $('#loader').addClass('out');
      mod = url;
    })
  }
});

$('#main-container, #mModal, .nav-item').on('click', '[data-bs-target="#mModalX"]', function(e) {
  e.preventDefault();
  let txt = $('.msg', $(this)).html();
  $('#ok').data('ref', $(this).attr('href'));
  $('#ok').data('content', $(this).data('content'));
  $('#alert-text').html(txt);
});
$('#ok').click(function(e){
  e.preventDefault();
  let url = $(this).data('ref');
  $('#overlay').removeClass('out');
  $.get(url, function(res){
    if (url.indexOf('/signout') != -1) location.reload();
    res = JSON.parse(res);
    if (!res.hasOwnProperty('status') || res.status == 'error') {
      toast('error', 'error', 'Request Failed');
      $('#overlay').addClass('out');
    } else if (res.status == 'success') {
      if (res.message.substring(0, 6) == 'https:') window.location = res.message;
      location.reload();
    }
  }).fail(function(r, s, x) {
    toast('error', s, r);
    $('#overlay').addClass('out');
  });;
});

var mModal = new bootstrap.Modal(document.getElementById('mModal'));
$('#mModal, #kForm, .kForm').on('click', '.submit', function(e){
  e.preventDefault();
  let me = $(this);
  let form = me.data('form') ? $(me.data('form')) : $(this).parents('form');
  let url = me.data('ref');
  me.prop('disabled', true);
  $('#loader').removeClass('out');
  $.post(url, form.serialize(), function(res){
    me.prop('disabled', false);
    res = JSON.parse(res);
    if (!res.hasOwnProperty('status') || !res.hasOwnProperty('message')) return;
    else if (res.status != 'success') {
      toast(res.status, res.status, res.message);
      $('#loader').addClass('out'); 
    } else if (res.message.substring(0, 6) == 'https:') window.location = res.message;
    else if (res.status == 'success') location.reload();
  }).fail(function(r, s, x) {
    toast('error', s, r);
    $('#loader').addClass('out');
  });
});

$('#mModal').on('click', '[data-t-toggle]', function(e) {
  e.preventDefault();
  $(this).parent().prev().toggleClass('edit');
  $('a, button', $(this).parent()).toggleClass('d-none');
  $('input', $(this).parent().prev()).prop('disabled', (a, b) => !b).focus();
});

$('#main-container').on('click', '.sub-url', function(e){
  e.preventDefault();
  $('#overlay').removeClass('out');
  $.get($(this).data('ref'), function(res){
    res = JSON.parse(res);
    if (!res.hasOwnProperty('status') || !res.hasOwnProperty('message')) {
      toast('warning', 'Ufff...', 'Request was not completed. <br />Refresh and try again');
      $('#overlay').addClass('out');
    }
    if (res.status == 'error') {
      toast(res.status, res.status, 'Request Failed');
      $('#overlay').addClass('out');
    }
    if (res.message == '') location.reload();
  }).fail(function(r, s, x) {
    toast('error', s, r);
    $('#overlay').removeClass('out');
  });
});
