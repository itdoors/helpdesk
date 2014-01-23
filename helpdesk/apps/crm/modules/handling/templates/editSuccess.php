<?php $isNew = $form->getObject()->isNew()?>
<!--<h1><?php /*echo $isNew ? __('New Handling') : $hasPermission ?  __('Edit Handling') : __('Show Dogovor') */?></h1>-->

<div id="sf_admin_container">
 <?php include_partial('form', array('form' => $form)) ?>
</div>



