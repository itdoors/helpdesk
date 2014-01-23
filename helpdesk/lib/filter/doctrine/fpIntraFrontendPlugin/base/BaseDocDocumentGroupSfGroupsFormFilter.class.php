<?php

/**
 * DocDocumentGroupSfGroups filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDocDocumentGroupSfGroupsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('doc_document_group_sf_groups_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocDocumentGroupSfGroups';
  }

  public function getFields()
  {
    return array(
      'sfguardgroup_id'     => 'Number',
      'docdocumentgroup_id' => 'Number',
      'actionkey'           => 'Enum',
    );
  }
}
