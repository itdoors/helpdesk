<?php

/**
 * GroupclaimClaim form base class.
 *
 * @method GroupclaimClaim getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGroupclaimClaimForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'claim_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'), 'add_empty' => false)),
      'groupclaim_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaim'), 'add_empty' => false)),
      'createdatetime' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'claim_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'))),
      'groupclaim_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaim'))),
      'createdatetime' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('groupclaim_claim[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GroupclaimClaim';
  }

}
