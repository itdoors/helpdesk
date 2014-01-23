<?php

/**
 * Salary filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSalaryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'year'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'month'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'days_count'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'weekends'     => new sfWidgetFormFilterInput(),
      'day_salary'   => new sfWidgetFormFilterInput(),
      'summary_coef' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'year'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'month'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'days_count'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'weekends'     => new sfValidatorPass(array('required' => false)),
      'day_salary'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'summary_coef' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('salary_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Salary';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'year'         => 'Number',
      'month'        => 'Number',
      'days_count'   => 'Number',
      'weekends'     => 'Text',
      'day_salary'   => 'Number',
      'summary_coef' => 'Number',
    );
  }
}
