<?php

/**
 * Tenderlinks
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    tenderfinder
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Tenderlinks extends BaseTenderlinks
{
    static function getAllTenderlinks()
    {
        return Doctrine::getTable('Tenderlinks')
        ->createQuery('tl')
        ->execute();
    }
}