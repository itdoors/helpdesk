<div id="claimtabs">
   <ul>
      <li><a href="#tab1"><span><?php echo __('Claim general') ?></span></a></li>
   </ul>
   <div id="tab1">
     <?php echo get_component('messages',$app."_general", array('claim'=>$claim))?>
   </div>
</div>