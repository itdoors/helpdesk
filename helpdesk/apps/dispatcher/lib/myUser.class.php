<?php

class myUser extends sfGuardSecurityUser
{
    public function getPositionUser()
    {
        /*$user = Doctrine::getTable('stuff')
        ->createQuery('c')
        ->where('c.user_id = '.$this->getGuardUser()->getId())
        ->fetchOne();
        //die()
        if ($user<>null)  
        {    
            $lookup = Doctrine::getTable('lookup')->find($user->position_id);
            //return $lookup->name();
        } else return ' ';    */
    }
    public function isFirstRequest($boolean = null)
    {
      if (is_null($boolean))
      {
        return $this->getAttribute('first_request', true);
      }
     
      $this->setAttribute('first_request', $boolean);
    }
}
