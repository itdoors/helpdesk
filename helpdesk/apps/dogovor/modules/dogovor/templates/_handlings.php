<div id="handling_added_list">
  <?php include_component('dogovor', 'handling_added_list',  array(
    'dogovorId' => $dogovor->getId(),
    'organizationId' => $dogovor->getOrganizationId()))?>
</div>
<br />
<div id="handling_for_add_list">
  <?php include_component('dogovor', 'handling_for_add_list',
    array(
      'dogovorId' => $dogovor->getId(),
      'organizationId' => $dogovor->getOrganizationId()))
  ?>
</div>
