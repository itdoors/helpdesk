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
  <?php ///echo htmlspecialchars_decode($userstuff->getDepartments()) ?>
  <?php echo get_component('ajax', 'show_data_by_button', 
    array(
      'href'=>url_for('stuff/show_departmentslist/').'?stuff_id='.$userstuff->getId(),
      'button_text'=>__('Show departments'),
      'button_id'=>'',
      'result_id'=>''
    )
  )?>
</td>
