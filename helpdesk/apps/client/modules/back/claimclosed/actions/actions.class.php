<?php

/**
 * claim actions.
 *
 * @package    helpdesk
 * @subpackage claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimclosedActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {

    $this->claimsclosed = Doctrine_Core::getTable('claim')->getClosedClaimsClient();

  }
}
