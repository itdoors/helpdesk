$('#dispatcher_change_ourcosts_button').live('click', function(event, ui){
    var edit_link = $(this).attr("href");
    var target = $('#dispatcher_change_ourcosts_value');
    var loading_img = $('#loading_ourcosts');
    target.addClass('loading');
    loading_img.show();
    target.load(edit_link, function() {
      target.removeClass('loading');
      loading_img.hide();  
    });
    return false;
}); 

$('#dispatcher_form_ourcosts_ajax').live('submit', function(event, ui){
    $(this).ajaxSubmit({
       success: saveOurcosts, 
       beforeSubmit: changeOurcostsClass
   })
   return false;
});

function saveOurcosts()
{
  var target = $('#dispatcher_change_ourcosts_value');
  var loading_img = $('#loading_ourcosts');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/dispatcher.php/claimopened/getourcostsajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}
function changeOurcostsClass()
{
   var target = $('#dispatcher_change_ourcosts_value');
   var loading_img = $('#loading_ourcosts');
   target.addClass('loading'); 
   loading_img.show();
}

$('#dispatcher_button_ourcosts_cancel').live('click', function(event, ui){
   changeOurcostsClass();
   saveOurcosts();
   return false;
});