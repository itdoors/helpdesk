<?php 
  $current = $target?"current$target":"current$model";
  $form_class = isset($form_class)?$form_class:"$model";
  $editable = $target?"editable$target":"editable$model"; 
  $process = $target?"process$target":"process$model";
  $reffunc = $target?"reffunc$target":"reffunc$model";
  $before = $target?"before$target":"before$model";
  $button_text = $button_text ? $button_text : 'Add';
  $with_dialog = isset($with_dialog) ? $with_dialog : false;
  $default_request = '';
  if (isset($default))
  {
    
    foreach($default as $key => $value)
    {
       $default_request .= htmlentities("&default[$key]=$value"); 
    } 
  }
?>

<?php $url_open = url_for('Fmodel/Edit_form')."?model=$model&form_class=$form_class$default_request"?><br />
<div id="<?php echo $before?>" style="display: none;"><a class="button" href="<?php echo $url_open?>" id="<?php echo rand();?>"><?php echo __($button_text)?></a></div>
<div id="<?php echo $editable?>"><a class="button" href="<?php echo $url_open?>" id="<?php echo rand();?>"><?php echo __($button_text)?></a></div>
<div id="<?php echo $current?>"
  <?php if (isset($ref_functions_names)):?>
    data-ref_functions_names="<?php echo $ref_functions_names ?>"
  <?php endif;?>
  ></div>
<div id="<?php echo $process?>"></div>

<?php if (isset($ref_functions)) : ?>
<ul id="<?php echo $reffunc?>" style="display: none;">
  <?php foreach ($ref_functions as $ref_key => $ref_value) :?>
    <li data-target="<?php echo $ref_key?>" data-url="<?php echo $ref_value?>"></li>
  <?php endforeach;?>
</ul>
<?php endif;?>

<script>
$('#<?php echo $editable?>').find('a').die('click'); 
$('#<?php echo $current?>').find('form').die('submit');
function load_form()
{
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
    <?php if ($with_dialog):?>
    var editable = $('#<?php echo $editable?>').find('a');
    target.dialog(
       {
           beforeClose: function (){
                var reffunc = $('#<?php echo $reffunc?> li');
                reffunc.each(function( index ) {
                  var target = $(this).data('target');
                  var url = $(this).data('url');
                  $(target).addClass('loading');
                  $(target).load(url+"/tempos/"+Math.random(), function() {
                      $(target).removeClass('loading');
                    });
                });
                editable.css('display','block');  
           },
           autoOpen:true,
           bgiframe:true,
           modal:true,
           resizable:true,
           width:500,height:500,position:['center', 'center'],draggable:true 
       }
     ); 
    <?php endif;?>
    
    return false; 
}

$('#<?php echo $editable?>').find('a').live('click', load_form);
$('#<?php echo $current?>').find('form').live('submit', function(event, ui){
    var target = $('#<?php echo $current?>');
    var process = $('#<?php echo $process?>');
    var editable = $('#<?php echo $editable?>').find('a'); 
    $(this).ajaxSubmit({
      success: function (responseText, statusText)
      {
        var response = JSON.parse(responseText);

        var isSuccess = response.success;
        var responseContent = response.text;

        if (isSuccess)
        {
          process.html('');
          editable.css('display','block');
          target.html(responseContent);
          <?php if ($with_dialog):?>
            if(target.dialog()){
              target.dialog('close');
            };
          <?php endif;?>

          var reffunc = $('#<?php echo $reffunc?> li');
          reffunc.each(function( index ) {
            var target = $(this).data('target');
            var url = $(this).data('url');
            $(target).addClass('loading');
            $(target).load(url+"/tempos/"+Math.random(), function() {
              $(target).removeClass('loading');
            });
          });

          var ref_functions_names = target.data('ref_functions_names');

          if (ref_functions_names)
          {
            for (key in ref_functions_names)
            {
              // if function with params
              if (typeof window[key] === 'function'){
                var funcParams = ref_functions_names[key];
                var funcName = key;
                formok = window[funcName](funcParams);
              }
              else // if function without params
              {
                var func_name = ref_functions_names[key];
                if (typeof window[func_name] === 'function'){
                  formok = window[func_name]();
                }
              }
            }
          }
        }
        else
        {
          target.html(responseContent);
        }
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
    <?php if ($with_dialog):?>
       if(target.dialog()){
          target.dialog('close');
     }; 
    <?php endif;?>
    editable.css('display','block');
    return false;
}); 
</script>