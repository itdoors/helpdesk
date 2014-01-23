<?php

/**
 * GrafikTime form base class.
 *
 * @method GrafikTime getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGrafikTimeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'year'                             => new sfWidgetFormInputText(),
      'month'                            => new sfWidgetFormInputText(),
      'day'                              => new sfWidgetFormInputText(),
      'department_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => false)),
      'department_people_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeople'), 'add_empty' => false)),
      'department_people_replacement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeopleReplacement'), 'add_empty' => false)),
      'from_time'                        => new sfWidgetFormTime(),
      'to_time'                          => new sfWidgetFormTime(),
      'total'                            => new sfWidgetFormInputText(),
      'total_day'                        => new sfWidgetFormInputText(),
      'total_evening'                    => new sfWidgetFormInputText(),
      'total_night'                      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'year'                             => new sfValidatorInteger(),
      'month'                            => new sfValidatorInteger(),
      'day'                              => new sfValidatorInteger(),
      'department_id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'department_people_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeople'))),
      'department_people_replacement_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeopleReplacement'), 'required' => false)),
      'from_time'                        => new sfValidatorTime(array('required' => false)),
      'to_time'                          => new sfValidatorTime(array('required' => false)),
      'total'                            => new sfValidatorNumber(array('required' => false)),
      'total_day'                        => new sfValidatorNumber(array('required' => false)),
      'total_evening'                    => new sfValidatorNumber(array('required' => false)),
      'total_night'                      => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('grafik_time[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GrafikTime';
  }

}
