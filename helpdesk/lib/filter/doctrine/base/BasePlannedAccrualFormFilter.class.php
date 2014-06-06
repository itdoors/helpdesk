<?php

/**
 * PlannedAccrual filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlannedAccrualFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'period'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'type'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'value'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'department_people_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeople'), 'add_empty' => true)),
      'is_active'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'name'                 => new sfValidatorPass(array('required' => false)),
      'code'                 => new sfValidatorPass(array('required' => false)),
      'period'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'type'                 => new sfValidatorPass(array('required' => false)),
      'value'                => new sfValidatorPass(array('required' => false)),
      'department_people_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DepartmentPeople'), 'column' => 'id')),
      'is_active'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('planned_accrual_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlannedAccrual';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'name'                 => 'Text',
      'code'                 => 'Text',
      'period'               => 'Date',
      'type'                 => 'Text',
      'value'                => 'Text',
      'department_people_id' => 'ForeignKey',
      'is_active'            => 'Boolean',
    );
  }
}
