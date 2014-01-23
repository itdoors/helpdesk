<?php

/**
 * Documents filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDocumentsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'datetime'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'createdatetime'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'documentstype_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Documentstype'), 'add_empty' => true)),
      'filepath'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'claim_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'claim')),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'datetime'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'createdatetime'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'documentstype_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Documentstype'), 'column' => 'id')),
      'filepath'         => new sfValidatorPass(array('required' => false)),
      'user_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Users'), 'column' => 'id')),
      'claim_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'claim', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documents_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addClaimListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.DocumentsClaim DocumentsClaim')
      ->andWhereIn('DocumentsClaim.claim_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Documents';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'datetime'         => 'Date',
      'createdatetime'   => 'Date',
      'documentstype_id' => 'ForeignKey',
      'filepath'         => 'Text',
      'user_id'          => 'ForeignKey',
      'claim_list'       => 'ManyKey',
    );
  }
}
