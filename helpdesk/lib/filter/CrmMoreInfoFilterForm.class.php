<?php
class CrmMoreInfoFilterForm extends sfFormFilter
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => true)));
    $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true)));
    $this->getWidget('user_id')->setLabel('Managers');

    $this->setWidget('scope_id' , new sfWidgetFormDoctrineChoice(array('model' => 'lookup', 'table_method' => 'getOnlyScope', 'add_empty' => true)));

    $this->setWidget('result_id' , new sfWidgetFormDoctrineChoice(array('model' => 'HandlingResult', 'table_method' => 'getOnlyLost', 'add_empty' => true)));

    $this->widgetSchema->setNameFormat('crm_more_info[%s]');

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }
}