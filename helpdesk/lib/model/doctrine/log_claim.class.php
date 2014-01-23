<?php

/**
 * log_claim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class log_claim extends Baselog_claim
{
    public function getAction()
    {
        $lookup = Doctrine::getTable('lookup')->find($this->action_id);
        return $lookup->name;
    }
    
    public function getUser()
    {
        $user = Doctrine::getTable('sfGuardUser')->find($this->user_id);
        return $user->__toString();
    }
    
    
    
    static public function NewLogRecord($claim_id, $user_id, $desc, $log_claim_type = '')
    {
        //$session =  sfContext::getInstance()->getUser();
        $log_record = new log_claim();
        $user_id = ($user_id == -1) ? 0 : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $claim_id = $claim_id ? $claim_id : sfContext::getInstance()->getUser()->getAttribute('claim_id');
       // $log_record = new log_claim();
        $log_record->claim_id = $claim_id;
        $log_record->user_id = $user_id;  
        $log_record->createdatetime = date("Y-m-d H:i:s");
        $log_record->description = $desc;
        $log_record->log_claim_type = $log_claim_type;
        $log_record->trySave();
    }
    
    static function NewLogRecordFinance($claimid, $desc, $log_claim_type = '', $finance_claim_id = null, $user_id = null, $claim_id = null)
    {
        $session =  sfContext::getInstance()->getUser();
        //$user_id = $session->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $user_id = ($user_id == -1) ? 0 : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        //$claim_id = $session->getAttribute('claim_id');
        $claimid = $claimid ? $claimid : $session->getAttribute('claim_id');
        $log_record = new log_claim();
          $log_record->setClaimId($claimid);
          $log_record->setUserId($user_id);
          $log_record->setCreatedatetime(date("Y-m-d H:i:s"));
          $log_record->setDescription($desc);
          $log_record->setLogClaimType($log_claim_type);
          $log_record->setFinanceClaimId($finance_claim_id);
        $log_record->save();
    }
    
/*    public function NewLogRecordClosed($claim_id, $user_id, $desc, $log_claim_type = '')
    {
        $this->claim_id = $claim_id;
        $this->user_id = $user_id;
        $this->createdatetime = date("2011-03-11 H:i:s");
        $this->description = $desc;
        $this->log_claim_type = $log_claim_type;
        $this->trySave();
    }*/
    
    public function getCreatedatetimeGood()
    {
        return format_date($this->getCreatedatetime(), 'dd.MM.yyyy, HH:mm', 'ru');
    }

}
