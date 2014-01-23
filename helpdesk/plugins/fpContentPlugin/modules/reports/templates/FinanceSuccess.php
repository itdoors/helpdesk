 <?php use_helper('Text', 'Date') ?>
<?php 
// обьявление фильтров
$filters = array(
        '2'=>'city_key',
        '3'=>'region_key',
        '4'=>'company_key',
        '7'=>'status_key',
        //'8'=>'departments_key',
        //'9'=>'importance_key',
        //'10'=>'status_key',
        
      );
//include_partial('common/datatables_general', array('filters'=> $filters, 'prefix'=>'reports', 'filters_data' => $filters_data)); 
include_partial('common/datatables_general', array('filters'=> $filters, 'prefix'=>'reports',)); 
?>  

<?php echo __('Filters')?> <br />

<br />
<!--вставка фильтров-->
<div class="filter_outer">
work_key:
    <div class="filter1">
       <select>
         <option></option>
         <option>d</option>
         <option>r</option>
         <option>t</option>
         <option>k</option>
       </select>
    </div>
</div>


<?php //include_partial('common/datatables_show_filters', array('filters'=> $filters, 'filters_data' => $filters_data)); ?> 
<?php include_partial('common/datatables_show_filters', array('filters'=> $filters)); ?> 
<div class="filter_outer">Активность<br />
с: <input type="text" id="fini" style="width: 65px;min-width: 65px;"> 
по: <input type="text" id="ffin" style="width: 65px; min-width: 65px;"></div> 
<!--вставка фильтров конец-->



<br /><br />
<form action="<?php echo url_for('reports/index')?>">
  <input type="submit" value="Переформировать отчет">
</form>

<table cellspacing="0" class="gray" id="example" width="100%">  
 
  <thead>
    <tr>
      <th>MPK</th>
      <th>Адрес</th>
      <th>Город</th>
      <th>Область</th>
      <th>Регион(наш)</th>
      <th>Работа</th>
      <th>№ заявки</th>
      <th>Дата создания</th>
      <th>Клиент</th>
      <th>Статус заявки</th>
      <th>Дата выполнения</th>
      <th>Номер сметы</th>
      <th>Затраты без НДС</th>
      <th>Затраты нал</th>
      <th>Докс</th>
      <th>Доход без НДС</th>
      <th>PF1(uah)</th>
      <th>PF1%</th>
      <th>№ бух. акта</th>
      <th>Дата акта</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $finance_claim): ?>
   
    <tr class="claim_border">
      <td><?php echo $finance_claim['mpk'] ? $finance_claim['mpk'] : ''?></td>
      <td><?php echo $finance_claim['departments_address']?></td>
      <td><?php echo $finance_claim['city']?></td>
      <td><?php echo $finance_claim['region']?></td>
      <td><?php echo $finance_claim['company_structure']?></td>
      <td><?php echo $finance_claim['work']?></td>
      <td><a href="<?php echo url_for('messages').'/show/claimid/'.$finance_claim['claim_id']?>"> <?php echo $finance_claim['claim_id']?></a></td>
      <td><?php echo format_date($finance_claim['claim_createdate'], 'dd.MM.yyyy', 'ru');?></td> 
      <td><?php echo $finance_claim['client']?></td> 
      <td><?php echo $finance_claim['claim_status']?></td> 
      <td><?php echo format_date($finance_claim['status_last_date'], 'dd.MM.yyyy', 'ru');?></td>
      <td><?php echo $finance_claim['smeta_number']?></td>
      <td><?php echo $finance_claim['costs_nonnds'] ? str_replace('.', ',',sprintf("%01.2f", $finance_claim['costs_nonnds'])) : ''?></td>
      <td><?php echo $finance_claim['costs_n'] ? str_replace('.', ',',sprintf("%01.2f", $finance_claim['costs_n'])) : ''?></td>
      <?php $documents = explode('-*;*-', $finance_claim['document_name']);?>
      <td <?php 
      if (empty($documents[0])): ?> style="background-color: #ff0000;" <?php endif;?>>
      <?php 
        if (!empty($documents[0])){
            $i = 0; 
            foreach($documents as $document_filepath)  
            {
                $document = explode('-:::-', $document_filepath);
                $document_name =  $document[0];
                $filepath =  isset($document[1]) ? $document[1] : '';
                echo '<a href="'.sfConfig::get('sf_upload_documentsfiles').$filepath.'" target="_blank">'.$document_name.'</a><br />';
            }
        }   
      ?> 
      </td>
      <td><?php echo $finance_claim['income_nonnds'] ? str_replace('.', ',',sprintf("%01.2f", $finance_claim['income_nonnds'])) : ''?></td>
      <td><?php 
      $profitability = $finance_claim['profitability'];  
      $profitability_percent =  $finance_claim['income_nonnds'] ? str_replace('.', ',',sprintf("%01.2f", $profitability / $finance_claim['income_nonnds'])*100) : '';
      echo  str_replace('.', ',',sprintf("%01.2f",  $profitability))?></td>
      <td style="font-weight: bold; <?php echo ($profitability_percent<0) ? ' color:#ff0000' : ''?>"><?php echo $profitability_percent?></td>
      <td><?php echo $finance_claim['bill_number']?></td>
      <td><?php echo format_date($finance_claim['akt_date'], 'dd.MM.yyyy', 'ru');?></td>
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
      
    </tr>
  </tfoot>
</table>



