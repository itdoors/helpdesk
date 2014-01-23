<?php

/**
 * HandlingMoreInfoType form base class.
 *
 * @method HandlingMoreInfoType getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHandlingMoreInfoTypeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'handling_result_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingResult'), 'add_empty' => true)),
      'name'               => new sfWidgetFormInputText(),
      'data_type'          => new sfWidgetFormChoice(array('choices' => array('integer' => 'integer', 'float' => 'float', 'string' => 'string', 'select' => 'select'))),
      'enum_choices'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'handling_result_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingResult'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 128)),
      'data_type'          => new sfValidatorChoice(array('choices' => array(0 => 'integer', 1 => 'float', 2 => 'string', 3 => 'select'), 'required' => false)),
      'enum_choices'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'HandlingMoreInfoType', 'column' => array('handling_result_id', 'name')))
    );

    $this->widgetSchema->setNameFormat('handling_more_info_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HandlingMoreInfoType';
  }

}
