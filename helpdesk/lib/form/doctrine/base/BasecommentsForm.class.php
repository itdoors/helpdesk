<?php

/**
 * comments form base class.
 *
 * @method comments getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecommentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'claim_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'), 'add_empty' => true)),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'description'    => new sfWidgetFormTextarea(),
      'createdatetime' => new sfWidgetFormDateTime(),
      'isvisible'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'claim_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'), 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'description'    => new sfValidatorString(),
      'createdatetime' => new sfValidatorDateTime(array('required' => false)),
      'isvisible'      => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('comments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'comments';
  }

}
