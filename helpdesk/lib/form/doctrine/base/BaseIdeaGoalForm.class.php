<?php

/**
 * IdeaGoal form base class.
 *
 * @method IdeaGoal getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIdeaGoalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInputText(),
      'idea_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Idea')),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 255)),
      'idea_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Idea', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('idea_goal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IdeaGoal';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['idea_list']))
    {
      $this->setDefault('idea_list', $this->object->Idea->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveIdeaList($con);

    parent::doSave($con);
  }

  public function saveIdeaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['idea_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Idea->getPrimaryKeys();
    $values = $this->getValue('idea_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Idea', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Idea', array_values($link));
    }
  }

}
