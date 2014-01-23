<?php

/**
 * sinfo actions.
 *
 * @package    helpdesk
 * @subpackage sinfo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sinfoActions extends sfActions
{
/*  public function executeIndex(sfWebRequest $request)
  {
    $this->stuffs = Doctrine_Core::getTable('stuff')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new stuffForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new stuffForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  } */

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($stuff = Doctrine_Core::getTable('stuff')->find(array($request->getParameter('id'))), sprintf('Object stuff does not exist (%s).', $request->getParameter('id')));
    $this->form = new stuffInfoForm($stuff);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($stuff = Doctrine_Core::getTable('stuff')->find(array($request->getParameter('id'))), sprintf('Object stuff does not exist (%s).', $request->getParameter('id')));
    $this->form = new stuffInfoForm($stuff);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

/*  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($stuff = Doctrine_Core::getTable('stuff')->find(array($request->getParameter('id'))), sprintf('Object stuff does not exist (%s).', $request->getParameter('id')));
    $stuff->delete();

    $this->redirect('sinfo/index');
  }    */

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $stuff = $form->save();

      $this->redirect('stuff/edit?id='.$stuff->getUserId());
    }
  }
}
