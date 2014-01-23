<?php
class userIntranetFilterForm extends sfFormFilter
{
  public function configure()
  {
    $this->setWidget('first_name', new sfWidgetFormInputText());
    $this->setWidget('last_name', new sfWidgetFormInputText());
    $this->setWidget('position', new sfWidgetFormInputText());
    
    $this->setWidget('position' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'sfGuardUser',
      'method' => 'getPosition',
      'url'=>url_for('ajaxdata/auto_position'),
    )));
    
    /*$this->setWidget('companystructure_id', new sfWidgetFormDoctrineChoice(
      array(
        'add_empty' => true,
        'model' => 'companystructure',
        'order_by' => array('name', 'ASC')
      )
    ));*/

    $choices = Doctrine::getTable('companystructure')->getTreeChoices();

    $this->setWidget('companystructure_id', new sfWidgetFormChoice(array('choices' => $choices)));
    
    $this->setWidget('is_fired', new sfWidgetFormInputCheckbox());
    
    $this->setWidget('city' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'city',
      'url'=>url_for('ajaxdata/auto_city'),
    )));
    
    $this->widgetSchema->setNameFormat('user_intranet_filter[%s]');
    
    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);
    
    $this->disableCSRFProtection();
  }
}
