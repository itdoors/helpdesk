<?php

/**
 * UserContactinfo form base class.
 *
 * @method UserContactinfo getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserContactinfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'contactinfo_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contactinfo'), 'add_empty' => false)),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'value'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'contactinfo_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contactinfo'))),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'value'          => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('user_contactinfo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserContactinfo';
  }

}
