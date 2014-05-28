<?php

/**
 * DocDocumentVersion form base class.
 *
 * @method DocDocumentVersion getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocDocumentVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'filepath'       => new sfWidgetFormInputText(),
      'mime_type'      => new sfWidgetFormInputText(),
      'createdatetime' => new sfWidgetFormDateTime(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'document_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocument'), 'add_empty' => false)),
      'isdeleted'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 255)),
      'filepath'       => new sfValidatorString(array('max_length' => 255)),
      'mime_type'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'createdatetime' => new sfValidatorDateTime(array('required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'document_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocument'))),
      'isdeleted'      => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('doc_document_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocDocumentVersion';
  }

}
