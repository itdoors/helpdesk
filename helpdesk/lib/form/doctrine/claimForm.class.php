<?php

/**
 * claim form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimForm extends BaseclaimForm
{
  public function configure()
  {
      //parent::setup();
      /*unset(
         //$this['createdatetime'], 
         $this['closedatetime'],  
         //$this['isclosedclient'],  
         $this['isclosedstuff']
      ); */
      
      $this->setWidget('status_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'),'table_method'=>'getAllNonSmetaStatuses', 'add_empty' => true)));
      $this->setWidget('smeta_status_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SmetaStatus'),'table_method'=>'getAllSmetaStatuses', 'add_empty' => true)));
      //$this->setWidget('contract_importance_id', new sfWidgetFormDoctrineChoiceMy(array('model' => $this->getRelatedModelName('ContractImportance'),'table_method'=>array('method'=>'getImportanceForDispatcher', 'add_empty' => true, 'parameters'=>array('claim'=>$this->getObject())))));
      $this->setWidget('organization_importance_id', new sfWidgetFormDoctrineChoiceMy(array('model' => $this->getRelatedModelName('ContractImportance'),'table_method'=>array('method'=>'getImportanceForDispatcher', 'add_empty' => true, 'parameters'=>array('claim'=>$this->getObject())))));
       $this->setWidget('akt_date', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%',), array('style'=>'min-width:70px;'))
      )));
      $this->setWidget('bill_date', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%',), array('style'=>'min-width:70px;'))
      )));
      /*$this->mergePostValidator(
        new BillDateValidator()
      );*/
      $this->setValidator('bill_date', new BillDateValidator(array('claim' => $this->getObject())));
      
      $this->getWidget('bill_date')->setDefault(time());
      
      $this->useFields(
      array('claimtype_id', 
      //'description', 
      //'contract_importance_id',
      'organization_importance_id',
      'status_id',
      'smeta_status_id',
      'isclosedclient',
      'bill_number', 
      'bill_description',
      'smeta_number',
      'smeta_costs',
      'akt_date',
      'bill_date',
      'mpk',
      'organization_type_id'
      )); 
  }
  
}

class BillDateValidator extends sfValidatorBase
{
  
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('claim');
  }
 
  protected function doClean($value)
  {
    $i18n = sfContext::getInstance()->getI18N();
    
    if (!$value['year'] || !$value['month'] || !$value['day'])
    {
      throw new sfValidatorError($this, $i18n->__('invalid bill date'));
    }
    
    $claim = $this->getOption('claim');
    $createdate = $claim->getCreatedatetime();
    $createdate = new DateTime($createdate);  
    $bill_date = new DateTime();
    $bill_date->setDate($value['year'], $value['month'], $value['day']);
    
    if ($createdate > $bill_date)
    {
      throw new sfValidatorError($this, $i18n->__('invalid bill date'));
    }
    
    $current_date = new DateTime();
    
    if ($current_date->format('Y') ==  $createdate->format('Y'))
    {
      if ( $current_date->format('m') > $createdate->format('m') )
      {
        if ($current_date->format('d') > sfConfig::get('app_claim_bill_date_day'))
        {
          if ($bill_date->format('Y') >= $current_date->format('Y'))
          {
            if ($bill_date->format('m') < $current_date->format('m'))
            {
              throw new sfValidatorError($this, $i18n->__('bill date cant be in that month')); 
            }
          }
        }
      }
    }
    
    return $bill_date->format('Y-m-d');
  }
}

class claimBillForm extends BaseclaimForm
{   
  public function configure()
  {
     $this->useFields(
      array('bill_number', 
      'bill_description', 
      )); 
  }
}


class claimWithCommentsForm extends BaseclaimForm
{
  public function configure()
  {
      $Comments = new comments();
      $Comments->setClaim($this->getObject());
      $CommentsForm = new commentsForm($Comments);
      unset($CommentsForm['claim_id']);
      $this->embedForm('comments', $CommentsForm);
  }
  
