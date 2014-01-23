<?php

/**
 * DogovorHandling form base class.
 *
 * @method DogovorHandling getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDogovorHandlingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'dogovor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'), 'add_empty' => false)),
      'handling_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dogovor_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'))),
      'handling_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'))),
    ));

    $this->widgetSchema->setNameFormat('dogovor_handling[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DogovorHandling';
  }

}
