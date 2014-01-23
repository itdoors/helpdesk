<?php

/**
 * Handling form base class.
 *
 * @method Handling getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHandlingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'number'              => new sfWidgetFormInputText(),
      'createdatetime'      => new sfWidgetFormDateTime(),
      'createdate'          => new sfWidgetFormDate(),
      'status_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'type_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'add_empty' => true)),
      'status_description'  => new sfWidgetFormTextarea(),
      'status_change_date'  => new sfWidgetFormDateTime(),
      'last_handling_date'  => new sfWidgetFormDate(),
      'service_offered'     => new sfWidgetFormTextarea(),
      'budget'              => new sfWidgetFormInputText(),
      'budget_client'       => new sfWidgetFormInputText(),
      'square'              => new sfWidgetFormInputText(),
      'chance'              => new sfWidgetFormTextarea(),
      'worktime_withclient' => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormTextarea(),
      'result_string'       => new sfWidgetFormTextarea(),
      'result_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Result'), 'add_empty' => true)),
      'status_admin'        => new sfWidgetFormInputCheckbox(),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => false)),
      'is_closed'           => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'number'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'createdatetime'      => new sfValidatorDateTime(),
      'createdate'          => new sfValidatorDate(),
      'status_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'required' => false)),
      'type_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'required' => false)),
      'status_description'  => new sfValidatorString(array('required' => false)),
      'status_change_date'  => new sfValidatorDateTime(array('required' => false)),
      'last_handling_date'  => new sfValidatorDate(array('required' => false)),
      'service_offered'     => new sfValidatorString(array('required' => false)),
      'budget'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'budget_client'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'square'              => new sfValidatorNumber(array('required' => false)),
      'chance'              => new sfValidatorString(array('required' => false)),
      'worktime_withclient' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'description'         => new sfValidatorString(array('required' => false)),
      'result_string'       => new sfValidatorString(array('required' => false)),
      'result_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Result'), 'required' => false)),
      'status_admin'        => new sfValidatorBoolean(array('required' => false)),
      'user_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'organization_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'))),
      'is_closed'           => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('handling[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Handling';
  }

}
