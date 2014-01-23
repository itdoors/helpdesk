<?php echo get_component('category', 'breadcrumbs')?>

<?php echo __('Categories')?>:<br />
<?php echo get_component('category','category_list',array('categories'=>$categories))?><br />
<?php echo __('Documents')?>:<br />
<?php echo get_component('category','documents_list',array('category_id'=>$category_id))?>
<br />
<?php 
$edit_actions = array('action_edit', 'action_all');
if (in_array(DocDocumentGroup::hasPermmisions(),$edit_actions)) :?>
<?php echo __('Actions')?>:<br />  
    <a href="<?php echo url_for('category/new') ?>"><?php echo __('New category')?></a><br />   
    <a href="<?php echo url_for('docdocument/new') ?>"><?php echo __('New document')?></a> 
<?php endif;?>  