<?php

/**
 * ModelContactTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ModelContactTable extends PluginModelContactTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object ModelContactTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ModelContact');
    }
}