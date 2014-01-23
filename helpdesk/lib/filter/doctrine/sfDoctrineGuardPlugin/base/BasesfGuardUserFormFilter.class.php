<?php

/**
 * sfGuardUser filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'middle_name'      => new sfWidgetFormFilterInput(),
      'position'         => new sfWidgetFormFilterInput(),
      'email_address'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'username'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'birthday'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'algorithm'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'             => new sfWidgetFormFilterInput(),
      'password'         => new sfWidgetFormFilterInput(),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_blocked'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_fired'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_super_admin'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_login'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'sex_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('lookup'), 'add_empty' => true)),
      'photo'            => new sfWidgetFormFilterInput(),
      'about'            => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'groups_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
      'doc_groups_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'DocDocumentGroup')),
      'contactinfo_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Contactinfo')),
    ));

    $this->setValidators(array(
      'first_name'       => new sfValidatorPass(array('required' => false)),
      'last_name'        => new sfValidatorPass(array('required' => false)),
      'middle_name'      => new sfValidatorPass(array('required' => false)),
      'position'         => new sfValidatorPass(array('required' => false)),
      'email_address'    => new sfValidatorPass(array('required' => false)),
      'username'         => new sfValidatorPass(array('required' => false)),
      'birthday'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'algorithm'        => new sfValidatorPass(array('required' => false)),
      'salt'             => new sfValidatorPass(array('required' => false)),
      'password'         => new sfValidatorPass(array('required' => false)),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_blocked'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_fired'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_super_admin'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_login'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'sex_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('lookup'), 'column' => 'id')),
      'photo'            => new sfValidatorPass(array('required' => false)),
      'about'            => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'groups_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'doc_groups_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'DocDocumentGroup', 'required' => false)),
      'contactinfo_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Contactinfo', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGroupsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.sfGuardUserGroup sfGuardUserGroup')
      ->andWhereIn('sfGuardUserGroup.group_id', $values)
    ;
  }

  public function addPermissionsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.sfGuardUserPermission sfGuardUserPermission')
      ->andWhereIn('sfGuardUserPermission.permission_id', $values)
    ;
  }

  public function addDocGroupsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('DocDocumentGroupSfUsers.docdocumentgroup_id', $values)
    ;
  }

  public function addContactinfoListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.UserContactinfo UserContactinfo')
      ->andWhereIn('UserContactinfo.contactinfo_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'first_name'       => 'Text',
      'last_name'        => 'Text',
      'middle_name'      => 'Text',
      'position'         => 'Text',
      'email_address'    => 'Text',
      'username'         => 'Text',
      'birthday'         => 'Date',
      'algorithm'        => 'Text',
      'salt'             => 'Text',
      'password'         => 'Text',
      'is_active'        => 'Boolean',
      'is_blocked'       => 'Boolean',
      'is_fired'         => 'Boolean',
      'is_super_admin'   => 'Boolean',
      'last_login'       => 'Date',
      'sex_id'           => 'ForeignKey',
      'photo'            => 'Text',
      'about'            => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'groups_list'      => 'ManyKey',
      'permissions_list' => 'ManyKey',
      'doc_groups_list'  => 'ManyKey',
      'contactinfo_list' => 'ManyKey',
    );
  }
}
