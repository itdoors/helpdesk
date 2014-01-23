<option value=""><?php echo __('Choose city...') ?></option>
<?php if ($citys) : ?>
  <?php foreach ($citys as $city): ?>
      <option value="<?php echo $city->getId()?>"><?php echo $city ?></option>
  <?php endforeach; ?>
<?php endif;?>

