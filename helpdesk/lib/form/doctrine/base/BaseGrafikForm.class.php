<?php

/**
 * Grafik form base class.
 *
 * @method Grafik getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGrafikForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'year'                             => new sfWidgetFormInputHidden(),
      'month'                            => new sfWidgetFormInputHidden(),
      'day'                              => new sfWidgetFormInputHidden(),
      'department_id'                    => new sfWidgetFormInputHidden(),
      'department_people_id'             => new sfWidgetFormInputHidden(),
      'department_people_replacement_id' => new sfWidgetFormInputHidden(),
      'total'                            => new sfWidgetFormInputText(),
      'total_day'                        => new sfWidgetFormInputText(),
      'total_evening'                    => new sfWidgetFormInputText(),
      'total_night'                      => new sfWidgetFormInputText(),
      'total_not_officially'             => new sfWidgetFormInputText(),
      'total_day_not_officially'         => new sfWidgetFormInputText(),
      'total_evening_not_officially'     => new sfWidgetFormInputText(),
      'total_night_not_officially'       => new sfWidgetFormInputText(),
      'is_sick'                          => new sfWidgetFormInputCheckbox(),
      'is_skip'                          => new sfWidgetFormInputCheckbox(),
      'is_fired'                         => new sfWidgetFormInputCheckbox(),
      'is_vacation'                      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'year'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('year')), 'empty_value' => $this->getObject()->get('year'), 'required' => false)),
      'month'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('month')), 'empty_value' => $this->getObject()->get('month'), 'required' => false)),
      'day'                              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('day')), 'empty_value' => $this->getObject()->get('day'), 'required' => false)),
      'department_id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('department_id')), 'empty_value' => $this->getObject()->get('department_id'), 'required' => false)),
      'department_people_id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('department_people_id')), 'empty_value' => $this->getObject()->get('department_people_id'), 'required' => false)),
      'department_people_replacement_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('department_people_replacement_id')), 'empty_value' => $this->getObject()->get('department_people_replacement_id'), 'required' => false)),
      'total'                            => new sfValidatorNumber(array('required' => false)),
      'total_day'                        => new sfValidatorNumber(array('required' => false)),
      'total_evening'                    => new sfValidatorNumber(array('required' => false)),
      'total_night'                      => new sfValidatorNumber(array('required' => false)),
      'total_not_officially'             => new sfValidatorNumber(array('required' => false)),
      'total_day_not_officially'         => new sfValidatorNumber(array('required' => false)),
      'total_evening_not_officially'     => new sfValidatorNumber(array('required' => false)),
      'total_night_not_officially'       => new sfValidatorNumber(array('required' => false)),
      'is_sick'                          => new sfValidatorBoolean(array('required' => false)),
      'is_skip'                          => new sfValidatorBoolean(array('required' => false)),
      'is_fired'                         => new sfValidatorBoolean(array('required' => false)),
      'is_vacation'                      => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('grafik[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grafik';
  }

}
