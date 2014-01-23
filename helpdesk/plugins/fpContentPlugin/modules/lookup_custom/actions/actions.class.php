<?php

/**
 * lookup_custom actions.
 *
 * @package    helpdesk
 * @subpackage lookup_custom
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lookup_customActions extends sfActions
{
  public function executeRefresh_list(sfWebRequest $request)
  {
    $lukey = $request->getParameter('lukey');

    return $this->renderComponent('lookup_custom', 'list', array('lukey' => $lukey));
  }
}
