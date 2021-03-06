<?php

/**
 * Baseregion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property float $square
 * @property float $population
 * @property string $flag
 * @property Doctrine_Collection $Companystructure
 * @property Doctrine_Collection $City
 * @property Doctrine_Collection $CompanystructureRegion
 * @property Doctrine_Collection $District
 * 
 * @method integer             getId()                     Returns the current record's "id" value
 * @method string              getName()                   Returns the current record's "name" value
 * @method float               getSquare()                 Returns the current record's "square" value
 * @method float               getPopulation()             Returns the current record's "population" value
 * @method string              getFlag()                   Returns the current record's "flag" value
 * @method Doctrine_Collection getCompanystructure()       Returns the current record's "Companystructure" collection
 * @method Doctrine_Collection getCity()                   Returns the current record's "City" collection
 * @method Doctrine_Collection getCompanystructureRegion() Returns the current record's "CompanystructureRegion" collection
 * @method Doctrine_Collection getDistrict()               Returns the current record's "District" collection
 * @method region              setId()                     Sets the current record's "id" value
 * @method region              setName()                   Sets the current record's "name" value
 * @method region              setSquare()                 Sets the current record's "square" value
 * @method region              setPopulation()             Sets the current record's "population" value
 * @method region              setFlag()                   Sets the current record's "flag" value
 * @method region              setCompanystructure()       Sets the current record's "Companystructure" collection
 * @method region              setCity()                   Sets the current record's "City" collection
 * @method region              setCompanystructureRegion() Sets the current record's "CompanystructureRegion" collection
 * @method region              setDistrict()               Sets the current record's "District" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baseregion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('region');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'unique' => true,
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('square', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('population', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('flag', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('companystructure as Companystructure', array(
             'refClass' => 'companystructure_region',
             'local' => 'region_id',
             'foreign' => 'companystructure_id'));

        $this->hasMany('city as City', array(
             'local' => 'id',
             'foreign' => 'region_id'));

        $this->hasMany('companystructure_region as CompanystructureRegion', array(
             'local' => 'id',
             'foreign' => 'region_id'));

        $this->hasMany('District', array(
             'local' => 'id',
             'foreign' => 'region_id'));
    }
}