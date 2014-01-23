<?php

/**
 * BaseHandlingResult
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Doctrine_Collection $Handling
 * @property Doctrine_Collection $HandlingMoreInfoType
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method string              getName()                 Returns the current record's "name" value
 * @method string              getSlug()                 Returns the current record's "slug" value
 * @method Doctrine_Collection getHandling()             Returns the current record's "Handling" collection
 * @method Doctrine_Collection getHandlingMoreInfoType() Returns the current record's "HandlingMoreInfoType" collection
 * @method HandlingResult      setId()                   Sets the current record's "id" value
 * @method HandlingResult      setName()                 Sets the current record's "name" value
 * @method HandlingResult      setSlug()                 Sets the current record's "slug" value
 * @method HandlingResult      setHandling()             Sets the current record's "Handling" collection
 * @method HandlingResult      setHandlingMoreInfoType() Sets the current record's "HandlingMoreInfoType" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHandlingResult extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('handling_result');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 128,
             ));
        $this->hasColumn('slug', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Handling', array(
             'local' => 'id',
             'foreign' => 'result_id'));

        $this->hasMany('HandlingMoreInfoType', array(
             'local' => 'id',
             'foreign' => 'handling_result_id'));
    }
}