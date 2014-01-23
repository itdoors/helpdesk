<?php

/**
 * BaseHandlingMessage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $type_id
 * @property timespamp $createdatetime
 * @property date $createdate
 * @property string $description
 * @property integer $handling_id
 * @property integer $user_id
 * @property string $filename
 * @property string $filepath
 * @property Handling $Handling
 * @property HandlingMessageType $HandlingMessageType
 * @property sfGuardUser $User
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method integer             getTypeId()              Returns the current record's "type_id" value
 * @method timespamp           getCreatedatetime()      Returns the current record's "createdatetime" value
 * @method date                getCreatedate()          Returns the current record's "createdate" value
 * @method string              getDescription()         Returns the current record's "description" value
 * @method integer             getHandlingId()          Returns the current record's "handling_id" value
 * @method integer             getUserId()              Returns the current record's "user_id" value
 * @method string              getFilename()            Returns the current record's "filename" value
 * @method string              getFilepath()            Returns the current record's "filepath" value
 * @method Handling            getHandling()            Returns the current record's "Handling" value
 * @method HandlingMessageType getHandlingMessageType() Returns the current record's "HandlingMessageType" value
 * @method sfGuardUser         getUser()                Returns the current record's "User" value
 * @method HandlingMessage     setId()                  Sets the current record's "id" value
 * @method HandlingMessage     setTypeId()              Sets the current record's "type_id" value
 * @method HandlingMessage     setCreatedatetime()      Sets the current record's "createdatetime" value
 * @method HandlingMessage     setCreatedate()          Sets the current record's "createdate" value
 * @method HandlingMessage     setDescription()         Sets the current record's "description" value
 * @method HandlingMessage     setHandlingId()          Sets the current record's "handling_id" value
 * @method HandlingMessage     setUserId()              Sets the current record's "user_id" value
 * @method HandlingMessage     setFilename()            Sets the current record's "filename" value
 * @method HandlingMessage     setFilepath()            Sets the current record's "filepath" value
 * @method HandlingMessage     setHandling()            Sets the current record's "Handling" value
 * @method HandlingMessage     setHandlingMessageType() Sets the current record's "HandlingMessageType" value
 * @method HandlingMessage     setUser()                Sets the current record's "User" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHandlingMessage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('handling_message');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('type_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('createdatetime', 'timespamp', null, array(
             'type' => 'timespamp',
             ));
        $this->hasColumn('createdate', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('handling_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('filename', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('filepath', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Handling', array(
             'local' => 'handling_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('HandlingMessageType', array(
             'local' => 'type_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}