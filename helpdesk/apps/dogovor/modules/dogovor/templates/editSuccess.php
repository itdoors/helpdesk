<?php $isNew = $form->getObject()->isNew()?>
<?php $hasPermission = $sf_user->hasCredential('dogovoradmin');?>
<h1><?php echo $isNew ? __('New Dogovor') : $hasPermission ?  __('Edit Dogovor') : __('Show Dogovor') ?></h1>   
  <div id="tabs">
     <ul>
        <?php if (!$isNew):?> <li><a href="#tab0"><span><?php echo __('Show') ?></span></a></li> <?php endif;?>
        <?php if ($hasPermission):?><li><a href="#tab1"><span><?php echo __('General') ?></span></a></li><?php endif;?> 
        <?php if (!$isNew):?><li><a href="#tab2"><span><?php echo __('Additional agreements') ?></span></a></li><?php endif;?> 
        <?php if (!$isNew && $hasPermission):?><li><a href="#tab3"><span><?php echo __('Departments') ?></span></a></li><?php endif;?>
        <?php if (!$isNew):?><li><a href="#tab4"><span><?php echo __('Handling with status "SOLED"') ?></span></a></li><?php endif;?>
     </ul>
     <?php if (!$isNew):?>
     <div id="tab0">
        <?php include_partial('general', array('dogovor'=>$form->getObject()))?>
     </div>
     <?php endif;?>
     <?php if ($hasPermission):?>
       <div id="tab1">
         <div id="sf_admin_container"> 
           <?php include_partial('form', array('form' => $form)) ?>
         </div>
       </div>
     <?php endif;?>
     <?php if (!$isNew):?> 
     <div id="tab2">
       <?php include_partial('additional_agreements', array('dogovor' => $form->getObject())) ?>
     </div>
     <?php endif;?>
     <?php if (!$isNew && $hasPermission):?> 
     <div id="tab3">
       <?php include_partial('departments', array('dogovor' => $form->getObject())) ?>
     </div>
     <?php endif;?>
    <?php if (!$isNew):?>
      <div id="tab4">
        <?php include_component('dogovor', 'handlings', array('dogovor'=>$form->getObject()))?>
      </div>
    <?php endif;?>
</div>


