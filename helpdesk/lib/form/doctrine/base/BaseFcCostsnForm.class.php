<?php

/**
 * FcCostsn form base class.
 *
 * @method FcCostsn getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFcCostsnForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'finance_claim_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FinanceClaim'), 'add_empty' => false)),
      'fc_costsn_types_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FcCostsntypes'), 'add_empty' => false)),
      'value'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'finance_claim_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FinanceClaim'))),
      'fc_costsn_types_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FcCostsntypes'))),
      'value'              => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('fc_costsn[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FcCostsn';
  }

}
