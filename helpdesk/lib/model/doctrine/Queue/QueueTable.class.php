<?php

/**
 * QueueTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class QueueTable extends PluginQueueTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object QueueTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Queue');
    }
}