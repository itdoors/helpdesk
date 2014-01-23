<?php foreach ($documents_version as $version): ?>
    <?php if (!$version->getIsdeleted()) {?>
        <?php 
       
       $mime_class = $version->getMimeClass();?>
        <a href="<?php echo sfConfig::get('sf_upload_docDocumentsfiles').$version->getDocumentId()."/".$version->getFilepath()?>" target="_blank" class="<?php echo $mime_class?>"> 
            <?php echo $version->getName() ?>
        </a>
    <?php } else echo $version->getName()?>
    &nbsp; 
    <?php
    if (!$version->getIsdeleted()) { 
      echo link_to(__('Delete'), 'docdocument_version/delete?id='.$version->getId(), array('method' => 'delete', 'confirm' => __('Are you sure?'),'style'=>"font-size: 9px;"));
    } else echo link_to(__('Return'), 'docdocument_version/restore?id='.$version->getId(), array('method' => 'put', 'confirm' => __('Are you sure?'),'style'=>"font-size: 9px;"));  
    ?> 
    <div style="clear: both;"></div>
    <br />
<?php endforeach; ?>