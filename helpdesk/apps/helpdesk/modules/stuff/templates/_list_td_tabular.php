<td class="sf_admin_text sf_admin_list_td_username">
  <?php echo link_to($userstuff->getUsername(), 'userstuff_edit', $userstuff) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $userstuff->getFirstName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_last_name">
  <?php echo $userstuff->getLastName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_departments">
  <?php echo htmlspecialchars_decode($userstuff->getDepartments()) ?>
</td>
