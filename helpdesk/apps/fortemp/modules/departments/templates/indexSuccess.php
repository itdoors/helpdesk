<?php foreach ($departments as $department):?>
<?php $stuff_departments = $department->getStuffDepartments()?>
<?php echo $department->getId()?> - <?php echo $department?> - <?php echo $department->getContractId()?>(
<?php foreach ($stuff_departments as $stuff):?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $stuff->getStuffId()?> - <?php echo $stuff->getDepartmentsId()?> - <?php echo $stuff->getClaimtypeId()?> - <?php echo $stuff->getUserkey()?><br />
<?php endforeach;?>
)<br />
<?php endforeach;?>