<?php

/**
 * Dogovor filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDogovorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'prolongation'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'name'                => new sfWidgetFormFilterInput(),
      'number'              => new sfWidgetFormFilterInput(),
      'startdatetime'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'stopdatetime'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'companystructure_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Companystructure'), 'add_empty' => true)),
      'city_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'subject'             => new sfWidgetFormFilterInput(),
      'filepath'            => new sfWidgetFormFilterInput(),
      'is_active'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'dogovor_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DogovorType'), 'add_empty' => true)),
      'company_role_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyRole'), 'add_empty' => true)),
      'mashtab'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'm_global' => 'm_global', 'm_local' => 'm_local'))),
      'stuff_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true)),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'total'               => new sfWidgetFormFilterInput(),
      'maturity'            => new sfWidgetFormFilterInput(),
      'completion_notice'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'payment_deferment'   => new sfWidgetFormFilterInput(),
      'prolongation_term'   => new sfWidgetFormFilterInput(),
      'launch_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'summ_month_vat'      => new sfWidgetFormFilterInput(),
      'planned_pf1'         => new sfWidgetFormFilterInput(),
      'planned_pf1_percent' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'prolongation'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'organization_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'name'                => new sfValidatorPass(array('required' => false)),
      'number'              => new sfValidatorPass(array('required' => false)),
      'startdatetime'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'stopdatetime'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'companystructure_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Companystructure'), 'column' => 'id')),
      'city_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'subject'             => new sfValidatorPass(array('required' => false)),
      'filepath'            => new sfValidatorPass(array('required' => false)),
      'is_active'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'dogovor_type_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DogovorType'), 'column' => 'id')),
      'company_role_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CompanyRole'), 'column' => 'id')),
      'mashtab'             => new sfValidatorChoice(array('required' => false, 'choices' => array('m_global' => 'm_global', 'm_local' => 'm_local'))),
      'stuff_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Stuff'), 'column' => 'id')),
      'user_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'total'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'maturity'            => new sfValidatorPass(array('required' => false)),
      'completion_notice'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'payment_deferment'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'prolongation_term'   => new sfValidatorPass(array('required' => false)),
      'launch_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'summ_month_vat'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'planned_pf1'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'planned_pf1_percent' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('dogovor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dogovor';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'prolongation'        => 'Boolean',
      'organization_id'     => 'ForeignKey',
      'name'                => 'Text',
      'number'              => 'Text',
      'startdatetime'       => 'Date',
      'stopdatetime'        => 'Date',
      'companystructure_id' => 'ForeignKey',
      'city_id'             => 'ForeignKey',
      'subject'             => 'Text',
      'filepath'            => 'Text',
      'is_active'           => 'Boolean',
      'dogovor_type_id'     => 'ForeignKey',
      'company_role_id'     => 'ForeignKey',
      'mashtab'             => 'Enum',
      'stuff_id'            => 'ForeignKey',
      'user_id'             => 'ForeignKey',
      'total'               => 'Number',
      'maturity'            => 'Text',
      'completion_notice'   => 'Boolean',
      'payment_deferment'   => 'Number',
      'prolongation_term'   => 'Text',
      'launch_date'         => 'Date',
      'summ_month_vat'      => 'Number',
      'planned_pf1'         => 'Number',
      'planned_pf1_percent' => 'Number',
    );
  }
}
