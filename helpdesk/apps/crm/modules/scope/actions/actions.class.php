<?php

/**
 * scope actions.
 *
 * @package    helpdesk
 * @subpackage scope
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class scopeActions extends sfActions
{
  protected $lukey = 'scope';

  public function executeIndex(sfWebRequest $request)
  {
    $this->redirectUnless($this->getUser()->hasCredential('crmadmin'), 'organization');
  }
}
