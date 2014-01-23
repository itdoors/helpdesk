<?php

/**
 * DocDocumentGroup form base class.
 *
 * @method DocDocumentGroup getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocDocumentGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormInputText(),
      'createdatetime' => new sfWidgetFormDateTime(),
      'level'          => new sfWidgetFormInputText(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'parent_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ParentCategory'), 'add_empty' => true)),
      'isdeleted'      => new sfWidgetFormInputCheckbox(),
      'sf_users_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'sf_groups_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 100)),
      'description'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'createdatetime' => new sfValidatorDateTime(array('required' => false)),
      'level'          => new sfValidatorInteger(array('required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'parent_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ParentCategory'), 'required' => false)),
      'isdeleted'      => new sfValidatorBoolean(array('required' => false)),
      'sf_users_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'sf_groups_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'DocDocumentGroup', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('doc_document_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocDocumentGroup';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['sf_users_list']))
    {
      $this->setDefault('sf_users_list', $this->object->sfUsers->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['sf_groups_list']))
    {
      $this->setDefault('sf_groups_list', $this->object->sfGroups->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savesfUsersList($con);
    $this->savesfGroupsList($con);

    parent::doSave($con);
  }

  public function savesfUsersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sf_users_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->sfUsers->getPrimaryKeys();
    $values = $this->getValue('sf_users_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('sfUsers', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('sfUsers', array_values($link));
    }
  }

  public function savesfGroupsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sf_groups_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->sfGroups->getPrimaryKeys();
    $values = $this->getValue('sf_groups_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('sfGroups', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('sfGroups', array_values($link));
    }
  }

}
