<?php

/**
 * city form base class.
 *
 * @method city getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'region_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'add_empty' => true)),
      'district_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('District'), 'add_empty' => true)),
      'population'  => new sfWidgetFormInputText(),
      'square'      => new sfWidgetFormInputText(),
      'density'     => new sfWidgetFormInputText(),
      'citytype'    => new sfWidgetFormChoice(array('choices' => array('м' => 'м', 'смт' => 'смт', 'с' => 'с'))),
      'stuff_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'stuff')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'region_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'required' => false)),
      'district_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('District'), 'required' => false)),
      'population'  => new sfValidatorNumber(array('required' => false)),
      'square'      => new sfValidatorNumber(array('required' => false)),
      'density'     => new sfValidatorNumber(array('required' => false)),
      'citytype'    => new sfValidatorChoice(array('choices' => array(0 => 'м', 1 => 'смт', 2 => 'с'), 'required' => false)),
      'stuff_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'stuff', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('city[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'city';
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
