<?php foreach ($types as $type):?>
<div class="tech_param_holder">
  <div class="tech_param_type"><?php echo $type;?></div>
  <div class="tech_param_item_holder">
    <?php if(isset($params_array[$type->getId()])):?>
    <table cellpadding="5" cellspacing="5">
      <?php foreach($params_array[$type->getId()] as $param):?>
        <tr>
          <td><?php echo $param?></td>
          <td style="padding: 30px;"><?php 
              echo 
              !$can_edit ? (isset($departments_params[$param->getId()]) ? $departments_params[$param->getId()]->getValue() : '') : 
              get_component('Fmodel', 'ajax_field_change',
                array(
                  'where' => array(
                    'department_id' => $department->getId(),
                    'param_id' => $param->getId()
                  ),
                  'model' => 'TechnicalParamDepartments',
                  'field' => 'value',
                  'toString' => 'getValue',
                  'default'  =>  isset($departments_params[$param->getId()]) ? $departments_params[$param->getId()]->getValue() : ''
                )
              );
            ?>
           </td>
           <td><?php echo $param->getUnit()?></td>
           <td style="padding: 30px;"><?php
              echo 
              !$can_edit ? (isset($departments_params[$param->getId()]) ? $departments_params[$param->getId()]->getDate() : '') : 
              get_component('Fmodel', 'ajax_field_change',
                array(
                  'where' => array(
                    'department_id' => $department->getId(),
                    'param_id' => $param->getId()
                  ),
                  'model' => 'TechnicalParamDepartments',
                  'field' => 'date',
                  'toString' => 'getDate',
                  'default'  =>  isset($departments_params[$param->getId()]) ? $departments_params[$param->getId()]->getDate() : ''
                )
              );
            ?>
           </td>
        </tr>
      <?php endforeach;?>
    </table>  
    <?php endif;?>
  </div>
</div>
<?php endforeach;?>
