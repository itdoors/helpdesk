 <?php foreach ($comments as $comment): ?>
     <div class="groupbox grayblack"><?php echo $comment->getUsers() ?> - <?php echo $comment->getCreatedatetimeGood();?> <?php if ($comment->isvisible) echo __('Stuff only'); ?></div>
     <div class="groupbox normal"><?php echo html_entity_decode($comment->getDescription()) ?></div>
     <div class="groupbox normal"><?php include_partial('attach/attachView', array('comments'=>$comment, 'claim'=>$claim))?></div>
<?php endforeach; ?>
<div class="delimiter"></div> 
<div id="tabs">
   <ul>
      <li><a href="#message1"><span><?php echo __('Message') ?></span></a></li>
     
   </ul>
   <div id="message1">
   <?php 
     include_partial('form', array('form' => $form, 'claim'=>$claim)); 
   ?>
   </div>
   
</div>
<div id="<?php echo $claim->getId()?>" class="claim_id"></div>
<div id="result"></div>