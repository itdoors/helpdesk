<div id="organization_contacts">
  <?php include_component('organization', 'organization_contact_list',
    array(
      'organization_id' => $handling->getOrganizationId(),
      'withDelete' => false
    ));?>
</div>