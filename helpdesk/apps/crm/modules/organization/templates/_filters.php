<div class="organization-filter">
  <form action="<?php echo url_for('organization/filter')?>" method="post" id="organization_filter_form">
    <?php
      echo $filter_form['organization_id']->renderLabel();
      echo $filter_form['organization_id']->render();

      echo $filter_form['city_id']->renderLabel();
      echo $filter_form['city_id']->render();

      echo $filter_form['region_id']->renderLabel();
      echo $filter_form['region_id']->render();

      echo $filter_form['scope_id']->renderLabel();
      echo $filter_form['scope_id']->render();

      echo $filter_form['user_id']->renderLabel();
      echo $filter_form['user_id']->render();
      
      echo $filter_form->renderHiddenFields();
    ?>
    <input type="submit" class="btn" value="<?php echo __('Filter')?>">
  </form>
</div>

<a href="<?php echo url_for('organization/clear_filter')?>"><?php echo __('Clear filter')?></a>

