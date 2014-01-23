<div class="handling-filter">
  <form action="<?php echo url_for('handling/filter')?>" method="post" id="handling_filter_form">
    <?php
      echo $filter_form['organization_id']->renderLabel();
      echo $filter_form['organization_id']->render();

      echo $filter_form['city_id']->renderLabel();
      echo $filter_form['city_id']->render();

      echo $filter_form['scope_id']->renderLabel();
      echo $filter_form['scope_id']->render();

      echo $filter_form['type_id']->renderLabel();
      echo $filter_form['type_id']->render();

      echo $filter_form['chance']->renderLabel();
      echo $filter_form['chance']->render();

      echo $filter_form['status_id']->renderLabel();
      echo $filter_form['status_id']->render();

      echo $filter_form['user_id']->renderLabel();
      echo $filter_form['user_id']->render();

      echo $filter_form['result_id']->renderLabel();
      echo $filter_form['result_id']->render();
      
      echo $filter_form->renderHiddenFields();
    ?>
    <input type="submit" class="btn" value="<?php echo __('Filter')?>">
  </form>
</div>

<a href="<?php echo url_for('handling/clear_filter')?>"><?php echo __('Clear filter')?></a>

