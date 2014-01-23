<?php
$rand = rand(100,2000);
$dialog_class = 'dialog_'.$rand;
$result_id = 'result_'.$rand;
$default = isset($text)?$text:'Редактировать';
$url_open = $url_open."/formtemplate/$formtemplate/cliam_id" 
?>
<a href="<?php echo $url_open?>" class="<?php echo $dialog_class?>"><?php echo $default?></a>
<div id="<?php echo $result_id?>">
 
</div>
<script>
$('.<?php echo $dialog_class?>').live('click', function(event, ui){
    edit_link = $(this).attr("href");
    var target = $('#<?php echo $result_id?>');
    target.html('Загрузка данных...');
    target.load(edit_link);
    if(!target.dialog()){
        target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true});
    

    
    return false;
});  

$('#<?php echo $result_id?>').find('form').live('submit', function(event, ui){
     $(this).ajaxSubmit({
      success: function ()
            {
                var target = $('div#<?php echo $result_id?>');
                //target.dialog('close'); 
              /* var target = $('div#<?php echo $result_id?>'); 
              
               edit_link = $('#refresh').attr("href");
               $('#depperson_list').load(edit_link, function()
               {
                   $('.loading_image').remove();
                    target.dialog('close'); 
               });
               //alert('good');    */
            }, 
      beforeSubmit: function ()
            {
                $('#<?php echo $result_id?>').find('form').after('zzzz<div class="loading_image new_claim">Загрузка</div>'); 
                
            }
    }) 
 return false;
});


</script>       
