<?php

/**
 * HandlingMessage form base class.
 *
 * @method HandlingMessage getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHandlingMessageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'type_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingMessageType'), 'add_empty' => true)),
      'createdatetime' => new sfWidgetFormInputText(),
      'createdate'     => new sfWidgetFormDate(),
      'description'    => new sfWidgetFormTextarea(),
      'handling_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'add_empty' => true)),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'filename'       => new sfWidgetFormInputText(),
      'filepath'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingMessageType'), 'required' => false)),
      'createdatetime' => new sfValidatorPass(array('required' => false)),
      'createdate'     => new sfValidatorDate(array('required' => false)),
      'description'    => new sfValidatorString(array('required' => false)),
      'handling_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'filename'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'filepath'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('handling_message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HandlingMessage';
  }

}
