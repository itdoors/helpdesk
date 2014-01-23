<?php

/**
 * DogovorDepartment filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDogovorDepartmentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dogovor_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'), 'add_empty' => true)),
      'dop_dogovor_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DopDogovor'), 'add_empty' => true)),
      'department_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'is_active'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'comment'        => new sfWidgetFormFilterInput(),
      'createdatetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'dogovor_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dogovor'), 'column' => 'id')),
      'dop_dogovor_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DopDogovor'), 'column' => 'id')),
      'department_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'is_active'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'comment'        => new sfValidatorPass(array('required' => false)),
      'createdatetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('dogovor_department_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DogovorDepartment';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'dogovor_id'     => 'ForeignKey',
      'dop_dogovor_id' => 'ForeignKey',
      'department_id'  => 'ForeignKey',
      'user_id'        => 'ForeignKey',
      'is_active'      => 'Boolean',
      'comment'        => 'Text',
      'createdatetime' => 'Date',
    );
  }
}
