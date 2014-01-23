<?php

/**
 * History filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHistoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'model_name'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'model_id'       => new sfWidgetFormFilterInput(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'field_name'     => new sfWidgetFormFilterInput(),
      'more'           => new sfWidgetFormFilterInput(),
      'old_value'      => new sfWidgetFormFilterInput(),
      'value'          => new sfWidgetFormFilterInput(),
      'createdatetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'model_name'     => new sfValidatorPass(array('required' => false)),
      'model_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'field_name'     => new sfValidatorPass(array('required' => false)),
      'more'           => new sfValidatorPass(array('required' => false)),
      'old_value'      => new sfValidatorPass(array('required' => false)),
      'value'          => new sfValidatorPass(array('required' => false)),
      'createdatetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('history_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'History';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'model_name'     => 'Text',
      'model_id'       => 'Number',
      'user_id'        => 'ForeignKey',
      'field_name'     => 'Text',
      'more'           => 'Text',
      'old_value'      => 'Text',
      'value'          => 'Text',
      'createdatetime' => 'Date',
    );
  }
}
