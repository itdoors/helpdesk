<?php

/**
 * Groupclaimperiod form base class.
 *
 * @method Groupclaimperiod getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGroupclaimperiodForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'groupclaim_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaim'), 'add_empty' => false)),
      'period_day'    => new sfWidgetFormInputText(),
      'period_month'  => new sfWidgetFormInputText(),
      'period_year'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'groupclaim_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaim'))),
      'period_day'    => new sfValidatorString(array('max_length' => 10)),
      'period_month'  => new sfValidatorString(array('max_length' => 10)),
      'period_year'   => new sfValidatorString(array('max_length' => 10)),
    ));

    $this->widgetSchema->setNameFormat('groupclaimperiod[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Groupclaimperiod';
  }

}
