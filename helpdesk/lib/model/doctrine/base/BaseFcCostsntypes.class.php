<?php

/**
 * BaseFcCostsntypes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $FcCostsn
 * 
 * @method integer             getId()       Returns the current record's "id" value
 * @method string              getName()     Returns the current record's "name" value
 * @method Doctrine_Collection getFcCostsn() Returns the current record's "FcCostsn" collection
 * @method FcCostsntypes       setId()       Sets the current record's "id" value
 * @method FcCostsntypes       setName()     Sets the current record's "name" value
 * @method FcCostsntypes       setFcCostsn() Sets the current record's "FcCostsn" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFcCostsntypes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('fc_costsntypes');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 150, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 150,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('FcCostsn', array(
             'local' => 'id',
             'foreign' => 'fc_costsn_types_id'));
    }
}