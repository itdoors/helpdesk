<?php

/**
 * Basecompanystructure
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $mpk
 * @property string $address
 * @property string $phone
 * @property integer $stuff_id
 * @property companystructure $companystructure
 * @property Doctrine_Collection $Region
 * @property stuff $Stuff
 * @property Doctrine_Collection $Dogovor
 * @property Doctrine_Collection $CompanystructureRegion
 * 
 * @method integer             getId()                     Returns the current record's "id" value
 * @method integer             getParentId()               Returns the current record's "parent_id" value
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getMpk()                    Returns the current record's "mpk" value
 * @method string              getAddress()                Returns the current record's "address" value
 * @method string              getPhone()                  Returns the current record's "phone" value
 * @method integer             getStuffId()                Returns the current record's "stuff_id" value
 * @method companystructure    getCompanystructure()       Returns the current record's "companystructure" value
 * @method Doctrine_Collection getRegion()                 Returns the current record's "Region" collection
 * @method stuff               getStuff()                  Returns the current record's "Stuff" value
 * @method Doctrine_Collection getDogovor()                Returns the current record's "Dogovor" collection
 * @method Doctrine_Collection getCompanystructureRegion() Returns the current record's "CompanystructureRegion" collection
 * @method companystructure    setId()                     Sets the current record's "id" value
 * @method companystructure    setParentId()               Sets the current record's "parent_id" value
 * @method companystructure    setName()                   Sets the current record's "name" value
 * @method companystructure    setMpk()                    Sets the current record's "mpk" value
 * @method companystructure    setAddress()                Sets the current record's "address" value
 * @method companystructure    setPhone()                  Sets the current record's "phone" value
 * @method companystructure    setStuffId()                Sets the current record's "stuff_id" value
 * @method companystructure    setCompanystructure()       Sets the current record's "companystructure" value
 * @method companystructure    setRegion()                 Sets the current record's "Region" collection
 * @method companystructure    setStuff()                  Sets the current record's "Stuff" value
 * @method companystructure    setDogovor()                Sets the current record's "Dogovor" collection
 * @method companystructure    setCompanystructureRegion() Sets the current record's "CompanystructureRegion" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basecompanystructure extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('companystructure');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('parent_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('mpk', 'string', 10, array(
             'unique' => true,
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('phone', 'string', 12, array(
             'type' => 'string',
             'length' => 12,
             ));
        $this->hasColumn('stuff_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('companystructure', array(
             'local' => 'parent_id',
             'foreign' => 'id'));

        $this->hasMany('region as Region', array(
             'refClass' => 'companystructure_region',
             'local' => 'companystructure_id',
             'foreign' => 'region_id'));

        $this->hasOne('stuff as Stuff', array(
             'local' => 'stuff_id',
             'foreign' => 'id'));

        $this->hasMany('Dogovor', array(
             'local' => 'id',
             'foreign' => 'companystructure_id'));

        $this->hasMany('companystructure_region as CompanystructureRegion', array(
             'local' => 'id',
             'foreign' => 'companystructure_id'));
    }
}