<?php

class claimsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    set_time_limit(0);
    
    $start_time = microtime(true);
    
    $claimIds = Doctrine::getTable('claim')
      ->createQuery('c')
      ->select('c.id')
      ->where('c.isclosedclient = ?', 1)
      //->limit(10)
      ->fetchArray(); 
      
    
    
    echo count($claimIds);
      
    $temp = array();
    
    foreach($claimIds as $key => $claimId)
    {
      $temp[] = $claimId['id'];
    } 
    
    ///$claimIds = array_keys(array_keys($claimIds)[0]);
    //$claimIds = array(4378);
    
    $log_claims_opened = Doctrine::getTable('log_claim')
      ->createQuery('lc')
      //->whereIn('lc.claim_id', $temp)
      ->addWhere('lc.description = ?', 'Заявка перенесена из закрытых в открытые: ')
      //->limit(10)
      ->execute();
      
    echo '<br />';
    echo count($log_claims_opened);  
    //$result_opened = array();  
    
    foreach ($log_claims_opened as $log)
    {
      if (isset($result_opened[$log->getClaimId()]))
      {
        if ($result_opened[$log->getClaimId()] < $log->getCreatedatetime('U'))
        {
          $result_opened[$log->getClaimId()] = $log->getCreatedatetime('U');
        }
      }
      else
      {
        $result_opened[$log->getClaimId()] = $log->getCreatedatetime('U');
      }
    }
      
    $log_claims = Doctrine::getTable('log_claim')
      ->createQuery('lc')
      //->whereIn('lc.claim_id', $temp)
      ->addWhere('lc.description = ?', 'Заявка закрыта: ')
      ->execute();
    
    $result = array();  
    
    foreach ($log_claims as $log)
    {
      if (isset($result_opened[$log->getClaimId()]))
      {
        if ($log->getCreatedatetime('U') < $result_opened[$log->getClaimId()])
        {
          continue;
        }
      }
      
      if (isset($result[$log->getClaimId()]))
      {
        if ($result[$log->getClaimId()]->getCreatedatetime('U') > $log->getCreatedatetime('U'))
        {
          $result[$log->getClaimId()] = $log;
        }
      }
      else
      {
        $result[$log->getClaimId()] = $log;
      }
    }
      
    $result1 = array();
    foreach($result as $r)
    {
      //$result1[] = $r->getId();
      $result1[$r->getClaimId()] = $r->getCreatedatetime('U');
    }
    
    $delete = array();
    
    foreach ($log_claims as $log) 
    {
      if (isset($result1[$log->getClaimId()]))
      {
        if ($log->getCreatedatetime('U') > $result1[$log->getClaimId()])
        {
          //$delete[] = $log->getId();
          $log->delete();
        }
      }
    } 
    
    $exec_time = microtime(true) - $start_time;
    echo '<br />';
    echo $exec_time;
    
    
    return $this->renderText('claims index');
  }
  
  public function executeFill(sfWebRequest $request)
  {
    $databaseManager = sfContext::getInstance()->getDatabaseManager(); 

    // "doctrine" is the most common name used, maybe yours can differ
    $database = $databaseManager->getDatabase("doctrine");
    $dbh = $database->getConnection(); 

    $query = "update 
    claim 
      set closedatetime = 
      (select lc.createdatetime from log_claim lc
        where lc.claim_id = claim.id and
        lc.description = :description
        order by lc.id desc limit 1
      )
    where 
      isclosedclient is not false"; 
    
    $params = array(':description' => 'Заявка закрыта: '); 
      
    $statement= $dbh->prepare($query);
    $statement->execute($params);
    
    return $this->renderText('claims fill'); 
  }
} 