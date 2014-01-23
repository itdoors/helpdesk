<?php
class IntranetIdeasFilterForm extends sfFormFilter
{
  public function configure()
  {
    $this->setWidget('date_range' , new  sfWidgetFormDateRange(
      array(
        'from_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%','can_be_empty'=>true), array('style'=>'min-width:70px;'))
        )),
        'to_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%', 'can_be_empty'=>true), array('style'=>'min-width:70px;'))
        ))
      )
    ));

    $this->setValidator('date_range',  new sfValidatorDateRange(
      array(
        'from_date' => new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d', 'required' => false)),
        'to_date' => new  sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d', 'required' => false))
      )
    ));

    $this->disableCSRFProtection();

    $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => true)));
    $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true)));

    $this->widgetSchema->setNameFormat('ideas_filter[%s]');
  }
}