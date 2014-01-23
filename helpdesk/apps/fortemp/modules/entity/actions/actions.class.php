<?php

/**
 * entity actions.
 *
 * @package    helpdesk
 * @subpackage entity
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entityActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    set_time_limit(0);

    $offset = 0;
    $limit = 100;

    $startTime = time();

    for ($offset = 0; $offset <= 100000; $offset += $limit)
    {
      $this->recount($offset, $limit);
    }

    $endTime = time();

    $totalTime = $endTime - $startTime;

    $this->totalTime = $totalTime/3600;
  }

  public function recount($offset, $limit)
  {
    $grafikTimes = Doctrine::getTable('GrafikTime')
      ->createQuery('gt')
      ->offset($offset)
      ->limit($limit)
      ->execute();

    foreach ($grafikTimes as $grafikTime )
    {
      $grafikTime->recount();
    }
  }
}
