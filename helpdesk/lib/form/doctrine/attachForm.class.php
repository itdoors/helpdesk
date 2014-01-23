<?php

/**
 * attach form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class attachForm extends BaseattachForm
{
  public function configure()
  {
     parent::configure();
     $this->setWidget('filepath', new sfWidgetFormInputFileEditable(array(
            'file_src'    => '/uploads/claimfiles/'.$this->getObject()->filename,
            'edit_mode'   => !$this->isNew(),
            'is_image'    => true,
            'with_delete' => false,
            'template' => '%input%'
          )),array('class'=>'required'));
          
     //$this['filepath']->doClean();
          
      $this->setValidator('filepath', new sfValidatorFile(array(
           'mime_types' => array(
               'image/jpeg',
               'image/png',
               'image/tiff',
               'image/x-tiff',
               'image/pjpeg', 'image/x-ms-bmp','image/gif',
               'application/vnd.ms-excel',
               'application/msword',
               'application/pdf',
               'application/x-rar',
               'application/x-zip',
               'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
               'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
               'application/vnd.openxmlformats-officedocument.presentationml.presentation',
               'application/octet-stream'
           ),
           //'mime_types' => array('image/jpeg','application/vnd.ms-excel'),
           'mime_type_guessers' =>'guessFromFileBinary',
       
        'path' => sfConfig::get('sf_upload_dir').'/claimfiles'.$this->getObject()->getComments()->getClaimId(),
        'validated_file_class' => 'sfPhotoValidatedFile',
      )));         
  }
    

}
  class sfPhotoValidatedFile extends sfValidatedFile
    {
      public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
      {
         $claim_id = sfContext::getInstance()->getUser()->getAttribute(sfConfig::get('claim_container'));
         sfContext::getInstance()->getUser()->getAttributeHolder()->remove(sfConfig::get('claim_container'));
         $file_name = parent::save($claim_id."-".$this->generateFilename(), $fileMode, $create, $dirMode);
         //$image = imagecreatefromjpeg($this->path.'/'.$file_name);
         return $file_name;
      }
    }
