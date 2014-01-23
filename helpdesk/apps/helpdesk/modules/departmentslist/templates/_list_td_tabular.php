<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($departments->getId(), 'departments_edit', $departments) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_mpk">
  <?php echo $departments->getMpk() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_contract">
  <?php echo $departments->getContract() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_organization">
  <?php echo $departments->getOrganization() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_region">
  <?php echo $departments->getRegion() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_city">
  <?php echo $departments->getCity() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_address">
  <?php echo $departments->getAddress() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_clientlist">
 <?php echo htmlspecialchars_decode($departments->getClientlist()) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_persons">
 <?php echo htmlspecialchars_decode($departments->getPersons()) ?>    
</td>
