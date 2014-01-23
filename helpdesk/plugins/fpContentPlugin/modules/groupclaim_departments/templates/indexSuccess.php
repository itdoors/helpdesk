<h1>Groupclaim departmentss List</h1>

<table>
  <thead>
    <tr>
      <th>Groupclaim</th>
      <th>Departments</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($groupclaim_departmentss as $groupclaim_departments): ?>
    <tr>
      <td><a href="<?php echo url_for('groupclaim_departments/edit?groupclaim_id='.$groupclaim_departments->getGroupclaimId().'&departments_id='.$groupclaim_departments->getDepartmentsId()) ?>"><?php echo $groupclaim_departments->getGroupclaimId() ?></a></td>
      <td><a href="<?php echo url_for('groupclaim_departments/edit?groupclaim_id='.$groupclaim_departments->getGroupclaimId().'&departments_id='.$groupclaim_departments->getDepartmentsId()) ?>"><?php echo $groupclaim_departments->getDepartmentsId() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('groupclaim_departments/new') ?>">New</a>
