<?php

/**
 * regionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class regionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object regionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('region');
    }

  public function getRegionOrderByName()
  {
    return Doctrine::getTable('region')
      ->createQuery('r')
      ->orderBy('r.name ASC')
      ->execute();
  }
}