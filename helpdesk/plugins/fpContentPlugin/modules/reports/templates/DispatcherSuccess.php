 <?php use_helper('Text', 'Date') ?>
<?php 
// обьявление фильтров
$filters = array(
        '4'=>'claimtype_key',
        '5'=>'organization_key',
        '6'=>'region_key',
        '7'=>'city_key',
        '8'=>'departments_key',
        '9'=>'importance_key',
        '10'=>'status_key',
        
      );
$filters_data = array();
include_partial('common/datatables_general', array('filters'=> $filters, 'prefix'=>'reports')); 
?>  

<?php echo __('Filters')?> <br />

<br />
<!--вставка фильтров-->
<?php include_partial('common/datatables_show_filters', array('filters'=> $filters, 'filters_data' => $filters_data)); ?> 
<!--вставка фильтров конец-->



<br /><br />
<form action="<?php echo url_for('reports/index')?>">
  <input type="submit" value="Переформировать отчет">
</form>

<table cellspacing="0" class="gray" id="example" width="100%">  
 
  <thead>
    <tr>
      <th>№</th>
      <th>MPK</th>
      <th>Дата создания</th>
      <th>Дата закрытия</th>
      <th>Отдел</th>
      <th>Организация</th>
      <th>Область</th>
      <th>Город</th>
      <th>Отделение</th>
      <th>Важность</th>
      <th>Статус</th>
      <th>Список работ</th>
      <th>Доход без НДС</th>
      <th>Доход с НДС</th>
      <th>Затраты Нал</th> 
      <th>Затраты без НДС</th> 
      <th>Затраты с НДС</th> 
      <th>Затраты безнал без НДС</th> 
      <th>Номер сметы</th>
      <th>Номер акта</th>
      <th>Акты</th>
      <th>PF1</th>
      <th>PF1%</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $claim): ?>
   
    <tr class="claim_border">
      <td><a href="<?php echo url_for('messages')."/show/claimid/".$claim['id'];?>"><?php echo $claim['id'] ?></a></td>
      <td><?php  echo $claim['mpk'] ?></td> 
      <td><?php echo format_date($claim['createdatetime'], 'dd.MM.yyyy, HH:mm', 'ru'); ?></td>
      <td><?php echo format_date($claim['closedatetime'], 'dd.MM.yyyy, HH:mm', 'ru'); ?></td>
      <td><?php echo $claim['claimtype']?></td>
      <td><?php echo $claim['organization_name'] ?></td>
      <td><?php echo $claim['region']?></td>
      <td><?php echo $claim['city_name']  ?></td>   
      <td><?php echo $claim['departments_address'] ?></td>
      <td style="color: <?php echo $claim['importance_color']?>;"><?php echo $claim['importance_name'] ?></td> 
      <td><?php echo $claim['status'] ?></td>
      <td><?php 
        $worklist = explode('-*;*-', $claim['worklist']);
        $i = 0;
        foreach($worklist as $work_price)  
        {
            $work = explode('-pr;pr-', $work_price);
            $work_name =  trim($work[0]);
            $work_price =  isset($work[1]) ? '<b>('.str_replace('.', ',',trim($work[1])).')</b>' : '';
            
            echo $work_name ? "<b>".++$i.".</b> ".$work_name." ".$work_price."<br />" : ''; 
            //echo $work_name ? "<b>".++$i.".</b> ".$work_name." ".$work_price." " : ''; 
        }   
      ?></td>
      <td><?php echo $claim['total_incomenonnds'] ? str_replace('.', ',',sprintf("%01.2f", $claim['total_incomenonnds'])) : ''?></td> 
      <td><?php echo str_replace('.', ',', $claim['total_income'])?></td>
      <td><?php echo str_replace('.', ',',$claim['total_costs_nal'])?></td> 
      <td><?php echo str_replace('.', ',',$claim['total_costsnonnds'])?></td> 
      <td><?php echo str_replace('.', ',',$claim['total_costs'])?></td>
      <td><?php echo str_replace('.', ',',$claim['total_costsbeznalnonnds'])?></td>

      <td><?php echo $claim['smeta_number']?></td>
      <td><?php echo $claim['bill_number']?></td>
      <td>
      <?php 
        $documents = explode('-*;*-', $claim['document_name']);
        $i = 0;
        foreach($documents as $document_filepath)  
        {
            $document = explode('-:::-', $document_filepath);
            $document_name =  $document[0];
            $filepath =  isset($document[1]) ? $document[1] : '';
            // document date
            if (isset($document[1]))
            {
              $document_date = explode('-:d:-', $document[1]);
              if (isset($document_date[0]) && isset($document_date[1]))
              {
                $filepath = $document_date[0];
                $document_date = strtotime($document_date[1]);
                $document_date = format_date($document_date, 'dd.MM.yyyy', 'ru');
                $document_name .= " ($document_date)";
              }
            }
            //eof document date  
            
            echo '<a href="'.sfConfig::get('sf_upload_documentsfiles').$filepath.'" target="_blank">'.$document_name.'</a><br />';
       }   
      ?> 
      </td>
      <td><?php 
      $profitability = ($claim['total_income'] - $claim['total_costs']);  
      $profitability_percent =  $claim['total_income'] ? str_replace('.', ',',sprintf("%01.2f", $profitability / $claim['total_income'])*100) : '';
      echo  str_replace('.', ',',$profitability)?></td>
      <td><?php echo $profitability_percent?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
   <tfoot>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
</table>



