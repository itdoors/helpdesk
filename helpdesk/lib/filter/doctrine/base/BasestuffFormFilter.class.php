<?php

/**
 * stuff filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasestuffFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'companystructure_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Companystructure'), 'add_empty' => true)),
      'mobilephone'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mobilephone_personal' => new sfWidgetFormFilterInput(),
      'phone_inside'         => new sfWidgetFormFilterInput(),
      'birth_place'          => new sfWidgetFormFilterInput(),
      'hire_date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fire_date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'education'            => new sfWidgetFormFilterInput(),
      'issues'               => new sfWidgetFormFilterInput(),
      'description'          => new sfWidgetFormFilterInput(),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'stuffclass'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'dispatcher' => 'dispatcher', 'stuff' => 'stuff', 'kurator' => 'kurator', 'smeta' => 'smeta'))),
      'departments_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'departments')),
      'city_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'city')),
      'claimtype_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'claimtype')),
    ));

    $this->setValidators(array(
      'companystructure_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Companystructure'), 'column' => 'id')),
      'mobilephone'          => new sfValidatorPass(array('required' => false)),
      'mobilephone_personal' => new sfValidatorPass(array('required' => false)),
      'phone_inside'         => new sfValidatorPass(array('required' => false)),
      'birth_place'          => new sfValidatorPass(array('required' => false)),
      'hire_date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'fire_date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'education'            => new sfValidatorPass(array('required' => false)),
      'issues'               => new sfValidatorPass(array('required' => false)),
      'description'          => new sfValidatorPass(array('required' => false)),
      'user_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Users'), 'column' => 'id')),
      'stuffclass'           => new sfValidatorChoice(array('required' => false, 'choices' => array('dispatcher' => 'dispatcher', 'stuff' => 'stuff', 'kurator' => 'kurator', 'smeta' => 'smeta'))),
      'departments_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'departments', 'required' => false)),
      'city_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'city', 'required' => false)),
      'claimtype_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'claimtype', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('stuff_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDepartmentsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.stuff_departments stuff_departments')
      ->andWhereIn('stuff_departments.departments_id', $values)
    ;
  }

  public function addCityListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.sfuff_city sfuff_city')
      ->andWhereIn('sfuff_city.city_id', $values)
    ;
  }

  public function addClaimtypeListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.stuff_departments stuff_departments')
      ->andWhereIn('stuff_departments.claimtype_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'stuff';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'companystructure_id'  => 'ForeignKey',
      'mobilephone'          => 'Text',
      'mobilephone_personal' => 'Text',
      'phone_inside'         => 'Text',
      'birth_place'          => 'Text',
      'hire_date'            => 'Date',
      'fire_date'            => 'Date',
      'education'            => 'Text',
      'issues'               => 'Text',
      'description'          => 'Text',
      'user_id'              => 'ForeignKey',
      'stuffclass'           => 'Enum',
      'departments_list'     => 'ManyKey',
      'city_list'            => 'ManyKey',
      'claimtype_list'       => 'ManyKey',
    );
  }
}
