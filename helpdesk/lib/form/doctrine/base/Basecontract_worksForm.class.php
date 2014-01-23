<?php

/**
 * contract_works form base class.
 *
 * @method contract_works getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basecontract_worksForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'works_id'    => new sfWidgetFormInputHidden(),
      'contract_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'works_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('works_id')), 'empty_value' => $this->getObject()->get('works_id'), 'required' => false)),
      'contract_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('contract_id')), 'empty_value' => $this->getObject()->get('contract_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contract_works[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'contract_works';
  }

}
