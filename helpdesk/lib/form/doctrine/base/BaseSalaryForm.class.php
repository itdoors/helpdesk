<?php

/**
 * Salary form base class.
 *
 * @method Salary getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSalaryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'year'         => new sfWidgetFormInputText(),
      'month'        => new sfWidgetFormInputText(),
      'days_count'   => new sfWidgetFormInputText(),
      'weekends'     => new sfWidgetFormInputText(),
      'day_salary'   => new sfWidgetFormInputText(),
      'summary_coef' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'year'         => new sfValidatorInteger(),
      'month'        => new sfValidatorInteger(),
      'days_count'   => new sfValidatorInteger(),
      'weekends'     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'day_salary'   => new sfValidatorNumber(array('required' => false)),
      'summary_coef' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Salary', 'column' => array('year', 'month')))
    );

    $this->widgetSchema->setNameFormat('salary[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Salary';
  }

}
