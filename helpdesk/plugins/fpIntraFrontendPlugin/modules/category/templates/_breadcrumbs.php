<?php echo __('Breadcrumbs')?>: 
<?php
$breadcrumbs = array();     
if ($current_category) echo htmlspecialchars_decode($current_category->generateBreadcrumbs()); 
else echo '<a href="'.url_for('@homepage').'">'.__('Main').'</a>'; 
?><br /><br />