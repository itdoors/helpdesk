<?php
  
class actors extends sfGuardUser
{
    public function __toString()
    {                               
        return $this->getLastName()." ".$this->getFirstName();
    }
        
    static function getAdditionalInfo($user_id)
    {
        if (!$user_id) return new UserContactinfo();
        $q = Doctrine::getTable('UserContactinfo')
        ->createQuery('uc')
        ->select('uc.id, uc.user_id, ci.name')
        ->leftJoin('uc.Contactinfo ci')
        ->where('uc.user_id = '.$user_id)
        ->execute();
        return $q;
    }
    

}
?>
