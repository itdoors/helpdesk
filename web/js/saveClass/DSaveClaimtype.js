$('#dispatcher_change_claimtype_button').live('click', function(event, ui){
    
    var edit_link = $(this).attr("href");
    //alert(edit_link);
    var target = $('#dispatcher_change_claimtype_value');
    var loading_img = $('#loading_claimtype');
    target.addClass('loading');
    loading_img.show();
    target.load(edit_link, function() {
      target.removeClass('loading');
      loading_img.hide();  
    });
    return false;
}); 

$('#dispatcher_form_claimtype_ajax').live('submit', function(event, ui){
    $(this).ajaxSubmit({
       success: saveClaimtype, 
       beforeSubmit: changeClaimtypeClass
   })
   return false;
});

function saveClaimtype()
{
  var target = $('#dispatcher_change_claimtype_value');
  var loading_img = $('#loading_claimtype');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/dispatcher.php/claimopened/getclaimtypeajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}

function changeClaimtypeClass()
{
   var target = $('#dispatcher_change_claimtype_value');
   var loading_img = $('#loading_claimtype');
   target.addClass('loading'); 
   loading_img.show();
}

$('#dispatcher_button_claimtype_cancel').live('click', function(event, ui){
   changeClaimtypeClass();
   saveClaimtype();
   return false;
});