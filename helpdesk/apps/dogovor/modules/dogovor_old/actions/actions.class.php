<?php

/**
 * dogovor actions.
 *
 * @package    helpdesk
 * @subpackage dogovor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dogovorActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->dogovors = Doctrine_Core::getTable('Dogovor')
      ->createQuery('a')
      ->orderBy('id DESC')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
     $this->redirectUnless($dogovor = Doctrine::getTable('Dogovor')->find($dogovor_id = $request->getParameter('id')), '@homepage');
     $this->dogovor = $dogovor;
     
     /*$this->dopdogovors = Doctrine::getTable('DopDogovor')
     ->createQuery('d')
     ->where('d.dogovor_id =?', $dogovor->getId())
     ->orderBy('d.id DESC')
     ->execute();   */
  }
  
  public function executeDopdogovors(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest() || !($dogovor_id = $request->getParameter('dogovor_id'))) return sfView::NONE;
    return $this->renderComponent('dogovor', 'dopdogovors', array('dogovor_id' => $dogovor_id));
  }
 
}
