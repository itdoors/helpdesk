<?php foreach ($documents as $document):?>
    <a href="<?php echo sfConfig::get('sf_upload_documentsfiles').$document->getFilepath()?>" target="_blank"><?php echo $document->getDocumentstype()?> (<?php echo $document->getName()?>)</a><br />
<?php endforeach;?><br /><br />