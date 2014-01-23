<?php echo use_helper('I18N')?>
<?php if (count($lists)) echo "<table>"; else echo __('No depatments appointed')?>
<?php foreach ($lists as $list) : ?>
<tr>
  <td><?php echo $list->getDepartments();?></td>
  <td><?php echo $list->getUserkey();?></td>
  <td><?php echo $list->getClaimtype();?></td>
  <td><?php echo $list->getDepartments()->getOrganization();?></td>
</tr>  
<?php endforeach;?>
<?php if (count($lists)) echo "</table>";?>