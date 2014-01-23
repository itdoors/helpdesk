<?php

/**
 * actors actions.
 *
 * @package    helpdesk
 * @subpackage actors
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actorsActions extends sfActions
{
  public function preExecute()
  {
      if (!$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser')) return $this->renderText('Please login');
  }
    
  public function executeIndex(sfWebRequest $request)
  {
    $this->sf_guard_users = Doctrine_Core::getTable('sfGuardUser')
      ->createQuery('a')
      ->execute();
  }
  
  public function executeSearch(sfWebRequest $request)
  {
      if (!$request->isXmlHttpRequest()) return $this->renderText('Direct access');
      $keywords['fio'] = $request->getParameter('search_keywords_fio');
      $keywords['position'] = $request->getParameter('search_keywords_position');
      $keywords['city'] = $request->getParameter('search_keywords_city');
      //$actors = Doctrine::getTable('actors')->getActorsByKeywords($keywords);
      $this->actors = Doctrine::getTable('actors')->getActorsByKeywords($keywords);
      //return $this->renderPartial('actors_list', array('actors'=>$actors));
  }
  

  public function executeShow(sfWebRequest $request)
  {
    //$user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
    $user_id = $request->getParameter('id');
    $this->sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find($user_id);
    $this->forward404Unless($this->sf_guard_user);
    $this->additionalinfos = actors::getAdditionalInfo($user_id);
  }

 
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->forwardIf($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser') != $request->getParameter('id'), 'nopermission', 'index');
    $this->form = new UserIntranetProfileForm($sf_guard_user);
    $this->additionalinfos = actors::getAdditionalInfo($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
    
  }

   
  public function executeEdit_contact_info(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->forwardIf($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser') != $request->getParameter('id'), 'nopermission', 'index');
    $this->form = new IntranetContactInfoForm($sf_guard_user);
    
  }
  
  
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserIntranetProfileForm($sf_guard_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
/*    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $sf_guard_user->delete();  */

    $this->redirect('actors/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user = $form->save();

      $this->redirect('actors/edit?id='.$sf_guard_user->getId());
    }
  }
  
  public function executeRefresh_additionalimfo(sfWebRequest $request)
  {
      if (!$request->isXmlHttpRequest()) return $this->renderText('Direct access');
      $this->additionalinfos = actors::getAdditionalInfo($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
      return $this->renderComponent('actors', 'user_additionalinfo_form', array('additionalinfos'=>$this->additionalinfos) );
  }
  
  
  
}
