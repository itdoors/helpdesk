<?php

/**
 * HandlingMessageTypeTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class HandlingMessageTypeTable extends PluginHandlingMessageTypeTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object HandlingMessageTypeTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('HandlingMessageType');
    }
}