<?php

class myUser extends sfGuardSecurityUser
{
        public function getPositionUser()
    {
  /*      $user = Doctrine::getTable('stuff')
        ->createQuery('c')
        ->where('c.user_id = '.$this->getGuardUser()->getId())
        ->fetchOne();
        //die()
        if ($user<>null)  
        {    
            $lookup = Doctrine::getTable('lookup')->find($user->position_id);
            return $lookup->name();
        } else return ' '; */   
    }
    
  public function getId()
  {
    return $this->getAttribute('user_id', null, 'sfGuardSecurityUser');
  }
  
  public function getCredentialIds()
  {
    $credentials =  $this->getCredentials();
    
    $credentialIds = sfGuardPermissionTable::getInstance()
      ->createQuery()
      ->select('id')
      ->whereIn('name', $credentials)
      ->fetchArray();
      
    if (!sizeof($credentialIds))
    {
      return array();
    }
    
    $return = GlobalFunctions::getFormattedArray($credentialIds, 'id');
      
    return $return;
  } 
}
