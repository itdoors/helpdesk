<?php

/**
 * GrafikTime filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGrafikTimeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'year'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'month'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'day'                              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'department_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'department_people_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeople'), 'add_empty' => true)),
      'department_people_replacement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentPeopleReplacement'), 'add_empty' => true)),
      'is_substitution'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'from_time'                        => new sfWidgetFormFilterInput(),
      'to_time'                          => new sfWidgetFormFilterInput(),
      'not_officially'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'total'                            => new sfWidgetFormFilterInput(),
      'total_day'                        => new sfWidgetFormFilterInput(),
      'total_evening'                    => new sfWidgetFormFilterInput(),
      'total_night'                      => new sfWidgetFormFilterInput(),
      'total_not_officially'             => new sfWidgetFormFilterInput(),
      'total_day_not_officially'         => new sfWidgetFormFilterInput(),
      'total_evening_not_officially'     => new sfWidgetFormFilterInput(),
      'total_night_not_officially'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'year'                             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'month'                            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'day'                              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'department_id'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'department_people_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DepartmentPeople'), 'column' => 'id')),
      'department_people_replacement_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DepartmentPeopleReplacement'), 'column' => 'id')),
      'is_substitution'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'from_time'                        => new sfValidatorPass(array('required' => false)),
      'to_time'                          => new sfValidatorPass(array('required' => false)),
      'not_officially'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'total'                            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_day'                        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_evening'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_night'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_not_officially'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_day_not_officially'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_evening_not_officially'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_night_not_officially'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('grafik_time_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GrafikTime';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'year'                             => 'Number',
      'month'                            => 'Number',
      'day'                              => 'Number',
      'department_id'                    => 'ForeignKey',
      'department_people_id'             => 'ForeignKey',
      'department_people_replacement_id' => 'ForeignKey',
      'is_substitution'                  => 'Boolean',
      'from_time'                        => 'Text',
      'to_time'                          => 'Text',
      'not_officially'                   => 'Boolean',
      'total'                            => 'Number',
      'total_day'                        => 'Number',
      'total_evening'                    => 'Number',
      'total_night'                      => 'Number',
      'total_not_officially'             => 'Number',
      'total_day_not_officially'         => 'Number',
      'total_evening_not_officially'     => 'Number',
      'total_night_not_officially'       => 'Number',
    );
  }
}
