<div class="groupbox"><?php echo $claim->getOrganization()?> - <?php echo $claim->getDepartments()?>
    <div style="float: right;">
       <a onclick="if (!confirm('<?php echo __('Are you sure you want close claim?')?>')){return false}; " href="<?php echo url_for('claimopened/close').'/claimid/'.$claim->getId() ?>" class="close"><?php echo __('Close_claim')?></a>      
    </div>
</div>
<script>
$(document).ready(function() {
   $("#claimtabs").tabs();
});
</script>
