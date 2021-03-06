<?php

/**
 * BaseHandlingMoreInfoType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $handling_result_id
 * @property string $name
 * @property enum $data_type
 * @property string $enum_choices
 * @property HandlingResult $HandlingResult
 * @property Doctrine_Collection $HandlingMoreInfo
 * 
 * @method integer              getId()                 Returns the current record's "id" value
 * @method integer              getHandlingResultId()   Returns the current record's "handling_result_id" value
 * @method string               getName()               Returns the current record's "name" value
 * @method enum                 getDataType()           Returns the current record's "data_type" value
 * @method string               getEnumChoices()        Returns the current record's "enum_choices" value
 * @method HandlingResult       getHandlingResult()     Returns the current record's "HandlingResult" value
 * @method Doctrine_Collection  getHandlingMoreInfo()   Returns the current record's "HandlingMoreInfo" collection
 * @method HandlingMoreInfoType setId()                 Sets the current record's "id" value
 * @method HandlingMoreInfoType setHandlingResultId()   Sets the current record's "handling_result_id" value
 * @method HandlingMoreInfoType setName()               Sets the current record's "name" value
 * @method HandlingMoreInfoType setDataType()           Sets the current record's "data_type" value
 * @method HandlingMoreInfoType setEnumChoices()        Sets the current record's "enum_choices" value
 * @method HandlingMoreInfoType setHandlingResult()     Sets the current record's "HandlingResult" value
 * @method HandlingMoreInfoType setHandlingMoreInfo()   Sets the current record's "HandlingMoreInfo" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHandlingMoreInfoType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('handling_more_info_type');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('handling_result_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 128,
             ));
        $this->hasColumn('data_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'integer',
              1 => 'float',
              2 => 'string',
              3 => 'select',
             ),
             ));
        $this->hasColumn('enum_choices', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));


        $this->index('handling_result_id_name', array(
             'fields' => 
             array(
              0 => 'handling_result_id',
              1 => 'name',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('HandlingResult', array(
             'local' => 'handling_result_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('HandlingMoreInfo', array(
             'local' => 'id',
             'foreign' => 'handling_more_info_type_id'));
    }
}