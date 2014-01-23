<?php

class myUser extends sfGuardSecurityUser
{
  public function getPositionUser()
  {
  }

  public function getId()
  {
    return $this->getAttribute('user_id', null, 'sfGuardSecurityUser');
  }
}
