<?php

/**
 * Documents form base class.
 *
 * @method Documents getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocumentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'datetime'         => new sfWidgetFormDateTime(),
      'createdatetime'   => new sfWidgetFormDateTime(),
      'documentstype_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Documentstype'), 'add_empty' => false)),
      'filepath'         => new sfWidgetFormInputText(),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'claim_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'claim')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 100)),
      'datetime'         => new sfValidatorDateTime(array('required' => false)),
      'createdatetime'   => new sfValidatorDateTime(array('required' => false)),
      'documentstype_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Documentstype'))),
      'filepath'         => new sfValidatorString(array('max_length' => 100)),
      'user_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'claim_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'claim', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Documents';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['claim_list']))
    {
      $this->setDefault('claim_list', $this->object->Claim->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveClaimList($con);

    parent::doSave($con);
  }

  public function saveClaimList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['claim_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Claim->getPrimaryKeys();
    $values = $this->getValue('claim_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Claim', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Claim', array_values($link));
    }
  }

}
