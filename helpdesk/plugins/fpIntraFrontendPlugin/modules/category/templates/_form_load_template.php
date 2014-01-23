<div><a href="<?php echo url_for('category/user_load_permission_form')?>" class="adduser_permissions" ><?php echo __('Add Users')?></a></div>
<div><a href="<?php echo url_for('category/group_load_permission_form')?>" class="addgroup_permissions" ><?php echo __('Add Group')?></a></div>
<?php 
  $forms = $form->getEmbeddedForm('user_permissions')->getEmbeddedForms();
  foreach($forms as $emform)
  {
        $next_embed_form = array();
        preg_match_all('/\d+/',$emform->getWidgetSchema()->getAttribute('cross'),$matches);
        foreach ($matches[0] as $key=>$val)
        {
            //echo "$a=>$key<br />";
            $next_embed_form[] = $val;
        }
        
      //echo  $emform->getWidgetSchema()->getAttribute('cross');
  }
  $next_embed_form_number = isset($next_embed_form)?max($next_embed_form):0;
  
  $group_forms = $form->getEmbeddedForm('group_permissions')->getEmbeddedForms();
  foreach($group_forms as $emgroup_form)
  {
        $next_embed_group_form = array();
        preg_match_all('/\d+/',$emgroup_form->getWidgetSchema()->getAttribute('cross'),$group_matches);
        foreach ($group_matches[0] as $key=>$val)
        {
            //echo "$a=>$key<br />";
            $next_embed_group_form[] = $val;
        }
        
      //echo  $emform->getWidgetSchema()->getAttribute('cross');
  }
  $next_embed_group_form_number = isset($next_embed_group_form)?max($next_embed_group_form):0;
  
?>
<script>
$(document).ready(function() {
  i = <?php echo $next_embed_form_number+1;?>; 
  $('.adduser_permissions').live('click', function(){
    edit_link = $(this).attr("href")+'/cross/user_permission_form'+i;  
    var target = $(this).parent('div');
     
    target.load(edit_link, function(){
            target.after('<div><a href="<?php echo url_for('category/user_load_permission_form')?>" class="adduser_permissions" ><?php echo __('Add more users')?></a></div>'); 
    });
    
    i++;
    return false;
  })
});
j = <?php echo $next_embed_group_form_number+1;?>;
$('.addgroup_permissions').live('click', function(){
    edit_link = $(this).attr("href")+'/cross/group_permission_form'+i;  
    var target = $(this).parent('div');
     
    target.load(edit_link, function(){
            target.after('<div><a href="<?php echo url_for('category/group_load_permission_form')?>" class="addgroup_permissions" ><?php echo __('Add more groups')?></a></div>'); 
    });
    
    i++;
    return false;
  })
  
$('.delete_embed_form').find('a').live('click', function (){
    //alert("xxx");
    //$(this).parent('div').parent('div').attr('disabled','disabled');
    if ($(this).html() == 'удалить') 
    {
        $(this).html("Восстановить");
        $(this).parent('div').parent('div').find('select').attr('disabled', 'disabled');
    } else 
    if ($(this).html() == 'Восстановить') 
    {
        $(this).html("удалить");
        $(this).parent('div').parent('div').find('select').removeAttr('disabled');
    }
    
    return false;
    
})

</script>