  protected function doSave($con = null)
  {
    
    $status = Doctrine::getTable('status')->getStatusOpen();
    $this->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
    $this->getObject()->setStatusId($status->getId());
    // дублируем mpk отделения
    $department = Doctrine::getTable('departments')->find($this->values['departments_id']);
    if ($department)
    {
      $this->getObject()->setMpk($department->getMpk());
    }
    // полуяаем id клиента и id создателя заявки
    
    $create_user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $this->client_id = isset($this->client_id) ? $this->client_id : $create_user_id;  
    // end - полуяаем id клиента и id создателя заявки
    
    
    parent::doSave($con);
    
    // сохранение в claimusers
    
    $this->claim = $this->getObject();
    
    
    // назначаем Куратора Исполнителя Клиента
    $claimuser = new claimusers();
    $kurator = new stuff();
    $kurator_class = $kurator->getExistKurator($this->claim->getDepartmentsId(), $this->claim->getClaimtypeId());
    $stuff_class = $kurator->getExistStuff($this->claim->getDepartmentsId(), $this->claim->getClaimtypeId());
    $claimuser->saveClientKuratorStuff($this->claim->getId(), $this->client_id/*id клиента*/, $kurator_class, $stuff_class, true, true);
    // end - назначаем Куратора Исполнителя Клиента
    
    // ставим "Прочитано"
    $this->claim->setIsread($create_user_id);
     // сохранение в claimusers - end
     
    // сохранение в историю
    if ($create_user_id)
    log_claim::NewLogRecord($this->claim->getId(), $create_user_id/*id создателя*/, sfConfig::get('logcliam_newclaim'));
    // сохранение в историю end
  }
 
  
} 


class claimKuratorNewForm extends claimWithCommentsForm
{
  public function configure()
  {
      $this->setWidget('organization_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Organization', 'table_method'=>'KuratorOrganizations','add_empty' => true)));  
      $this->setValidator('organization_list' , new sfValidatorDoctrineChoice(array('model' => 'Organization', 'required' => false)));  
      $this->setWidget('departments_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'Departments', 'add_empty' => false, 'table_method' => 'NoInfo')));  
      $this->setValidator('departments_id' , new sfValidatorDoctrineChoice(array('model' => 'Departments', 'required' => true)));  
      $this->setWidget('city_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'City', 'table_method' => 'NoInfo', 'add_empty' => true)));  
      $this->setValidator('city_list' , new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)));  
      
      //$this->widgetSchema['departments_id']->setOption('table_method','NoInfo'); 
      //$this->widgetSchema['contract_importance_id']->setOption('table_method','NoInfo'); 
      $this->setWidget('organization_importance_id', new sfWidgetFormChoice(array('choices' => array())));
      $this->setWidget('client_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Client', 'add_empty' => false, 'table_method'=>'NoInfo', 'multiple' => false)));  
      $this->setValidator('client_list' , new sfValidatorDoctrineChoice(array('multiple' => false, 'model' => 'Client', 'required' => true)));  
     

      $this->useFields(array(
         'claimtype_id',
         'organization_list',
         'city_list',
         'departments_id',
         //'contract_importance_id',
         'organization_importance_id',
         'client_list',
      ));
      parent::configure();
   }
   
     
  protected function doSave($con = null)
  {
    // переопределяем $this->client_id
    $values = $this->values;
    $client_id = $values['client_list'];
    $userclient = Doctrine::getTable('Client')->find($client_id);
    $this->client_id = $userclient->getUserId();
    // end  -  переопределяем $this->client_id
    
    // дабавляем тип организации
    $organization = organizationTable::getInstance()->find($values['organization_list']);
    $organization_type_id = $organization ? $organization->getOrganizationTypeId() : null;
    
    $this->organization_type_id = $organization_type_id;
    
    parent::doSave($con);
    
    $object = $this->getObject();
    $object->setOrganizationTypeId($organization_type_id);
    $object->save();
    
  }
 
}

