<?php

/**
 * Idea filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIdeaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'createdatetime'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'description'        => new sfWidgetFormFilterInput(),
      'result'             => new sfWidgetFormFilterInput(),
      'expert_description' => new sfWidgetFormFilterInput(),
      'significance'       => new sfWidgetFormFilterInput(),
      'financial'          => new sfWidgetFormFilterInput(),
      'originality'        => new sfWidgetFormFilterInput(),
      'readiness'          => new sfWidgetFormFilterInput(),
      'goals_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'IdeaGoal')),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'user_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'createdatetime'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'description'        => new sfValidatorPass(array('required' => false)),
      'result'             => new sfValidatorPass(array('required' => false)),
      'expert_description' => new sfValidatorPass(array('required' => false)),
      'significance'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'financial'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'originality'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'readiness'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'goals_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'IdeaGoal', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('idea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGoalsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('IdeaIdeaGoal.goal_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Idea';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'user_id'            => 'ForeignKey',
      'createdatetime'     => 'Date',
      'description'        => 'Text',
      'result'             => 'Text',
      'expert_description' => 'Text',
      'significance'       => 'Number',
      'financial'          => 'Number',
      'originality'        => 'Number',
      'readiness'          => 'Number',
      'goals_list'         => 'ManyKey',
    );
  }
}
