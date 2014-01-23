$('.depperson').find('form').live('submit', function(event, ui){
    if (confirm("Удалить?"))
    {
       $(this).ajaxSubmit({
           success: function ()
                   {
                      $(this).parent().parent().remove();
                      $('.loading_image').remove();  
                   }, 
           beforeSubmit: function ()
                   {
                      $(this).before('<div class="loading_image">Загрузка</div>');
                   }
       })
       $(this).parent().parent().remove(); 
    }
    
   return false;
});
$('.join_user').live('click', function(event, ui){
    edit_link = $(this).attr("href");
    var target = $('#result');
    target.html('Загрузка данных...');
    target.load(edit_link);
    if(!target.dialog()){
        target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true});
    
    return false;
    
});
$('.add_person_form').live('submit', function(event, ui){
    $(this).ajaxSubmit({
      success: function ()
            {
               var target = $('div#result'); 
              
               edit_link = $('#refresh').attr("href");
               $('#depperson_list').load(edit_link, function()
               {
                   $('.loading_image').remove();
                    target.dialog('close'); 
               });
               //alert('good');
            }, 
      beforeSubmit: function ()
            {
                $('.add_person_form').after('<div class="loading_image claim_new">Загрузка</div>'); 
            }
    }) 
 return false;
});



