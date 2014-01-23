<?php

/**
 * finance_claim form base class.
 *
 * @method finance_claim getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basefinance_claimForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'claim_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('claim'), 'add_empty' => false)),
      'mpk'                => new sfWidgetFormInputText(),
      'work'               => new sfWidgetFormInputText(),
      'costs_n'            => new sfWidgetFormInputText(),
      'costs_nds'          => new sfWidgetFormInputText(),
      'costs_nonnds'       => new sfWidgetFormInputText(),
      'costs_beznalnonnds' => new sfWidgetFormInputText(),
      'income_nds'         => new sfWidgetFormInputText(),
      'income_nonnds'      => new sfWidgetFormInputText(),
      'bill_number'        => new sfWidgetFormInputText(),
      'profitability'      => new sfWidgetFormInputText(),
      'status_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'nds'                => new sfWidgetFormInputText(),
      'obnal'              => new sfWidgetFormInputText(),
      'is_closed'          => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'claim_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('claim'))),
      'mpk'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'work'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'costs_n'            => new sfValidatorNumber(array('required' => false)),
      'costs_nds'          => new sfValidatorNumber(array('required' => false)),
      'costs_nonnds'       => new sfValidatorNumber(array('required' => false)),
      'costs_beznalnonnds' => new sfValidatorNumber(array('required' => false)),
      'income_nds'         => new sfValidatorNumber(array('required' => false)),
      'income_nonnds'      => new sfValidatorNumber(array('required' => false)),
      'bill_number'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'profitability'      => new sfValidatorNumber(array('required' => false)),
      'status_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'required' => false)),
      'nds'                => new sfValidatorNumber(array('required' => false)),
      'obnal'              => new sfValidatorNumber(array('required' => false)),
      'is_closed'          => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('finance_claim[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'finance_claim';
  }

}
