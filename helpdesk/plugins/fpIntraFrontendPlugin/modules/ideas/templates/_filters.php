<div class="ideas-filter">
  <form action="<?php echo url_for('ideas/filter')?>" method="post" id="ideas_filter_form">
    <?php
      echo $filter_form['date_range']->renderError();
      echo $filter_form['date_range']->renderLabel();
      echo $filter_form['date_range']->render();

      echo $filter_form['user_id']->renderLabel();
      echo $filter_form['user_id']->render();

      echo $filter_form->renderHiddenFields();
    ?>
    <input type="submit" class="btn" value="<?php echo __('Filter')?>">
  </form>
</div>

<a href="<?php echo url_for('ideas/clear_filter')?>"><?php echo __('Clear filter')?></a>

