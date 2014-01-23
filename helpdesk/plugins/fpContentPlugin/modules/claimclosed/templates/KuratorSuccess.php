<?php use_helper('Text', 'Date') ?>    
 
<?php 
// обьявление фильтров
$filters = array(
        '5'=>__("Claimtype"),
        '6'=>__("Organization"),
        '7'=>__("Departments"),
      );
include_partial('common/datatables_general', array('filters'=> $filters)); 
?> 
 
<div class="groupbox"><?php echo __('Close claims')?></div>
<?php include_partial('claimclosed/date_range_form', array('form' => $form))?>
<br />
<!--вставка фильтров-->
<?php include_partial('common/datatables_show_filters', array('filters'=> $filters)); ?> 
<!--вставка фильтров конец-->

<table cellspacing="0" width="100%" class="gray" id="example">  
 
  <thead>
    <tr>
      <th></th>
      <th><?php echo __('Claim №')?></th>
      <th><?php echo __('Mpk')?></th>
      <th><?php echo __('Createdatetime')?></th>
      <th><?php echo __('Closedatetime')?></th>
      <th><?php echo __('Claimtype')?></th>
      <th><?php echo __('Organization')?></th>
      <th><?php echo __('Departments')?></th>
      <th><?php echo __('Client')?></th>
      <th><?php echo __('Importance')?></th>
      <th><?php echo __('Status')?></th>
       <th><?php echo __('Actions')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($claimsclosed as $claim): ?>
    
     <tr class="claim_border <?php if ($claim['is_not_read']) echo 'notread'?>">
      <td class="<?php if ($claim['is_not_read']) echo 'notread'?>"><?php echo __('Work list')?>: 
      <?php //echo htmlspecialchars_decode(str_replace(' &lt;br /&gt;',' ', $claim['worklist']))
      $worklist = explode('-*;*-', $claim['worklist']);
      $i = 0;
      foreach ($worklist as $work)
      {
        echo "<b>".++$i.".</b> ".$work." ";  
      }
      ?>
      <span style="color:#F3F5F7; text-indent: -9999px;"><?php echo $claim['id']?></span></td> 
      <td><?php echo $claim['id'] ?></td>
      <td><?php echo $claim['mpk'] ?></td>
      <td ><?php echo format_date($claim['createdatetime'], 'dd.MM.yyyy, HH:mm', 'ru');  ?></td>
      <td ><?php echo format_date($claim['closedatetime'], 'dd.MM.yyyy, HH:mm', 'ru');  ?></td>
      <td ><?php echo $claim['claimtype'] ?></td>
      <td><?php echo $claim['organization_name']?></td>
      <td><?php echo $claim['departments_address']?></td>
      <td><?php echo $claim['client']?></td>  
      <td style="color: <?php echo $claim['importance_color']?>;"><?php echo $claim['importance_name'] ?></td> 
      <td><?php echo $claim['status'] ?></td>
     <td>
      <ul class="sf_admin_td_actions">
             <li class="sf_admin_action_view">
                 <a href="<?php echo url_for('messages')?>/show/claimid/<?php echo $claim['id'] ?>" title="Посмотреть переписку">Посмотреть переписку</a>
            </li>
            <br />
       <?php if ($claim['isclosedstuff']):?><img src="/img/closefinance.jpg"><?php endif;?>
       </ul>
      
      </td>
    </tr>
      <?php endforeach; ?>
  </tbody>
 
</table>       



