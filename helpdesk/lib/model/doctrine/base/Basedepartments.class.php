<?php

/**
 * Basedepartments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $mpk
 * @property string $name
 * @property string $fullname
 * @property integer $city_id
 * @property string $address
 * @property integer $contract_id
 * @property integer $organization_id
 * @property float $square
 * @property boolean $isdeleted
 * @property string $added_field
 * @property integer $status_id
 * @property date $status_date
 * @property integer $departments_type_id
 * @property string $description
 * @property string $coordinates
 * @property city $City
 * @property contract $contract
 * @property organization $Organization
 * @property Doctrine_Collection $Client
 * @property Doctrine_Collection $Stuff
 * @property DepartmentsType $DepartmentsType
 * @property DepartmentsStatus $Status
 * @property Doctrine_Collection $DogovorDepartment
 * @property Doctrine_Collection $DepartmentPeople
 * @property Doctrine_Collection $DepartmentMpk
 * @property Doctrine_Collection $Groupclaim
 * @property Doctrine_Collection $GroupclaimDepartments
 * @property Doctrine_Collection $Claim
 * @property Doctrine_Collection $ClientDepartments
 * @property Doctrine_Collection $StuffDepartments
 * @property Doctrine_Collection $TechnicalParamDepartments
 * 
 * @method integer             getId()                        Returns the current record's "id" value
 * @method string              getMpk()                       Returns the current record's "mpk" value
 * @method string              getName()                      Returns the current record's "name" value
 * @method string              getFullname()                  Returns the current record's "fullname" value
 * @method integer             getCityId()                    Returns the current record's "city_id" value
 * @method string              getAddress()                   Returns the current record's "address" value
 * @method integer             getContractId()                Returns the current record's "contract_id" value
 * @method integer             getOrganizationId()            Returns the current record's "organization_id" value
 * @method float               getSquare()                    Returns the current record's "square" value
 * @method boolean             getIsdeleted()                 Returns the current record's "isdeleted" value
 * @method string              getAddedField()                Returns the current record's "added_field" value
 * @method integer             getStatusId()                  Returns the current record's "status_id" value
 * @method date                getStatusDate()                Returns the current record's "status_date" value
 * @method integer             getDepartmentsTypeId()         Returns the current record's "departments_type_id" value
 * @method string              getDescription()               Returns the current record's "description" value
 * @method string              getCoordinates()               Returns the current record's "coordinates" value
 * @method city                getCity()                      Returns the current record's "City" value
 * @method contract            getContract()                  Returns the current record's "contract" value
 * @method organization        getOrganization()              Returns the current record's "Organization" value
 * @method Doctrine_Collection getClient()                    Returns the current record's "Client" collection
 * @method Doctrine_Collection getStuff()                     Returns the current record's "Stuff" collection
 * @method DepartmentsType     getDepartmentsType()           Returns the current record's "DepartmentsType" value
 * @method DepartmentsStatus   getStatus()                    Returns the current record's "Status" value
 * @method Doctrine_Collection getDogovorDepartment()         Returns the current record's "DogovorDepartment" collection
 * @method Doctrine_Collection getDepartmentPeople()          Returns the current record's "DepartmentPeople" collection
 * @method Doctrine_Collection getDepartmentMpk()             Returns the current record's "DepartmentMpk" collection
 * @method Doctrine_Collection getGroupclaim()                Returns the current record's "Groupclaim" collection
 * @method Doctrine_Collection getGroupclaimDepartments()     Returns the current record's "GroupclaimDepartments" collection
 * @method Doctrine_Collection getClaim()                     Returns the current record's "Claim" collection
 * @method Doctrine_Collection getClientDepartments()         Returns the current record's "ClientDepartments" collection
 * @method Doctrine_Collection getStuffDepartments()          Returns the current record's "StuffDepartments" collection
 * @method Doctrine_Collection getTechnicalParamDepartments() Returns the current record's "TechnicalParamDepartments" collection
 * @method departments         setId()                        Sets the current record's "id" value
 * @method departments         setMpk()                       Sets the current record's "mpk" value
 * @method departments         setName()                      Sets the current record's "name" value
 * @method departments         setFullname()                  Sets the current record's "fullname" value
 * @method departments         setCityId()                    Sets the current record's "city_id" value
 * @method departments         setAddress()                   Sets the current record's "address" value
 * @method departments         setContractId()                Sets the current record's "contract_id" value
 * @method departments         setOrganizationId()            Sets the current record's "organization_id" value
 * @method departments         setSquare()                    Sets the current record's "square" value
 * @method departments         setIsdeleted()                 Sets the current record's "isdeleted" value
 * @method departments         setAddedField()                Sets the current record's "added_field" value
 * @method departments         setStatusId()                  Sets the current record's "status_id" value
 * @method departments         setStatusDate()                Sets the current record's "status_date" value
 * @method departments         setDepartmentsTypeId()         Sets the current record's "departments_type_id" value
 * @method departments         setDescription()               Sets the current record's "description" value
 * @method departments         setCoordinates()               Sets the current record's "coordinates" value
 * @method departments         setCity()                      Sets the current record's "City" value
 * @method departments         setContract()                  Sets the current record's "contract" value
 * @method departments         setOrganization()              Sets the current record's "Organization" value
 * @method departments         setClient()                    Sets the current record's "Client" collection
 * @method departments         setStuff()                     Sets the current record's "Stuff" collection
 * @method departments         setDepartmentsType()           Sets the current record's "DepartmentsType" value
 * @method departments         setStatus()                    Sets the current record's "Status" value
 * @method departments         setDogovorDepartment()         Sets the current record's "DogovorDepartment" collection
 * @method departments         setDepartmentPeople()          Sets the current record's "DepartmentPeople" collection
 * @method departments         setDepartmentMpk()             Sets the current record's "DepartmentMpk" collection
 * @method departments         setGroupclaim()                Sets the current record's "Groupclaim" collection
 * @method departments         setGroupclaimDepartments()     Sets the current record's "GroupclaimDepartments" collection
 * @method departments         setClaim()                     Sets the current record's "Claim" collection
 * @method departments         setClientDepartments()         Sets the current record's "ClientDepartments" collection
 * @method departments         setStuffDepartments()          Sets the current record's "StuffDepartments" collection
 * @method departments         setTechnicalParamDepartments() Sets the current record's "TechnicalParamDepartments" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basedepartments extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('departments');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('mpk', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('fullname', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('city_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('contract_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('organization_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('square', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('isdeleted', 'boolean', null, array(
             'default' => false,
             'type' => 'boolean',
             ));
        $this->hasColumn('added_field', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('status_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('status_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('departments_type_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('coordinates', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('city as City', array(
             'local' => 'city_id',
             'foreign' => 'id'));

        $this->hasOne('contract', array(
             'local' => 'contract_id',
             'foreign' => 'id'));

        $this->hasOne('organization as Organization', array(
             'local' => 'organization_id',
             'foreign' => 'id'));

        $this->hasMany('client as Client', array(
             'refClass' => 'client_departments',
             'local' => 'departments_id',
             'foreign' => 'client_id'));

        $this->hasMany('stuff as Stuff', array(
             'refClass' => 'stuff_departments',
             'local' => 'departments_id',
             'foreign' => 'stuff_id'));

        $this->hasOne('DepartmentsType', array(
             'local' => 'departments_type_id',
             'foreign' => 'id'));

        $this->hasOne('DepartmentsStatus as Status', array(
             'local' => 'status_id',
             'foreign' => 'id'));

        $this->hasMany('DogovorDepartment', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $this->hasMany('DepartmentPeople', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $this->hasMany('Mpk as DepartmentMpk', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $this->hasMany('Groupclaim', array(
             'refClass' => 'GroupclaimDepartments',
             'local' => 'departments_id',
             'foreign' => 'groupclaim_id'));

        $this->hasMany('GroupclaimDepartments', array(
             'local' => 'id',
             'foreign' => 'departments_id'));

        $this->hasMany('claim as Claim', array(
             'local' => 'id',
             'foreign' => 'departments_id'));

        $this->hasMany('client_departments as ClientDepartments', array(
             'local' => 'id',
             'foreign' => 'departments_id'));

        $this->hasMany('stuff_departments as StuffDepartments', array(
             'local' => 'id',
             'foreign' => 'departments_id'));

        $this->hasMany('TechnicalParamDepartments', array(
             'local' => 'id',
             'foreign' => 'department_id'));
    }
}