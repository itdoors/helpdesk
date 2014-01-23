<table width='100%' cellpadding='0' cellspacing='0' class="gray">
  <tr>
    <td class='option' width='20%'><?php echo __('Id')?></td>
    <td class='value' width='30%'><?php echo $handling->getId()?></td>
    <td class='option' width='20%'><?php echo __('Number')?></td>
    <td class='value' width='30%'><?php echo $handling->getId()?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Organization')?></td>
    <td class='value'><?php echo $handling->getOrganization()?></td>
    <td class='option'><?php echo __('Creator')?></td>
    <td class='value'><?php echo $handling->getUser()?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Createdatetime')?></td>
    <td class='value'><?php echo format_date($handling->getCreatedate(), 'dd.MM.yyyy', 'ru')?></td>
    <td class='option'><?php echo __('Descrition')?></td>
    <td class='value'>
      <?php
        if (!$handling->getIsClosed())
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'description',
            'toString' => 'getDescription',
            'default'  =>  $handling->getDescription()
          )
        );
      ?>
    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Status')?></td>
    <td class='value'>
      <?php
        echo $handling->getIsClosed() ? $handling->getStatusWithDate() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'status_id',
            'toString' => 'getStatusWithDate',
            'default'  =>  $handling->getStatusWithDate()
          )
        );
      ?>
    </td>
    <td class='option'><?php echo __('Status description')?></td>
    <td class='value'>
      <?php
        echo $handling->getIsClosed() ? $handling->getStatusDescription() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'status_description',
            'toString' => 'getStatusDescription',
            'default'  =>  $handling->getStatusDescription()
          )
        );
      ?>
    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Service offered')?></td>
    <td class='value'>
      <?php
        echo $handling->getIsClosed() ? $handling->getServiceOffered() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'service_offered',
            'toString' => 'getServiceOffered',
            'default'  =>  $handling->getServiceOffered()
          )
        );
      ?>
    </td>
    <td class='option'><?php echo __('Type')?></td>
    <td class='value'>
      <?php
      echo $handling->getIsClosed() ? $handling->getTypeName() :
      get_component('Fmodel', 'ajax_field_change',
        array(
          'where' => array(
            'id' => $handling->getId(),
          ),
          'model' => 'Handling',
          'field' => 'type_id',
          'toString' => 'getTypeName',
          'default'  =>  $handling->getTypeName()
        )
      );
      ?>
    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Square')?></td>
    <td class='value'>
      <?php
        echo $handling->getIsClosed() ? $handling->getSquare() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'square',
            'toString' => 'getSquare',
            'default'  =>  $handling->getSquare()
          )
        );
      ?>
    </td>
    <td class='option'><?php echo __('Chance')?></td>
    <td class='value'>
      <?php
        echo $handling->getIsClosed() ? $handling->getChance() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'chance',
            'toString' => 'getChance',
            'default'  =>  $handling->getChance()
          )
        );
      ?>
    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Month budget')?></td>
    <td class='value'>
      <?php
        echo $handling->getIsClosed() ? $handling->getBudget() :
        get_component('Fmodel', 'ajax_field_change',
        array(
          'where' => array(
            'id' => $handling->getId(),
          ),
          'model' => 'Handling',
          'field' => 'budget',
          'toString' => 'getBudget',
          'default'  =>  $handling->getBudget()
        )
      );
      ?>
    </td>
    <td class='option'><?php echo __('Budget client')?></td>
    <td class='value'><?php
      echo $handling->getIsClosed() ? $handling->getBudgetClient() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'budget_client',
            'toString' => 'getBudgetClient',
            'default'  =>  $handling->getBudgetClient()
          )
        );
      ?>
    </td>
    </tr>
    <tr>
    <td class='option'><?php echo __('Is closed')?></td>
    <td class='value'><?php echo $handling->getIsClosed() ?  __('Closed') : __('Opened')?>
      <?php if ($sf_user->hasCredential('crmadmin')):?>
        <?php $link = $handling->getIsClosed() ? 'open' : 'close';?>
        <a href="<?php echo url_for('handling_close', array('link' => $link, 'handling_id' =>$handling->getId()))?>" class="button">
          <?php echo $handling->getIsClosed() ?  __('Open') : __('Close')?>
        </a>
      <?php endif;?>
    </td>
    <td class='option'><?php echo __('Result')?></td>
    <td class='value'>
      <?php
      echo $handling->getIsClosed() ? $handling->getResultNameWithLink() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'result_id',
            'toString' => 'getResultNameWithLink',
            'default'  =>  $handling->getResultNameWithLink()
          )
        );
      ?>
    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Result string')?></td>
    <td class='value'>
      <?php
      echo $handling->getIsClosed() ? $handling->getResult() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $handling->getId(),
            ),
            'model' => 'Handling',
            'field' => 'result_string',
            'toString' => 'getResultString',
            'default'  =>  $handling->getResultString()
          )
        );
      ?>
    </td>
    <td class='option'><?php echo __('History')?></td>
    <td class='value'>
      <div class="history">
        <?php include_component('Fmodel', 'history',
          array(
            'model_id' => $handling->getId(),
            'model_name' => History::MODEL_HANDLING
          )
        )?>
      </div>
    </td>
  </tr>
</table>
<div id="dialog_holder"></div>