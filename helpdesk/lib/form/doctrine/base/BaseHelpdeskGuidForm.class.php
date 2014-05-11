<?php

/**
 * HelpdeskGuid form base class.
 *
 * @method HelpdeskGuid getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHelpdeskGuidForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'helpdesk_name' => new sfWidgetFormInputHidden(),
      'helpdesk_id'   => new sfWidgetFormInputHidden(),
      'guid'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'helpdesk_name' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('helpdesk_name')), 'empty_value' => $this->getObject()->get('helpdesk_name'), 'required' => false)),
      'helpdesk_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('helpdesk_id')), 'empty_value' => $this->getObject()->get('helpdesk_id'), 'required' => false)),
      'guid'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('guid')), 'empty_value' => $this->getObject()->get('guid'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('helpdesk_guid[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HelpdeskGuid';
  }

}
