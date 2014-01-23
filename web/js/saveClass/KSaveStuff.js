$('#kurator_change_stuff_button').live('click', function(event, ui){
    var target = $('#result');
    var edit_link = $(this).attr("href");
    target.html('Загрузка данных...');
    target.load(edit_link);
    if(!target.dialog()){
        target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true});
    return false;
}); 

$('#kurator_form_stuff_ajax').live('submit', function(event, ui){
    $(this).ajaxSubmit({
       success: saveStuff, 
       beforeSubmit: changeStuffClass
   })
   return false;
});

function saveStuff()
{
  var target = $('#kurator_change_stuff_value');
  var loading_img = $('#loading_stuff');
  var claim_id = $('.claim_id').attr('id');
  edit_link = '/kurator.php/claimopened/getstuffajax/id/'+claim_id;
  target.load(edit_link, function(){
     loading_img.hide();
     target.removeClass('loading'); 
  });  
}

function changeStuffClass()
{
   var target = $('#kurator_change_stuff_value');
   var loading_img = $('#loading_stuff');
   $('#result').dialog('close');
   target.addClass('loading'); 
   loading_img.show();
} 
