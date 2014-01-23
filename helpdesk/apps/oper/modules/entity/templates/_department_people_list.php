<?php if (!$isShowMore && !$lastRecord): ?>
  <div id="department_people_form_holder" style="display: none;"></div>
  <?php
  include_component('Fmodel','form_add',
    array(
      'model' => 'DepartmentPeople',
      'form_class' => 'DepartmentPeople',
      'target'=>'department_people_form_holder',
      'button_text' => __('Add department people'),
      'with_dialog' => 1,
      'default' =>
        array(
          'department_id'=>$department->getId()
        ),
      'ref_functions_names'=>
        array(
          'updateLastRecord' => 'department-people-list'
        )
    )
  );?>
<?php endif;?>



  <?php if (!$isShowMore && !$lastRecord): ?>

  <table cellspacing="0" width="100%" class="gray department-people-list" id="example"
    data-offset="<?php echo $offset?>"
    data-url-update-last-record="<?php echo url_for('ajax_entity_department_people_post')?>"
    data-department_id="<?php echo $department->getId()?>"
  >
    <thead>
      <tr>
        <th>Id</th>
        <th><?php echo __('FIO(old)')?></th>
        <th><?php echo __('Tabel number')?></th>
        <th><?php echo __('DRFO')?></th>
        <th><?php echo __('Passport')?></th>
        <th><?php echo __('Person code')?></th>
        <th><?php echo __('Last name')?></th>
        <th><?php echo __('First name')?></th>
        <th><?php echo __('Middle name')?></th>
        <th><?php echo __('Birthday')?></th>
        <th><?php echo __('Admission date')?></th>
        <th><?php echo __('Dismissal date')?></th>
        <th><?php echo __('Phone')?></th>
        <th><?php echo __('Address')?></th>
        <th><?php echo __('Parent person')?></th>
      </tr>
    </thead>
  <?php endif;?>
  <?php foreach ($departmentPeople as $person): /** @var DepartmentPeople $person */ ?>
    <?php
      $rowId = 'department-people-'.$person->getId();
      $color = '#64CDC6';
      if ($person->getIsFromOneC() && !$person->getIsApproved())
      {
        $color = '#C25757';
      }

      if (!$person->getIsFromOneC() && $person->getIsApproved())
      {
        $color = '#68CD64';
      }
    ?>
    <tr style="background-color: <?php echo $color?>" id="<?php echo $rowId?>" class="body-tr">
      <td><?php echo $person->getId()?></td>
      <td><?php echo $person->getFullName()?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'number',
            'toString' => 'getNumber',
            'default'  =>  $person->getNumber(),
          )
        );
        ?></td>
      <td>
        <?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'drfo',
            'toString' => 'getDrfo',
            'default'  =>  $person->getDrfo(),
          )
        );
        ?>
      </td>
      <td>
        <?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'passport',
            'toString' => 'getPassport',
            'default'  =>  $person->getPassport(),
          )
        );
        ?>
      </td>
      <td>
        <?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'person_code',
            'toString' => 'getPersonCode',
            'default'  =>  $person->getPersonCode(),
          )
        );
        ?>
      </td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'last_name',
            'toString' => 'getLastName',
            'default'  =>  $person->getLastName(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'first_name',
            'toString' => 'getFirstName',
            'default'  =>  $person->getFirstName(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'middle_name',
            'toString' => 'getMiddleName',
            'default'  =>  $person->getMiddleName(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'birthday',
            'toString' => 'getBirthday',
            'default'  =>  $person->getBirthday(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'admission_date',
            'toString' => 'getAdmissionDate',
            'default'  =>  $person->getAdmissionDate(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'dismissal_date',
            'toString' => 'getDismissalDate',
            'default'  =>  $person->getDismissalDate(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'phone',
            'toString' => 'getPhone',
            'default'  =>  $person->getPhone(),
          )
        );
        ?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'address',
            'toString' => 'getAddress',
            'default'  =>  $person->getAddress(),
          )
        );
        ?>
      </td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getId(),
            ),
            'model' => 'DepartmentPeople',
            'field' => 'department_people_parent_id',
            'toString' => 'getParentId',
            'default'  =>  __('Change to other person'),
            'ref_functions_names'=>
              array(
                'deleteSelector'=> '#'.$rowId
              )
          )
        );
      ?></td>
    </tr>
  <?php endforeach;?>
  <?php if (!$lastRecord && sizeof($departmentPeople)) : ?>
    <tr class="show-more">
      <td colspan="16"><a href="#" style="display: block"><?php echo __('show more')?></a></td>
    </tr>
  <?php endif;?>
  <?php if (!$isShowMore && !$lastRecord): ?>
    </table>
  <?php endif;?>

<?php if (!$isShowMore && !$lastRecord): ?>
<script type="text/javascript">

  $('table.department-people-list tr.show-more').appear();

  $('table.department-people-list tr.show-more').live('appear', function(event, $all_appeared_elements) {
    $('table.department-people-list tr.show-more').trigger('click');
  })

  var isDepartmentPeopleListLoading = false;

  $('table.department-people-list tr.show-more').live('click', function(e){
    e.preventDefault();

    if (isDepartmentPeopleListLoading)
    {
      return false;
    }

    var target = $(this);

    var parentTable = $('table.department-people-list');

    var offset = parentTable.data('offset');

    var limit = <?php echo $limit?>;

    $.ajax({
      type: 'POST',
      url: '<?php echo url_for('ajax_entity_department_people_post')?>',
      data: {
        department_id: '<?php echo $departmentId?>',
        offset: offset,
        canEdit: '<?php echo $can_edit?>'
      },
      beforeSend: function(){
        isDepartmentPeopleListLoading = true;
      },
      success: function(response){
        isDepartmentPeopleListLoading = false;

        parentTable.data('offset', offset + limit)

        target.replaceWith(response);
      }
    })
  });
</script>
<?php endif ?>