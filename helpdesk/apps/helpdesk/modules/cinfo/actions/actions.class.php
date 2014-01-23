<?php

/**
 * cinfo actions.
 *
 * @package    helpdesk
 * @subpackage cinfo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cinfoActions extends sfActions
{
 /* public function executeIndex(sfWebRequest $request)
  {
    $this->clients = Doctrine_Core::getTable('client')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new clientForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new clientForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }                              */

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($client = Doctrine_Core::getTable('client')->find(array($request->getParameter('id'))), sprintf('Object client does not exist (%s).', $request->getParameter('id')));
    $this->form = new clientInfoForm($client);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($client = Doctrine_Core::getTable('client')->find(array($request->getParameter('id'))), sprintf('Object client does not exist (%s).', $request->getParameter('id')));
    $this->form = new clientInfoForm($client);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

/*  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($client = Doctrine_Core::getTable('client')->find(array($request->getParameter('id'))), sprintf('Object client does not exist (%s).', $request->getParameter('id')));
    $client->delete();

    $this->redirect('cinfo/index');
  }*/

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $client = $form->save();

      $this->redirect('client/edit?id='.$client->getUserId());
    }
  }
}
