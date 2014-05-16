<?php

/**
 * HelpdeskProtocol form base class.
 *
 * @method HelpdeskProtocol getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHelpdeskProtocolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'model_name'   => new sfWidgetFormInputText(),
      'model_id'     => new sfWidgetFormInputText(),
      'field_name'   => new sfWidgetFormInputText(),
      'value_before' => new sfWidgetFormInputText(),
      'value_after'  => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'action'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'model_name'   => new sfValidatorString(array('max_length' => 100)),
      'model_id'     => new sfValidatorInteger(),
      'field_name'   => new sfValidatorString(array('max_length' => 100)),
      'value_before' => new sfValidatorString(array('max_length' => 100)),
      'value_after'  => new sfValidatorString(array('max_length' => 100)),
      'created_at'   => new sfValidatorDateTime(),
      'action'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('helpdesk_protocol[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HelpdeskProtocol';
  }

}
