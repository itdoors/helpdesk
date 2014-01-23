<?php

/**
 * DopDogovor form base class.
 *
 * @method DopDogovor getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDopDogovorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'dogovor_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'), 'add_empty' => false)),
      'dop_dogovor_type' => new sfWidgetFormInputText(),
      'number'           => new sfWidgetFormInputText(),
      'startdatetime'    => new sfWidgetFormDateTime(),
      'activedatetime'   => new sfWidgetFormDateTime(),
      'subject'          => new sfWidgetFormInputText(),
      'is_active'        => new sfWidgetFormInputCheckbox(),
      'total'            => new sfWidgetFormInputText(),
      'filepath'         => new sfWidgetFormInputText(),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'stuff_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dogovor_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'))),
      'dop_dogovor_type' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'startdatetime'    => new sfValidatorDateTime(),
      'activedatetime'   => new sfValidatorDateTime(array('required' => false)),
      'subject'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'        => new sfValidatorBoolean(array('required' => false)),
      'total'            => new sfValidatorNumber(array('required' => false)),
      'filepath'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'stuff_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dop_dogovor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DopDogovor';
  }

}
