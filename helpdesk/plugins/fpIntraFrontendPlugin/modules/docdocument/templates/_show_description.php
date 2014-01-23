<?php
  $document_id = $document->getId();
  $id_class = "docid$document_id";
  $description_class = "description$document_id";
?>
<div class="<?php echo $id_class?>"><a href=""><?php echo $document->getId()?></a></div>
<div class="<?php echo $description_class?>" style="position: absolute; display: none;background-color: #ff0000; padding: 10px;"><a href="#"><?php echo $document->getDescription()?></a></div>
<script>
  $('.<?php echo $id_class?>').live('click', function() {
      var target = $('.<?php echo $description_class?>');
      if (target.css('display') == 'none') target.css('display','block');
      else target.css('display', 'none');
      
      return false;
  })
  $('.<?php echo $description_class?>').live('click', function() {
      $(this).css('display','none');
      return false; 
  })
</script>