<?php foreach ($importances as $importance): ?>
    <option value="<?php echo $importance->getId()?>"><?php echo $importance->getImportance()?></option>
<?php endforeach; ?>
