<?php 
$rand = $field;
$relfield_add = isset($relfield)?"/relfield/$relfield/":''; 
$relresult_id = isset($relfield)?'result_'.$relfield:'';
$relfunction_ajax = isset($relfieldRefreshFunction)?$relfieldRefreshFunction."/relfield/$relfield/claim_id/$claim_id":'';
$profitability_url = url_for('ajax/getAjaxProfitability')."/claim_id/$claim_id";
$dialog_class = 'field_'.$rand;
$result_id = 'result_'.$rand;
$resultpofitability_id = 'result_profitability';
$before_id = 'before_'.$rand; 
$loading_class = 'loading_'.$rand;
$file_path = isset($file_path)?"/file_path/$file_path":"";
$url_fefresh_file_transfer = $file_path?url_for('ajax/refreshFilesTransfered')."/claim_id/$claim_id":"";
?>
<div id="<?php echo $before_id?>" style="display: none;"><?php echo htmlspecialchars_decode($default)?></div>
<div id="<?php echo $result_id?>"><?php echo htmlspecialchars_decode($default)?></div>
<?php if (!$formtemplate) $formtemplate = 'ajaxFieldForm'; ?>
<a href="<?php echo $url_open."/claim_id/$claim_id/field/$field/formtemplate/$formtemplate".$relfield_add.$file_path?>" class="<?php echo $dialog_class?>">Редактировать</a> 
<script>
$('.<?php echo $dialog_class?>').live('click', function(event, ui){
    edit_link = $(this).attr("href");
    var target = $('#<?php echo $result_id?>');
    target.addClass('loading');
    target.load(edit_link, function() {
      target.removeClass('loading');
    });
    $(this).css('display','none');
    return false;
});  

$('#<?php echo $result_id?>').find('form').live('submit', function(event, ui){
     $(this).ajaxSubmit({
      success: function (responseText, statusText)
            {
                var target = $('div#<?php echo $result_id?>');
                if (responseText=='False') 
                {
                    $('.<?php echo $loading_class?>').html('Неверно введенные данные');
                } else {
                   $('.<?php echo $loading_class?>').remove();
                   target.html(responseText);
                   <?php if ($relresult_id) :?>
                       $('div#<?php echo $relresult_id?>').load('<?php echo $relfunction_ajax?>');
                   <?php endif;?>
                   <?php if ($file_path) :?>
                       $('#result_smeta_file').load('<?php echo $url_fefresh_file_transfer?>');
                   <?php endif;?>
                    
                   $('div#<?php echo $resultpofitability_id?>').load('<?php echo $profitability_url?>');
                   $('.<?php echo $dialog_class?>').css('display','block');    
                }
                

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
                $('.<?php echo $loading_class?>').remove();
                $('#<?php echo $result_id?>').find('form').after('<div class="<?php echo $loading_class?>">Сохранение...</div>'); 
                <?php if ($relresult_id) :?>
                       $('div#<?php echo $relresult_id?>').after('<div class="<?php echo $loading_class?>">Сохранение...</div>');
                <?php endif;?> 
            }
    }) 
 return false;
});

$('#<?php echo $result_id?>').find('.cancel_form').live('click', function(event, ui){
    var target = $('#<?php echo $result_id?>');
    target.html($('#<?php echo $before_id?>').html())
    $('.<?php echo $dialog_class?>').css('display','block');
        
    return false;
});


</script>