<?php

/**
 * QueueLogTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class QueueLogTable extends PluginQueueLogTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object QueueLogTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('QueueLog');
    }
}