<?php

/**
 * finance_claim filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class Basefinance_claimFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'claim_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('claim'), 'add_empty' => true)),
      'mpk'                => new sfWidgetFormFilterInput(),
      'work'               => new sfWidgetFormFilterInput(),
      'costs_n'            => new sfWidgetFormFilterInput(),
      'costs_nds'          => new sfWidgetFormFilterInput(),
      'costs_nonnds'       => new sfWidgetFormFilterInput(),
      'costs_beznalnonnds' => new sfWidgetFormFilterInput(),
      'income_nds'         => new sfWidgetFormFilterInput(),
      'income_nonnds'      => new sfWidgetFormFilterInput(),
      'bill_number'        => new sfWidgetFormFilterInput(),
      'profitability'      => new sfWidgetFormFilterInput(),
      'status_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'nds'                => new sfWidgetFormFilterInput(),
      'obnal'              => new sfWidgetFormFilterInput(),
      'is_closed'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'claim_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('claim'), 'column' => 'id')),
      'mpk'                => new sfValidatorPass(array('required' => false)),
      'work'               => new sfValidatorPass(array('required' => false)),
      'costs_n'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costs_nds'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costs_nonnds'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costs_beznalnonnds' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'income_nds'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'income_nonnds'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bill_number'        => new sfValidatorPass(array('required' => false)),
      'profitability'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'status_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Status'), 'column' => 'id')),
      'nds'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'obnal'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_closed'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('finance_claim_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'finance_claim';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'claim_id'           => 'ForeignKey',
      'mpk'                => 'Text',
      'work'               => 'Text',
      'costs_n'            => 'Number',
      'costs_nds'          => 'Number',
      'costs_nonnds'       => 'Number',
      'costs_beznalnonnds' => 'Number',
      'income_nds'         => 'Number',
      'income_nonnds'      => 'Number',
      'bill_number'        => 'Text',
      'profitability'      => 'Number',
      'status_id'          => 'ForeignKey',
      'nds'                => 'Number',
      'obnal'              => 'Number',
      'is_closed'          => 'Boolean',
    );
  }
}