class claimDispatcherNewForm extends claimWithCommentsForm
{
  public function configure()
  {
      /*$this->setWidget('organization_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Organization', 'add_empty' => true)));  */
      
      sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
      
      $this->setWidget('organization_list', new sfWidgetFormDoctrineJQueryAutocompleter(array(
        'model'=>'organization',
        'url'=>url_for('ajaxdata/auto_organization'),
        'js_callback' => 'auto_organization'
        //'config' => '{ width: 350,max: 100,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 250}'
      )));
      
      $this->setValidator('organization_list' , new sfValidatorDoctrineChoice(array('model' => 'Organization', 'required' => false)));  
      $this->setWidget('departments_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'Departments', 'add_empty' => false, 'table_method' => 'NoInfo')));  
      $this->setValidator('departments_id' , new sfValidatorDoctrineChoice(array('model' => 'Departments', 'required' => true)));  
     

      $this->setWidget('city_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'City', 'table_method' => 'NoInfo', 'add_empty' => true)));  
      $this->setValidator('city_list' , new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)));  
      
      //$this->widgetSchema['departments_id']->setOption('table_method','NoInfo'); 
      //$this->widgetSchema['contract_importance_id']->setOption('table_method','NoInfo'); 
      $this->setWidget('organization_importance_id', new sfWidgetFormChoice(array('choices' => array())));
      
      $this->setWidget('client_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Client', 'add_empty' => false, 'table_method'=>'NoInfo', 'multiple' => false)));  
      $this->setValidator('client_list' , new sfValidatorDoctrineChoice(array('multiple' => false, 'model' => 'Client', 'required' => true)));  
     
      $this->useFields(array(
         'claimtype_id',
         'organization_list',
         'city_list',
         'departments_id',
         //'contract_importance_id',
         'organization_importance_id',
         'client_list',
      ));
      parent::configure();
      
   }
  

  
  protected function doSave($con = null)
  {
    // переопределяем $this->client_id
    $values = $this->values;
    $client_id = $values['client_list'];
    $userclient = Doctrine::getTable('Client')->find($client_id);
    $this->client_id = $userclient->getUserId();
    // end  -  переопределяем $this->client_id
    
    // дабавляем тип организации
    $organization = organizationTable::getInstance()->find($values['organization_list']);
    $organization_type_id = $organization ? $organization->getOrganizationTypeId() : OrganizationType::TYPE__NETWORK_ID;
    
    $this->organization_type_id = $organization_type_id;
    
    parent::doSave($con);
    
    $object = $this->getObject();
    $object->setOrganizationTypeId($organization_type_id);
    $object->save();
    
  }
}


