<?php

/**
 * claim_works form base class.
 *
 * @method claim_works getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Baseclaim_worksForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'works_id' => new sfWidgetFormInputHidden(),
      'claim_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'works_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('works_id')), 'empty_value' => $this->getObject()->get('works_id'), 'required' => false)),
      'claim_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('claim_id')), 'empty_value' => $this->getObject()->get('claim_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('claim_works[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'claim_works';
  }

}
