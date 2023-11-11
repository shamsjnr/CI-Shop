$(document).ready(function(){
  $('#overlay').addClass('out');
  
  $('#submit').click(function(e){    
    var me = $(this);
    me.addClass('in').prop('disabled', true);
    e.preventDefault();
    var url = $(this).data('ref');
    $.post(url, $('#myForm').serialize(), function(res){
      res = JSON.parse(res);
      if (!res.hasOwnProperty('status') || !res.hasOwnProperty('message')) {
        me.removeClass('in').prop('disabled', false);
        return;
      }
      if (res.status == 'success') location.reload();
      else me.removeClass('in').prop('disabled', false);
      res.status = res.status || 'error';
      let status = res.status.charAt(0).toUpperCase() + res.status.slice(1);
      toast(res.status, status, res.message);
    });
  });

  function toast(type, title, message) {
    $.Toast(title, message, type, {
      has_icon:true,
      has_close_btn:true,
      stack: true,
      timeout:7000,
      sticky:false,
      position_class: 'toast-top-right',
      has_progress:true,
      rtl:false
    });
  }
});