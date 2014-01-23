<div class="more_info-filter">
  <form action="<?php echo url_for($baseRoute.'/filter')?>" method="post" id="more_info_filter_form">
    <?php

      echo $filter_form['user_id']->renderLabel();
      echo $filter_form['user_id']->render();

      echo $filter_form['subject']->renderLabel();
      echo $filter_form['subject']->render();

      echo $filter_form['mashtab']->renderLabel();
      echo $filter_form['mashtab']->render();

      echo $filter_form->renderHiddenFields();
    ?>
    <input type="submit" class="btn" value="<?php echo __('Filter')?>">
  </form>
</div>

<a href="<?php echo url_for($baseRoute.'/clear_filter')?>"><?php echo __('Clear filter')?></a>

