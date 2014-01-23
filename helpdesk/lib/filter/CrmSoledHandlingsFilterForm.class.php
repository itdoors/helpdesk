<?php
class CrmSoledHandlingsFilterForm extends sfFormFilter
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => true)));
    $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true)));
    $this->getWidget('user_id')->setLabel('Managers');

    $this->setWidget('subject', new sfWidgetFormInputText());

    $this->setWidget('mashtab', new sfWidgetFormChoice(array('choices' => array('' => '', 'm_local' => 'Локальный', 'm_global' => 'Сетевой'))));

    $this->widgetSchema->setNameFormat('soled_handlings_info[%s]');

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }
}