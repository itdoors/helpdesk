$('#dispatcher_change_description_button').live('click', function(event, ui){
    var edit_link = $(this).attr("href");
    var target = $('#dispatcher_change_description_value');
    var loading_img = $('#loading_description');
    target.addClass('loading');
    loading_img.show();
    target.load(edit_link, function() {
      target.removeClass('loading');
      loading_img.hide();  
    });
    return false;
}); 

$('#dispatcher_form_description_ajax').live('submit', function(event, ui){
    $(this).ajaxSubmit({
       success: saveDescription, 
       beforeSubmit: changeDescriptionClass
   })
   return false;
});

function saveDescription()
{
  var target = $('#dispatcher_change_description_value');
  var loading_img = $('#loading_description');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/dispatcher.php/claimopened/getdescriptionajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}
function changeDescriptionClass()
{
   var target = $('#dispatcher_change_description_value');
   var loading_img = $('#loading_description');
   target.addClass('loading'); 
   loading_img.show();
}

$('#dispatcher_button_description_cancel').live('click', function(event, ui){
   changeDescriptionClass();
   saveDescription();
   return false;
});