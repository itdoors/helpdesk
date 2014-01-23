<?php 
$rand = rand(100,2000);

$dialog_class = (isset($target)) ? $target : 'dialog_'.$rand;
$dialog_class_link = $dialog_class."_link";
$result_id = 'result_'.$rand;
?>
<div class="<?php echo $dialog_class?>">
  <a href="<?php echo $url?>" class="<?php echo $dialog_class_link?>"><?php echo $text?></a>
</div>
<div id="<?php echo $result_id?>"></div>
<script>
$('.<?php echo $dialog_class?>').find('a').live('click', function(event, ui){
    edit_link = $(this).attr("href")+"/&tempos="+Math.random();
    var target = $('#<?php echo $result_id?>');
    target.html('Загрузка данных...');
    target.load(edit_link);
    /*if(!target.dialog()){
        target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true});
    */   
     target.dialog(
       {
           beforeClose: function (){
               <?php if (isset($ref_functions))
                   foreach ($ref_functions as $ref_key => $ref_value) :
                ?>
                  $("<?php echo $ref_key?>").addClass('loading');
                  $("<?php echo $ref_key?>").load("<?php echo $ref_value?>"+"/tempos/"+Math.random(), function() {
                      $("<?php echo $ref_key?>").removeClass('loading');
                      
                    }); 
                <?php endforeach;?>
           },
           autoOpen:true,
           bgiframe:true,
           modal:true,
           resizable:true,
           width:500,height:500,position:['center', 'center'],draggable:true 
       }
     ); 
     //if (target.dialog( "isOpen" )) {alert('xxx')};
     //target.dialog();
    //target.dialog();
    return false;
});
</script>