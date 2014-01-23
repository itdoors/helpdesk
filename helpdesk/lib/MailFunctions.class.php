<?php
class MailFunctions
{
   static  $Users_to_Notificate = array(
        'client',
        'dispatcher',
        'kurator',
        'stuff'
    );
    static function sendMessageForAllExcept($claim, $except = array(), $subject, $text)
    {
        $users =  array_flip(MailFunctions::$Users_to_Notificate);
        foreach ($except as $ex)
        {
            unset($users[$ex]);
        };
        $users = array_flip($users);
        foreach ($users as $userkey)
        {
            $is_mailed = true;
            
            if ($userkey == 'client')
            {
                $client = $claim->getClientObject();
                if ($client instanceof Client) $is_mailed = $client->getIsMailed();
            }
            if ($is_mailed)
            {
               $subject_function = "get".ucfirst($userkey)."_Messages_Create_Subject";
                $text_function = "get".ucfirst($userkey)."_Messages_Create_Text";
                if (method_exists(new SDtexts(), $subject_function))
                {
                    $subject = SDtexts::$subject_function($claim);   
                    $text = SDtexts::$text_function($claim);   
                    MailFunctions::sendSDEmail($claim->getId(), null, $userkey, $subject, $text); 
                }  
            }
                
        };
        
    }
    
    
    static function sendSDEmail($claim_id, $user_id = null, $userkey = null, $subject, $text) 
    {
       if ($user_id)
       {
           $user = Doctrine::getTable('sfGuardUser')->find($user_id);
           if ($user) MailFunctions::sendMessageToUser($user->getEmailAddress(), $subject, $text);
           return true;
       }
       if ($userkey && $claim_id)
       {
           $users = MailFunctions::getClaimusersByUsertypeAndClaimId($claim_id, $userkey);
           foreach ($users as $user)
           {
               MailFunctions::sendMessageToUser($user->getEmailAddress(), $subject, $text); 
           }
       }
    }
    
    static function  sendMessageToUser($to, $subject, $text, $html = false)
    {
      $message = sfContext::getInstance()->getMailer()->compose(
      array(sfConfig::get('email_from') => 'Service Desk'),
      $to,
      $subject,
      $text);
      if ($html)
      {
        $message->setContentType("text/html");
      }
      sfContext::getInstance()->getMailer()->send($message);  
    }

    static function  sendMessageToUserById($userId, $subject, $text, $html = false)
    {
      $user = Doctrine::getTable('sfGuardUser')->find($userId);

      if (!$user)
      {
        return;
      }

      $to = $user->getEmailAddress();

      $message = sfContext::getInstance()->getMailer()->compose(
        array(sfConfig::get('email_from') => 'Service Desk'),
        $to,
        $subject,
        $text);
      if ($html)
      {
        $message->setContentType("text/html");
      }

      sfContext::getInstance()->getMailer()->send($message);
    }
    
    static function getClaimusersByUsertypeAndClaimId($claim_id, $userkey)
    {
        $q = Doctrine::getTable('sfGuardUser')
        ->createQuery('u')
        ->select('u.email_address')
        ->leftJoin('u.ClaimUsers cu')
        ->where('cu.claim_id ='.$claim_id)
        ->addWhere('cu.userkey = \''.$userkey.'\'')
        ->execute();
        return $q;
    }
  
}
?>
