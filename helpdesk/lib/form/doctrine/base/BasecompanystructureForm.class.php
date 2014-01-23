<?php

/**
 * companystructure form base class.
 *
 * @method companystructure getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecompanystructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'parent_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('companystructure'), 'add_empty' => true)),
      'name'        => new sfWidgetFormInputText(),
      'mpk'         => new sfWidgetFormInputText(),
      'address'     => new sfWidgetFormInputText(),
      'phone'       => new sfWidgetFormInputText(),
      'stuff_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true)),
      'region_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'region')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'parent_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('companystructure'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'mpk'         => new sfValidatorString(array('max_length' => 10)),
      'address'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'       => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'stuff_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'required' => false)),
      'region_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'region', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'companystructure', 'column' => array('mpk')))
    );

    $this->widgetSchema->setNameFormat('companystructure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'companystructure';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['region_list']))
    {
      $this->setDefault('region_list', $this->object->Region->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveRegionList($con);

    parent::doSave($con);
  }

  public function saveRegionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['region_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Region->getPrimaryKeys();
    $values = $this->getValue('region_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Region', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Region', array_values($link));
    }
  }

}
