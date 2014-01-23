<?php

require_once dirname(__FILE__).'/../lib/BaseF_finance_claimActions.class.php';

/**
 * F_finance_claim actions.
 * 
 * @package    fpAppFunctionsPlugin
 * @subpackage F_finance_claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class F_finance_claimActions extends BaseF_finance_claimActions
{
    public function executeRefresh_profitability(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      { 
         $finance_claim = Doctrine::getTable('finance_claim')->find($request->getParameter('id'));
         $finance_claim->refreshFinanceClaim();
         return $this->renderPartial('profitability_response', array('finance_claim'=>$finance_claim)); 
      } 
      return $this->renderText('Direct access');
    }
    
    
    public function executeRefresh_total_finance(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      { 
         $claim = Doctrine::getTable('claim')->find($request->getParameter('id'));
         $total_function = $request->getParameter('total_function');
         return $this->renderPartial('total_finance', array('claim'=>$claim, 'total_function'=>$total_function)); 
      } 
     return $this->renderText('Direct access');
    }
    
    public function executeRefresh_costsn(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      { 
         return $this->renderPartial('total_costsn', array('finance_claim_id'=>$request->getParameter('finance_claim_id'))); 
      } 
     return $this->renderText('Direct access');
    }
    

    
    
    
    
}
