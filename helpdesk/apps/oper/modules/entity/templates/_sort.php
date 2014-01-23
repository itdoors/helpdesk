<?php 
  $sort_invert = array('ASC' => 'DESC', 'DESC' => 'ASC');
  $sort_type = 'DESC';
  $class = '';
  if (isset($sort[$sort_field]))
  {
    $sort_type = $sort[$sort_field];
    $class = 'class="'.$sort_type.'"';
  }
?>


<a href="<?php echo url_for('entity_sort', array('sort_field' => $sort_field, 'sort_type' => $sort_invert[$sort_type]))?>" <?php echo $class?>>
  <?php echo __($text)?>
</a>
