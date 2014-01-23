$('#kurator_change_status_button').live('click', function(event, ui){
    var edit_link = $(this).attr("href");
    var target = $('#kurator_change_status_value');
    var loading_img = $('#loading_status');
    target.addClass('loading');
    loading_img.show();
    target.load(edit_link, function() {
      target.removeClass('loading');
      loading_img.hide();  
    });
    return false;
});

$('#kurator_form_status_ajax').live('submit', function(event, ui){
   $(this).ajaxSubmit({
       success: saveStatus, 
       beforeSubmit: changeStatusClass
   })
   return false;
});

function saveStatus()
{
  var target = $('#kurator_change_status_value');
  var loading_img = $('#loading_status');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/kurator.php/claimopened/getstatusajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}
function changeStatusClass()
{
   var target = $('#kurator_change_status_value');
   var loading_img = $('#loading_status');
   target.addClass('loading'); 
   loading_img.show();
}
$('#kurator_button_status_cancel').live('click', function(event, ui){
   changeStatusClass()
   saveStatus();
   return false;
});