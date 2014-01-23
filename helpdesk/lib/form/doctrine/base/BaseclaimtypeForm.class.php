<?php

/**
 * claimtype form base class.
 *
 * @method claimtype getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseclaimtypeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'stuff_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'stuff')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'stuff_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'stuff', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('claimtype[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'claimtype';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['stuff_list']))
    {
      $this->setDefault('stuff_list', $this->object->Stuff->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveStuffList($con);

    parent::doSave($con);
  }

  public function saveStuffList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['stuff_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Stuff->getPrimaryKeys();
    $values = $this->getValue('stuff_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Stuff', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Stuff', array_values($link));
    }
  }

}
