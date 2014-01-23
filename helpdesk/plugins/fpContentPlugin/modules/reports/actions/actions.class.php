<?php

/**
 * claim actions.
 *
 * @package    helpdesk
 * @subpackage claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportsActions extends sfActions
{
  public function preExecute()
  {
     $this->app = ucfirst(sfContext::getInstance()->getConfiguration()->getApplication());
     $this->form_name = "reports".$this->app."Form";
  }
    
  public function executeDone(sfWebRequest $request)
  {
     $form = new $this->form_name();    
     $paramets_holder = $request->getParameter($form->getName());
     $form->bind($paramets_holder,$request->getFiles($form->getName()));
     $this->form = $form;
     if ($form->isValid())
     {
        $results_function = "getResultsFor".$this->app;
        $results_filters_function = "getFiltersResultsFor".$this->app;
        $this->results = reports::$results_function($paramets_holder);
        //$this->filters_data = reports::$results_filters_function($paramets_holder);
        $this->setTemplate($this->app);
     } 
     else $this->setTemplate('index');
  }
  public function executeIndex(sfWebRequest $request)
  {
      $this->form = new $this->form_name();
  }   
}
