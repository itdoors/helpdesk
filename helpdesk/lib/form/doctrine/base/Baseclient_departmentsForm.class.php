<?php

/**
 * client_departments form base class.
 *
 * @method client_departments getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Baseclient_departmentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'client_id'      => new sfWidgetFormInputHidden(),
      'departments_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'client_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('client_id')), 'empty_value' => $this->getObject()->get('client_id'), 'required' => false)),
      'departments_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('departments_id')), 'empty_value' => $this->getObject()->get('departments_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('client_departments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'client_departments';
  }

}
