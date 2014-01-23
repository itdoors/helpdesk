<?php
$current = "current$id$model$field";
$editable = "editable$id$model$field";
$process = "process$id$model$field";
$before = "before$id$model$field";
$delete = "delete$id$model$field";
$float = isset($float)?$float:0;
$with_delete = (isset($with_delete) ? $with_delete : false);
//$default = $default?$default:'Редактировать';
?>
<div id="<?php echo $before?>" style="display: none;"><?php if (!$float) echo $default; else printf("%01.2f", $default)?></div>
<div id="<?php echo $current?>"><?php echo $default?></div>
<div id="<?php echo $editable?>"><a href="<?php echo url_for('Fmodel/edit_field')."/model/$model/field/$field/id/$id/toString/$toString/float/$float"?>"><?php echo __('Edit')?></a></div>
<?php if ($with_delete):?>
   <form id="<?php echo $delete?>" action="<?php echo url_for('Fmodel/delete')."/model/$model/field/$field/id/$id/toString/$toString/float/$float"?>">
      <input type="submit" value="Удалить">
   </form>
<?php endif;?>
<div id="<?php echo $process?>"></div>
<script>
$('#<?php echo $editable?>').find('a').bind('click', function(event, ui){ 
    edit_link = $(this).attr("href")+"/tempos/"+Math.random();
    var target = $('#<?php echo $current?>');
    var process = $('#<?php echo $process?>');
    target.addClass('loading');
    process.html('<?php echo __('Loading...')?>');
    target.load(edit_link, function() {
      target.removeClass('loading');
      process.html('');
    });
    $(this).css('display','none');
    return false; 
});

 $('#<?php echo $delete?>').submit(function(event, ui){
     var process = $('#<?php echo $process?>');
     confirm("<?php echo __('Are you sure')?>"); 
      $(this).ajaxSubmit({
      success: function (responseText, statusText)
            {
                <?php if (isset($ref_functions))
                   foreach ($ref_functions as $ref_key => $ref_value) :
                ?>
                  $("<?php echo $ref_key?>").addClass('loading');
                  $("<?php echo $ref_key?>").load("<?php echo $ref_value?>"+"/tempos/"+Math.random(), function() {
                      $("<?php echo $ref_key?>").removeClass('loading');
                      
                    }); 
                <?php endforeach;?>
            }, 
      beforeSubmit: function ()
            {
                process.html('<?php echo __('Deleting...')?>');
            }
    })  
 return false;
});


$('#<?php echo $current?>').submit(function(event, ui){
   // alert("xxx");
     var target = $('#<?php echo $current?>');
     var process = $('#<?php echo $process?>');
     var before = $('#<?php echo $before?>');
     var editable = $('#<?php echo $editable?>').find('a');
     $(this).find('form').ajaxSubmit({
      success: function (responseText, statusText)
            {
                process.html('');
                editable.css('display','block'); 
                target.html(responseText);
                before.html(responseText);
                <?php if (isset($ref_functions))
                   foreach ($ref_functions as $ref_key => $ref_value) :
                ?>
                  $("<?php echo $ref_key?>").addClass('loading');
                  $("<?php echo $ref_key?>").load("<?php echo $ref_value?>"+"/tempos/"+Math.random(), function() {
                      $("<?php echo $ref_key?>").removeClass('loading');
                      
                    }); 
                <?php endforeach;?>
            }, 
      beforeSubmit: function ()
            {
                process.html('<?php echo __('Saving...')?>');
            }
    })  
 return false;
});
$('#<?php echo $current?>').find('.cancel_form').live('click', function(event, ui){
    var target = $('#<?php echo $current?>');
    var editable = $('#<?php echo $editable?>').find('a');
    target.html($('#<?php echo $before?>').html());
    editable.css('display','block');
    return false;
}); 
</script>