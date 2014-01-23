<?php


class reportsForm extends BaseForm
{
  public function configure()
  {
      $choices_claimtype = array(
      'all'=> $this->getWidgetSchema()->getFormFormatter()->translate('All'),
      'open'=>$this->getWidgetSchema()->getFormFormatter()->translate('Open claims'),
      'close'=>$this->getWidgetSchema()->getFormFormatter()->translate('Close claims'),
      );
      $choices_claimfinance = array(
      'all'=>$this->getWidgetSchema()->getFormFormatter()->translate('All'),
      'close'=>$this->getWidgetSchema()->getFormFormatter()->translate('Finance close'),
      'open'=>$this->getWidgetSchema()->getFormFormatter()->translate('Finance open'),
      ); 
      $choices_datetype = array(
      'open'=>$this->getWidgetSchema()->getFormFormatter()->translate('by createdatetime'),
      'close'=>$this->getWidgetSchema()->getFormFormatter()->translate('by closedatetime'),
      'bill_date'=>$this->getWidgetSchema()->getFormFormatter()->translate('by bill date'),
      ); 
      $this->setWidget('claimtype' , new  sfWidgetFormChoice(array('choices'=>$choices_claimtype)));
      $this->setWidget('claimfinance' , new  sfWidgetFormChoice(array('choices'=>$choices_claimfinance)));
      $this->setWidget('claim_datetype' , new  sfWidgetFormChoice(array('choices'=>$choices_datetype)));
      $this->setWidget('date_range' , new  sfWidgetFormDateRange(
      array(
      'from_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%',), array('style'=>'min-width:70px;'))
      )),
      'to_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%', 'can_be_empty'=>false), array('style'=>'min-width:70px;'))
      ))
      )
      ));
      $this->setDefault('date_range',
      array(
        'from' =>array('year' => date('Y'), 'month' => 1, 'day' =>1),
        'to' =>array('year' => date('Y'), 'month' => date('n'), 'day' => date('j'))
      )
      );
      $this->setValidator('claimtype', new sfValidatorString());
      $this->setValidator('claimfinance', new sfValidatorString());
      $this->setValidator('claim_datetype', new sfValidatorString());
      $this->setValidator('date_range',  new sfValidatorDateRange(
      array(
      'from_date' => new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')),
      'to_date' => new  sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d'))
      )
      )); 
       $this->getWidget('claimtype')->setLabel($this->getWidgetSchema()->getFormFormatter()->translate('Condition'));
       $this->widgetSchema->setNameFormat('reports[%s]');
       $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}

class reportsClientForm extends reportsForm
{
  public function configure()
  {
     parent::configure();
     unset($this['claimfinance']); 
  }
}

class reportsDispatcherForm extends reportsForm
{
  public function configure()
  {
    parent::configure(); 
    //$this->setWidget('organization' , new  sfWidgetFormDoctrineChoice(array('model'=>'organization', 'add_empty'=>true))); 
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
     
    $this->setWidget('organization', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization')
     )));
     
     $this->setValidator('organization' , new  sfValidatorDoctrineChoice(array('model'=>'organization' ,'required'=>false))); 
     $this->useFields(
     array(
        'organization',
        'claimtype',
        'claimfinance',
        'claim_datetype',
        'date_range',
     ));
  }
}

class reportsFinanceForm  extends reportsDispatcherForm
{

}
class reportsSupervisorForm  extends reportsDispatcherForm
{

}
class reportsKuratorForm  extends reportsDispatcherForm
{

}