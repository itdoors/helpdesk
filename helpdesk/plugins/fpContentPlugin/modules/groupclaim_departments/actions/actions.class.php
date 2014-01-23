<?php

/**
 * groupclaim_departments actions.
 *
 * @package    helpdesk
 * @subpackage groupclaim_departments
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupclaim_departmentsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->groupclaim_departmentss = Doctrine_Core::getTable('GroupclaimDepartments')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GroupclaimDepartmentsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GroupclaimDepartmentsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($groupclaim_departments = Doctrine_Core::getTable('GroupclaimDepartments')->find(array($request->getParameter('groupclaim_id'),
$request->getParameter('departments_id'))), sprintf('Object groupclaim_departments does not exist (%s).', $request->getParameter('groupclaim_id'),
$request->getParameter('departments_id')));
    $this->form = new GroupclaimDepartmentsForm($groupclaim_departments);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($groupclaim_departments = Doctrine_Core::getTable('GroupclaimDepartments')->find(array($request->getParameter('groupclaim_id'),
$request->getParameter('departments_id'))), sprintf('Object groupclaim_departments does not exist (%s).', $request->getParameter('groupclaim_id'),
$request->getParameter('departments_id')));
    $this->form = new GroupclaimDepartmentsForm($groupclaim_departments);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($groupclaim_departments = Doctrine_Core::getTable('GroupclaimDepartments')->find(array($request->getParameter('groupclaim_id'),
$request->getParameter('departments_id'))), sprintf('Object groupclaim_departments does not exist (%s).', $request->getParameter('groupclaim_id'),
$request->getParameter('departments_id')));
    $groupclaim_departments->delete();

    $this->redirect('groupclaim_departments/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $groupclaim_departments = $form->save();

      $this->redirect('groupclaim_departments/edit?groupclaim_id='.$groupclaim_departments->getGroupclaimId().'&departments_id='.$groupclaim_departments->getDepartmentsId());
    }
  }
}
