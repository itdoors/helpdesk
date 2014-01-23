<?php

/**
 * attach form base class.
 *
 * @method attach getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseattachForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'filename'    => new sfWidgetFormInputText(),
      'filepath'    => new sfWidgetFormInputText(),
      'comments_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Comments'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'filename'    => new sfValidatorString(array('max_length' => 255)),
      'filepath'    => new sfValidatorString(array('max_length' => 255)),
      'comments_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Comments'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attach[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'attach';
  }

}
