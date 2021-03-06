<?php

/**
 * GrafikTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GrafikTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object GrafikTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Grafik');
  }

  /**
   * Get DepartmentPeople Ids in current year month
   *
   * @param int[] $departmentIds
   * @param int $year
   * @param int $month
   * @param int $departmentPeopleId
   * @param int $departmentPeopleReplacementId
   * @param int $offset
   * @param int $limit
   * @return int[]
   */
  static public function getPeopleIds(
    $departmentIds,
    $year,
    $month,
    $departmentPeopleId = null,
    $departmentPeopleReplacementId = null,
    $offset = 0,
    $limit = 0
  )
  {
    if (!is_array($departmentIds) && $departmentIds)
    {
      $departmentIds = array($departmentIds);
    }

    $conn = Doctrine_Manager::getInstance()->connection();

    // @todo people ids must count from DepartmentPeopleMonthInfo
    $query = "
      SELECT
        DISTINCT(d.department_people_id) AS people_id,
        d2.last_name as lastName
      FROM
        department_people_month_info d
     LEFT JOIN department_people d2 ON d.department_people_id = d2.id
     WHERE
       d.year = :year AND
       d.month = :month AND
       d2.parent_id is null AND
       d2.department_id IN (:department_id)";

    $params = array(
      ':year' => $year,
      ':month' => $month,
      ':department_id' => implode(',', $departmentIds),
      ':offset' => $offset
    );

    if ($limit)
    {
      $params[':limit'] = $limit;
    }

    if ($departmentPeopleId)
    {
      $query .= ' AND d.department_people_id = :department_people_id';
      $params[':department_people_id'] = $departmentPeopleId;
    }

    if (!is_null($departmentPeopleReplacementId))
    {
      $query .= ' AND d.department_people_replacement_id = :department_people_replacement_id';
      $params[':department_people_replacement_id'] = $departmentPeopleReplacementId;
    }

    $query .= ' ORDER BY d2.last_name ASC ';

    // Offset limit
    $query .= ' OFFSET :offset';

    if ($limit)
    {
      $query .=' LIMIT :limit';
    }


    $stmt = $conn->prepare($query);

    $stmt->execute($params);

    $people = $stmt->fetchAll();

    // @todo remove before roduction
    /*$query = "
      SELECT
        DISTINCT(g.department_people_id) AS people_id
      FROM
        grafik g
     WHERE
       g.year = :year AND
       g.month = :month AND
       g.department_id IN (:department_id)";

    $stmtGrafik = $conn->prepare($query);

    $params = array(
      ':year' => $year,
      ':month' => $month,
      ':department_id' => implode(',', $departmentIds)
    );

    $stmtGrafik->execute($params);

    $grafikPeople = $stmtGrafik->fetchAll();*/
    // eof remove

    $result = array();

    foreach($people as $item)
    {
      if (!isset($result[$item['people_id']]))
      {
        $result[$item['people_id']] = $item['people_id'];
      }
    }

    // @todo remove before production
    /*foreach($grafikPeople as $item)
    {
      if (!isset($result[$item['people_id']]))
      {
        $result[$item['people_id']] = $item['people_id'];
      }
    }*/

    return $result;
  }
}