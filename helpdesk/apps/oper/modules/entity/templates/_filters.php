<div class="entity-filter">
  <form action="<?php echo url_for('entity/filter')?>" method="post" id="entity_filter_form">
    <?php
      echo $filter_form['mpk']->renderLabel();
      echo $filter_form['mpk']->render();
      
      echo $filter_form['organization_id']->renderLabel();
      echo $filter_form['organization_id']->render();
      
      echo $filter_form['companystructure_id']->renderLabel();
      echo $filter_form['companystructure_id']->render();
      
      echo $filter_form['region_id']->renderLabel();
      echo $filter_form['region_id']->render();
      
      echo $filter_form['city_id']->renderLabel();
      echo $filter_form['city_id']->render();
      
      echo $filter_form['status_id']->renderLabel();
      echo $filter_form['status_id']->render();
      
      echo $filter_form['departments_type_id']->renderLabel();
      echo $filter_form['departments_type_id']->render();
      
      echo $filter_form['address']->renderLabel();
      echo $filter_form['address']->render();

      echo $filter_form['opermanager_id']->renderLabel();
      echo $filter_form['opermanager_id']->render();
      
      
      echo $filter_form->renderHiddenFields();
    ?>
    <input type="submit" class="btn" value="<?php echo __('Filter')?>">
  </form>
</div>

<a href="<?php echo url_for('entity/clear_filter')?>"><?php echo __('Clear filters')?></a>

