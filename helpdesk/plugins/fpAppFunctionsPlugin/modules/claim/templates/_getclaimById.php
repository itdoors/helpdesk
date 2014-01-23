<div style="float: right;padding-top:5px;">  
<form action="<?php echo url_for('messages/show')?>" method="get" id="claimsearch">
  <label for="claimid"><?php echo __('Go to claim')?>: </label>
  <input type="text" name="claimid" id="claimid">
  <input id="claimid_submit" type="submit" value="<?php echo __('Search')?>"> 
</form>
</div> 