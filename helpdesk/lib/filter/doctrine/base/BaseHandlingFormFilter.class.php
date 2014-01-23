<?php

/**
 * Handling filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHandlingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'number'              => new sfWidgetFormFilterInput(),
      'createdatetime'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'createdate'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'status_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'type_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type'), 'add_empty' => true)),
      'status_description'  => new sfWidgetFormFilterInput(),
      'status_change_date'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'last_handling_date'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'service_offered'     => new sfWidgetFormFilterInput(),
      'budget'              => new sfWidgetFormFilterInput(),
      'budget_client'       => new sfWidgetFormFilterInput(),
      'square'              => new sfWidgetFormFilterInput(),
      'chance'              => new sfWidgetFormFilterInput(),
      'worktime_withclient' => new sfWidgetFormFilterInput(),
      'description'         => new sfWidgetFormFilterInput(),
      'result_string'       => new sfWidgetFormFilterInput(),
      'result_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Result'), 'add_empty' => true)),
      'status_admin'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'is_closed'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'number'              => new sfValidatorPass(array('required' => false)),
      'createdatetime'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'createdate'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'status_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Status'), 'column' => 'id')),
      'type_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type'), 'column' => 'id')),
      'status_description'  => new sfValidatorPass(array('required' => false)),
      'status_change_date'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'last_handling_date'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'service_offered'     => new sfValidatorPass(array('required' => false)),
      'budget'              => new sfValidatorPass(array('required' => false)),
      'budget_client'       => new sfValidatorPass(array('required' => false)),
      'square'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'chance'              => new sfValidatorPass(array('required' => false)),
      'worktime_withclient' => new sfValidatorPass(array('required' => false)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'result_string'       => new sfValidatorPass(array('required' => false)),
      'result_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Result'), 'column' => 'id')),
      'status_admin'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'user_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'organization_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'is_closed'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('handling_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Handling';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'number'              => 'Text',
      'createdatetime'      => 'Date',
      'createdate'          => 'Date',
      'status_id'           => 'ForeignKey',
      'type_id'             => 'ForeignKey',
      'status_description'  => 'Text',
      'status_change_date'  => 'Date',
      'last_handling_date'  => 'Date',
      'service_offered'     => 'Text',
      'budget'              => 'Text',
      'budget_client'       => 'Text',
      'square'              => 'Number',
      'chance'              => 'Text',
      'worktime_withclient' => 'Text',
      'description'         => 'Text',
      'result_string'       => 'Text',
      'result_id'           => 'ForeignKey',
      'status_admin'        => 'Boolean',
      'user_id'             => 'ForeignKey',
      'organization_id'     => 'ForeignKey',
      'is_closed'           => 'Boolean',
    );
  }
}
