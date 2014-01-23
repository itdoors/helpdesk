<?php

/**
 * LogIntranet form base class.
 *
 * @method LogIntranet getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLogIntranetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormInputText(),
      'obj_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocumentGroup'), 'add_empty' => false)),
      'createdatetime' => new sfWidgetFormDateTime(),
      'description'    => new sfWidgetFormInputText(),
      'logkey'         => new sfWidgetFormChoice(array('choices' => array('new' => 'new', 'edit' => 'edit', 'delete' => 'delete'))),
      'logtype'        => new sfWidgetFormChoice(array('choices' => array('doc_document_group' => 'doc_document_group', 'doc_document' => 'doc_document', 'doc_document_vesion' => 'doc_document_vesion'))),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'        => new sfValidatorInteger(),
      'obj_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocumentGroup'))),
      'createdatetime' => new sfValidatorDateTime(array('required' => false)),
      'description'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'logkey'         => new sfValidatorChoice(array('choices' => array(0 => 'new', 1 => 'edit', 2 => 'delete'), 'required' => false)),
      'logtype'        => new sfValidatorChoice(array('choices' => array(0 => 'doc_document_group', 1 => 'doc_document', 2 => 'doc_document_vesion'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('log_intranet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LogIntranet';
  }

}
