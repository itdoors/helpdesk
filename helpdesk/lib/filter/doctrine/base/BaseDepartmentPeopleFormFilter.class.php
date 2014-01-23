<?php

/**
 * DepartmentPeople filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDepartmentPeopleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'department_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'name'               => new sfWidgetFormFilterInput(),
      'first_name'         => new sfWidgetFormFilterInput(),
      'middle_name'        => new sfWidgetFormFilterInput(),
      'last_name'          => new sfWidgetFormFilterInput(),
      'salary'             => new sfWidgetFormFilterInput(),
      'number'             => new sfWidgetFormFilterInput(),
      'person_code'        => new sfWidgetFormFilterInput(),
      'position_string'    => new sfWidgetFormFilterInput(),
      'position_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Position'), 'add_empty' => true)),
      'year'               => new sfWidgetFormFilterInput(),
      'month'              => new sfWidgetFormFilterInput(),
      'birthday'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'type_id'            => new sfWidgetFormFilterInput(),
      'type_string'        => new sfWidgetFormFilterInput(),
      'employment_type_id' => new sfWidgetFormFilterInput(),
      'salary_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lookup'), 'add_empty' => true)),
      'contacts'           => new sfWidgetFormFilterInput(),
      'phone'              => new sfWidgetFormFilterInput(),
      'bonus'              => new sfWidgetFormFilterInput(),
      'fine'               => new sfWidgetFormFilterInput(),
      'is_clean_salary'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'norma_days'         => new sfWidgetFormFilterInput(),
      'parent_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'is_from_one_c'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_approved'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'drfo'               => new sfWidgetFormFilterInput(),
      'address'            => new sfWidgetFormFilterInput(),
      'admission_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dismissal_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'individual_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Individual'), 'add_empty' => true)),
      'guid'               => new sfWidgetFormFilterInput(),
      'passport'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'department_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'name'               => new sfValidatorPass(array('required' => false)),
      'first_name'         => new sfValidatorPass(array('required' => false)),
      'middle_name'        => new sfValidatorPass(array('required' => false)),
      'last_name'          => new sfValidatorPass(array('required' => false)),
      'salary'             => new sfValidatorPass(array('required' => false)),
      'number'             => new sfValidatorPass(array('required' => false)),
      'person_code'        => new sfValidatorPass(array('required' => false)),
      'position_string'    => new sfValidatorPass(array('required' => false)),
      'position_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Position'), 'column' => 'id')),
      'year'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'month'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'birthday'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'type_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type_string'        => new sfValidatorPass(array('required' => false)),
      'employment_type_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'salary_type_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Lookup'), 'column' => 'id')),
      'contacts'           => new sfValidatorPass(array('required' => false)),
      'phone'              => new sfValidatorPass(array('required' => false)),
      'bonus'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fine'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_clean_salary'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'norma_days'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'parent_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Parent'), 'column' => 'id')),
      'is_from_one_c'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_approved'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'drfo'               => new sfValidatorPass(array('required' => false)),
      'address'            => new sfValidatorPass(array('required' => false)),
      'admission_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'dismissal_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'individual_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Individual'), 'column' => 'id')),
      'guid'               => new sfValidatorPass(array('required' => false)),
      'passport'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('department_people_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DepartmentPeople';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'department_id'      => 'ForeignKey',
      'name'               => 'Text',
      'first_name'         => 'Text',
      'middle_name'        => 'Text',
      'last_name'          => 'Text',
      'salary'             => 'Text',
      'number'             => 'Text',
      'person_code'        => 'Text',
      'position_string'    => 'Text',
      'position_id'        => 'ForeignKey',
      'year'               => 'Number',
      'month'              => 'Number',
      'birthday'           => 'Date',
      'type_id'            => 'Number',
      'type_string'        => 'Text',
      'employment_type_id' => 'Number',
      'salary_type_id'     => 'ForeignKey',
      'contacts'           => 'Text',
      'phone'              => 'Text',
      'bonus'              => 'Number',
      'fine'               => 'Number',
      'is_clean_salary'    => 'Boolean',
      'norma_days'         => 'Number',
      'parent_id'          => 'ForeignKey',
      'is_from_one_c'      => 'Boolean',
      'is_approved'        => 'Boolean',
      'drfo'               => 'Text',
      'address'            => 'Text',
      'admission_date'     => 'Date',
      'dismissal_date'     => 'Date',
      'individual_id'      => 'ForeignKey',
      'guid'               => 'Text',
      'passport'           => 'Text',
    );
  }
}
