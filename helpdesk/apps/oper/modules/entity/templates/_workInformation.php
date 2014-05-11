<table class="gray">
  <tr>
    <th colspan="2"><?php echo __('Officially') ?></th>
    <th><?php echo __('Not Officially') ?></th>
  </tr>
  <tr>
    <?php /** @var DepartmentPeople $departmentPeople */?>
    <td><?php echo __('Admission date') ?></td>
    <td><?php echo $departmentPeople->getAdmissionDate() ?></td>
    <td><?php echo $departmentPeople->getAdmissionDateNotOfficially() ?></td>
  </tr>
  <tr>
    <td><?php echo __('Dismissal date') ?></td>
    <td><?php echo $departmentPeople->getDismissalDate() ?></td>
    <td><?php echo $departmentPeople->getDismissalDateNotOfficially() ?></td>
  </tr>
</table>