class claimDispatcherGroupNewForm extends claimWithCommentsForm
{
  public function configure()
  {
      //$this->setWidget('organization_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Organization', 'add_empty' => true)));  
      
      sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
      
      $this->setWidget('organization_list', new sfWidgetFormDoctrineJQueryAutocompleter(array(
        'model'=>'organization',
        'url'=>url_for('ajaxdata/auto_organization'),
        'js_callback' => 'auto_organization'
        //'config' => '{ width: 350,max: 100,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 250}'
      )));
      
      $this->setValidator('organization_list' , new sfValidatorDoctrineChoice(array('model' => 'Organization', 'required' => false)));  
      
      //$this->widgetSchema['contract_importance_id']->setOption('table_method','NoInfo'); 
      $this->setWidget('organization_importance_id', new sfWidgetFormChoice(array('choices' => array())));
      $this->setWidget('client_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Client', 'add_empty' => false, 'table_method'=>'NoInfo')));  
      $this->setValidator('client_list' , new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Client', 'required' => true)));  
      $this->setWidget('departments_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'Departments', 'add_empty' => false, 'table_method' => 'NoInfo', 'multiple' => true)));  
      $this->setValidator('departments_id' , new sfValidatorDoctrineChoice(array('model' => 'Departments', 'required' => true, 'multiple' => true)));
      $this->useFields(array(
         'claimtype_id',
         'organization_list',
         'departments_id',
         //'contract_importance_id',
         'organization_importance_id',
         'client_list',
      ));
      
      parent::configure();
     /* unset($this['city_list']);
      $this->setWidget('departments_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'Departments', 'add_empty' => false, 'table_method' => 'NoInfo', 'multiple' => true)));  
      $this->setValidator('departments_id' , new sfValidatorDoctrineChoice(array('model' => 'Departments', 'required' => true, 'multiple' => true)));  */
     
 }
   protected function doSave($con = null)
  {
    $values = $this->values;
    $departments = $values['departments_id'];
    foreach ($departments as $department => $value)
    {
        $taintedValues = $this->taintedValues;
        $taintedValues['departments_id'] = $value;
        //$taintedValues
        $form = new claimDispatcherNewForm();
        $form->disableCSRFProtection();
        unset($taintedValues['_csrf_token'], $form['_csrf_token']);
        $form->bind($taintedValues);
        $form->save();
        
    }   
    
  }
  
  
}



class claimStatusChangeForm extends BaseclaimForm
{
  public function configure()
  {
     $this->setWidget('status_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'),'table_method'=>'getAllNonSmetaStatuses', 'add_empty' => true)));
     $this->useFields(
        array(
            'status_id'
            )
       );
      
      
  }
}


class claimImportanceChangeForm extends BaseclaimForm
{
  public function configure()
  {
      parent::setup();
      unset(
         $this['createdatetime'], 
         $this['closedatetime'],  
         $this['isclosedclient'],  
         $this['isclosedstuff'], 
         $this['claimtype_id'], 
         $this['departments_id'], 
         $this['status_id'], 
         $this['description'], 
         $this['stuffdescription'] 
      );
      
      
  }
}

class claimKuratorChangeForm extends BaseclaimForm
{
  public function configure()
  {
      $this->setWidget('stuff_list' , new  sfWidgetFormDoctrineChoiceMy(array('model' => 'Stuff', 'add_empty' => false, 'multiple' => true, 'table_method'=> array('method' => 'getAllKurators', 'parameters' => array($this->getObject()->getDepartmentsId())))));  
      $this->setValidator('stuff_list' , new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Stuff', 'required' => false)));  
      $this->useFields(
        array(
            'stuff_list'
            )
       );
      
  }
}

class claimStuffChangeForm extends BaseclaimForm
{
  public function configure()
  {
       
      $this->setWidget('stuff_list' , new  sfWidgetFormDoctrineChoiceMy(array('model' => 'Stuff', 'add_empty' => false, 'multiple' => true,  'table_method'=> array('method' => 'getAllStuff', 'parameters' => array($this->getObject()->getDepartmentsId())))));  
      $this->setValidator('stuff_list' , new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Stuff', 'required' => false)));  
      $this->useFields(
        array(
            'stuff_list'
            )
       );
      
  }
}

class claimDescriptionChangeForm extends BaseclaimForm
{
  public function configure()
  {
   $this->useFields(
       array(
            'description'
            )
       );
      
  }
}

class claimOurcostsChangeForm extends BaseclaimForm
{
  public function configure()
  {
       $this->useFields(
       array(
            'ourcosts'
            )
       );
      
  }
}
class claimStuffDescriptionChangeForm extends BaseclaimForm
{
  public function configure()
  {
       $this->useFields(
       array(
            'stuffdescription'
            )
       );
      
  }
}

class claimClaimtypeChangeForm extends BaseclaimForm
{
  public function configure()
  {
       $this->useFields(
       array(
            'claimtype_id'
            )
       );
      
  }
}

class claimclosedRangeForm extends BaseclaimForm
{
  public function configure()
  {
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
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%',), array('style'=>'min-width:70px;'))
      ))
      )
    ));
    
    $this->useFields(array('date_range'));
    
    $this->setDefault('date_range',
      array(
        'from' =>array('year' => date('Y'), 'month' => 1, 'day' =>1),
        'to' =>array('year' => date('Y'), 'month' => date('n'), 'day' => date('j'))
      )
    );
    
    $this->setValidator('date_range',  new sfValidatorDateRange(
      array(
      'from_date' => new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')),
      'to_date' => new  sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d'))
      )
    ));
  }
}

