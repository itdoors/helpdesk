<?php

/**
 * DocDocumentGroupSfUsers form base class.
 *
 * @method DocDocumentGroupSfUsers getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocDocumentGroupSfUsersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sfguarduser_id'      => new sfWidgetFormInputHidden(),
      'docdocumentgroup_id' => new sfWidgetFormInputHidden(),
      'actionkey'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'sfguarduser_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('sfguarduser_id')), 'empty_value' => $this->getObject()->get('sfguarduser_id'), 'required' => false)),
      'docdocumentgroup_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('docdocumentgroup_id')), 'empty_value' => $this->getObject()->get('docdocumentgroup_id'), 'required' => false)),
      'actionkey'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('actionkey')), 'empty_value' => $this->getObject()->get('actionkey'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('doc_document_group_sf_users[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocDocumentGroupSfUsers';
  }

}
