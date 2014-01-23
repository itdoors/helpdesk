<?php use_helper('Text', 'Date') ?>
<?php include_partial("Kurator_header", array('claim'=>$claim))?>
<?php include_partial($app."_content", array('claim'=>$claim, 'app'=>$app))?>
<div class="delimiter"></div>
<?php include_partial("Kurator_messages", array('claim'=>$claim, 'form'=>$form, 'app'=>$app, 'comments'=>$comments))?>
