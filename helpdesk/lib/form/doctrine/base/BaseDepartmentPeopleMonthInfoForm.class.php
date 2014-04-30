<?php

/**
 * DepartmentPeopleMonthInfo form base class.
 *
 * @method DepartmentPeopleMonthInfo getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDepartmentPeopleMonthInfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'department_people_id'             => new sfWidgetFormInputHidden(),
      'year'                             => new sfWidgetFormInputHidden(),
      'month'                            => new sfWidgetFormInputHidden(),
      'surcharge'                        => new sfWidgetFormInputText(),
      'bonus'                            => new sfWidgetFormInputText(),
      'fine'                             => new sfWidgetFormInputText(),
      'surcharge_type_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SurchargeType'), 'add_empty' => true)),
      'bonus_type_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BonusType'), 'add_empty' => true)),
      'fine_type_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FineType'), 'add_empty' => true)),
      'surcharge_type_key'               => new sfWidgetFormInputText(),
      'bonus_type_key'                   => new sfWidgetFormInputText(),
      'fine_type_key'                    => new sfWidgetFormInputText(),
      'surcharge_description'            => new sfWidgetFormInputText(),
      'bonus_description'                => new sfWidgetFormInputText(),
      'fine_description'                 => new sfWidgetFormInputText(),
      'salary'                           => new sfWidgetFormInputText(),
      'position_id'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Position'), 'add_empty' => true)),
      'type_id'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'add_empty' => true)),
      'type_string'                      => new sfWidgetFormInputText(),
      'employment_type_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EmploymentType'), 'add_empty' => true)),
      'salary_type_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SalaryType'), 'add_empty' => true)),
      'is_clean_salary'                  => new sfWidgetFormInputCheckbox(),
      'norma_days'                       => new sfWidgetFormInputText(),
      'department_people_replacement_id' => new sfWidgetFormInputHidden(),
      'replacement_type'                 => new sfWidgetFormInputHidden(),
      'real_salary'                      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'department_people_id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('department_people_id')), 'empty_value' => $this->getObject()->get('department_people_id'), 'required' => false)),
      'year'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('year')), 'empty_value' => $this->getObject()->get('year'), 'required' => false)),
      'month'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('month')), 'empty_value' => $this->getObject()->get('month'), 'required' => false)),
      'surcharge'                        => new sfValidatorNumber(array('required' => false)),
      'bonus'                            => new sfValidatorNumber(array('required' => false)),
      'fine'                             => new sfValidatorNumber(array('required' => false)),
      'surcharge_type_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SurchargeType'), 'required' => false)),
      'bonus_type_id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('BonusType'), 'required' => false)),
      'fine_type_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FineType'), 'required' => false)),
      'surcharge_type_key'               => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'bonus_type_key'                   => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'fine_type_key'                    => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'surcharge_description'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'bonus_description'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fine_description'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'salary'                           => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'position_id'                      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Position'), 'required' => false)),
      'type_id'                          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'required' => false)),
      'type_string'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'employment_type_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EmploymentType'), 'required' => false)),
      'salary_type_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SalaryType'), 'required' => false)),
      'is_clean_salary'                  => new sfValidatorBoolean(array('required' => false)),
      'norma_days'                       => new sfValidatorInteger(array('required' => false)),
      'department_people_replacement_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('department_people_replacement_id')), 'empty_value' => $this->getObject()->get('department_people_replacement_id'), 'required' => false)),
      'replacement_type'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('replacement_type')), 'empty_value' => $this->getObject()->get('replacement_type'), 'required' => false)),
      'real_salary'                      => new sfValidatorString(array('max_length' => 128, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('department_people_month_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DepartmentPeopleMonthInfo';
  }

}
