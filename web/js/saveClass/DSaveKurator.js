$('#dispatcher_change_kurator_button').live('click', function(event, ui){
    var target = $('#result');
    var edit_link = $(this).attr("href");
    target.html('Загрузка данных...');
    target.load(edit_link);
    if(!target.dialog()){
        target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true});
    return false;
}); 

$('#dispatcher_form_kurator_ajax').live('submit', function(event, ui){
    $(this).ajaxSubmit({
       success: saveKurator, 
       beforeSubmit: changeKuratorClass
   })
   return false;
});

function saveKurator()
{
  var target = $('#dispatcher_change_kurator_value');
  var loading_img = $('#loading_kurator');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/dispatcher.php/claimopened/getkuratorajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}

function changeKuratorClass()
{
   var target = $('#dispatcher_change_kurator_value');
   var loading_img = $('#loading_kurator');
   $('#result').dialog('close');
   target.addClass('loading'); 
   loading_img.show();
}