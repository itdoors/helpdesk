<?php

/**
 * claimusers form base class.
 *
 * @method claimusers getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseclaimusersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'claim_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'), 'add_empty' => false)),
      'userkey'  => new sfWidgetFormInputText(),
      'isread'   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'claim_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'))),
      'userkey'  => new sfValidatorString(array('max_length' => 20)),
      'isread'   => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('claimusers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'claimusers';
  }

}
