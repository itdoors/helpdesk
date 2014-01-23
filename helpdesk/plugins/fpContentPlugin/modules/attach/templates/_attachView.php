<h3><?php if (count($comments->getAttach())) echo __("Attachments")?></h3>
<?php
 foreach($comments->getAttach() as $attach)
 {
    echo "<a href=".sfConfig::get('sf_upload_claimfiles').'/'.$attach->getFilepath()." target=\"_blank\">".$attach->getFilename()."</a><br />"; 
    $app = sfContext::getInstance()->getConfiguration()->getApplication();
 
    if ($app == sfConfig::get('application_finance')||$app == sfConfig::get('application_dispatcher')) 
     echo get_component('ajax','ajaxField', 
                         array(
                         'default'=>'',  
                         'field' => 'document_transfer_'.$attach->getId(),
                         'claim_id' => $claim->getId(), 
                         'file_path' => $attach->getFilepath(), 
                         'url_open'=>url_for('ajax/ajaxFieldFormDocumentsTransfer'),
                         //'url_s'=>url_for('ajax/ajaxFieldFormDocumentsTransfer'),
                         'formtemplate' => 'ajaxFieldFormDocumentsTransfer',
                         'url_refresh' =>url_for('ajax/getAjaxField')
        )); 
              
   /* echo get_component('dialog','Dialogform',
    array(
      'url_open'=>url_for('dialog/FiananceDocumentTransferForm'),
      'url_save'=>'',
      'url_refresh'=>'',
      'file_path'=>$attach->getFilepath(),
      'formtemplate'=>'FiananceDocumentTransferForm',
    )
    );*/
    
 }
?>