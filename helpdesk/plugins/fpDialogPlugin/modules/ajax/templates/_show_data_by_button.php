<?php
  $rand = rand();
  $button_id = $button_id ? $button_id : "button_$rand"; 
  $result_id = $result_id ? $result_id : "result_$rand";
  $button_text = $button_text ? $button_text : "Show";
  $href = $href ? $href : "#";
  
?>
<input type="button" value="<?php echo $button_text?>"  id="<?php echo $button_id?>"/>
<div id ="<?php echo $result_id?>"></div>
<script>
  $("#<?php echo $button_id?>").live('click', function (){
      if ($("#<?php echo $result_id ?>").html() != '') $("#<?php echo $result_id ?>").html('');
      else {
          $("#<?php echo $result_id?>").html("<?php echo __('Loading...')?>");
          $("#<?php echo $result_id ?>").load("<?php echo $href?>", function(){
              
          })                                                                   
      }
  })
</script>