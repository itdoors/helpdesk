<?php

class myUser extends sfGuardSecurityUser
{
    public function getPositionUser()
    {
        /*$user = Doctrine::getTable('client')
        ->createQuery('c')
        ->where('user_id = '.$this->getGuardUser()->getId())
        ->fetchOne();
        if ($user<>null) return $user->getPosition(); 
        else return '';*/
    }
}

