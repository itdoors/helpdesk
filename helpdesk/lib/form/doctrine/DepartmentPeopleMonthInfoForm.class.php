<?php

/**
 * DepartmentPeopleMonthInfo form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartmentPeopleMonthInfoForm extends BaseDepartmentPeopleMonthInfoForm
{
  protected $isReplacementTypeChanged = false;
  protected $objectToReplace = null;

  public function configure()
  {
    $this->i18n = sfContext::getInstance()->getI18N();
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $isNew = $this->isNew();

    if (!$isNew)
    {
      $this->setWidget('department_people_name', new sfWidgetFormInput(array(), array(
        'disabled' => 'disabled'
      )));

      $object = $this->getObject();

      /** @var DepartmentPeople $departmentPeople */
      $departmentPeople = Doctrine::getTable('DepartmentPeople')->find($object->getDepartmentPeopleId());

      $this->getWidget('department_people_name')->setDefault($departmentPeople->getFullName());
      $this->getWidget('department_people_name')->setLabel('FIO');

      $personId = $this->getObject()->getDepartmentPeopleId();

      /** @var DepartmentPeople $person*/
      $person = Doctrine::getTable('DepartmentPeople')->find($personId);

      $departmentId = $person->getDepartmentId();
    }
    else
    {
      $departmentId = $this->getOption('departmentId');
      $year = $this->getOption('year');
      $month = $this->getOption('month');

      if ($departmentId && $year && $month)// form load but not submitted
      {
        $peopleIds = GrafikTable::getPeopleIds($departmentId, $year, $month);

        $query = Doctrine::getTable('DepartmentPeople')
          ->createQuery('dp')
          ->where('dp.department_id = ?', $departmentId)
          // ->andWhereNotIn('dp.id', $peopleIds)
          ->andWhere('dp.parent_id is null')
          ->orderBy('dp.name ASC');

        $this->setWidget('department_people_id', new sfWidgetFormDoctrineChoice(array(
          'model' => 'DepartmentPeople',
          'query' => $query
        )));

        $this->setValidator('department_people_id', new sfValidatorDoctrineChoice(array(
          'model' => 'DepartmentPeople',
          'query' => $query
        )));
      }
    }

    // Replacement type
    $replacementChoices = array(
      DepartmentPeople::REPLACEMENT_TYPE_REPLACEMENT => $this->i18n->__('Replacement'),
      DepartmentPeople::REPLACEMENT_TYPE_SUBSTITUTION => $this->i18n->__('Substitution'),
    );
    $this->setWidget('replacement_type', new sfWidgetFormChoice(array(
      'choices' => $replacementChoices
    )));
    $this->setValidator('replacement_type', new sfValidatorString(array(
      'required' => false,
    )));
    // EOF Replacement type

    $this->setWidget('mpk_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'Mpk',
      'url'=>url_for('ajaxdata/auto_mpk'),
      'js_callback' => 'auto_mpk',
    ), array(
      'data-department_id' => $departmentId
    )));

    if ($departmentId) {
      /** @var Mpk $mpk */
      $mpk = Doctrine::getTable('Mpk')->findOneBy('department_id', $departmentId);

      if ($mpk) {
        $this->getWidget('mpk_id')->setDefault($mpk->getId());
      }
    }

    $this->setWidget('department_people_replacement_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'DepartmentPeople',
      'url'=>url_for('ajaxdata/auto_department_people'),
    )));

    /*$queryReplacement = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.department_id = ?', $departmentId)
      ->andWhere('dp.parent_id is null')
      ->orderBy('dp.name ASC');

    $this->setWidget('department_people_replacement_id', new sfWidgetFormDoctrineChoice(array(
        'model' => 'DepartmentPeople',
        'query' => $queryReplacement,
        'add_empty' => true
      )
    ));*/

    /*$this->setValidator('department_people_replacement_id', new sfValidatorDoctrineChoice(array(
      'model' => 'DepartmentPeople',
      'query' => $queryReplacement,
      'required' => false
    )));*/

    $this->setWidget('type_id', new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getDepartmentPeople',
        'add_empty' => false
      ),
      array(
        'data-permanentTypeId' => lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_PERMANENT),
        'data-replacementTypeId' => lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT)
      )
    ));

    $this->setWidget('employment_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      ),
      array(
        'data-aTypeId' => lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_A),
        'data-cTypeId' => lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_C),
        'data-bTypeId' => lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_B)
      )
    ));

    $this->setWidget('surcharge_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      )
    ));

    $this->setWidget('bonus_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      )
    ));

    $this->setWidget('fine_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      )
    ));

    $department_people = Doctrine::getTable('lookup')->getDepartmentPeople();
    if (sizeof($department_people))
    {
      $this->setDefault('type_string', $department_people->getFirst()->getName());
    }

    unset($this['salary_type_id']);

    $charChoices = array(
      'k' => 'k',
      'd' => 'd',
      'r' => 'r'
    );

    $this->setWidget('surcharge_type_key', new sfWidgetFormChoice(array(
      'choices' => $charChoices,
    )));
    $this->setWidget('bonus_type_key', new sfWidgetFormChoice(array(
      'choices' => $charChoices,
    )));
    $this->setWidget('fine_type_key', new sfWidgetFormChoice(array(
      'choices' => $charChoices,
    )));

    $this->setValidator('surcharge_type_key', new sfValidatorChoice(array(
      'choices' => $charChoices,
      'required' => false
    )));
    $this->setValidator('bonus_type_key', new sfValidatorChoice(array(
      'choices' => $charChoices,
      'required' => false
    )));
    $this->setValidator('fine_type_key', new sfValidatorChoice(array(
      'choices' => $charChoices,
      'required' => false
    )));

    $this->setValidator('department_people_id', new sfValidatorString());
    $this->setValidator('department_people_replacement_id', new sfValidatorInteger(array(
      'required' => false
    )));
    $this->setValidator('year', new sfValidatorString());
    $this->setValidator('month', new sfValidatorString());

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkReplacement'),
            )
          ),
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkSurchargeBonusFine'),
            )
          ),
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkReplacementType'),
            )
          )
        ))
     );

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }

  /**
   * Binds the form with input values.
   *
   * It triggers the validator schema validation.
   *
   * @param array $taintedValues  An array of input values
   * @param array $taintedFiles   An array of uploaded files (in the $_FILES or $_GET format)
   */
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $isNew = $this->isNew();

    if (!$isNew && $personId = $taintedValues['department_people_id'])
    {
      /** @var DepartmentPeople $person */
      $person = Doctrine::getTable('DepartmentPeople')->find($personId);

      if ($person)
      {
        $taintedValues['department_people_name'] = $person->getFullName();
      }
    }

    if (isset($taintedValues['department_people_replacement_id']))
    {
      if (!$taintedValues['department_people_replacement_id'])
      {
        $taintedValues['department_people_replacement_id'] = 0;
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  }

  public function save($con = null)
  {
    /** @var DepartmentPeopleMonthInfo $object */
    $object = parent::save($con);

    $aTypeId = lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_A);
    $cTypeId = lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_C);
    $bTypeId = lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_B);

    $replacementTypeId = lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT);

    if ($object->getEmploymentTypeId() != $cTypeId && $object->getEmploymentTypeId() != $bTypeId && $object->getEmploymentTypeId() != $aTypeId)
    {
      $object->setIsCleanSalary(false);
      $object->setNormaDays(null);
      $object->save();
    }

    if ($object->getTypeId() != $replacementTypeId)
    {
      $object->setDepartmentPeopleReplacementId(0);
      //$object->setIsSubstitution(false);
      $object->save();
    }

    // Process person
    /*$values = $this->values;
    if (isset($values['department_people_parent_id']))
    {
      $personId = $object->getDepartmentPeopleId();

      $person = Doctrine::getTable('DepartmentPeople')->find($personId);

      $person->setParentId($values['department_people_parent_id']);
      $person->save();

      DepartmentPeople::processParent($person, null, false);
    }*/

    return $object;
  }

  /**
   * Returns object to replace cz replacement_type part of PK.
   * And that's why on change replacement type object became isNew == true
   *
   * @return DepartmentPeopleMonthInfo
   */
  public function getObjectToReplace()
  {
    return $this->objectToReplace;
  }

  /**
   * Sets object to replace cz replacement_type part of PK.
   * And that's why on change replacement type object became isNew == true
   *
   * @param DepartmentPeopleMonthInfo $object
   */
  public function setObjectToReplace($object)
  {
    $this->objectToReplace = clone $object;
  }

  /**
   * Updates data in grafik & grafik_time table if replacement type where changed
   *
   * @return DepartmentPeopleMonthInfo $object
   */
  public function replacementTypeUpdate()
  {
    $values = $this->getValues();
    $object = $this->getObjectToReplace();

    $replacementTypeNew = $values['replacement_type'];
    $replacementTypeOld = $object->getReplacementType();

    $conn = Doctrine_Manager::getInstance()->connection();

    $params = array(
      ':year' => $object->getYear(),
      ':month' => $object->getMonth(),
      ':department_people_id' => $object->getDepartmentPeopleId(),
      ':department_people_replacement_id' => $object->getDepartmentPeopleReplacementId(),
      ':department_id' => $object->getDepartmentId(),
      ':replacement_type_new' => $replacementTypeNew,
      ':replacement_type_old' => $replacementTypeOld,
    );

    $query = "
    UPDATE
      grafik
    SET
      replacement_type = :replacement_type_new
      where
        year = :year and
        month = :month and
        department_people_id = :department_people_id and
        department_people_replacement_id = :department_people_replacement_id and
        department_id = :department_id and
        replacement_type = :replacement_type_old";

    $stmt = $conn->prepare($query);

    $stmt->execute($params);

    $query = "
    UPDATE
      grafik_time
    SET
      replacement_type = :replacement_type_new
      where
        year = :year and
        month = :month and
        department_people_id = :department_people_id and
        department_people_replacement_id = :department_people_replacement_id and
        department_id = :department_id and
        replacement_type = :replacement_type_old";

    $stmt = $conn->prepare($query);

    $stmt->execute($params);

    return $object;
  }

  /**
   * When change replacement type from R to S or from S to R
   * Checks if there is no person with other replacement type
   */
  public function checkReplacementType($validator, $values, $arguments)
  {
    if (!isset($values['replacement_type'])) {
      $error = $this->i18n->__('There is no replacement type');
      $this->setOption('replacementError', $error);
      throw new sfValidatorError($validator, $error);
    }

    $replacementTypeNew = $values['replacement_type'];
    $object = $this->getObject();

    if ($replacementTypeNew != $object->getReplacementType()) {
      // If person exists => throw exception
      $params = $object->toArray();
      $params['replacement_type'] = $replacementTypeNew;

      /** @var DepartmentPeopleMonthInfo $person */
      $person = DepartmentPeopleMonthInfo::findOne($params);

      if ($person) {
        $error = $this->i18n->__('Person with same data already exists');
        $this->setOption('replacementError', $error);
        throw new sfValidatorError($validator, $error);
      } else {
        // If changed set some variable to true and in form save
        // Update grafik && grafik time with new replacement type
        $this->isReplacementTypeChanged = true;
        $this->setObjectToReplace($object);
      }
    }

    return $values;
  }

  public function checkReplacement($validator, $values, $arguments)
  {
    $replacementTypeId = lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT);

    if (isset($values['type_id']))
    {
      if ($values['type_id'] == $replacementTypeId)
      {
        if (!isset($values['department_people_replacement_id']) || !$values['department_people_replacement_id'])
        {
          $error = $this->i18n->__('Choose some one to replacement');
          $this->setOption('replacementError', $error);
          throw new sfValidatorError($validator, $error);
        }
        else
        {
          if (isset($values['department_people_id']) && isset($values['department_people_replacement_id']))
          {
            if ($values['department_people_id'] == $values['department_people_replacement_id'])
            {
              $error = $this->i18n->__('You can\'t replace person by himself');
              $this->setOption('replacementError', $error);
              throw new sfValidatorError($validator, $error);
            }
          }
        }
      }
    }

    return $values;
  }

  public function checkSurchargeBonusFine($validator, $values, $arguments)
  {
    if ( (isset($values['surcharge']) && $values['surcharge']) xor
         (isset($values['surcharge_type_id']) && $values['surcharge_type_id']))
    {
      $error = $this->i18n->__('Surcharge Surcharge Type required');
      if (is_array($this->getOptions()))
      {
        $this->setOption('surchargeError', $error);
      }
      throw new sfValidatorError($validator, $error);
    }

    if ( (isset($values['bonus']) && $values['bonus']) xor
      (isset($values['bonus_type_id']) && $values['bonus_type_id']))
    {
      $error = $this->i18n->__('Bonus Bonus Type required');
      if (is_array($this->getOptions()))
      {
        $this->setOption('bonusError', $error);
      }
      throw new sfValidatorError($validator, $error);
    }

    if ( (isset($values['fine']) && $values['fine']) xor
      (isset($values['fine_type_id']) && $values['fine_type_id']))
    {
      $error = $this->i18n->__('Fine Fine Type required');
      if (is_array($this->getOptions()))
      {
        $this->setOption('fineError', $error);
      }
      throw new sfValidatorError($validator, $error);
    }
    return $values;
  }
}
