<div id="tenderserults">
<input type="button" id="startbutton" value="<?php echo __('Start')?>">
<div id="current_link"></div>
<?php $i = 0?>
<?php  foreach ($tenderlinks as $tenderlink):?>
<?php $i++?><a href="<?php echo url_for('findtender/show').'?link='.$tenderlink->getName()?>" class="tenderlink <?php if ($i == 1) echo 'startlink'?>"><?php echo $tenderlink->getName()?></a>
<div class="result"></div>
<?php endforeach?>
</div>
<script>
  $("#startbutton").live('click', function(){
     $('.startlink').click();  
  })
 

  $('.tenderlink').live('click', function(){
      var current_link = $('#current_link');
      var target = $(this).next('div');
      var href = $(this).attr('href');
      current_link_text = $(this).html(); 
      current_link.html(current_link_text);
      current_link.addClass('loading');
      var next_link = target.next('a');
      target.load(href, function(){
        current_link.removeClass('loading');
        current_link.html('');
        next_link.click();
      });
          
      return false;
  })
</script>
