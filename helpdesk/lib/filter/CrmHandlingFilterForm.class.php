<?php
class CrmHandlingFilterForm extends sfFormFilter
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $this->setWidget('organization_id' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization'),
    )));

    $this->setWidget('city_id' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'city',
      'url'=>url_for('ajaxdata/auto_city'),
    )));

    $this->setWidget('status_id' , new sfWidgetFormDoctrineChoice(array('model' => 'HandlingStatus', 'add_empty' => true)));
    $this->setWidget('type_id' , new sfWidgetFormDoctrineChoice(
      array('model' => 'HandlingType', 'add_empty' => '', 'multiple' => true),
      array('style' => 'height:130px;')
    ));

    $this->setWidget('chance', new sfWidgetFormInputText());

    $this->setWidget('scope_id' , new sfWidgetFormDoctrineChoice(array('model' => 'lookup', 'table_method' => 'getOnlyScope', 'add_empty' => true)));

    $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => true)));
    $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true)));

    $this->setWidget('result_id' , new sfWidgetFormDoctrineChoice(array('model' => 'HandlingResult', 'add_empty' => true)));

    $this->widgetSchema->setNameFormat('crm_organization[%s]');

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }
}