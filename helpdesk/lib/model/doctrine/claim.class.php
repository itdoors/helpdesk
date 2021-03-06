<?php

/**
 * claim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class claim extends Baseclaim
{
/*    public function getStatus()
    {
        $lookup = Doctrine::getTable('lookup')->find($this->status_id);
        return $lookup->name;
    }  */
    
/*    public function getClient()
    {
        $claimuser = new claimusers();
        $user_id = $claimuser->getClaimClientId($this->getId());
        //die ($user_id);
        $user = Doctrine::getTable('sfGuardUser')->find($user_id);
        if ($user<>null) return $user;
        else return '';
    }     */
    
   public function objectFieldSaveToLogClaim($field = null, $toString  = null)
   {
       if (!$field||!$toString) return null;
       $logclaim_status = '';
       switch ($field)
       {
           case 'smeta_status_id':
             claimusers::setSmeta($this->getId());
             MailFunctions::sendSDEmail($this->getId(), null, sfConfig::get('claimuserkey_smeta'),SDtexts::getSmeta_Status_Update_Subject($this), SDtexts::getSmeta_Status_Update_Text($this));
           break;
           case 'status_id':
             $logclaim_status = sfConfig::get('logclaimtype_status');
           break;
       }  
       log_claim::NewLogRecord($this->getId(), null, sfConfig::get('logcliam_'.$field)." ".$this->$toString(), $logclaim_status);
   } 
   

    
    public function getClient()
    {
        $tostr = '';
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            //echo $claimuser->getUserkey();
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_client'))
            {
              $user = $claimuser->getUsers();
              $tostr .= $user.', ';
            }  
            
        }
        return $tostr; 
    }
    
    public function getClientObject()
    {
        $tostr = '';
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            //echo $claimuser->getUserkey();
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_client'))
            {
              return $claimuser->getUsers()->getClient()->getFirst();
            }  
            
        }
        return $tostr; 
    }

     public function sendClientEmail()
    {
        $tostr = '';
        
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_client'))
            {
              $user_email = $claimuser->getUsers()->getEmailAddress();
              //die($user_email);
              $message = sfContext::getInstance()->getMailer()->compose(
array('noreply@griffin.ua' => 'Service Desk Griffin'),
$user_email,
'Заявка №'.$this->getId().' новое сообщение',
'Новое сообщение по заявке №'.$this->getId().'
Подробную информацию можно получить по адресу: http://helpdesk.griffin.ua/
Не отвечайте на это письмо.
');
sfContext::getInstance()->getMailer()->send($message);
              
            }  
            
        }
        return true;  
    }
    
    public function getKurator()
    {
        $tostr = '';
        
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_kurator'))
            {
              $user = $claimuser->getUsers();
              $tostr .= $user.', ';
            }  
            
        }
        return $tostr;  
    }
    
     public function sendKuratorEmail()
    {
        $tostr = '';
        
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_kurator'))
            {
              $user_email = $claimuser->getUsers()->getEmailAddress();
              //die($user_email);
              $message = sfContext::getInstance()->getMailer()->compose(
array('noreply@griffin.ua' => 'Service Desk Griffin'),
$user_email,
'Заявка №'.$this->getId().' новое сообщение',
'Новое сообщение по заявке №'.$this->getId().'
Подробную информацию можно получить по адресу: http://helpdesk.griffin.ua/kurator.php/
Не отвечайте на это письмо.
');
sfContext::getInstance()->getMailer()->send($message);
              
            }  
            
        }
        return true;  
    }
    
    
    
    
    public function getStuff()
    {
        $tostr = '';
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_stuff'))
            {
              $user = $claimuser->getUsers();
              $tostr .= $user.', ';
            }  
            
        }
        return $tostr;  
    }  
    
     public function sendStuffEmail()
    {
        $tostr = '';
        
        $claimusers = $this->getClaimUsers();
        foreach ($claimusers as $claimuser)
        {
            if ($claimuser->getUserkey() == sfConfig::get('claimuserkey_stuff'))
            {
              $user_email = $claimuser->getUsers()->getEmailAddress();
              //die($user_email);
              $message = sfContext::getInstance()->getMailer()->compose(
array('noreply@griffin.ua' => 'Service Desk Griffin'),
$user_email,
'Заявка №'.$this->getId().' новое сообщение',
'Новое сообщение по заявке №'.$this->getId().'
Подробную информацию можно получить по адресу: http://helpdesk.griffin.ua/stuff.php/
Не отвечайте на это письмо.
');
sfContext::getInstance()->getMailer()->send($message);
              
            }  
            
        }
        return true;  
    }
        
    
/*    public function getContractImportance()
    {
        /*$ctr_imp = Doctrine::getTable('contract_importance')->find($this->contract_importance_id);
        if ($ctr_imp<>null) return $ctr_imp->getImportance();
        else return '';
        //return $this->getcontract_importance();
    }*/ 
    
    public function getImportance()
    {
       //return $this->getContractImportance()->getImportance()->getName();
       return $this->getOrganizationImportance()->getImportance()->getName();
    }
    
    public function getImportanceColor()
    {
       //return $this->getContractImportance()->getImportance()->getColor();
       return $this->getOrganizationImportance()->getImportance()->getColor();
    }
      
    
    public function getContractImportanceColor()
    {
        $ctr_imp = Doctrine::getTable('contract_importance')->find($this->contract_importance_id);
        if ($ctr_imp<>null) return $ctr_imp->getImportance()->getColor();
        else return '';
    }
    
    public function __toString()
    {
        return $this->getId().'-'.$this->getClaimtype();
    }
    
    public function getCreatedatetimeGood()
    {
        return format_date($this->getCreatedatetime(), 'dd.MM.yyyy, HH:mm', 'ru');
    }
    
    public function getClosedatetimeGood()
    {
        return format_date($this->getClosedatetime(), 'dd.MM.yyyy, HH:mm', 'ru');
    }
    
    public function closeClaimClient()
    {
      $this->closeClaim();
    }
    public function closeClaim()
    {
      if (!$this->isclosedclient)
      {
        $this->isclosedclient = true;
        $this->closedatetime = date("Y-m-d H:i:s");
        $this->trySave();  
      }
    }
    public function openClaim()
    {
      //$this->isclosedstuff = true;
      $this->isclosedclient = false;
      $this->closedatetime = NULL;
      //$this->closedatetime = date("2011-03-11 H:i:s");
      $this->trySave();  
    }
    
    
    public function saveManager($claim)
    {
        $status = Doctrine::getTable('status')->getStatusOpen();
        $sf_user = sfContext::getInstance()->getUser();
        $new_claim = new claim();
        $new_claim->departments_id = $claim['departments_id'];
        $new_claim->createdatetime = date("Y-m-d H:i:s");
        $new_claim->status_id = $status->getId();
        $new_claim->claimtype_id = $claim['claimtype_id'];
        $new_claim->contract_importance_id = $claim['contract_importance_id'];
        $client_id = $sf_user->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $new_claim->trySave();  
        
        //$nonamestuff = Doctrine::getTable('sfGuardUser')->findOneBy('username',sfConfig::get('nostuff'));
        //$nonamekurator = Doctrine::getTable('sfGuardUser')->findOneBy('username',sfConfig::get('nokurator'));
        
        $claimuser = new claimusers();
        $kurator = new stuff();
        $kurator_class = $kurator->getExistKurator($claim['departments_id'], $claim['claimtype_id']);
        $stuff_class = $kurator->getExistStuff($claim['departments_id'], $claim['claimtype_id']);
        //if (!$kurator_class) die("xxx");
        //if (!$kurator_class) $kurator_class = Doctrine::getTable('sfGuardUser')->findBy('username',sfConfig::get('nokurator')); 
        //if (!$stuff_class) die("xxx");
        //if (!$stuff_class) $stuff_class = Doctrine::getTable('sfGuardUser')->findBy('username',sfConfig::get('nostuff')); 
                
        
        $claimuser->saveClientKuratorStuff($new_claim->getId(), $client_id, $kurator_class, $stuff_class, true, true);
        $new_claim->setIsread();
        //$new 
        
        //$this->stuff_id = $noname;
        return $new_claim->getId();
        
        
    }
    
    //public functino
    
    public static function saveDispatcher($claim, $group = false, $user_id = null)
    {
        $claimTable = doctrine::getTable('claim');
        $con = $claimTable->getConnection();
        try
        {
          $con->beginTransaction();
       
        $status = Doctrine::getTable('status')->getStatusOpen();
       
        $user_id = $user_id ? $user_id : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        //$user_id = -1;
        if ($group) {
            foreach ($claim['departments_id'] as $key) {
                    $new_claim = new claim();
                    $new_claim->departments_id = $key;
                    $new_claim->createdatetime = date("Y-m-d H:i:s");
                    $new_claim->status_id = $status->getId();
                    $new_claim->claimtype_id = $claim['claimtype_id'];
                    $new_claim->contract_importance_id = $claim['contract_importance_id'];
                    $new_claim->trySave();                                                                    
                    $claimuser = new claimusers();
                    $client_id = $claim['client_list'];
                    $userclient = Doctrine::getTable('Client')->find($client_id);
                    $kurator = new stuff();
                    $kurator_class = $kurator->getExistKurator($key, $claim['claimtype_id']);
                    $stuff_class = $kurator->getExistStuff($key, $claim['claimtype_id']);
                    $claimuser->saveClientKuratorStuff($new_claim->getId(), $userclient->getUserId(), $kurator_class, $stuff_class, true, true);
                    $new_claim_id = $new_claim->getId();
                    $new_claim->setIsread($user_id);
                    $new_comment = new comments();
                    $new_comment->saveManager($claim, $new_claim_id);
                    $new_log_claim = new log_claim();
                    $new_log_claim->NewLogRecord($new_claim_id, $user_id, sfConfig::get('logcliam_newclaim'));  
            }
            
        }
        else {
                    $new_claim = new claim();
                    $new_claim->departments_id = $claim['departments_id'];
                    $new_claim->createdatetime = date("Y-m-d H:i:s");
                    $new_claim->status_id = $status->getId();
                    $new_claim->claimtype_id = $claim['claimtype_id'];
                    $new_claim->contract_importance_id = $claim['contract_importance_id'];
                    $new_claim->trySave();                                                                    
                    $claimuser = new claimusers();
                    $client_id = $claim['client_list'];
                    $userclient = Doctrine::getTable('Client')->find($client_id);
                    $kurator = new stuff();
                    $kurator_class = $kurator->getExistKurator($claim['departments_id'], $claim['claimtype_id']);
                    $stuff_class = $kurator->getExistStuff($claim['departments_id'], $claim['claimtype_id']);
                    $claimuser->saveClientKuratorStuff($new_claim->getId(), $userclient->getUserId(), $kurator_class, $stuff_class, true, true);
                    $new_claim_id = $new_claim->getId();
                    $new_claim->setIsread($user_id);
                    $new_comment = new comments();
                    $new_comment->saveManager($claim, $new_claim_id, $user_id);
                    $new_log_claim = new log_claim();
                    //$user_id = $sf_user->getAttribute('user_id',null, 'sfGuardSecurityUser');
                    $new_log_claim->NewLogRecord($new_claim_id, $user_id, sfConfig::get('logcliam_newclaim'));     
        }
         
        
            $con->commit();
        }
        catch (Exception $e)
        {
          $con->rollBack();

          throw $e;
        }
      
         return $new_claim->getId();  
        
       
    }
    
    public function getOrganization()
    {
       //return $this->getDepartments()->getContract()->getOrganization();
       return $this->getDepartments()->getOrganization();
    }
    public function setIsread($user_id = null)
    {
        //$user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $user_id = ($user_id == -1) ? 0 : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $claim_users = Doctrine::getTable('Claimusers')
        ->createQuery('cu')
        ->where('cu.claim_id = '.$this->getId())
        ->andWhere('cu.user_id <>'.$user_id)
        ->execute();
        foreach ($claim_users as $claim_user)
        {
            $claim_user->setIsread(true);
            $claim_user->trySave();
        };
        
                        
    }
    
    public function Isread()
    {
        $bool = true;
        $claim_users = $this->getClaimUsers();
        $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        foreach ($claim_users as $claim_user)
        {
            if ($claim_user->getIsread()&&$claim_user->getUserId() == $user_id) $bool = false; 
        };
        return $bool;
     }
     
     public function setIsReadByUser()
     {
        $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $claim_users = Doctrine::getTable('Claimusers')
        ->createQuery('cu')
        ->where('cu.claim_id = '.$this->getId())
        ->andWhere('cu.user_id ='.$user_id)
        ->execute();
        foreach ($claim_users as $claim_user)
        {
            $claim_user->setIsread(false);
            $claim_user->trySave();
        }; 
     }
    
    
    
    
    public function getStatusLastDate()
    {
        $q = Doctrine::getTable('log_claim')
        ->createQuery('l')
        ->where('l.claim_id = '.$this->getId())
        ->addWhere('l.log_claim_type = \''.sfConfig::get('logclaimtype_status').'\'')
        ->orderBy('l.createdatetime DESC')
        ->fetchOne();
        
        if ($q) return $q->getCreatedatetimeGood(); else return null;
    }
    
    public function getDocumentHolder($doctype)
    {
       return $q = Doctrine::getTable('Documents')
        ->createQuery('d')
        ->leftJoin('d.DocumentsClaim dc')
        ->leftJoin('d.Documentstype dt')
        ->where('dc.claim_id ='.$this->getId())
        ->andWhere('dt.dockey =\''.$doctype.'\'') 
        ->execute();
    }
    
    public function getFinanceClaimRecords()
    {
        return $q = Doctrine::getTable('finance_claim')
        ->createQuery('fc')
        ->select('fc.*, costs.*')
        ->leftJoin('fc.FcCostsn costs')
        //->setQuery('row_number() OVER(order by fc.ia) as row_nn')
        //->sqlParts('row_number() OVER(order by fc.ia) as row_nn')
        ->where('fc.claim_id ='.$this->getId())
        ->orderBy('fc.id ASC')
        ->execute();
    }

    public function getTotalIncomeNds()
    {
       //$worklist = $this->getFinanceClaimRecords();
       $worklist = $this->getFinanceClaim();
       $summ = 0;
       foreach ($worklist as $work)
       {
          $summ += $work->getIncomeNds(); 
       }
       return round($summ, 2);
    }
    
    public function getTotalIncomeNonnds()
    {
       //$worklist = $this->getFinanceClaimRecords();
       $worklist = $this->getFinanceClaim(); 
       $summ = 0;
       foreach ($worklist as $work)
       {
          $summ += $work->getIncomeNonnds(); 
       }
       return round($summ, 2);
    }
    
    public function getTotalCostsNonnds()
    {
       //$worklist = $this->getFinanceClaimRecords();
       $worklist = $this->getFinanceClaim();
       $summ = 0;
       foreach ($worklist as $work)
       {
          $summ += $work->getRealCosts(); 
       }
       return round($summ, 2);
    }

    
   public function getTotalCostsNds()
    {
       //$worklist = $this->getFinanceClaimRecords();
       $worklist = $this->getFinanceClaim();
       $summ = 0;
       foreach ($worklist as $work)
       {
          $summ += $work->getRealCostsNds(); 
       }
       return round($summ, 2);
    }
    
    public function getProfitability()
    {
       $profitability = $this->getTotalIncomeNonnds() - $this->getTotalCostsNonnds();
       
       return round($profitability, 2);
    }
    public function getProfitabilityPersent()
    {
         if ($this->getTotalIncomeNonnds()) return round($this->getProfitability()/$this->getTotalIncomeNonnds()*100,2);
         else return false;
    }
    
    public function getTotalProfitabilityResponse()
    {
        return include_partial('F_finance_claim/profitability_response', array('finance_claim'=>$this));
    }
    
    public function showTotalIncomeString()
    {
       return $this->getTotalIncomeNds()?$this->getTotalIncomeNds()." грн. С НДС ":($this->getDescription()?$this->getDescription():'');
    }
    
    public function showTotalIncome()
    {
       return $this->getTotalIncomeNds()?$this->getTotalIncomeNds():($this->getDescription()?$this->getDescription():'');
    }
    
        
    public function showTotalCostsString()
    {
       return $this->getTotalCostsNds()?$this->getTotalCostsNds().' грн. С НДС ':($this->getOurcosts()?$this->getOurcosts():'');
    }
    public function showTotalCosts()
    {
       return $this->getTotalCostsNds()?$this->getTotalCostsNds():($this->getOurcosts()?$this->getOurcosts():'');
    }
    
    public function getWorkList()
    {
        $finance_claims = $this->getFinanceClaim();
        $count = 0;
        $s = '';
        foreach ($finance_claims as $finance_claim)
        {
            $count++;
            $s .= "<b>$count</b>. ".$finance_claim->getWork()." <br />";
        }
        
        return $s ? $s : ($this->getStuffdescription()?$this->getStuffdescription():'');
    }
    
    static public function hasClaimAccess($claim_id)
    {
        
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        switch ($app)
        {
            case 'dispatcher':
            case 'finance':
            case 'supervisor':
              return true;
            break;
            case 'client':
              return claim::hasClientClaimAccess($user_id, $claim_id) ? true : false;
            break; 
            case 'kurator':
            case 'stuff':
            case 'oper':
              return claim::hasStuffClaimAccess($user_id, $claim_id, $app) ? true : false;
            break;  
            case 'smeta':
              return claim::hasSmetaClaimAccess($user_id, $claim_id, $app) ? true : false;
            break;
        }
        return false; 
    }          
    
    static public function hasClientClaimAccess($user_id, $claim_id)
    {
        $claim = Doctrine::getTable('claim')->find($claim_id);
        $dep_id = $claim->getDepartments()->getId();
        if (!$claim || !$user_id) return false;
        $q = Doctrine::getTable('client_departments')
        ->createQuery('cd')
        ->select('cd.departments_id, cd.client_id')
        ->leftJoin('cd.Client client')
        ->where('cd.departments_id = '.$dep_id)
        ->addWhere('client.user_id ='.$user_id)
        ->execute();
        return count($q) ? true : false; 
        
    }
    
    static public function hasStuffClaimAccess($user_id, $claim_id, $app)
    {
      //$claim = Doctrine::getTable('claim')->find($claim_id);
      if (!$user_id || !$app) return false;
      $q = Doctrine::getTable('Claimusers')
        ->createQuery('cu')
        ->select('cu.id')
        ->where('cu.user_id = ? ', $user_id);
      
      if ($app != 'oper')
      {
        $q
          ->addWhere('cu.userkey =  ?' , sfConfig::get('claimuserkey_'.$app));
      }
      
      $count = $q
        ->addWhere('cu.claim_id = ?', $claim_id)
        ->count();
      return $count ? true : false; 
    }

    static public function hasSmetaClaimAccess($user_id, $claim_id, $app)
    {
        $claim = Doctrine::getTable('claim')->find($claim_id); 
        $getSmetaStatuses = Doctrine::getTable('status')->getAllSmetaStatuses();
        if (!$claim || !$user_id) return false;
        return in_array($claim->getSmetaStatusId(), $getSmetaStatuses->getPrimaryKeys()) ? true : false; 
    }
    
    public function getBillDateFormatted()
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers('Date');
      return format_date($this->getBillDate(), 'dd.MM.yyyy', 'ru');
    }
    
}
