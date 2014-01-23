<?php

class lookup_customComponents extends sfComponents
{
  public function executeCrud()
  {
  }

  public function executeList()
  {
    $this->lookups = Doctrine_Core::getTable('lookup')
      ->createQuery('l')
      ->where('l.lukey = ? ', $this->lukey)
      ->execute();
  }
}

