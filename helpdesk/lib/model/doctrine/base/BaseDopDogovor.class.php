<?php

/**
 * BaseDopDogovor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $dogovor_id
 * @property string $dop_dogovor_type
 * @property string $number
 * @property timestamp $startdatetime
 * @property timestamp $activedatetime
 * @property string $subject
 * @property boolean $is_active
 * @property float $total
 * @property string $filepath
 * @property integer $user_id
 * @property integer $stuff_id
 * @property Dogovor $Dogovor
 * @property sfGuardUser $User
 * @property stuff $Stuff
 * @property Doctrine_Collection $DogovorDepartment
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method integer             getDogovorId()         Returns the current record's "dogovor_id" value
 * @method string              getDopDogovorType()    Returns the current record's "dop_dogovor_type" value
 * @method string              getNumber()            Returns the current record's "number" value
 * @method timestamp           getStartdatetime()     Returns the current record's "startdatetime" value
 * @method timestamp           getActivedatetime()    Returns the current record's "activedatetime" value
 * @method string              getSubject()           Returns the current record's "subject" value
 * @method boolean             getIsActive()          Returns the current record's "is_active" value
 * @method float               getTotal()             Returns the current record's "total" value
 * @method string              getFilepath()          Returns the current record's "filepath" value
 * @method integer             getUserId()            Returns the current record's "user_id" value
 * @method integer             getStuffId()           Returns the current record's "stuff_id" value
 * @method Dogovor             getDogovor()           Returns the current record's "Dogovor" value
 * @method sfGuardUser         getUser()              Returns the current record's "User" value
 * @method stuff               getStuff()             Returns the current record's "Stuff" value
 * @method Doctrine_Collection getDogovorDepartment() Returns the current record's "DogovorDepartment" collection
 * @method DopDogovor          setId()                Sets the current record's "id" value
 * @method DopDogovor          setDogovorId()         Sets the current record's "dogovor_id" value
 * @method DopDogovor          setDopDogovorType()    Sets the current record's "dop_dogovor_type" value
 * @method DopDogovor          setNumber()            Sets the current record's "number" value
 * @method DopDogovor          setStartdatetime()     Sets the current record's "startdatetime" value
 * @method DopDogovor          setActivedatetime()    Sets the current record's "activedatetime" value
 * @method DopDogovor          setSubject()           Sets the current record's "subject" value
 * @method DopDogovor          setIsActive()          Sets the current record's "is_active" value
 * @method DopDogovor          setTotal()             Sets the current record's "total" value
 * @method DopDogovor          setFilepath()          Sets the current record's "filepath" value
 * @method DopDogovor          setUserId()            Sets the current record's "user_id" value
 * @method DopDogovor          setStuffId()           Sets the current record's "stuff_id" value
 * @method DopDogovor          setDogovor()           Sets the current record's "Dogovor" value
 * @method DopDogovor          setUser()              Sets the current record's "User" value
 * @method DopDogovor          setStuff()             Sets the current record's "Stuff" value
 * @method DopDogovor          setDogovorDepartment() Sets the current record's "DogovorDepartment" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDopDogovor extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('dop_dogovor');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('dogovor_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('dop_dogovor_type', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('number', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('startdatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('activedatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('subject', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('total', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('filepath', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('stuff_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dogovor', array(
             'local' => 'dogovor_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('stuff as Stuff', array(
             'local' => 'stuff_id',
             'foreign' => 'id'));

        $this->hasMany('DogovorDepartment', array(
             'local' => 'id',
             'foreign' => 'dop_dogovor_id'));
    }
}