class claimDispatcherNewOnceForm extends claimWithCommentsForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    
    parent::configure();
      
    $this->setWidget('organization_list', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization_once'),
      'js_callback' => 'auto_organization_once',
    ), array(
        'data-url_clients' => url_for('ajaxdata/clients'),
        'data-url_importance' => url_for('ajaxdata/importance'),
        'data-url_department_form' => url_for('ajaxdata/department_form')
      )
    ));
    
    $this->setValidator('organization_list' , new sfValidatorDoctrineChoice(array('model' => 'Organization', 'required' => false)));  
    
    // unset($this['departments_id']);
    $this->setWidget('departments_id' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'departments',
      'url'=>url_for('ajaxdata/auto_departments_once'),
      'js_callback' => 'auto_department_once',
      'js_onSuccess' => 'departments_onSuccess'
    )));  
    
    $this->setValidator('departments_id' , new sfValidatorDoctrineChoice(array('model' => 'Departments', 'required' => true)));  
   

    $this->setWidget('city_list' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'city',
      'url'=>url_for('ajaxdata/auto_city'),
      'js_callback' => 'auto_city_once'
    )));
    
    //$this->setWidget('city_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'City', 'add_empty' => true)));  
    $this->setValidator('city_list' , new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)));  
    
    //$this->widgetSchema['departments_id']->setOption('table_method','NoInfo'); 
    //$this->widgetSchema['contract_importance_id']->setOption('table_method','NoInfo'); 
    $this->setWidget('organization_importance_id', new sfWidgetFormChoice(array('choices' => array())));
    
    $this->setWidget('client_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'Client', 'add_empty' => false, 'table_method'=>'NoInfo', 'multiple' => false)));  
    $this->setValidator('client_list' , new sfValidatorDoctrineChoice(array('multiple' => false, 'model' => 'Client', 'required' => true)));  
   
    $this->useFields(array(
       'claimtype_id',
       'organization_list',
       'city_list',
       'departments_id',
       //'contract_importance_id',
       'organization_importance_id',
       'client_list',
       'comments'
    ));

   }
   
   protected function doSave($con = null)
  {
    // переопределяем $this->client_id
    $values = $this->values;
    $client_id = $values['client_list'];
    $userclient = Doctrine::getTable('Client')->find($client_id);
    $this->client_id = $userclient->getUserId();
    // end  -  переопределяем $this->client_id
    
    // дабавляем тип организации
    $organization = organizationTable::getInstance()->find($values['organization_list']);
    $organization_type_id = $organization ? $organization->getOrganizationTypeId() : null;
    
    $this->organization_type_id = $organization_type_id;
    
    parent::doSave($con);
    
    $object = $this->getObject();
    $object->setOrganizationTypeId($organization_type_id);
    $object->save();
    
    //todo set kurator
    // назначаем Куратора Исполнителя Клиента
    $claimuser = new claimusers();
    $kurator = new stuff();
    $kurator_class = $kurator->getExistKurator($object->getDepartmentsId(), $object->getClaimtypeId());
    $stuff_class = $kurator->getExistStuff($object->getDepartmentsId(), $object->getClaimtypeId());
    $claimuser->saveClientKuratorStuff($object->getId(), $this->client_id/*id клиента*/, $kurator_class, $stuff_class, true, true);
    // end - назначаем Куратора Исполнителя Клиента
  }
}
