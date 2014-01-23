<div class="groupbox">
  <div>
    <?php echo __('Ideas fabric'). ' '. __('Idea #').$record->getName()?>
    <?php if ($canEdit) : ?>
      <div style="float: right">
        <?php if ($canEdit)
          echo get_component('Fmodel', 'history',
            array(
              'model_id' => $record->getId(),
              'model_name' => History::MODEL_IDEA
            )
          )?>
      </div>
    <?php endif;?>
  </div>
</div>


<br />

<div class="groupbox">
  <div><?php echo $record->getName()?></div>
</div>
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
  <tr>
    <td class='option'><?php echo __('Number')?></td>
    <td class='value'><?php echo $record->getId()?></td>
  </tr>
  <tr>
    <td class='option'>
      <?php echo __('Name')?>
    </td>
    <td class='value'><?php echo $record->getName()?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Staff')?></td>
    <td class='value'><?php echo $record->getUser()?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Createdatetime')?></td>
    <td class='value'><?php echo format_date($record->getCreatedatetime(), 'dd.MM.yyyy HH:mm', 'ru')?></td>
  </tr>
  <tr>
    <td class='option'>
      <?php echo __('Description')?>
    </td>
    <td class='value'><?php echo html_entity_decode($record->getDescription())?></td>
  </tr>
  <tr>
    <td class='option'>
      <?php echo __('Result')?>
    </td>
    <td class='value'><?php echo html_entity_decode($record->getResult())?>

    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Goals')?></td>
    <td class='value'><?php
      $goals = $record->getGoals();
      foreach ($goals as $goal):?>
        <?php echo $goal->getName()?><br />
      <?php endforeach;?>
    </td>
  </tr>

  <tr>
    <td class='option'><?php echo __('Significance')?></td>
    <td class='value'><?php
      echo !$canEdit ? $record->getSignificance() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $record->getId(),
            ),
            'model' => 'Idea',
            'form' => 'IdeaExpertForm',
            'field' => 'significance',
            'toString' => 'getSignificance',
            'default'  =>  $record->getSignificance(),
            'ref_functions' => array(
              '#idea_total' => url_for('ideas_refresh_total', array('id' => $record->getId()))
            )
          )
        );
      ?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Financial')?></td>
    <td class='value'><?php
      echo !$canEdit ? $record->getFinancial() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $record->getId(),
            ),
            'model' => 'Idea',
            'form' => 'IdeaExpertForm',
            'field' => 'financial',
            'toString' => 'getFinancial',
            'default'  =>  $record->getFinancial(),
            'ref_functions' => array(
              '#idea_total' => url_for('ideas_refresh_total', array('id' => $record->getId()))
            )
          )
        );
      ?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Originality')?></td>
    <td class='value'><?php
      echo !$canEdit ? $record->getOriginality() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $record->getId(),
            ),
            'model' => 'Idea',
            'form' => 'IdeaExpertForm',
            'field' => 'originality',
            'toString' => 'getOriginality',
            'default'  =>  $record->getOriginality(),
            'ref_functions' => array(
              '#idea_total' => url_for('ideas_refresh_total', array('id' => $record->getId()))
            )
          )
        );
      ?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Readiness')?></td>
    <td class='value'><?php
      echo !$canEdit ? $record->getReadiness() :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $record->getId(),
            ),
            'model' => 'Idea',
            'form' => 'IdeaExpertForm',
            'field' => 'readiness',
            'toString' => 'getReadiness',
            'default'  =>  $record->getReadiness(),
            'ref_functions' => array(
              '#idea_total' => url_for('ideas_refresh_total', array('id' => $record->getId()))
            )
          )
        );
      ?></td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Total')?></td>
    <td class='value'>
      <div id="idea_total">
        <?php echo $record->getTotal()?>
      </div>
      <?php if ($canEdit) : ?>
      <div id="idea_total_email_holder">
        <a href="<?php echo url_for('ideas_send_email', array('id' => $record->getId()))?>" id="idea_total_email"
           data-text="<?php echo __('Mail was sent')?>"
           data-sending_text="<?php echo __('Sending...')?>"
          >
          <?php echo __('Send idea total email')?>
        </a>
      </div>
      <?php endif;?>
    </td>
  </tr>
  <tr>
    <td class='option'><?php echo __('Expert description')?></td>
    <td class='value'><?php
      echo !$canEdit ? html_entity_decode($record->getExpertDescription()) :
        get_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $record->getId(),
            ),
            'model' => 'Idea',
            'form' => 'IdeaExpertForm',
            'field' => 'expert_description',
            'toString' => 'getExpertDescription',
            'default'  =>  $record->getExpertDescription()
          )
        );
      ?></td>
  </tr>
</table>
