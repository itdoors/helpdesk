<?php

/**
 * status form base class.
 *
 * @method status getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasestatusForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'stakey'       => new sfWidgetFormInputText(),
      'name'         => new sfWidgetFormInputText(),
      'timereminder' => new sfWidgetFormInputText(),
      'color'        => new sfWidgetFormInputText(),
      'icon'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'stakey'       => new sfValidatorString(array('max_length' => 50)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'timereminder' => new sfValidatorInteger(array('required' => false)),
      'color'        => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'icon'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'status', 'column' => array('stakey')))
    );

    $this->widgetSchema->setNameFormat('status[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'status';
  }

}
