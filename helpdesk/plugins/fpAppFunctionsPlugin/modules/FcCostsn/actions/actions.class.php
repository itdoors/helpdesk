<?php

/**
 * FcCostsn actions.
 *
 * @package    helpdesk
 * @subpackage FcCostsn
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FcCostsnActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
    {
        $finance_claim_id = $request->getParameter('finance_claim_id');
        if (!$finance_claim_id) return $this->renderText('Direct access');
        
        $finance_claim = Doctrine::getTable('finance_claim')->find($finance_claim_id);
        
        $claim = Doctrine::getTable('claim')->find($finance_claim->getClaimId());
        
        if ($claim->getIsclosedstuff() && !$this->getUser()->hasCredential('dispatcher'))
        {
          return sfView::NONE;
        }
        
        $this->fc_costsns = Doctrine::getTable('FcCostsn')->getFcCostsnByFinanceId($finance_claim_id);
        
        return $this->renderPartial('show', array('fc_costsns'=>$this->fc_costsns, 'finance_claim_id' =>$finance_claim_id));  
    } else return $this->renderText('Direct access');
  }
  
  public function executeRefresh_costsn_list(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
    {
      $finance_claim_id = $request->getParameter('finance_claim_id');
      if (!$finance_claim_id) return 'Direct access';
      $this->fc_costsns = Doctrine::getTable('FcCostsn')->getFcCostsnByFinanceId($finance_claim_id);
      return $this->renderPartial('fc_costsn_list', array('fc_costsns'=>$this->fc_costsns, 'finance_claim_id' =>$finance_claim_id));   
    } else return $this->renderText('Direct access');
  }

/*  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FcCostsnForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FcCostsnForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($fc_costsn = Doctrine_Core::getTable('FcCostsn')->find(array($request->getParameter('id'))), sprintf('Object fc_costsn does not exist (%s).', $request->getParameter('id')));
    $this->form = new FcCostsnForm($fc_costsn);
    return $this->renderPartial('form', array('form'=>$this->form));
  } */                                        

/*  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($fc_costsn = Doctrine_Core::getTable('FcCostsn')->find(array($request->getParameter('id'))), sprintf('Object fc_costsn does not exist (%s).', $request->getParameter('id')));
    $this->form = new FcCostsnForm($fc_costsn);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }*/

  public function executeDelete(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
    {
        $this->forward404Unless($fc_costsn = Doctrine_Core::getTable('FcCostsn')->find(array($request->getParameter('id'))), sprintf('Object fc_costsn does not exist (%s).', $request->getParameter('id')));
        $fc_costsn->delete();
        return true;
    } else return $this->renderText('Direct access');
    //$this->redirect('FcCostsn/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $fc_costsn = $form->save();

      $this->redirect('FcCostsn/edit?id='.$fc_costsn->getId());
    }
  }
}
