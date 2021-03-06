<?php

/**
 * BaseDocDocumentGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property timestamp $createdatetime
 * @property integer $level
 * @property integer $user_id
 * @property integer $parent_id
 * @property boolean $isdeleted
 * @property sfGuardUser $Users
 * @property DocDocumentGroup $ParentCategory
 * @property Doctrine_Collection $Childrens
 * @property Doctrine_Collection $sfUsers
 * @property Doctrine_Collection $sfGroups
 * @property Doctrine_Collection $LogIntranet
 * @property Doctrine_Collection $DocDocument
 * @property Doctrine_Collection $DocDocumentGroupSfUsers
 * @property Doctrine_Collection $DocDocumentGroupSfGroups
 * 
 * @method integer             getId()                       Returns the current record's "id" value
 * @method string              getName()                     Returns the current record's "name" value
 * @method string              getDescription()              Returns the current record's "description" value
 * @method timestamp           getCreatedatetime()           Returns the current record's "createdatetime" value
 * @method integer             getLevel()                    Returns the current record's "level" value
 * @method integer             getUserId()                   Returns the current record's "user_id" value
 * @method integer             getParentId()                 Returns the current record's "parent_id" value
 * @method boolean             getIsdeleted()                Returns the current record's "isdeleted" value
 * @method sfGuardUser         getUsers()                    Returns the current record's "Users" value
 * @method DocDocumentGroup    getParentCategory()           Returns the current record's "ParentCategory" value
 * @method Doctrine_Collection getChildrens()                Returns the current record's "Childrens" collection
 * @method Doctrine_Collection getSfUsers()                  Returns the current record's "sfUsers" collection
 * @method Doctrine_Collection getSfGroups()                 Returns the current record's "sfGroups" collection
 * @method Doctrine_Collection getLogIntranet()              Returns the current record's "LogIntranet" collection
 * @method Doctrine_Collection getDocDocument()              Returns the current record's "DocDocument" collection
 * @method Doctrine_Collection getDocDocumentGroupSfUsers()  Returns the current record's "DocDocumentGroupSfUsers" collection
 * @method Doctrine_Collection getDocDocumentGroupSfGroups() Returns the current record's "DocDocumentGroupSfGroups" collection
 * @method DocDocumentGroup    setId()                       Sets the current record's "id" value
 * @method DocDocumentGroup    setName()                     Sets the current record's "name" value
 * @method DocDocumentGroup    setDescription()              Sets the current record's "description" value
 * @method DocDocumentGroup    setCreatedatetime()           Sets the current record's "createdatetime" value
 * @method DocDocumentGroup    setLevel()                    Sets the current record's "level" value
 * @method DocDocumentGroup    setUserId()                   Sets the current record's "user_id" value
 * @method DocDocumentGroup    setParentId()                 Sets the current record's "parent_id" value
 * @method DocDocumentGroup    setIsdeleted()                Sets the current record's "isdeleted" value
 * @method DocDocumentGroup    setUsers()                    Sets the current record's "Users" value
 * @method DocDocumentGroup    setParentCategory()           Sets the current record's "ParentCategory" value
 * @method DocDocumentGroup    setChildrens()                Sets the current record's "Childrens" collection
 * @method DocDocumentGroup    setSfUsers()                  Sets the current record's "sfUsers" collection
 * @method DocDocumentGroup    setSfGroups()                 Sets the current record's "sfGroups" collection
 * @method DocDocumentGroup    setLogIntranet()              Sets the current record's "LogIntranet" collection
 * @method DocDocumentGroup    setDocDocument()              Sets the current record's "DocDocument" collection
 * @method DocDocumentGroup    setDocDocumentGroupSfUsers()  Sets the current record's "DocDocumentGroupSfUsers" collection
 * @method DocDocumentGroup    setDocDocumentGroupSfGroups() Sets the current record's "DocDocumentGroupSfGroups" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDocDocumentGroup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('doc_document_group');
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
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('createdatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('level', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('parent_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('isdeleted', 'boolean', null, array(
             'default' => false,
             'type' => 'boolean',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as Users', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('DocDocumentGroup as ParentCategory', array(
             'local' => 'parent_id',
             'foreign' => 'id'));

        $this->hasMany('DocDocumentGroup as Childrens', array(
             'local' => 'id',
             'foreign' => 'parent_id'));

        $this->hasMany('sfGuardUser as sfUsers', array(
             'refClass' => 'DocDocumentGroupSfUsers',
             'local' => 'docdocumentgroup_id',
             'foreign' => 'sfguarduser_id'));

        $this->hasMany('sfGuardGroup as sfGroups', array(
             'refClass' => 'DocDocumentGroupSfGroups',
             'local' => 'docdocumentgroup_id',
             'foreign' => 'sfguardgroup_id'));

        $this->hasMany('LogIntranet', array(
             'local' => 'id',
             'foreign' => 'obj_id'));

        $this->hasMany('DocDocument', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('DocDocumentGroupSfUsers', array(
             'local' => 'id',
             'foreign' => 'docdocumentgroup_id'));

        $this->hasMany('DocDocumentGroupSfGroups', array(
             'local' => 'id',
             'foreign' => 'docdocumentgroup_id'));
    }
}