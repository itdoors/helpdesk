<?php

/**
 * switchapp actions.
 *
 * @package    helpdesk
 * @subpackage switchapp
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class switchappActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeStuff(sfWebRequest $request)
  {
     $this->redirect('/stuff.php');
  }
  public function executeKurator(sfWebRequest $request)
  {
     $this->redirect('/kurator.php');
  }
}
