<?php

/**
 * DocumentsClaim form base class.
 *
 * @method DocumentsClaim getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocumentsClaimForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'claim_id'     => new sfWidgetFormInputHidden(),
      'documents_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'claim_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('claim_id')), 'empty_value' => $this->getObject()->get('claim_id'), 'required' => false)),
      'documents_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('documents_id')), 'empty_value' => $this->getObject()->get('documents_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documents_claim[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentsClaim';
  }

}
