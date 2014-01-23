<?php

/**
 * Documents form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocumentsForm extends BaseDocumentsForm
{
  public function configure()
  {
      $this->setWidget('filepath', new sfWidgetFormInputFileEditable(array(
            'file_src'    => sfConfig::get('sf_upload_documentsfiles').$this->getObject()->filepath,
            'edit_mode'   => !$this->isNew(),
            'is_image'    => true,
            'with_delete' => false,
            'template' => '%input%'
          )),array('class'=>'required'));
      $this->setValidator('filepath', new sfValidatorFile(array(
           'mime_types' => array('image/jpeg','image/x-ms-bmp','image/gif', 'application/msword','application/pdf','application/octet-stream', 'application/x-rar','application/x-zip'),
           'mime_type_guessers' =>'guessFromFileBinary',  
        'path' => sfConfig::get('sf_upload_dir').'/claimfiles',
        'validated_file_class' => 'sfPhotoValidatedFileSmeta',
      )));
      $this->setWidget('user_id' , new  sfWidgetFormInputHidden());
      $this->setWidget('claim_id' , new  sfWidgetFormInputHidden());
      $this->setValidator('claim_id',  new sfValidatorDoctrineChoice(array( 'model' => 'claim', 'required' => true)));
      $this->setWidget('datetime', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
      )));
       $this->setValidator('datetime',  new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')));  
      unset($this['createdatetime'], $this['claim_list']);
      $this->setDefault('datetime',
      array('year' => date('Y'), 'month' => date('n'), 'day' => date('j'))
      
      );
  }
}
   class sfPhotoValidatedFileSmeta extends sfValidatedFile
    {
      public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
      {
         $claim_id = sfContext::getInstance()->getUser()->getAttribute(sfConfig::get('claim_container'));
         $file_name = parent::save($claim_id."-".$this->generateFilename(), $fileMode, $create, $dirMode);
         $image = imagecreatefromjpeg($this->path.'/'.$file_name);
         return $file_name;
      }
    } 
class DocumentsTransferForm extends DocumentsForm
{
  public function configure()
  {
      parent::configure();
      $this->setWidget('filepath' , new  sfWidgetFormInputHidden());
      $this->setValidator('filepath',  new sfValidatorString());
     
  }
}