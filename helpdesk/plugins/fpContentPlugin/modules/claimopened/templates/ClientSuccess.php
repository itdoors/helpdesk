<?php use_helper('Text', 'Date') ?>
<?php 
// обьявление фильтров
if ($show_added_field)
{
   $filters = array(
        '2'=>__("Claimtype"),
        '3'=>__("Added filed lable"),
        '6'=>__("Status"),
        '7'=>__("Importance"),
      );  
} else 
$filters = array(
        '2'=>__("Claimtype"),
        '5'=>__("Status"),
        '6'=>__("Importance"),
      );
include_partial('common/datatables_general', array('filters'=> $filters)); 
?>    
 

<div class="groupbox"><?php echo __('Open claims')?> 
      <div style="float:right;">
          <a href="<?php echo url_for('claimopened/new') ?>" class="add">
              <?php echo __('Create claim')?>
          </a>
      </div>
</div>
<br />
<!--вставка фильтров-->
<?php include_partial('common/datatables_show_filters', array('filters'=> $filters)); ?> 
<!--вставка фильтров конец-->

<table cellspacing="0" width="100%" class="gray" id="example">  
  <thead>
    <tr>
      <th> </th>
      <th><?php echo __('Claim №')?></th>
      <th><?php echo __('Claimtype')?></th>
      <?php if ($show_added_field):?>
      <th><?php echo __('Added filed lable')?></th> 
      <?php endif;?>
      <th><?php echo __('Departments')?></th>
      <th><?php echo __('Createdatetime')?></th>
      <th><?php echo __('Status')?></th>
      <th><?php echo __('Importance')?></th>
      <th><?php echo __('Kurator')?></th>
      <th><?php echo __('Stuff')?></th>
      <th><?php echo __('Actions')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($claimsopen as $claim): ?>
    <tr <?php if ($claim['is_not_read']) echo 'class="notread"'?>>
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
      <td><?php echo $claim['claimtype'] ?></td>
      <?php if ($show_added_field):?>
      <td><?php echo $claim['departments_added_filed'] ?></td> 
      <?php endif;?>
      <td><?php echo $claim['departments_address'] ?></td>
      <td><?php echo format_date($claim['createdatetime'], 'dd.MM.yyyy, HH:mm', 'ru'); ?></td>
      <td><?php echo $claim['status'] ?></td>
      <td style="color: <?php echo $claim['importance_color']?>;"><?php echo $claim['importance_name'] ?></td> 
      <td><?php echo $claim['kurator'] ?></td>
      <td><?php echo $claim['stuff'] ?></td>
      <td>
      <ul class="sf_admin_td_actions">
         <li class="sf_admin_action_view">
             <a href="<?php echo url_for('messages')?>/show/claimid/<?php echo $claim['id'] ?>"><?php echo __('Show claim')?></a>
        </li>    
        <li class="sf_admin_action_delete">
            <a onclick="if (!confirm('<?php echo __('Are you sure you want close claim?')?>')){return false}; " href="<?php echo url_for('claimopened/close').'/claimid/'.$claim['id'] ?>"><?php echo __('Close_claim')?></a>
        </li>  
      </ul>
      </td>
      
    </tr>
     <?php endforeach; ?>
  </tbody>
</table>       



