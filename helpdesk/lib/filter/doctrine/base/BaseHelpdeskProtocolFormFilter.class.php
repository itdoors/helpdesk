<?php

/**
 * HelpdeskProtocol filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHelpdeskProtocolFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'model_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'model_id'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'field_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'value_before' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'value_after'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'action'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'model_name'   => new sfValidatorPass(array('required' => false)),
      'model_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'field_name'   => new sfValidatorPass(array('required' => false)),
      'value_before' => new sfValidatorPass(array('required' => false)),
      'value_after'  => new sfValidatorPass(array('required' => false)),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'action'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('helpdesk_protocol_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HelpdeskProtocol';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'model_name'   => 'Text',
      'model_id'     => 'Number',
      'field_name'   => 'Text',
      'value_before' => 'Text',
      'value_after'  => 'Text',
      'created_at'   => 'Date',
      'action'       => 'Text',
    );
  }
}
