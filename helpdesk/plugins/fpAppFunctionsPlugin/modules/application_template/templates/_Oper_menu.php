    <li><a href="<?php echo url_for('homepage')?>"><?php echo __('Main')?></a></li>
    <li><a href="<?php echo url_for('entity')?>"><?php echo __('Entity')?></a></li>
    <!--<li><a href="<?php /*echo url_for('entity_copy_all')*/?>"><?php /*echo __('Entity copy all permanent stuff to next month')*/?></a></li>-->
    <!--<li><a href="<?php /*echo url_for('entity_export_excel_1c_all')*/?>"><?php /*echo __('Export all departments to excel for 1C')*/?></a></li>-->
    <?php if ($sf_user->hasCredential('supervisor')) : ?>
      <li><a href="<?php echo url_for('entity_contacts_excel')?>">
        <?php echo __('Export to excel')?>
      </a></li>
    <?php endif;?>
    <?php if ($sf_user->hasCredential('supervisor') || $sf_user->hasCredential('oper')) : ?>
      <li><a href="<?php echo url_for('entity_department_people_excel')?>">
          <?php echo __('Export to excel department people')?>
        </a></li>
    <?php endif;?>
    <?php if ($sf_user->hasCredential('supervisor')) : ?>
      <li><a href="<?php echo url_for('entity_organization_excel')?>">
          <?php echo __('Export to excel organization')?>
        </a></li>
    <?php endif;?>
    <li><a href="http://intranet.griffin.ua"><?php echo __('Intranet') ?></a></li>