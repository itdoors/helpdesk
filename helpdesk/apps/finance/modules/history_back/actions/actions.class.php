<?php

/**
 * history actions.
 *
 * @package    helpdesk
 * @subpackage history
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class historyActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->log_claims = Doctrine_Core::getTable('log_claim')->getAllLogClaim();
  }

  public function executeShow(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
    {
        $this->forward404Unless($log_claims = Doctrine_Core::getTable('log_claim')->getLogClaimById($request->getParameter('claimid')), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        //$log_claims = Doctrine_Core::getTable('log_claim')->getLogClaimById($request->getParameter('claimid'));
        return $this->renderPartial('history/show', array('log_claims' => $log_claims ));
    }   return $this->renderText('Direct access');
      
      
  }
  public function executeShowfinance(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
    {
        $this->forward404Unless($log_claims = Doctrine_Core::getTable('log_claim')->getLogClaimByIdFinance($request->getParameter('claimid')), sprintf('Object claim does not exist (%s).', $request->getParameter('id')));
        //$log_claims = Doctrine_Core::getTable('log_claim')->getLogClaimById($request->getParameter('claimid'));
        return $this->renderPartial('history/show', array('log_claims' => $log_claims ));
    }   return $this->renderText('Direct access');
      
      
  }
  
}
