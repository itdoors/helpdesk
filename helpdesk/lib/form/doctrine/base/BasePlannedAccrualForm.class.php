<?php

/**
 * PlannedAccrual form base class.
 *
 * @method PlannedAccrual getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlannedAccrualForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'code'                 => new sfWidgetFormInputText(),
      'period'               => new sfWidgetFormDate(),
      'type'                 => new sfWidgetFormInputText(),
      'value'                => new sfWidgetFormInputText(),
      'department_people_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeople'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 100)),
      'code'                 => new sfValidatorString(array('max_length' => 10)),
      'period'               => new sfValidatorDate(),
      'type'                 => new sfValidatorString(array('max_length' => 10)),
      'value'                => new sfValidatorString(array('max_length' => 100)),
      'department_people_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeople'))),
    ));

    $this->widgetSchema->setNameFormat('planned_accrual[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlannedAccrual';
  }

}
