<?php

/**
 * Grafik filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGrafikFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'total'                            => new sfWidgetFormFilterInput(),
      'total_day'                        => new sfWidgetFormFilterInput(),
      'total_evening'                    => new sfWidgetFormFilterInput(),
      'total_night'                      => new sfWidgetFormFilterInput(),
      'is_sick'                          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_skip'                          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_fired'                         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_vacation'                      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'total'                            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_day'                        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_evening'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_night'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_sick'                          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_skip'                          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_fired'                         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_vacation'                      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('grafik_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grafik';
  }

  public function getFields()
  {
    return array(
      'year'                             => 'Number',
      'month'                            => 'Number',
      'day'                              => 'Number',
      'department_id'                    => 'Number',
      'department_people_id'             => 'Number',
      'department_people_replacement_id' => 'Number',
      'total'                            => 'Number',
      'total_day'                        => 'Number',
      'total_evening'                    => 'Number',
      'total_night'                      => 'Number',
      'is_sick'                          => 'Boolean',
      'is_skip'                          => 'Boolean',
      'is_fired'                         => 'Boolean',
      'is_vacation'                      => 'Boolean',
    );
  }
}
