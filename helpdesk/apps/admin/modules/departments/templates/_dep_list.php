<?php foreach ($departmentss as $departments): ?>
    <?php
      if ($departments->isClient()) $s = 'selected="selected"'; else $s = '';
    ?>
    <option value="<?php echo $departments->getId()?>" <?php echo $s?>><?php echo $departments ?></option>
<?php endforeach; ?>

