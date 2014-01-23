$('#dispatcher_change_stuffdescription_button').live('click', function(event, ui){
    var edit_link = $(this).attr("href");
    var target = $('#dispatcher_change_stuffdescription_value');
    var loading_img = $('#loading_stuffdescription');
    target.addClass('loading');
    loading_img.show();
    target.load(edit_link, function() {
      target.removeClass('loading');
      loading_img.hide();  
    });
    return false;
});

$('#dispatcher_form_stuffdescription_ajax').live('submit', function(event, ui){
    $(this).ajaxSubmit({
       success: saveStuffDescription, 
       beforeSubmit: changeStuffDescriptionClass
   })
   return false;
});

function saveStuffDescription()
{
  var target = $('#dispatcher_change_stuffdescription_value');
  var loading_img = $('#loading_stuffdescription');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/dispatcher.php/claimopened/getstuffdescriptionajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}

function changeStuffDescriptionClass()
{
   var target = $('#dispatcher_change_stuffdescription_value');
   var loading_img = $('#loading_stuffdescription');
   target.addClass('loading'); 
   loading_img.show();
}

$('#dispatcher_button_stuffdescription_cancel').live('click', function(event, ui){
   changeStuffDescriptionClass();
   saveStuffDescription();
   return false;
});