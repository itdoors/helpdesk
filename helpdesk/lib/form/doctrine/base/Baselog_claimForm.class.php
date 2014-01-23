<?php

/**
 * log_claim form base class.
 *
 * @method log_claim getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Baselog_claimForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'claim_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('claim'), 'add_empty' => false)),
      'description'      => new sfWidgetFormInputText(),
      'createdatetime'   => new sfWidgetFormDateTime(),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'log_claim_type'   => new sfWidgetFormInputText(),
      'finance_claim_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FinanceClaim'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'claim_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('claim'))),
      'description'      => new sfValidatorString(array('max_length' => 255)),
      'createdatetime'   => new sfValidatorDateTime(),
      'user_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'required' => false)),
      'log_claim_type'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'finance_claim_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FinanceClaim'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('log_claim[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'log_claim';
  }

}
