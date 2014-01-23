<?php

/**
 * region form base class.
 *
 * @method region getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseregionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInputText(),
      'square'                => new sfWidgetFormInputText(),
      'population'            => new sfWidgetFormInputText(),
      'flag'                  => new sfWidgetFormInputText(),
      'companystructure_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'companystructure')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 100)),
      'square'                => new sfValidatorNumber(array('required' => false)),
      'population'            => new sfValidatorNumber(array('required' => false)),
      'flag'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'companystructure_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'companystructure', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'region', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('region[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'region';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['companystructure_list']))
    {
      $this->setDefault('companystructure_list', $this->object->Companystructure->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCompanystructureList($con);

    parent::doSave($con);
  }

  public function saveCompanystructureList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['companystructure_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Companystructure->getPrimaryKeys();
    $values = $this->getValue('companystructure_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Companystructure', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Companystructure', array_values($link));
    }
  }

}
