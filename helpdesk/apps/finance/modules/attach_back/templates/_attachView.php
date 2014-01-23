<h3><?php if (count($comments->getAttach())) echo __("Attachments")?></h3>
<?php
 foreach($comments->getAttach() as $attach)
 {
    echo "<a href=".sfConfig::get('sf_upload_claimfiles').'/'.$attach->getFilepath()." target=\"_blank\">".$attach->getFilename()."</a><br />"; 
 }
?>