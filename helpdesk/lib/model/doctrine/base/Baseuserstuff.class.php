<?php

/**
 * Baseuserstuff
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * 
 * @method integer   getId() Returns the current record's "id" value
 * @method userstuff setId() Sets the current record's "id" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baseuserstuff extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('userstuff');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}