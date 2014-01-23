<?php

/**
 * claim actions.
 *
 * @package    helpdesk
 * @subpackage claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimopenedActions extends sfActions
{
  public function preExecute()
  {
     $this->app = ucfirst(sfContext::getInstance()->getConfiguration()->getApplication());
     $form_name = "claim".$this->app."NewForm";
     $group_form_name = "claim".$this->app."GroupNewForm";
     $this->form_name = $form_name;
     $this->group_form_name = $group_form_name;
  }
    
  public function executeIndex(sfWebRequest $request)
  {
      $table_method =  "getOpenedClaimsFor".$this->app;
      $this->claimsopen = Doctrine_Core::getTable('claim')->$table_method();
      $this->setTemplate($this->app);
      $this->show_added_field = false;
      if ($this->app == 'Client') 
      {
          $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
          $user = Doctrine::getTable('sfGuardUser')->find($user_id)->getClient()->getFirst();
          $this->show_added_field = $user->getShowAddedField();
      }
  }

  
  public function executeClose(sfWebRequest $request)
  {
     $claim_id = $request->getParameter('claimid');
     $close_claim = Doctrine::getTable('claim')->find($claim_id);
     $close_claim->closeClaim();
     $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
     $new_log_claim = new log_claim();
     $new_log_claim->NewLogRecord($close_claim->getId(), $user_id, sfConfig::get('logcliam_close'));
     $this->redirect('claimopened/index'); 
  }
  
  public function executeOpen(sfWebRequest $request)
  {
     $claim_id = $request->getParameter('claimid');
     $close_claim = Doctrine::getTable('claim')->find($claim_id);
     $close_claim->openClaim();
     $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
     $new_log_claim = new log_claim();
     $new_log_claim->NewLogRecord($close_claim->getId(), $user_id, sfConfig::get('logcliam_open'));
     $this->redirect('claimopened/index'); 
  }
  
  public function executeNew(sfWebRequest $request)
  {
    
     $this->form = new $this->form_name();
  }
  
  public function executeNewgroup(sfWebRequest $request)
  {
     $this->form = new $this->group_form_name();
    
  }
  
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new $this->form_name();
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
         $this->form->save();
         $this->getUser()->setFlash('notice','Claim has created successfully');
         $this->redirect('claimopened/index');
    } else $this->getUser()->setFlash('error','Invalid.');
    $this->setTemplate('new');    
  }
  
  public function executeCreateonce(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form_name = 'claimDispatcherNewOnceForm';
    $this->form = new $this->form_name();
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
         $this->form->save();
         $this->getUser()->setFlash('notice','Claim has created successfully');
         $this->redirect('claimopened/index');
    } else $this->getUser()->setFlash('error','Invalid.');
    $this->setTemplate('newonce');    
  }
  
  public function executeCreategroup(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new $this->group_form_name();
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
         $this->form->save();
         $this->getUser()->setFlash('notice','Claims has created successfully');
         $this->redirect('claimopened/index');
    } else $this->getUser()->setFlash('error','Invalid.');
    $this->setTemplate('newgroup');    
  }
 
 //START GROUP BLOCK
 
/*  public function executeNewgroup(sfWebRequest $request)
  {
    $this->form = new claimDispatcherGroupForm();
    
  }
  
  
  public function executeCreategroup(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new claimDispatcherGroupForm();
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
        $claim = $request->getParameter($this->form->getName());
        //$new_claim = $this->form->getObject();
        $new_claim_id = claim::saveDispatcher($claim, true);
        $this->redirect('claimopened/index');
        
   } else $this->getUser()->setFlash('error','Ошибка добавления заявки');
   $this->setTemplate('newgroup');        
    
  }     */
 
 //END GROUP BLOCK
 
 
 
  
  
   public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new claimImportanceChangeForm($claim);

    $this->processForm($request, $this->form);
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($this->form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newimportance').$this->form->getObject()->getContractImportance());


    $this->redirect('claimopened/index');
  } 
  

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new claimImportanceChangeForm($claim);
    
  }
  
       
  
    
  public function executeEditstatus(sfWebRequest $request)
  {
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new claimStatusChangeForm($claim);
  }
  
  public function executeUpdatestatus(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new claimStatusChangeForm($claim);

    $this->processForm($request, $this->form);
      
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($this->form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newstatus').$this->form->getObject()->getStatus());

     $this->redirect('claimopened/index');
  }  
  
  
  public function executeEditkurator(sfWebRequest $request)
  {
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new claimKuratorChangeForm($claim);
  }
  
  public function executeUpdatekurator(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    
    $kurators = $request->getParameter('claim');
    
    if (isset($kurators['stuff_list'])){
        $users = Doctrine::getTable('Stuff')
        ->createQuery('s')
        ->whereIn('id', $kurators['stuff_list'])
        ->execute();
        $claimstuff = new claimusers();
        $claimstuff->saveClientKuratorStuff($request->getParameter('id'),'',$users,'');
    }
    //$claim
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($request->getParameter('id'), $user_id, sfConfig::get('logcliam_newkurator').$claim->getKurator());

    
    $this->redirect('claimopened/index');
  } 
  
  public function executeEditstuff(sfWebRequest $request)
  {
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new claimStuffChangeForm($claim);
  }
  
  public function executeUpdatestuff(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    
    $kurators = $request->getParameter('claim');
    if (isset($kurators['stuff_list'])){
        $users = Doctrine::getTable('Stuff')
        ->createQuery('s')
        ->whereIn('id', $kurators['stuff_list'])
        ->execute();
        $claimstuff = new claimusers();
        $claimstuff->saveClientKuratorStuff($request->getParameter('id'),'',null,$users);
    }
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($request->getParameter('id'), $user_id, sfConfig::get('logcliam_newstuff').$claim->getStuff());

    
    $this->redirect('claimopened/index');
  }   
  
  
  


  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $claim->delete();

    $this->redirect('claim/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $claim = $form->save();

      //$this->redirect('claimopened/index');
    }
  }
  
  
  //AJAX
  public function executeEditstatusajax(sfWebRequest $request)
  {
    
    if ($request->isXmlHttpRequest())
    {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $this->form = new claimStatusChangeForm($claim);
        return $this->renderPartial('claimopened/formeditstatusajax', array('form' => $this->form));
    }  
     
      return $this->renderText('Direct access');
  }
  
  public function executeUpdatestatusajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    $form = new claimStatusChangeForm($claim);

    $this->processForm($request, $form);
      
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newstatus').$form->getObject()->getStatus(), sfConfig::get('logclaimtype_status'));
   
    return true; 
  }  
  
  
  //AJAX GET status 
  public function executeGetstatusajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getStatusajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  
  //AJAX CHANGE KURATOR
  public function executeEditkuratorajax(sfWebRequest $request)
  {
     if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $this->form = new claimKuratorChangeForm($claim);
        return $this->renderPartial('claimopened/formeditkuratorajax', array('form' => $this->form));
     } 
     
      return $this->renderText('Direct access'); 
      
  }
  
  public function executeUpdatekuratorajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    
    $kurators = $request->getParameter('claim');
    
    if (isset($kurators['stuff_list'])){
        $users = Doctrine::getTable('Stuff')
        ->createQuery('s')
        ->whereIn('id', $kurators['stuff_list'])
        ->execute();
        $claimstuff = new claimusers();
        $claimstuff->saveClientKuratorStuff($request->getParameter('id'),'',$users,'');
    }
    //$claim
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($request->getParameter('id'), $user_id, sfConfig::get('logcliam_newkurator').$claim->getKurator());

    
    return true;
  } 
  
  
    //AJAX GET JURATOR
  public function executeGetkuratorajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getKuratorajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  
  //AJAX CHANGE description
  public function executeEditdescriptionajax(sfWebRequest $request)
  {
     if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $this->form = new claimDescriptionChangeForm($claim);
        return $this->renderPartial('claimopened/formeditdescriptionajax', array('form' => $this->form));
     } 
     
      return $this->renderText('Direct access'); 
      
  }
  
  public function executeUpdatedescriptionajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
     
    $claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id')));
    $form = new claimDescriptionChangeForm($claim);
    $this->processForm($request, $form);   
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newdescription').$form->getObject()->getDescription());
    
    return true;
  } 
  
  //AJAX GET description 
  public function executeGetdescriptionajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getDescriptionajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  
  
  //AJAX CHANGE STUFFDESCRIPTION
  public function executeEditstuffdescriptionajax(sfWebRequest $request)
  {
     if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $form = new claimStuffDescriptionChangeForm($claim);
        return $this->renderPartial('claimopened/formstuffdescription', array('form' => $form)); 
     } 
     
      return $this->renderText('Direct access'); 
      
  }
  
  public function executeUpdatestuffdescriptionajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
     
    $claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id')));
    $form = new claimStuffDescriptionChangeForm($claim);
    $this->processForm($request, $form);   
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newstuffdescription').$form->getObject()->getStuffdescription());
    
    return true;
  } 
  
  //AJAX GET description 
  public function executeGetstuffdescriptionajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getStuffdescriptionajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  
  
  //AJAX CHANGE CLAIMTYPE
  public function executeEditclaimtypeajax(sfWebRequest $request)
  {
     if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine::getTable('claim')->find($request->getParameter('id')), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $form = new claimClaimtypeChangeForm($claim);
        return $this->renderPartial('claimopened/formeditclaimtypeajax', array('form' => $form)); 
     } 
     
      return $this->renderText('Direct access'); 
      
  }
  
  public function executeUpdateclaimtypeajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
     
    $claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id')));
    $form = new claimClaimtypeChangeForm($claim);
    $this->processForm($request, $form);   
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newclaimtype').$form->getObject()->getClaimtype());
    
    return true;
  } 
  
  //AJAX GET CLAIMTYPE 
  public function executeGetclaimtypeajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getClaimtypeajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  
  // AJAX GET STUFF
   public function executeEditstuffajax(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $this->form = new claimStuffChangeForm($claim);
        return $this->renderPartial('claimopened/formeditstuffajax', array('form' => $this->form));
     }
  }
  
  public function executeUpdatestuffajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    
    $kurators = $request->getParameter('claim');
    if (isset($kurators['stuff_list'])){
        $users = Doctrine::getTable('Stuff')
        ->createQuery('s')
        ->whereIn('id', $kurators['stuff_list'])
        ->execute();
        $claimstuff = new claimusers();
        $claimstuff->saveClientKuratorStuff($request->getParameter('id'),'',null,$users);
    }
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($request->getParameter('id'), $user_id, sfConfig::get('logcliam_newstuff').$claim->getStuff());

    
    return true;
  }   
  
      //AJAX GET STUFF
  public function executeGetstuffajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getStuffajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  
  
  public function executeDepartmentslist(sfWebRequest $request)
  {
      $org_id = $request->getParameter('orgid');
      if (!$org_id) return $this->renderText('No records');
      $this->departmentss = Doctrine_Core::getTable('departments')->getDepartmentsByOrganization($org_id);
      if ($request->isXmlHttpRequest())
      {  
          //$this->getUser()->setAttribute('organization_id', $org_id);
          return $this->renderPartial('claimopened/dep_list', array('departmentss' => $this->departmentss));
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  
   //AJAX CHANGE description
  public function executeEditourcostsajax(sfWebRequest $request)
  {
     if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        $this->form = new claimOurcostsChangeForm($claim);
        return $this->renderPartial('claimopened/formeditourcostsajax', array('form' => $this->form));
     } 
     
      return $this->renderText('Direct access'); 
      
  }
  
  public function executeUpdateourcostsajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
     
    $claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id')));
    $form = new claimOurcostsChangeForm($claim);
    $this->processForm($request, $form);   
    
    $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $new_log_claim = new log_claim();
    $new_log_claim->NewLogRecord($form->getObject()->getId(), $user_id, sfConfig::get('logcliam_newourcosts').$form->getObject()->getOurcosts());
    
    return true;
  } 
  
  //AJAX GET description 
  public function executeGetourcostsajax(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT)); 
    $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
    if ($request->isXmlHttpRequest())
     {
        $this->forward404Unless($claim = Doctrine_Core::getTable('claim')->find(array($request->getParameter('id'))), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        return $this->renderPartial('claimopened/getOurcostsajax', array('claim' => $claim));
     }
     return $this->renderText('Direct access');  
  }
  
  public function executeIndexonce(sfWebRequest $request)
  {
      $table_method =  "getOpenedOnceClaimsFor".$this->app;
      $this->claimsopen = Doctrine_Core::getTable('claim')->$table_method();
      $this->setTemplate($this->app);
      $this->show_added_field = false;
      if ($this->app == 'Client') 
      {
          $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
          $user = Doctrine::getTable('sfGuardUser')->find($user_id)->getClient()->getFirst();
          $this->show_added_field = $user->getShowAddedField();
      }
  }
  
  public function executeIndexlocal(sfWebRequest $request)
  {
      $table_method =  "getOpenedLocalClaimsFor".$this->app;
      $this->claimsopen = Doctrine_Core::getTable('claim')->$table_method();
      $this->setTemplate($this->app);
      $this->show_added_field = false;
      if ($this->app == 'Client') 
      {
          $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
          $user = Doctrine::getTable('sfGuardUser')->find($user_id)->getClient()->getFirst();
          $this->show_added_field = $user->getShowAddedField();
      }
  }
  
  
  public function executeNewonce(sfWebRequest $request)
  {
    $this->form = new claimDispatcherNewOnceForm();
  }
  
  
  
}
