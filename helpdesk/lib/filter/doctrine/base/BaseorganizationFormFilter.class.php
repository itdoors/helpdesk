<?php

/**
 * organization filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseorganizationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mpk'                  => new sfWidgetFormFilterInput(),
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contacts'             => new sfWidgetFormFilterInput(),
      'shortname'            => new sfWidgetFormFilterInput(),
      'is_smeta'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mailing_address'      => new sfWidgetFormFilterInput(),
      'organization_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationType'), 'add_empty' => true)),
      'rs'                   => new sfWidgetFormFilterInput(),
      'edrpou'               => new sfWidgetFormFilterInput(),
      'inn'                  => new sfWidgetFormFilterInput(),
      'certificate'          => new sfWidgetFormFilterInput(),
      'short_description'    => new sfWidgetFormFilterInput(),
      'site'                 => new sfWidgetFormFilterInput(),
      'scope_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Scope'), 'add_empty' => true)),
      'client_type_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ClientType'), 'add_empty' => true)),
      'city_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'organization_sign_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationSign'), 'add_empty' => true)),
      'client_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'client')),
    ));

    $this->setValidators(array(
      'mpk'                  => new sfValidatorPass(array('required' => false)),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'address'              => new sfValidatorPass(array('required' => false)),
      'contacts'             => new sfValidatorPass(array('required' => false)),
      'shortname'            => new sfValidatorPass(array('required' => false)),
      'is_smeta'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mailing_address'      => new sfValidatorPass(array('required' => false)),
      'organization_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrganizationType'), 'column' => 'id')),
      'rs'                   => new sfValidatorPass(array('required' => false)),
      'edrpou'               => new sfValidatorPass(array('required' => false)),
      'inn'                  => new sfValidatorPass(array('required' => false)),
      'certificate'          => new sfValidatorPass(array('required' => false)),
      'short_description'    => new sfValidatorPass(array('required' => false)),
      'site'                 => new sfValidatorPass(array('required' => false)),
      'scope_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Scope'), 'column' => 'id')),
      'client_type_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ClientType'), 'column' => 'id')),
      'city_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'organization_sign_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrganizationSign'), 'column' => 'id')),
      'client_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'client', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('organization_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addClientListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ClientOrganization ClientOrganization')
      ->andWhereIn('ClientOrganization.client_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'organization';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'mpk'                  => 'Text',
      'name'                 => 'Text',
      'address'              => 'Text',
      'contacts'             => 'Text',
      'shortname'            => 'Text',
      'is_smeta'             => 'Boolean',
      'mailing_address'      => 'Text',
      'organization_type_id' => 'ForeignKey',
      'rs'                   => 'Text',
      'edrpou'               => 'Text',
      'inn'                  => 'Text',
      'certificate'          => 'Text',
      'short_description'    => 'Text',
      'site'                 => 'Text',
      'scope_id'             => 'ForeignKey',
      'client_type_id'       => 'ForeignKey',
      'city_id'              => 'ForeignKey',
      'organization_sign_id' => 'ForeignKey',
      'client_list'          => 'ManyKey',
    );
  }
}
