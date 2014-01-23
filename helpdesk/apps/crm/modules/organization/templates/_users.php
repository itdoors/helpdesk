<div id="organization_users_list">
  <?php include_component('organization', 'users_list', array('organizationId' => $organization->getId()))?>
</div>
<?php
echo
!true ? '' :
  get_component('Fmodel','form_add',
    array(
      'model' => 'OrganizationUser',
      'form_class' => 'OrganizationUserMultiple',
      'target'=>'org_users_list',
      'button_text' => __('Add manager'),
      'default' =>
      array(
        'organization_id'=> $organization->getId()
      ),
      'ref_functions'=>
      array(
        '#organization_users_list'=>url_for('organization/refresh_users').'/organization_id/'.$organization->getId()
      )

    )
  )
?>

<script type="text/javascript">
  $('#editableorg_users_list a').live('click', function(e){
    console.log('open popup');
    var target = $('#currentorg_users_list');
    if(!target.dialog()){
      target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true});
  })
  $('#currentorg_users_list input[type=submit]').live('click', function(e){
    dialog_close();
  })
  $('#currentorg_users_list .cancel_form').live('click', function(e){
    dialog_close();
  })

  function dialog_close()
  {
    var target = $('#currentorg_users_list');
    if(target.dialog()){
      target.dialog('close');
    }
  }
</script>