<?php

/**
 * contract_importance form base class.
 *
 * @method contract_importance getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basecontract_importanceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'contract_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('contract'), 'add_empty' => false)),
      'importance_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('importance'), 'add_empty' => false)),
      'organization_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'duration'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'contract_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('contract'))),
      'importance_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('importance'))),
      'organization_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false)),
      'duration'        => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('contract_importance[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'contract_importance';
  }

}
