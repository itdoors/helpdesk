<?php if (!count($documents)) echo __('No results');?>
<?php if (count($documents)):?>
<table class="doc_documents gray">
  <thead>
    <th>Id</th>
    <th><?php echo __('Name')?></th>
    <th><?php echo __('Last document version')?></th>
    <th><?php echo __('Last version date')?></th>
    <th><?php echo __('Actions')?></th>
  </thead>
<?php endif;?>
<?php foreach ($documents as $document): ?>
   <tr>
      <td>
      <?php echo get_component('docdocument', 'show_description', array('document'=>$document))?>
      </td>
      <td><?php echo $document->getName();?></td>
      <td height="25">
    <?php if (!$document->getIsdeleted()) {?>
       <?php 
           $version = $document->getLastVersion();
           if ($version) {
           $mime_class = $version->getMimeClass();
       ?>
          <a href="<?php echo sfConfig::get('sf_upload_docDocumentsfiles').$version->getDocumentId()."/".$version->getFilepath()?>" target="_blank" class="<?php echo $mime_class?>"> 
             <?php echo $version->getName() ?>
          </a>
       <?php } else
       {
       ?>
          <?php echo __('Document has no version'); ?>
       <?php 
       }?>
    <?php } else //echo $document->getName()?>
      </td>
      <td><?php echo format_date($document->getCreatedatetime())?></td>
      <td>
    <?php
    if (!$document->getIsdeleted()) {
         
      /*  echo link_to_if(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all',__('Edit'), 'docdocument/edit?id='.$document->getId(), array('style'=>"font-size: 9px;"));
        echo " ";
        echo link_to_if(DocDocumentGroup::hasPermmisions() == 'action_all',__('Delete'), 'docdocument/delete?id='.$document->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'style'=>"font-size: 9px;"));
        echo " ";
        echo link_to(__('Edit version list'),url_for('docdocument/show').'/id/'.$document->getId(), array('style'=>"font-size: 9px;"));*/
        echo link_to(__('Edit'), 'docdocument/edit?id='.$document->getId(), array('style'=>"font-size: 9px;"));
        echo " ";
        echo link_to(__('Delete'), 'docdocument/delete?id='.$document->getId(), array('method' => 'delete', 'confirm' => __('Are you sure?'), 'style'=>"font-size: 9px;"));
        echo " ";
        echo link_to(__('Edit version list'),url_for('docdocument/show').'/id/'.$document->getId(), array('style'=>"font-size: 9px;"));
        
        
    //} else echo link_to_if(DocDocumentGroup::hasPermmisions() == 'action_all', __('Return'), 'docdocument/restore?id='.$document->getId(), array('method' => 'put', 'confirm' => __('Are you sure?'),'style'=>"font-size: 9px;"));  
    } else echo link_to(__('Return'), 'docdocument/restore?id='.$document->getId(), array('method' => 'put', 'confirm' => __('Are you sure?'),'style'=>"font-size: 9px;"));  
    ?> 
      </td>
    </tr>
<?php endforeach; ?>
<?php if (count($documents)):?>
</table>
<?php endif;?>