<div id="claimtabs">
   <ul>
      <li><a href="#tab1"><span><?php echo __('Claim general') ?></span></a></li>
      <li><a href="#tab2"><span><?php echo __('Work list + documents') ?></span></a></li>
   </ul>
   <div id="tab1">
      <?php echo get_component('messages',$app."_general", array('claim'=>$claim))?>
   </div>
   <div id="tab2">
      <?php echo get_component('messages',$app."_finance", array('claim'=>$claim))?>
      <div class="delimiter"></div>
      <div id="claim_worklist_refresh">
        <?php echo get_component('messages',$app."_worklist", array('claim'=>$claim, 'app'=>$app))?>
      </div>
      <?php echo get_component('dialog','dialogopen', array('url'=>url_for('history/showfinance').'/claimid/'.$claim->getId(),'text'=>__('Show history')))?> 
     

   </div>
</div>