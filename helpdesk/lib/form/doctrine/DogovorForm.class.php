<?php

/**
 * Dogovor form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DogovorForm extends BaseDogovorForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    
    $this->setWidget('organization_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('dogovor/autocomplite'),
      //'config' => '{ width: 350,max: 100,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 250}'
    )));
    
    $this->setWidget('city_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'city',
      'url'=>url_for('ajaxdata/auto_city'),
      //'config' => '{ width: 350,max: 100,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 250}'
    )));
    
    $this->setWidget('startdatetime', new sfWidgetFormJQueryDate(array(
        'config' => '{}',
        'culture' => 'ru',
        'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
    )));
    $this->setWidget('stopdatetime', new sfWidgetFormJQueryDate(array(
        'config' => '{}',
        'culture' => 'ru',
        'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
    )));
    
    $this->setWidget('dogovor_type_id' , new sfWidgetFormDoctrineChoice(array('model' => 'lookup', 'table_method' => 'getOnlyDogovor', 'add_empty' => true)));
    $this->setWidget('company_role_id' , new sfWidgetFormDoctrineChoice(array('model' => 'lookup', 'table_method' => 'getOnlyCompanyRole', 'add_empty' => true)));
    
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
    
    
    
    $this->setWidget('mashtab', new sfWidgetFormChoice(array('choices' => array('m_local' => 'Локальный', 'm_global' => 'Сетевой'))));
    $this->setWidget('stuff_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true, 'table_method'=>'getAllPersons')));

    $this->setWidget('launch_date', new sfWidgetFormJQueryDate(array(
      'config' => '{}',
      'culture' => 'ru',
      'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
    )));
    
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