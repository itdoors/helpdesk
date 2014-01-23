<?php

/**
 * QueueLog form base class.
 *
 * @method QueueLog getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseQueueLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'object_model'    => new sfWidgetFormInputText(),
      'object_submodel' => new sfWidgetFormInputText(),
      'params'          => new sfWidgetFormInputText(),
      'createdatetime'  => new sfWidgetFormDateTime(),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'status'          => new sfWidgetFormChoice(array('choices' => array('new' => 'new', 'proceed' => 'proceed', 'done' => 'done'))),
      'persent'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'object_model'    => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'object_submodel' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'params'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'createdatetime'  => new sfValidatorDateTime(array('required' => false)),
      'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'status'          => new sfValidatorChoice(array('choices' => array(0 => 'new', 1 => 'proceed', 2 => 'done'), 'required' => false)),
      'persent'         => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('queue_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'QueueLog';
  }

}
