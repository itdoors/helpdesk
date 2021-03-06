<?php

/**
 * FcCostsn
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class FcCostsn extends BaseFcCostsn
{
   public function refreshFinanceClaim()
   {
       
   }
   
   public function save(Doctrine_Connection $conn = null)
   {
      $new = $this->isNew();
      parent::save();
      if ($new) {
          //$this->refreshFinanceClaim();
          $nds = Doctrine::getTable('lookup')->getNds();
          $obnal = Doctrine::getTable('lookup')->getObnal();
          log_claim::NewLogRecordFinance($this->getFinanceClaim()->getClaimId(), sfConfig::get('logcliam_new_value')." ".$this->getValue(), sfConfig::get('logcliam_finance'), $this->getFinanceClaim()->getId());   
      }
    } 
   
   public function delete(Doctrine_Connection $conn = null)
   {
      $value = $this->getValue();
      $finance_claim_id = $this->getFinanceClaim()->getId();
      $claim_id = $this->getFinanceClaim()->getClaimId(); 
      parent::delete();
      log_claim::NewLogRecordFinance($claim_id, sfConfig::get('logcliam_delete_value')." ".$value, sfConfig::get('logcliam_finance'), $finance_claim_id);    
   }
   
   public function objectFieldSaveToLogClaim($field = null, $toString  = null)
   {
       if (!$field||!$toString) return null;
       log_claim::NewLogRecordFinance($this->getFinanceClaim()->getClaimId(), sfConfig::get('logcliam_'.$field)." ".$this->$toString(), sfConfig::get('logcliam_finance'), $this->getFinanceClaim()->getId());   
   }
}