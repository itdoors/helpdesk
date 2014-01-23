<?php

/**
 * LogIntranet filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLogIntranetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'obj_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocDocumentGroup'), 'add_empty' => true)),
      'createdatetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'description'    => new sfWidgetFormFilterInput(),
      'logkey'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'new' => 'new', 'edit' => 'edit', 'delete' => 'delete'))),
      'logtype'        => new sfWidgetFormChoice(array('choices' => array('' => '', 'doc_document_group' => 'doc_document_group', 'doc_document' => 'doc_document', 'doc_document_vesion' => 'doc_document_vesion'))),
    ));

    $this->setValidators(array(
      'user_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'obj_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocDocumentGroup'), 'column' => 'id')),
      'createdatetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'description'    => new sfValidatorPass(array('required' => false)),
      'logkey'         => new sfValidatorChoice(array('required' => false, 'choices' => array('new' => 'new', 'edit' => 'edit', 'delete' => 'delete'))),
      'logtype'        => new sfValidatorChoice(array('required' => false, 'choices' => array('doc_document_group' => 'doc_document_group', 'doc_document' => 'doc_document', 'doc_document_vesion' => 'doc_document_vesion'))),
    ));

    $this->widgetSchema->setNameFormat('log_intranet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LogIntranet';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'user_id'        => 'Number',
      'obj_id'         => 'ForeignKey',
      'createdatetime' => 'Date',
      'description'    => 'Text',
      'logkey'         => 'Enum',
      'logtype'        => 'Enum',
    );
  }
}
