<?php

/**
 * log_claim actions.
 *
 * @package    helpdesk
 * @subpackage log_claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class log_claimActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->log_claims = Doctrine_Core::getTable('log_claim')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new log_claimForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new log_claimForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($log_claim = Doctrine_Core::getTable('log_claim')->find(array($request->getParameter('id'))), sprintf('Object log_claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new log_claimForm($log_claim);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($log_claim = Doctrine_Core::getTable('log_claim')->find(array($request->getParameter('id'))), sprintf('Object log_claim does not exist (%s).', $request->getParameter('id')));
    $this->form = new log_claimForm($log_claim);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($log_claim = Doctrine_Core::getTable('log_claim')->find(array($request->getParameter('id'))), sprintf('Object log_claim does not exist (%s).', $request->getParameter('id')));
    $log_claim->delete();

    $this->redirect('log_claim/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $log_claim = $form->save();

      $this->redirect('log_claim/edit?id='.$log_claim->getId());
    }
  }
}
