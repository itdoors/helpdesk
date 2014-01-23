<div id="usertabs">
    <ul>
      <li><a href="#user_general"><span><?php echo __('User general') ?></span></a></li>
      <li><a href="#user_additional"><span><?php echo __('User additional') ?></span></a></li>
   </ul>
   <div id="user_general">
     <?php include_partial('form', array('form' => $form)) ?>
   </div>
   <div id="user_additional">
     <?php include_partial('additionalinfo', array('additionalinfos' => $additionalinfos)) ?>
   </div>
</div> 
<script>
$(document).ready(function() {
   $("#usertabs").tabs();
});
</script>



