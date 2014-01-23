<?php

/**
 * Dogovor form base class.
 *
 * @method Dogovor getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDogovorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'prolongation'        => new sfWidgetFormInputCheckbox(),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => false)),
      'name'                => new sfWidgetFormInputText(),
      'number'              => new sfWidgetFormInputText(),
      'startdatetime'       => new sfWidgetFormDateTime(),
      'stopdatetime'        => new sfWidgetFormDateTime(),
      'companystructure_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Companystructure'), 'add_empty' => true)),
      'city_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'subject'             => new sfWidgetFormInputText(),
      'filepath'            => new sfWidgetFormInputText(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'dogovor_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DogovorType'), 'add_empty' => true)),
      'company_role_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyRole'), 'add_empty' => true)),
      'mashtab'             => new sfWidgetFormChoice(array('choices' => array('m_global' => 'm_global', 'm_local' => 'm_local'))),
      'stuff_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true)),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'total'               => new sfWidgetFormInputText(),
      'maturity'            => new sfWidgetFormInputText(),
      'completion_notice'   => new sfWidgetFormInputCheckbox(),
      'payment_deferment'   => new sfWidgetFormInputText(),
      'prolongation_term'   => new sfWidgetFormInputText(),
      'launch_date'         => new sfWidgetFormDate(),
      'summ_month_vat'      => new sfWidgetFormInputText(),
      'planned_pf1'         => new sfWidgetFormInputText(),
      'planned_pf1_percent' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'prolongation'        => new sfValidatorBoolean(array('required' => false)),
      'organization_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'))),
      'name'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'startdatetime'       => new sfValidatorDateTime(),
      'stopdatetime'        => new sfValidatorDateTime(array('required' => false)),
      'companystructure_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Companystructure'), 'required' => false)),
      'city_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)),
      'subject'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'filepath'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'           => new sfValidatorBoolean(array('required' => false)),
      'dogovor_type_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DogovorType'), 'required' => false)),
      'company_role_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyRole'), 'required' => false)),
      'mashtab'             => new sfValidatorChoice(array('choices' => array(0 => 'm_global', 1 => 'm_local'), 'required' => false)),
      'stuff_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'required' => false)),
      'user_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'total'               => new sfValidatorNumber(array('required' => false)),
      'maturity'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'completion_notice'   => new sfValidatorBoolean(array('required' => false)),
      'payment_deferment'   => new sfValidatorInteger(array('required' => false)),
      'prolongation_term'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'launch_date'         => new sfValidatorDate(array('required' => false)),
      'summ_month_vat'      => new sfValidatorNumber(array('required' => false)),
      'planned_pf1'         => new sfValidatorNumber(array('required' => false)),
      'planned_pf1_percent' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dogovor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dogovor';
  }

}
