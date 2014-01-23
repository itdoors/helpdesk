<?php

/**
 * DopDogovor filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDopDogovorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dogovor_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'), 'add_empty' => true)),
      'dop_dogovor_type' => new sfWidgetFormFilterInput(),
      'number'           => new sfWidgetFormFilterInput(),
      'startdatetime'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'activedatetime'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'subject'          => new sfWidgetFormFilterInput(),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'total'            => new sfWidgetFormFilterInput(),
      'filepath'         => new sfWidgetFormFilterInput(),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'stuff_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'dogovor_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dogovor'), 'column' => 'id')),
      'dop_dogovor_type' => new sfValidatorPass(array('required' => false)),
      'number'           => new sfValidatorPass(array('required' => false)),
      'startdatetime'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'activedatetime'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'subject'          => new sfValidatorPass(array('required' => false)),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'total'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'filepath'         => new sfValidatorPass(array('required' => false)),
      'user_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'stuff_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Stuff'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('dop_dogovor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DopDogovor';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'dogovor_id'       => 'ForeignKey',
      'dop_dogovor_type' => 'Text',
      'number'           => 'Text',
      'startdatetime'    => 'Date',
      'activedatetime'   => 'Date',
      'subject'          => 'Text',
      'is_active'        => 'Boolean',
      'total'            => 'Number',
      'filepath'         => 'Text',
      'user_id'          => 'ForeignKey',
      'stuff_id'         => 'ForeignKey',
    );
  }
}
