<?php

/**
 * DepartmentPeopleMonthInfo filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDepartmentPeopleMonthInfoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'surcharge'                        => new sfWidgetFormFilterInput(),
      'bonus'                            => new sfWidgetFormFilterInput(),
      'fine'                             => new sfWidgetFormFilterInput(),
      'surcharge_type_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SurchargeType'), 'add_empty' => true)),
      'bonus_type_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BonusType'), 'add_empty' => true)),
      'fine_type_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FineType'), 'add_empty' => true)),
      'salary'                           => new sfWidgetFormFilterInput(),
      'position_id'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Position'), 'add_empty' => true)),
      'type_id'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'add_empty' => true)),
      'type_string'                      => new sfWidgetFormFilterInput(),
      'employment_type_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EmploymentType'), 'add_empty' => true)),
      'salary_type_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SalaryType'), 'add_empty' => true)),
      'is_clean_salary'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'norma_days'                       => new sfWidgetFormFilterInput(),
      'real_salary'                      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'surcharge'                        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bonus'                            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fine'                             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'surcharge_type_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SurchargeType'), 'column' => 'id')),
      'bonus_type_id'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('BonusType'), 'column' => 'id')),
      'fine_type_id'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FineType'), 'column' => 'id')),
      'salary'                           => new sfValidatorPass(array('required' => false)),
      'position_id'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Position'), 'column' => 'id')),
      'type_id'                          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type'), 'column' => 'id')),
      'type_string'                      => new sfValidatorPass(array('required' => false)),
      'employment_type_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EmploymentType'), 'column' => 'id')),
      'salary_type_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SalaryType'), 'column' => 'id')),
      'is_clean_salary'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'norma_days'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'real_salary'                      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('department_people_month_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DepartmentPeopleMonthInfo';
  }

  public function getFields()
  {
    return array(
      'department_people_id'             => 'Number',
      'year'                             => 'Number',
      'month'                            => 'Number',
      'surcharge'                        => 'Number',
      'bonus'                            => 'Number',
      'fine'                             => 'Number',
      'surcharge_type_id'                => 'ForeignKey',
      'bonus_type_id'                    => 'ForeignKey',
      'fine_type_id'                     => 'ForeignKey',
      'salary'                           => 'Text',
      'position_id'                      => 'ForeignKey',
      'type_id'                          => 'ForeignKey',
      'type_string'                      => 'Text',
      'employment_type_id'               => 'ForeignKey',
      'salary_type_id'                   => 'ForeignKey',
      'is_clean_salary'                  => 'Boolean',
      'norma_days'                       => 'Number',
      'department_people_replacement_id' => 'Number',
      'real_salary'                      => 'Text',
    );
  }
}
