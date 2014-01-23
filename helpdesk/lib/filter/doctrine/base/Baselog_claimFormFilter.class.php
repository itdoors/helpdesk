<?php

/**
 * log_claim filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class Baselog_claimFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'claim_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('claim'), 'add_empty' => true)),
      'description'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'createdatetime'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'log_claim_type'   => new sfWidgetFormFilterInput(),
      'finance_claim_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FinanceClaim'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'claim_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('claim'), 'column' => 'id')),
      'description'      => new sfValidatorPass(array('required' => false)),
      'createdatetime'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'user_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Users'), 'column' => 'id')),
      'log_claim_type'   => new sfValidatorPass(array('required' => false)),
      'finance_claim_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FinanceClaim'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('log_claim_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'log_claim';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'claim_id'         => 'ForeignKey',
      'description'      => 'Text',
      'createdatetime'   => 'Date',
      'user_id'          => 'ForeignKey',
      'log_claim_type'   => 'Text',
      'finance_claim_id' => 'ForeignKey',
    );
  }
}
