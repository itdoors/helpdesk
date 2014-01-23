<?php 
  $current = $target?"current$target":"current$model";
  $editable = $target?"editable$target":"editable$model"; 
  $process = $target?"process$target":"process$model";
  $before = $target?"before$target":"before$model";
  $default_request = '';
  if (isset($default))
  {
    
    foreach($default as $key => $value)
    {
       $default_request .= htmlentities("&default[$key]=$value"); 
    } 
  }
?>

<?php $url_open = url_for('Fmodel/Edit_form')."?model=$model$default_request"?><br />
<div id="<?php echo $before?>" style="display: none;"><a class="button" href="<?php echo $url_open?>" id="<?php echo rand();?>"><?php echo __('Add work')?></a></div>
<div id="<?php echo $editable?>"><a class="button" href="<?php echo $url_open?>" id="<?php echo rand();?>"><?php echo __('Add work')?></a></div>
<div id="<?php echo $current?>"></div>
<div id="<?php echo $process?>"></div>

<script>
$('#<?php echo $editable?>').find('a').live('click', function(event, ui){ 
    edit_link = $(this).attr("href")+"&tempos="+Math.random();
    var target = $('#<?php echo $current?>');
    var process = $('#<?php echo $process?>'); 
    target.addClass('loading');
    process.html('Загрузка...');
    $(this).css('display','none');  
    target.load(edit_link, function() {
      target.removeClass('loading');
      process.html('');
    });
    return false; 
});
$('#<?php echo $current?>').find('form').live('submit', function(event, ui){
    var target = $('#<?php echo $current?>');
    var process = $('#<?php echo $process?>');
    var editable = $('#<?php echo $editable?>').find('a'); 
    $(this).ajaxSubmit({
      success: function (responseText, statusText)
            {
                process.html('');
                editable.css('display','block'); 
                target.html(responseText);
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
                process.html('Сохранение...');
            }
    }) 
 return false;
});
$('#<?php echo $current?>').find('.cancel_form').live('click', function(event, ui){
    var target = $('#<?php echo $current?>');
    var editable = $('#<?php echo $editable?>').find('a');
    target.html('');
    editable.css('display','block');
    return false;
}); 
</script>