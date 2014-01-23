<?php 
$rand = rand(100,2000);
$dialog_class = 'dialog_'.$rand;
$result_id = 'result_'.$rand;
?>
<a href="<?php echo $url?>" class="<?php echo $dialog_class?>"><?php echo $text?></a>
<div id="<?php echo $result_id?>"></div>
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
</script>