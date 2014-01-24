<?php

/**
 * HandlingMessage form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HandlingMessageForm extends BaseHandlingMessageForm
{
  public function configure()
  {
    $this->i18n = sfContext::getInstance()->getI18N();
    sfContext::getInstance()->getConfiguration()->loadHelpers('Date');

    $this->setWidget('createdate', new sfWidgetFormJQueryDate(array(
      'config' => '{}',
      'culture' => 'ru',
      'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
    )));
    $this->setValidator('createdate',  new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')));

    $this->setWidget('description' ,
      new isicsWidgetFormTinyMCE(
        array(
          'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),
        )
        ,
        array('class'=>'handling_message')
      ));
    $this->setValidator('description' , new sfValidatorString(array('required' => false)));

    $handlingId = $this->getOption('handling_id');

    $this->setWidget('filepath', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/handling_message/'.$handlingId.'/'.$this->getObject()->filepath,
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
      'template' => '%input%'
    )),array('class'=>'required'));

    $path = sfConfig::get('sf_upload_dir').'/handling_message/'.$handlingId.'/';

    $this->setValidator('filepath', new sfValidatorFile(array(
      'required' => false,
      /*'mime_types' => array(
        'image/jpeg',
        'image/png',
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
      ),*/
      'path' => $path
    )));

    $this->validatorSchema['filepath']->setOption('mime_type_guessers', array(
      //array($this->validatorSchema['image'], 'guessFromFileinfo'),
      //array($this->validatorSchema['filepath'], 'guessFromMimeContentType')
    ));

    $this->useFields(array(
      'type_id',
      'createdate',
      'description',
      'filename',
      'filepath'
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkCreatedate')))
    );

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }

  public function checkCreatedate($validator, $values, $arguments)
  {
    if (!isset($values['createdate']))//ajax field change
    {
      return $values;
    }

    $createdate = $values['createdate'];

    if (!$this->isNew)
    {
      $handlingId = $this->getObject()->getHandlingId();
    }
    else
    {
      $handlingId = $values['handling_id'];
    }

    $handling = Doctrine::getTable('Handling')->find($handlingId);

    if (!$handling)
    {
      $error = $this->i18n->__('Handling not found');
      throw new sfValidatorError($validator, $error);
    }

    $handlingCreateDate = $handling->getCreatedate();

    $handlingCreateDateUnix = strtotime($handlingCreateDate);

    $createdateUnix = strtotime($createdate) + 86399;

    if ($createdateUnix <= $handlingCreateDateUnix)
    {
      $params = array(
        '%handling_date' => format_date($handling->getCreatedate(), 'dd.MM.yyyy,', 'ru')
      );
      $error = $this->i18n->__('Date can\'t be less than handling date : %handling_date', $params);
      throw new sfValidatorError($validator, $error);
    }

    return $values;
  }

  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }

    $values['user_id'] = GlobalFunctions::getUserId();
    $values['createdatetime'] = date("Y-m-d H:i:s");

    return parent::updateObject($values);
  }

  public function save($con = null)
  {
    $object = parent::save();

    $handling = Doctrine::getTable('Handling')->find($object->getHandlingId());

    if ($handling)
    {
      $handling->recountLastHandlingDate();
    }
  }
}
