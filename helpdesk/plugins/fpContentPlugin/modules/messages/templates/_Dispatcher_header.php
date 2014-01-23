<div class="groupbox"><?php echo $claim->getOrganization()?> - <?php echo $claim->getDepartments()?>
    <div style="float: right;">
        <a href="<?php echo url_for('prnt/show?claimid='.$claim->getId())?>">
            <?php echo __('Print')?>
        </a>
        <a href="<?php echo url_for('prnt/showakt').'/claimid/'.$claim->getId()?>">
            <?php echo __('Print akt')?>
        </a>
    </div>
</div>
<script>
$(document).ready(function() {
   $("#claimtabs").tabs();
});
</script>