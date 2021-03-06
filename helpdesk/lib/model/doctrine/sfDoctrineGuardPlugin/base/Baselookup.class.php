<?php

/**
 * Baselookup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $lukey
 * @property string $name
 * @property Doctrine_Collection $sfGuardUser
 * @property Doctrine_Collection $Stuff
 * @property Doctrine_Collection $log_claim
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getLukey()       Returns the current record's "lukey" value
 * @method string              getName()        Returns the current record's "name" value
 * @method Doctrine_Collection getSfGuardUser() Returns the current record's "sfGuardUser" collection
 * @method Doctrine_Collection getStuff()       Returns the current record's "Stuff" collection
 * @method Doctrine_Collection getLogClaim()    Returns the current record's "log_claim" collection
 * @method lookup              setId()          Sets the current record's "id" value
 * @method lookup              setLukey()       Sets the current record's "lukey" value
 * @method lookup              setName()        Sets the current record's "name" value
 * @method lookup              setSfGuardUser() Sets the current record's "sfGuardUser" collection
 * @method lookup              setStuff()       Sets the current record's "Stuff" collection
 * @method lookup              setLogClaim()    Sets the current record's "log_claim" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baselookup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('lookup');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('lukey', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('sfGuardUser', array(
             'local' => 'id',
             'foreign' => 'sex_id'));

        $this->hasMany('stuff as Stuff', array(
             'local' => 'id',
             'foreign' => 'position_id'));

        $this->hasMany('log_claim', array(
             'local' => 'id',
             'foreign' => 'action_id'));
    }
}