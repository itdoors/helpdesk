<?php


class usersActions extends sfActions
{
    public function executeJoinuserform(sfWebRequest $request)
    {
       if ($request->isXmlHttpRequest())
       {
           
          $this->form = new JoinUserForm();
          $this->form->setDefault('claim_id',$request->getParameter('claim_id'));
          $this->form->setDefault('userkey',sfConfig::get('claimuserkey_joined'));
          return $this->renderPartial('joinuserform', array('form' => $this->form));
       }
       return $this->renderText('Direct access denide');
    }
    
    public function executeJoinusersave(sfWebRequest $request)
    {
       $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)); 
       $form = new JoinUserForm();
       $claimuser_data = $request->getParameter($form->getName());
       foreach ($claimuser_data['user_id'] as $user => $key)
       {
          $claimuser = new claimusers();
          $claimuser->setUserId($key);
          $claimuser->setClaimId($claimuser_data['claim_id']);  
          $claimuser->setUserkey($claimuser_data['userkey']);
          $claimuser->trySave();  
       } 
       return true;

    }
    
    public function executeGet_kurator(sfWebRequest $request)
    {
        if (! $claim = Doctrine::getTable('claim')->find($request->getParameter('claim_id'))) return $this->renderText(__('No object'));
        return $this->renderText($claim->getKurator());
    }
    
    public function executeGet_stuff(sfWebRequest $request)
    {
        if (! $claim = Doctrine::getTable('claim')->find($request->getParameter('claim_id'))) return $this->renderText(__('No object'));
        return $this->renderText($claim->getStuff());
    }

}            
