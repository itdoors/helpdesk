<?php
$rand = 'isFinanceClosed'; 
$result_id = 'result_'.$rand;
$loading_class = 'loading_'.$rand;  
//$url_response = $url_response."/claim_id/$claim_id";
$url_change = $url_change."/claim_id/$claim_id";
$status = $claim->getIsclosedstuff()?'Закрыта':'Открыта';
$status_form_submit = $claim->getIsclosedstuff()?'Открыть':'Закрыть';
?>
<div id="<?php echo $result_id?>">
  
  <?php echo get_component('ajax','boolForm', 
     array(
        'claim_id'=>$claim_id,
        'status'=>$status,
        'status_form_submit'=>$status_form_submit, 
        'url_change'=>$url_change))
        ?>
</div>
<script>
$('#<?php echo $result_id?>').find('form').live('submit', function(event, ui){
     $(this).ajaxSubmit({
      success: function (responseText, statusText)
            {
                var target = $('div#<?php echo $result_id?>');
                $('#<?php echo $result_id?>').html(responseText);
            }, 
      beforeSubmit: function ()
            {
                $('.<?php echo $loading_class?>').remove();
                $('#<?php echo $result_id?>').find('form').after('<div class="<?php echo $loading_class?>">Сохранение...</div>'); 
 
            }
    }) 
 return false;
});
</script>
