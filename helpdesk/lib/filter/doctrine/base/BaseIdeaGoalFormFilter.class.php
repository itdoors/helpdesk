<?php

/**
 * IdeaGoal filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIdeaGoalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'idea_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Idea')),
    ));

    $this->setValidators(array(
      'name'      => new sfValidatorPass(array('required' => false)),
      'idea_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Idea', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('idea_goal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addIdeaListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.IdeaIdeaGoal IdeaIdeaGoal')
      ->andWhereIn('IdeaIdeaGoal.idea_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'IdeaGoal';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'name'      => 'Text',
      'idea_list' => 'ManyKey',
    );
  }
}
