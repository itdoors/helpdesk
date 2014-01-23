<?php

/**
 * DopDogovor form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DopDogovorForm extends BaseDopDogovorForm
{
  public function configure()
  {
      $this->setWidget('startdatetime', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
      )));
      $this->setWidget('activedatetime', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
      )));
      
      $this->setWidget('filepath', new sfWidgetFormInputFileEditable(array(
            'file_src'    => '/uploads/dogovor/'.$this->getObject()->filepath,
            'edit_mode'   => !$this->isNew(),
            'is_image'    => true,
            'with_delete' => false,
            'template' => '%input%'
          )),array('class'=>'required'));
      
      $doc_types = sfConfig::get('document_mime_types');
      
      $this->setValidator('filepath', new sfValidatorFile(array(
           'mime_types' => $doc_types,
           'mime_type_guessers' =>'guessFromFileBinary',
       
        'path' => sfConfig::get('sf_upload_dir').'/dogovor/',
        'validated_file_class' => 'sfPhotoValidatedFile',
        'required' => false 
      )));
      
      $this->setWidget('stuff_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true, 'table_method'=>'getAllPersons')));
      $this->widgetSchema['stuff_id']->setLabel('Sell manager'); 
      
      unset($this['user_id']); 
  }
  
  function save($con = null)
  {
    $isNew = $this->getObject()->isNew();
    $object = parent::save();
    if ($isNew)
    {
      $user_id = GlobalFunctions::getUserId();
      $object->setUserId($user_id);
      $object->save();
    }
    return $object;
  }
}

class sfPhotoValidatedFile extends sfValidatedFile
    {
      public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
      {
         
         $file_name = parent::save($this->generateFilename(), $fileMode, $create, $dirMode);
         //$image = imagecreatefromjpeg($this->path.'/'.$file_name);
         return $file_name;
      }
    }
