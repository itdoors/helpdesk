<?php

/**
 * Groupclaim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Groupclaim extends BaseGroupclaim
{
   public function save(Doctrine_Connection $conn = null)
   {
       parent::save();
       //LogIntranet::SaveLog($this);
   }
   
   public function delete(Doctrine_Connection $conn = null)
   {
       $this->deleteAllDepartments();
       $this->deleteAllPeriods();
       $this->setIsDeleted(true);
       $this->save();
   }
   
   protected function deleteAllDepartments()
   {
       $qs = Doctrine::getTable('GroupclaimDepartments')
       ->createQuery('gd')
       ->where('gd.groupclaim_id ='.$this->getId())
       ->execute();
       foreach ($qs as $q)
       {
          $q->delete(); 
       }
   }
   
   protected function deleteAllPeriods()
   {
       $qs = Doctrine::getTable('Groupclaimperiod')
       ->createQuery('gp')
       ->where('gp.groupclaim_id ='.$this->getId())
       ->execute();
       foreach ($qs as $q)
       {
          $q->delete(); 
       }
   }
   
    public static function StartGroupclaim()
    {
        //DONE 7: все заявки групповые, которые не is_deleted
        $groupclaims = Doctrine::getTable('Groupclaim')
        ->createQuery('gc')
        ->where('gc.is_deleted is false')
        ->execute();
       //начало транцакции!!!!!!!!!!
     $groupclaimTable = doctrine::getTable('Groupclaim');
     $con = $groupclaimTable->getConnection();
     try
     {
       $con->beginTransaction();
             
           foreach($groupclaims as $groupclaim)
           {
               $groupclaim->CreateClaims($groupclaim);
               
           };  
       
      $con->commit();
     }
     catch (Exception $e)
     {
        $con->rollBack();
        throw $e;
     }
        
    //конец транцакции!!!!!!!!!!!!!!  
     return 'Связка установлена'; 
    }
    
    protected function CreateClaims($groupclaim = array())
    {
        if (!$groupclaim->PeriodIsOk()) return false;
        $departments = $groupclaim->getGroupclaimDepartments();  
        if (!count($departments))  return false; 
        $claim_holder = array();
        $claim_holder['claimtype_id'] = $groupclaim->getClaimtypeId();
        $claim_holder['contract_importance_id'] = $groupclaim->getContractImportanceId();
        $claim_holder['client_list'] = $groupclaim->getClientId();
        $claim_holder['message'] = $groupclaim->getMessage();
        
        $nds = Doctrine::getTable('lookup')->getNds();
        $obnal = Doctrine::getTable('lookup')->getObnal();
        
        foreach($departments as $department)
        {
           $claim_holder['departments_id'] = $department->getDepartmentsId();
           $real_department = Doctrine::getTable('departments')->find($claim_holder['departments_id']);
           $new_claim_id = claim::saveDispatcher($claim_holder, false, -1);       
           //TODO 7: А здесь будет функция сохранения работы и СТОИМОСТИ!!!!!!!!!!!!!!! 
           finance_claim::newByGroupClaim($new_claim_id, $groupclaim->getGroupclaimwork()->getName(), $real_department, $groupclaim->getFormula(), $nds, $obnal);
           //А здесь будет функция сохранения работы и СТОИМОСТИ!!!!!!!!!!!!!!!
           
           GroupclaimClaim::saveAssociation($groupclaim->getId(), $new_claim_id); 
        }
        

        
    }
    
    protected function PeriodIsOk()
    {
       
        $periods = $this->getGroupclaimperiod();
        if (!count($periods)) return false;
        $bool = false;//если установленно несколько периодов, и хоть один удовлетворяет условию
        //создания заявки $bool = true;
        foreach ($periods as $period)
        {
           $current_day = $period->getPeriodDay() != '00' ? $period->getPeriodDay() : date("d");
           $current_month = $period->getPeriodMonth() != '00' ? $period->getPeriodMonth() : date("m");
           $current_year = $period->getPeriodYear() != '00' ? $period->getPeriodYear() : date("Y");
           $current_period = $current_year.'-'.$current_month.'-'.$current_day;
           $today = date("Y-m-d");
           //Написать функцию  $this->NotInLastStart(): возвращает true если можно создавать заявку
           if ($current_period == $today&& $this->NotInLastStart($current_period)) return $bool = true;
           
        }
        return  $bool;
                        
    }
    
    protected function NotInLastStart($current_period)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Date');
        $groupclaim_claims = $this->getGroupclaimClaim();
        if (!count($groupclaim_claims)) return true;
        $groupclaim_claim = $groupclaim_claims[0];
        $last_start = format_date($groupclaim_claim->getCreatedatetime(), 'i');
        if ($current_period == $last_start) return false; else return true;
    }
    
    
    public function getPeriod()
    {
        return $this->getGroupclaimperiod()->getFirst();
    }
    
/*    public function getDepartmentsList()
    {
        $departments = $this->getGroupclaimDepartments();
        foreach ($departments as $departments)
    }*/
    
}
