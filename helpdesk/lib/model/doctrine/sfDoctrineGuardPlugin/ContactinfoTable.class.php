<?php

/**
 * ContactinfoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ContactinfoTable extends PluginContactinfoTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object ContactinfoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Contactinfo');
    }
}