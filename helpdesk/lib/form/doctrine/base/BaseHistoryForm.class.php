<?php

/**
 * History form base class.
 *
 * @method History getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHistoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'model_name'     => new sfWidgetFormInputText(),
      'model_id'       => new sfWidgetFormInputText(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'field_name'     => new sfWidgetFormInputText(),
      'more'           => new sfWidgetFormInputText(),
      'old_value'      => new sfWidgetFormInputText(),
      'value'          => new sfWidgetFormInputText(),
      'createdatetime' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'model_name'     => new sfValidatorString(array('max_length' => 255)),
      'model_id'       => new sfValidatorInteger(array('required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'field_name'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'more'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'old_value'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'value'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'createdatetime' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'History';
  }

}
