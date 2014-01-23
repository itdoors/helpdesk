<?php echo $status?>
<form action="<?php echo url_for($url_change)?>" method="post">
  <input type="hidden" name="claim_id" value="<?php echo $claim_id?>">
  <input type="hidden" name="url_change" value="<?php echo $url_change?>">
  <input type="submit"  value="<?php echo $status_form_submit?>">
</form>
