<?php

/**
 * sfGuardUser form base class.
 *
 * @method sfGuardUser getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'first_name'       => new sfWidgetFormInputText(),
      'last_name'        => new sfWidgetFormInputText(),
      'middle_name'      => new sfWidgetFormInputText(),
      'position'         => new sfWidgetFormInputText(),
      'email_address'    => new sfWidgetFormInputText(),
      'username'         => new sfWidgetFormInputText(),
      'birthday'         => new sfWidgetFormDate(),
      'algorithm'        => new sfWidgetFormInputText(),
      'salt'             => new sfWidgetFormInputText(),
      'password'         => new sfWidgetFormInputText(),
      'is_active'        => new sfWidgetFormInputCheckbox(),
      'is_blocked'       => new sfWidgetFormInputCheckbox(),
      'is_fired'         => new sfWidgetFormInputCheckbox(),
      'is_super_admin'   => new sfWidgetFormInputCheckbox(),
      'last_login'       => new sfWidgetFormDateTime(),
      'sex_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('lookup'), 'add_empty' => true)),
      'photo'            => new sfWidgetFormInputText(),
      'about'            => new sfWidgetFormTextarea(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'groups_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
      'doc_groups_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'DocDocumentGroup')),
      'contactinfo_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Contactinfo')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'first_name'       => new sfValidatorString(array('max_length' => 255)),
      'last_name'        => new sfValidatorString(array('max_length' => 255)),
      'middle_name'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'position'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_address'    => new sfValidatorString(array('max_length' => 255)),
      'username'         => new sfValidatorString(array('max_length' => 128)),
      'birthday'         => new sfValidatorDate(array('required' => false)),
      'algorithm'        => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'salt'             => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'password'         => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'is_active'        => new sfValidatorBoolean(array('required' => false)),
      'is_blocked'       => new sfValidatorBoolean(array('required' => false)),
      'is_fired'         => new sfValidatorBoolean(array('required' => false)),
      'is_super_admin'   => new sfValidatorBoolean(array('required' => false)),
      'last_login'       => new sfValidatorDateTime(array('required' => false)),
      'sex_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('lookup'), 'required' => false)),
      'photo'            => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'about'            => new sfValidatorString(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'groups_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'doc_groups_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'DocDocumentGroup', 'required' => false)),
      'contactinfo_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Contactinfo', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address'))),
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username'))),
      ))
    );

    $this->widgetSchema->setNameFormat('sf_guard_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['groups_list']))
    {
      $this->setDefault('groups_list', $this->object->Groups->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['permissions_list']))
    {
      $this->setDefault('permissions_list', $this->object->Permissions->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['doc_groups_list']))
    {
      $this->setDefault('doc_groups_list', $this->object->DocGroups->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['contactinfo_list']))
    {
      $this->setDefault('contactinfo_list', $this->object->Contactinfo->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveGroupsList($con);
    $this->savePermissionsList($con);
    $this->saveDocGroupsList($con);
    $this->saveContactinfoList($con);

    parent::doSave($con);
  }

  public function saveGroupsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['groups_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Groups->getPrimaryKeys();
    $values = $this->getValue('groups_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Groups', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Groups', array_values($link));
    }
  }

  public function savePermissionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['permissions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Permissions->getPrimaryKeys();
    $values = $this->getValue('permissions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Permissions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Permissions', array_values($link));
    }
  }

  public function saveDocGroupsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['doc_groups_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DocGroups->getPrimaryKeys();
    $values = $this->getValue('doc_groups_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DocGroups', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DocGroups', array_values($link));
    }
  }

  public function saveContactinfoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['contactinfo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Contactinfo->getPrimaryKeys();
    $values = $this->getValue('contactinfo_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Contactinfo', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Contactinfo', array_values($link));
    }
  }

}
