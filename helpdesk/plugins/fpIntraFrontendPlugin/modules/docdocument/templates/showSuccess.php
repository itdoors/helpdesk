<?php echo get_component('category', 'breadcrumbs', array('is_active_last' => true))?>  

<h1><b><?php echo __('Document')?>: <?php echo $doc_document->getName()?></b></h1><br />
<?php echo __('Document versions')?>:<br />
<?php echo get_component('docdocument','versions_list',array('documents_version'=>$doc_document->getDocDocumentVersion()))?>
<br />
<a href="<?php echo url_for('docdocument_version/new') ?>"><?php echo __('New document version')?></a>
