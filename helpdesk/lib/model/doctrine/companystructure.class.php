<?php

/**
 * companystructure
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class companystructure extends Basecompanystructure
{
  public function getTreeElement()
  {
    $s = '';

    if ($this->getParentId())
    {
      $s .= ' - ';
    }
    return $s.$this->getName();
  }
}