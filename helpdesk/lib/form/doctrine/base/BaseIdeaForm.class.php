<?php

/**
 * Idea form base class.
 *
 * @method Idea getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIdeaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'createdatetime'     => new sfWidgetFormDateTime(),
      'description'        => new sfWidgetFormTextarea(),
      'result'             => new sfWidgetFormTextarea(),
      'expert_description' => new sfWidgetFormTextarea(),
      'significance'       => new sfWidgetFormInputText(),
      'financial'          => new sfWidgetFormInputText(),
      'originality'        => new sfWidgetFormInputText(),
      'readiness'          => new sfWidgetFormInputText(),
      'goals_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'IdeaGoal')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 255)),
      'user_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'createdatetime'     => new sfValidatorDateTime(),
      'description'        => new sfValidatorString(array('required' => false)),
      'result'             => new sfValidatorString(array('required' => false)),
      'expert_description' => new sfValidatorString(array('required' => false)),
      'significance'       => new sfValidatorInteger(array('required' => false)),
      'financial'          => new sfValidatorInteger(array('required' => false)),
      'originality'        => new sfValidatorInteger(array('required' => false)),
      'readiness'          => new sfValidatorInteger(array('required' => false)),
      'goals_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'IdeaGoal', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('idea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Idea';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['goals_list']))
    {
      $this->setDefault('goals_list', $this->object->Goals->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveGoalsList($con);

    parent::doSave($con);
  }

  public function saveGoalsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['goals_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Goals->getPrimaryKeys();
    $values = $this->getValue('goals_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Goals', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Goals', array_values($link));
    }
  }

}
