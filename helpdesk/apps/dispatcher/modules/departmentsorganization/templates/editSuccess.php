<?php use_helper('I18N', 'Date') ?>
<?php include_partial('departmentsorganization/assets') ?>

<div id="sf_admin_container"> 
   <div id="sf_admin_header">
       <?php include_partial('departmentsorganization/form_header', array('departments' => $departments, 'form' => $form, 'configuration' => $configuration)) ?>
   </div>
   <div id="tabs">
     <ul>
       <li><a href="#deptab-1"><span><?php echo __('Edit Departmentslist', array(), 'messages') ?></span></a></li>
       <?php
         // if ($sfuserid<>0) $link = url_for('cinfo').'/edit/id/'.$sfuserid.''; else  $link="#fragment-2";
       ?>
       <li  ><a href="#deptab-2"><span><?php echo __('Edit Client Info', array(), 'messages') ?></span></a></li>
     </ul>
     <div id="deptab-1">
        <div id="sf_admin_content">
           <?php include_partial('departmentsorganization/form', array('departments' => $departments, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper))?>
        </div>
     </div>
     <div id="deptab-2">
        <?php echo get_component('departmentsorganization','joinuser',array('departments' => $departments))?>
     </div>
   </div>

  <div id="sf_admin_footer">
    <?php include_partial('departmentsorganization/form_footer', array('departments' => $departments, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
