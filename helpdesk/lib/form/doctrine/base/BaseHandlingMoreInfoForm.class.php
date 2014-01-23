<?php

/**
 * HandlingMoreInfo form base class.
 *
 * @method HandlingMoreInfo getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHandlingMoreInfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'handling_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'add_empty' => false)),
      'handling_more_info_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingMoreInfoType'), 'add_empty' => false)),
      'value'                      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'handling_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'))),
      'handling_more_info_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingMoreInfoType'))),
      'value'                      => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('handling_more_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HandlingMoreInfo';
  }

}
