<?php

class ManagersActivity
{
  static public function getResults($params)
  {
    $fromDate = $params['date_range']['from']['year'].'-'.$params['date_range']['from']['month'].'-'.$params['date_range']['from']['day'].' 0:0:0';
    $toDate = $params['date_range']['to']['year'].'-'.$params['date_range']['to']['month'].'-'.$params['date_range']['to']['day'].' 23:59:59';

    $q = Doctrine::getTable('HandlingMessage')
      ->createQuery('hm')
      ->where('hm.createdate >= ?', $fromDate)
      ->addWhere('hm.createdate <= ?', $toDate)
      ->leftJoin('hm.User user')
      ->execute();

    if (!sizeof($q))
    {
      return array();
    }

    $types = HandlingMEssageType::getList();

    $result = array();

    foreach ($q as $handlingMessage)
    {
      if (!isset ( $result[$handlingMessage->getUserId()] ))
      {
        $result[$handlingMessage->getUserId()] = array();
        $result[$handlingMessage->getUserId()]['user'] = $handlingMessage->getUser();
      }

      $current = 0;

      if (isset( $result[$handlingMessage->getUserId()][$handlingMessage->getTypeId()] ))
      {
        $current = $result[$handlingMessage->getUserId()][$handlingMessage->getTypeId()];
      }

      $result[$handlingMessage->getUserId()][$handlingMessage->getTypeId()] = $current + 1;
    }

    return $result;
  }
}