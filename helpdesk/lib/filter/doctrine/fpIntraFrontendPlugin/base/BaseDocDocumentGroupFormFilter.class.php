<?php

/**
 * DocDocumentGroup filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDocDocumentGroupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'    => new sfWidgetFormFilterInput(),
      'createdatetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'level'          => new sfWidgetFormFilterInput(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'parent_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ParentCategory'), 'add_empty' => true)),
      'isdeleted'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'sf_users_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'sf_groups_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'createdatetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'level'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Users'), 'column' => 'id')),
      'parent_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ParentCategory'), 'column' => 'id')),
      'isdeleted'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'sf_users_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'sf_groups_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('doc_document_group_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addSfUsersListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.DocDocumentGroupSfUsers DocDocumentGroupSfUsers')
      ->andWhereIn('DocDocumentGroupSfUsers.sfguarduser_id', $values)
    ;
  }

  public function addSfGroupsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.DocDocumentGroupSfGroups DocDocumentGroupSfGroups')
      ->andWhereIn('DocDocumentGroupSfGroups.sfguardgroup_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'DocDocumentGroup';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'description'    => 'Text',
      'createdatetime' => 'Date',
      'level'          => 'Number',
      'user_id'        => 'ForeignKey',
      'parent_id'      => 'ForeignKey',
      'isdeleted'      => 'Boolean',
      'sf_users_list'  => 'ManyKey',
      'sf_groups_list' => 'ManyKey',
    );
  }
}
