<?php

/**
 * BaseHistory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $model_name
 * @property integer $model_id
 * @property integer $user_id
 * @property string $field_name
 * @property string $more
 * @property string $old_value
 * @property string $value
 * @property timestamp $createdatetime
 * @property sfGuardUser $User
 * 
 * @method integer     getId()             Returns the current record's "id" value
 * @method string      getModelName()      Returns the current record's "model_name" value
 * @method integer     getModelId()        Returns the current record's "model_id" value
 * @method integer     getUserId()         Returns the current record's "user_id" value
 * @method string      getFieldName()      Returns the current record's "field_name" value
 * @method string      getMore()           Returns the current record's "more" value
 * @method string      getOldValue()       Returns the current record's "old_value" value
 * @method string      getValue()          Returns the current record's "value" value
 * @method timestamp   getCreatedatetime() Returns the current record's "createdatetime" value
 * @method sfGuardUser getUser()           Returns the current record's "User" value
 * @method History     setId()             Sets the current record's "id" value
 * @method History     setModelName()      Sets the current record's "model_name" value
 * @method History     setModelId()        Sets the current record's "model_id" value
 * @method History     setUserId()         Sets the current record's "user_id" value
 * @method History     setFieldName()      Sets the current record's "field_name" value
 * @method History     setMore()           Sets the current record's "more" value
 * @method History     setOldValue()       Sets the current record's "old_value" value
 * @method History     setValue()          Sets the current record's "value" value
 * @method History     setCreatedatetime() Sets the current record's "createdatetime" value
 * @method History     setUser()           Sets the current record's "User" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHistory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('history');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('model_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('model_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('field_name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('more', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('old_value', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('value', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('createdatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}