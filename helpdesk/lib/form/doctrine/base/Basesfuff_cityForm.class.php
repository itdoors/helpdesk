<?php

/**
 * sfuff_city form base class.
 *
 * @method sfuff_city getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basesfuff_cityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'stuff_id' => new sfWidgetFormInputHidden(),
      'city_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'stuff_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('stuff_id')), 'empty_value' => $this->getObject()->get('stuff_id'), 'required' => false)),
      'city_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('city_id')), 'empty_value' => $this->getObject()->get('city_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sfuff_city[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfuff_city';
  }

}
