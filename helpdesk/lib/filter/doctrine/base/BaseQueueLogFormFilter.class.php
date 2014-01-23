<?php

/**
 * QueueLog filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseQueueLogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'object_model'    => new sfWidgetFormFilterInput(),
      'object_submodel' => new sfWidgetFormFilterInput(),
      'params'          => new sfWidgetFormFilterInput(),
      'createdatetime'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'status'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'new' => 'new', 'proceed' => 'proceed', 'done' => 'done'))),
      'persent'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'object_model'    => new sfValidatorPass(array('required' => false)),
      'object_submodel' => new sfValidatorPass(array('required' => false)),
      'params'          => new sfValidatorPass(array('required' => false)),
      'createdatetime'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'user_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'status'          => new sfValidatorChoice(array('required' => false, 'choices' => array('new' => 'new', 'proceed' => 'proceed', 'done' => 'done'))),
      'persent'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('queue_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'QueueLog';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'object_model'    => 'Text',
      'object_submodel' => 'Text',
      'params'          => 'Text',
      'createdatetime'  => 'Date',
      'user_id'         => 'ForeignKey',
      'status'          => 'Enum',
      'persent'         => 'Number',
    );
  }
}
