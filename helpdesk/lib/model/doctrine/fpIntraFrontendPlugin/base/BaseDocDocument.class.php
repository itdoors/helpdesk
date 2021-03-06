<?php

/**
 * BaseDocDocument
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property timestamp $createdatetime
 * @property string $tags
 * @property integer $user_id
 * @property integer $category_id
 * @property boolean $isdeleted
 * @property sfGuardUser $Users
 * @property DocDocumentGroup $Category
 * @property Doctrine_Collection $LogIntranet
 * @property Doctrine_Collection $DocDocumentVersion
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method string              getName()               Returns the current record's "name" value
 * @method string              getDescription()        Returns the current record's "description" value
 * @method timestamp           getCreatedatetime()     Returns the current record's "createdatetime" value
 * @method string              getTags()               Returns the current record's "tags" value
 * @method integer             getUserId()             Returns the current record's "user_id" value
 * @method integer             getCategoryId()         Returns the current record's "category_id" value
 * @method boolean             getIsdeleted()          Returns the current record's "isdeleted" value
 * @method sfGuardUser         getUsers()              Returns the current record's "Users" value
 * @method DocDocumentGroup    getCategory()           Returns the current record's "Category" value
 * @method Doctrine_Collection getLogIntranet()        Returns the current record's "LogIntranet" collection
 * @method Doctrine_Collection getDocDocumentVersion() Returns the current record's "DocDocumentVersion" collection
 * @method DocDocument         setId()                 Sets the current record's "id" value
 * @method DocDocument         setName()               Sets the current record's "name" value
 * @method DocDocument         setDescription()        Sets the current record's "description" value
 * @method DocDocument         setCreatedatetime()     Sets the current record's "createdatetime" value
 * @method DocDocument         setTags()               Sets the current record's "tags" value
 * @method DocDocument         setUserId()             Sets the current record's "user_id" value
 * @method DocDocument         setCategoryId()         Sets the current record's "category_id" value
 * @method DocDocument         setIsdeleted()          Sets the current record's "isdeleted" value
 * @method DocDocument         setUsers()              Sets the current record's "Users" value
 * @method DocDocument         setCategory()           Sets the current record's "Category" value
 * @method DocDocument         setLogIntranet()        Sets the current record's "LogIntranet" collection
 * @method DocDocument         setDocDocumentVersion() Sets the current record's "DocDocumentVersion" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDocDocument extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('doc_document');
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
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('createdatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('tags', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('category_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
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

        $this->hasOne('DocDocumentGroup as Category', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $this->hasMany('LogIntranet', array(
             'local' => 'id',
             'foreign' => 'obj_id'));

        $this->hasMany('DocDocumentVersion', array(
             'local' => 'id',
             'foreign' => 'document_id'));
    }
}