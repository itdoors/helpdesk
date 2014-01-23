<?php foreach ($departmentss as $departments): ?>
    <option value="<?php echo $departments->getId()?>"><?php echo $departments->getName() ?></option>
<?php endforeach; ?>

