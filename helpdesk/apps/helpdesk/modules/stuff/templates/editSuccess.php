<?php use_helper('I18N', 'Date') ?>
<?php include_partial('stuff/assets') ?>

<div id="sf_admin_container"> 
 <?php include_partial('stuff/flashes') ?>
       <div id="sf_admin_header">
          <?php include_partial('stuff/form_header', array('userstuff' => $userstuff, 'form' => $form, 'configuration' => $configuration)) ?>
       </div>
        <div id="tabs">
            <ul>
                <li><a href="#fragment-1"><span><?php echo __('Edit stuff', array(), 'messages') ?></span></a></li>
                <?php
                   if ($sfuserid<>0) $link = url_for('sinfo').'/edit/id/'.$sfuserid.''; else  $link="#fragment-2";
                ?>
                <li><a href="<?php echo $link?>"><span><?php echo __('Edit stuff Info', array(), 'messages') ?></span></a></li>
            </ul>
            <div id="fragment-1">
                 <div id="sf_admin_content">
                    <?php include_partial('stuff/form', array('userstuff' => $userstuff, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
                 </div>
            </div>
            <div id="fragment-2">
               Сохраните основные данные
            </div>
        </div>

  <div id="sf_admin_footer">
    <?php include_partial('stuff/form_footer', array('userstuff' => $userstuff, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
