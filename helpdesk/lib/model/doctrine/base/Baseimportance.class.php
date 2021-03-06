<?php

/**
 * Baseimportance
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $color
 * @property integer $duration
 * @property Doctrine_Collection $Contract
 * @property Doctrine_Collection $organization_importance
 * @property Doctrine_Collection $contract_importance
 * 
 * @method integer             getId()                      Returns the current record's "id" value
 * @method string              getName()                    Returns the current record's "name" value
 * @method string              getColor()                   Returns the current record's "color" value
 * @method integer             getDuration()                Returns the current record's "duration" value
 * @method Doctrine_Collection getContract()                Returns the current record's "Contract" collection
 * @method Doctrine_Collection getOrganizationImportance()  Returns the current record's "organization_importance" collection
 * @method Doctrine_Collection getContractImportance()      Returns the current record's "contract_importance" collection
 * @method importance          setId()                      Sets the current record's "id" value
 * @method importance          setName()                    Sets the current record's "name" value
 * @method importance          setColor()                   Sets the current record's "color" value
 * @method importance          setDuration()                Sets the current record's "duration" value
 * @method importance          setContract()                Sets the current record's "Contract" collection
 * @method importance          setOrganizationImportance()  Sets the current record's "organization_importance" collection
 * @method importance          setContractImportance()      Sets the current record's "contract_importance" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baseimportance extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('importance');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('color', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('duration', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('contract as Contract', array(
             'refClass' => 'contract_importance',
             'local' => 'importance_id',
             'foreign' => 'contract_id'));

        $this->hasMany('organization_importance', array(
             'local' => 'id',
             'foreign' => 'importance_id'));

        $this->hasMany('contract_importance', array(
             'local' => 'id',
             'foreign' => 'importance_id'));
    }
}