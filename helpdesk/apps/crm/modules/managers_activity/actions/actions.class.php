<?php

/**
 * managers_activity actions.
 *
 * @package    helpdesk
 * @subpackage managers_activity
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class managers_activityActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function preExecute()
  {
    $isCrmAdmin = $this->getUser()->hasCredential('crmadmin');

    $this->redirectUnless($isCrmAdmin, 'handling');

    $this->form = new ManagersActivityDateRangeForm();
  }

  public function executeIndex(sfWebRequest $request)
  {

  }

  public function executeDone(sfWebRequest $request)
  {
    $params = $request->getParameter($this->form->getName());

    $this->form->bind($params);

    if ($this->form->isValid())
    {
      $this->results = ManagersActivity::getResults($params);

      $this->types = HandlingMessageType::getList();
    }
    else
    {
      $this->setTemplate('index');
    }

  }
}
