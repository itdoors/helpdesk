<?php

/**
 * groupclaim actions.
 *
 * @package    helpdesk
 * @subpackage groupclaim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class finance_recountActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $finance_claims = Doctrine_Core::getTable('finance_claim')
      ->createQuery('a')
      ->execute();
    foreach($finance_claims as $claim)
    {
       $claim->refreshFinanceClaim(); 
    }
  }


}
