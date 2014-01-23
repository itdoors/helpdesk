<?php

/**
 * DepartmentPeople form base class.
 *
 * @method DepartmentPeople getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDepartmentPeopleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'department_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'name'               => new sfWidgetFormInputText(),
      'first_name'         => new sfWidgetFormInputText(),
      'middle_name'        => new sfWidgetFormInputText(),
      'last_name'          => new sfWidgetFormInputText(),
      'salary'             => new sfWidgetFormInputText(),
      'number'             => new sfWidgetFormInputText(),
      'person_code'        => new sfWidgetFormInputText(),
      'position_string'    => new sfWidgetFormInputText(),
      'position_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Position'), 'add_empty' => true)),
      'year'               => new sfWidgetFormInputText(),
      'month'              => new sfWidgetFormInputText(),
      'birthday'           => new sfWidgetFormDate(),
      'type_id'            => new sfWidgetFormInputText(),
      'type_string'        => new sfWidgetFormInputText(),
      'employment_type_id' => new sfWidgetFormInputText(),
      'salary_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lookup'), 'add_empty' => true)),
      'contacts'           => new sfWidgetFormInputText(),
      'phone'              => new sfWidgetFormInputText(),
      'bonus'              => new sfWidgetFormInputText(),
      'fine'               => new sfWidgetFormInputText(),
      'is_clean_salary'    => new sfWidgetFormInputCheckbox(),
      'norma_days'         => new sfWidgetFormInputText(),
      'parent_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'is_from_one_c'      => new sfWidgetFormInputCheckbox(),
      'is_approved'        => new sfWidgetFormInputCheckbox(),
      'drfo'               => new sfWidgetFormInputText(),
      'address'            => new sfWidgetFormInputText(),
      'admission_date'     => new sfWidgetFormDate(),
      'dismissal_date'     => new sfWidgetFormDate(),
      'individual_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Individual'), 'add_empty' => true)),
      'guid'               => new sfWidgetFormInputText(),
      'passport'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'department_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'         => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'middle_name'        => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'last_name'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'salary'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'person_code'        => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'position_string'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'position_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Position'), 'required' => false)),
      'year'               => new sfValidatorInteger(array('required' => false)),
      'month'              => new sfValidatorInteger(array('required' => false)),
      'birthday'           => new sfValidatorDate(array('required' => false)),
      'type_id'            => new sfValidatorInteger(array('required' => false)),
      'type_string'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'employment_type_id' => new sfValidatorInteger(array('required' => false)),
      'salary_type_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Lookup'), 'required' => false)),
      'contacts'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'bonus'              => new sfValidatorNumber(array('required' => false)),
      'fine'               => new sfValidatorNumber(array('required' => false)),
      'is_clean_salary'    => new sfValidatorBoolean(array('required' => false)),
      'norma_days'         => new sfValidatorInteger(array('required' => false)),
      'parent_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'required' => false)),
      'is_from_one_c'      => new sfValidatorBoolean(array('required' => false)),
      'is_approved'        => new sfValidatorBoolean(array('required' => false)),
      'drfo'               => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'address'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'admission_date'     => new sfValidatorDate(array('required' => false)),
      'dismissal_date'     => new sfValidatorDate(array('required' => false)),
      'individual_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Individual'), 'required' => false)),
      'guid'               => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'passport'           => new sfValidatorString(array('max_length' => 8, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('department_people[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DepartmentPeople';
  }

}
