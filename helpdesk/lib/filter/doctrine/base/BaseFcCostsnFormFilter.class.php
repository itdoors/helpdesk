<?php

/**
 * FcCostsn filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFcCostsnFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'finance_claim_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FinanceClaim'), 'add_empty' => true)),
      'fc_costsn_types_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FcCostsntypes'), 'add_empty' => true)),
      'value'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'finance_claim_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FinanceClaim'), 'column' => 'id')),
      'fc_costsn_types_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FcCostsntypes'), 'column' => 'id')),
      'value'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('fc_costsn_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FcCostsn';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'finance_claim_id'   => 'ForeignKey',
      'fc_costsn_types_id' => 'ForeignKey',
      'value'              => 'Number',
    );
  }
}
