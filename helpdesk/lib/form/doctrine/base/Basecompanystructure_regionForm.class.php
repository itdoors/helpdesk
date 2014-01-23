<?php

/**
 * companystructure_region form base class.
 *
 * @method companystructure_region getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basecompanystructure_regionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'companystructure_id' => new sfWidgetFormInputHidden(),
      'region_id'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'companystructure_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('companystructure_id')), 'empty_value' => $this->getObject()->get('companystructure_id'), 'required' => false)),
      'region_id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('region_id')), 'empty_value' => $this->getObject()->get('region_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('companystructure_region[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'companystructure_region';
  }

}
