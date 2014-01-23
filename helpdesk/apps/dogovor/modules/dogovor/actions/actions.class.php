<?php

/**
 * dogovor_admin actions.
 *
 * @package    helpdesk
 * @subpackage dogovor_admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dogovorActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->dogovors = Doctrine_Core::getTable('Dogovor')->getAllDogovors();
  }

  public function executeProlongation(sfWebRequest $request)
  {
    $this->dogovors = Doctrine_Core::getTable('Dogovor')->getProlongationDogovors();

    $this->setTemplate('index');
  }

  public function executeNew(sfWebRequest $request)
  {
    if (!$this->getUser()->hasCredential('dogovoradmin')) $this->redirect('dogovor/index');
    $this->form = new DogovorForm();
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DogovorForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($dogovor = Doctrine_Core::getTable('Dogovor')->find(array($request->getParameter('id'))), sprintf('Object dogovor does not exist (%s).', $request->getParameter('id')));
    $this->form = new DogovorForm($dogovor);
    $this->setTemplate('edit');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($dogovor = Doctrine_Core::getTable('Dogovor')->find(array($request->getParameter('id'))), sprintf('Object dogovor does not exist (%s).', $request->getParameter('id')));
    $this->form = new DogovorForm($dogovor);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($dogovor = Doctrine_Core::getTable('Dogovor')->find(array($request->getParameter('id'))), sprintf('Object dogovor does not exist (%s).', $request->getParameter('id')));
    $dogovor->delete();

    $this->redirect('dogovor/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $dogovor = $form->save();

      $this->redirect('dogovor/edit?id='.$dogovor->getId());
    }
  }
  
  public function executeDopdogovors(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest() || !($dogovor_id = $request->getParameter('dogovor_id'))) return sfView::NONE;
    return $this->renderComponent('dogovor', 'dopdogovors', array('dogovor_id' => $dogovor_id));
  }
  
  public function executeDepartments_list(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest() || !($dogovor_id = $request->getParameter('dogovor_id'))) return sfView::NONE;
    return $this->renderComponent('dogovor', 'departments_list', array('dogovor_id' => $dogovor_id));
  }
  
  public function executeAutocomplite(sfWebRequest $request)
  {
    $search_field_value = $request->getParameter('q');
    $results = organizationTable::getSearchResultsAutocomplite($search_field_value); 
    if ($request->isXmlHttpRequest()) 
    {
        return $this->renderText(json_encode($results));
    }  
  }

  public function executeIndexexcel(sfWebRequest $request)
  {
    $this->dogovors = Doctrine_Core::getTable('Dogovor')->getAllActiveDogovors();

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->getResponse()->setContent('application/vnd.ms-excel; charset=windows-1251');
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=dogovors-'.time().'.xls');
    $this->getResponse()->setHttpHeader('Pragma','no-cache');
    $this->getResponse()->setHttpHeader('Expires','0');
  }

  public function executeAdd_handling(sfWebRequest $request)
  {
    $handlingId = $request->getParameter('handling_id');
    $dogovorId = $request->getParameter('dogovor_id');
    $organizationId = $request->getParameter('organization_id');

    $DogovorHandling = new DogovorHandling();
    $DogovorHandling->setDogovorId($dogovorId);
    $DogovorHandling->setHandlingId($handlingId);
    $DogovorHandling->save();

    return $this->renderComponent('dogovor', 'handling_added_list',  array(
      'dogovorId' => $dogovorId,
      'organizationId' => $organizationId));
  }

  public function executeUpdate_handling_for_add(sfWebRequest $request)
  {
    $dogovorId = $request->getParameter('dogovor_id');
    $organizationId = $request->getParameter('organization_id');

    return $this->renderComponent('dogovor', 'handling_for_add_list',  array(
      'dogovorId' => $dogovorId,
      'organizationId' => $organizationId));
  }
}
