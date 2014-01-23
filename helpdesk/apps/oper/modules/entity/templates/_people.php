<?php if (sizeof($result)):?>
<table cellspacing="0" width="100%" class="gray">
<?php foreach($result as $res):?>
  <tr>
    <td>
      <?php echo $res['fullname'];?>
    </td>
    <td>
      <?php if (isset($res['kurator']) || isset($res['stuff'])):?>
        <table cellspacing="0" width="100%" class="gray">
          <?php if (isset($res['kurator'])):?>
          <tr>
            <td><?php echo __('Kurator')?></td>
            <td>
              <?php foreach($res['kurator'] as $claimtype):?>
                <?php echo $claimtype?><br />
              <?php endforeach;?>
            </td>
          </tr>  
          <?php endif;?>
          <?php if (isset($res['stuff'])):?>
          <tr>
            <td><?php echo __('Staff')?></td>
            <td>
              <?php foreach($res['stuff'] as $claimtype):?>
                <?php echo $claimtype?><br />
              <?php endforeach;?>
            </td>
          </tr>  
          <?php endif;?> 
        </table>
      <?php endif;?>
    </td>
  </tr>  
<?php endforeach;?>
</table>
<?php endif;?>
