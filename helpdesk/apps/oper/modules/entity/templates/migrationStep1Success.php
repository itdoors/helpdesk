<?php if (sizeof($departmentPeople)): ?>
  <?php if (!$isAjax) : ?>
    <table cellspacing="0" width="100%" class="gray migration-step1" id="example" data-offset="<?php echo $offset?>">
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
          <th><?php echo __('Department')?></th>
          <th><?php echo __('Department status')?></th>
          <th><?php echo __('Employment type')?></th>
          <th><?php echo __('Salary')?></th>
          <th><?php echo __('Birthday')?></th>
          <th><?php echo __('Admission date')?></th>
          <th><?php echo __('Dismissal date')?></th>
          <th><?php echo __('Phone')?></th>
          <th><?php echo __('Address')?></th>
          <th><?php echo __('Parent person')?></th>
        </tr>
      </thead>
  <?php endif; ?>
  <?php
    /** @var DepartmentPeople[] $departmentPeople */
    foreach ($departmentPeople as $person): ?>
    <?php
      if ($lastDepartmentId != $person->getDepartmentId()) :
      $lastDepartmentId = $person->getDepartmentId();
    ?>
      <tr>
        <td colspan="15">
          <a href="<?php echo url_for('entity_show', array('department_id' => $person->getDepartmentId()))?>#ui-tabs-6" target="_blank">
            #<?php echo $person->getDepartmentId() ?>
             (<?php echo $person->getDepartment()->getMpk() ?>)
              - <?php echo $person->getDepartment() ?>
              - <?php echo $person->getDepartment()->getOrganization() ?>
          </a>
        </td>
      </tr>
    <?php endif ?>

    <?php
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
    <tr style="background-color: <?php echo $color?>">
      <td><?php echo $person->getId()?></td>
      <td><?php echo $person->getFullName()?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => json_encode(array(
              'id' => $person->getId(),
            )),
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
      <td>
        <a href="<?php echo url_for('entity_show', array('department_id' => $person->getDepartmentId()))?>#ui-tabs-6" target="_blank">
          <?php echo $person->getDepartmentId()?>
        </a>
      </td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $person->getDepartmentId(),
            ),
            'model' => 'departments',
            'field' => 'status_id',
            'toString' => 'getStatusString',
            'default'  =>  $person->getDepartment()->getStatusString(),
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
            'field' => 'employment_type_id',
            'toString' => 'getBaseEmploymentTypeChar',
            'default'  =>  $person->getBaseEmploymentTypeChar(),
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
            'field' => 'salary',
            'toString' => 'getBaseSalary',
            'default'  =>  $person->getBaseSalary(),
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
          )
        );
      ?></td>
    </tr>
  <?php endforeach;?>
    <tr class="show-more" data-last-dapartment-id="<?php echo $lastDepartmentId?>">
      <td colspan="19"><a href="#" style="display: block"><?php echo __('show more')?></a></td>
    </tr>
  <?php if (!$isAjax) : ?>
    </table>
  <?php endif;?>
<?php endif;?>

<?php if (!$isAjax) : ?>
<script type="text/javascript">

    $('table.migration-step1 tr.show-more').appear();

    $('table.migration-step1 tr.show-more').live('appear', function(event, $all_appeared_elements) {
      $('table.migration-step1 tr.show-more').trigger('click');
    })

    var isMigrationLoading = false;

    $('table.migration-step1 tr.show-more').live('click', function(e){
      e.preventDefault();

      if (isMigrationLoading)
      {
        return false;
      }

      var target = $(this);

      var parentTable = $('table.migration-step1');

      var offset = parentTable.data('offset');

      var limit = <?php echo $limit?>;

      var lastDepartmentId = target.data('last-dapartment-id')

      $.ajax({
        type: 'POST',
        url: '<?php echo url_for('entity_migration_step_1_post')?>',
        data: {
          sort: '<?php echo $sort?>',
          department_id: '<?php echo $departmentId?>',
          offset: offset,
          lastDepartmentId: lastDepartmentId
        },
        beforeSend: function(){
          isMigrationLoading = true;
        },
        success: function(response){
          isMigrationLoading = false;

          parentTable.data('offset', offset + limit)

          target.replaceWith(response);
        }
      })
    });

</script>
<?php endif; ?>