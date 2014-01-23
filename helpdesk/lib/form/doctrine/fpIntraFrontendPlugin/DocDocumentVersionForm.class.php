<?php

/**
 * DocDocumentVersion form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocDocumentVersionForm extends PluginDocDocumentVersionForm
{
  public function configure()
  {
      $this->setWidget('filepath', new sfWidgetFormInputFileEditable(array(
            'file_src'    => sfConfig::get('sf_upload_docDocumentsfiles').'/'.$this->getObject()->getId(),
            'edit_mode'   => !$this->isNew(),
            'is_image'    => true,
            'with_delete' => false,
            'template' => '%input%'
          )),array('class'=>'required'));
      $this->setValidator('filepath', new sfValidatorFile(array(
        //'mime_types' => array('image/jpeg','image/x-ms-bmp','image/gif', 'application/msword','application/pdf',/*'application/octet-stream',*/ 'application/x-rar','application/x-zip', 'application/zip', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'),
        'path' => sfConfig::get('sf_upload_dir').'/docdocuments/'.$this->getObject()->getId(),
        'validated_file_class' => 'sfVersionValidatedFile',
      )));
     $document_id = sfContext::getInstance()->getUser()->getAttribute('document_id');
     if ($document_id) 
      {
         $document_choices = $this->getDocumentById($document_id);
         $this->setWidget('document_id', new sfWidgetFormChoice(array('choices' => $document_choices)));
         $this->setDefault('document_id', $document_id); 
      } else
      {
         $this->setWidget('document_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocument'), 'add_empty' => false))); 
      }     
      $this->setValidator('document_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocument'), 'required' => true)));
      $this->useFields(array(
        'name',
        'document_id',
        'filepath',
        //'user_id'
        )
      );
  }
  
  protected function getDocumentById($document_id)
  {
      $q = Doctrine::getTable('DocDocument')->find($document_id);
      return array($document_id => $q->getName());
  }
    
  public function doSave($con = null)
  {
    $values = $this->updateObject();
    if ($this->getObject()->isNew())
    {
        $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $this->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
        $this->getObject()->setUserId($user_id);
     }
    $this->getObject()->save();
    //$this->getObject()->save();
    //$this->saveEmbeddedForms();
      
   }
   public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }
    $values['mime_type'] =  $values['filepath']->getType() ? $values['filepath']->getType() : ''; 
    $values = $this->processValues($values);

    $this->doUpdateObject($values);

    // embedded forms
    $this->updateObjectEmbeddedForms($values);

    return $this->getObject();
  }
     
}


  class sfVersionValidatedFile extends sfValidatedFile
    {
      public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
      {
         $document_id = sfContext::getInstance()->getUser()->getAttribute('document_id');
         $temp_path = $this->path; 
         $this->path = $temp_path.DIRECTORY_SEPARATOR.$document_id;
         $file_name = parent::save($this->generateFilename(), $fileMode, $create, $dirMode);
/*        
        копирование файла index.html чтоб не было   возможность посмотреть содержимое директории
        if (!file_exists(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'docdocuments'.DIRECTORY_SEPARATOR.$document_id.DIRECTORY_SEPARATOR."index.html"))
         {
             if (file_exists(sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR."index.html"))
             copy(
                sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR."index.html",
                sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'docdocuments'.DIRECTORY_SEPARATOR.$document_id.DIRECTORY_SEPARATOR."index.html"
             );
         }  */
         //$image = imagecreatefromjpeg($this->path.'/'.$file_name);
         return $file_name;
      }
    }