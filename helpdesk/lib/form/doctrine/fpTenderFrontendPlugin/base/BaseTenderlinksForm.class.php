<?php

/**
 * Tenderlinks form base class.
 *
 * @method Tenderlinks getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTenderlinksForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'name'              => new sfWidgetFormInputText(),
      'tendercategory_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tendercategory'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 200)),
      'tendercategory_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tendercategory'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tenderlinks[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tenderlinks';
  }

}
