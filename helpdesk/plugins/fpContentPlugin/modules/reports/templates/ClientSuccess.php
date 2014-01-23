<?php use_helper('Text', 'Date') ?>    
 
<script>
$(document).ready( function () {
    
    TableToolsInit.sSwfPath = "/js/media/swf/ZeroClipboard.swf";
    TableToolsInit.oFeatures.bCsv = false;
    TableToolsInit.oFeatures.bCopy = false;
     var oTable = $('#example').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "bPaginate": false,
        "oLanguage": {
            "sSearch": "<?php echo __('Search')?>",
            "sLengthMenu": "<?php echo __('Show')?> _MENU_ <?php echo __('entries')?>",
            "sInfo": "<?php echo __('Showing')?> _START_ <?php echo __('to')?> _END_ <?php echo __('of')?> _TOTAL_ <?php echo __('entries')?>",
            "sInfoFiltered": "(<?php echo __('filtered from')?> _MAX_ <?php echo __('total entries')?>)",
            "sZeroRecords": "<?php echo __('No matching records found')?>",
            "sInfoEmpty": "<?php echo __('Showing')?> 0 <?php echo __('to')?> 0 <?php echo __('of')?> 0 <?php echo __('entries')?>",
        },
        "oTableTools": {
            "oFeatures": {
                "bCsv": false,
                "bXls": true,
                "bCopy": false,
                "bPrint": true
            },
        },
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
            /*
             * Calculate the total market share for all browsers in this table (ie inc. outside
             * the pagination)
             */
            var costs = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
                 costs+= aaData[aiDisplay[i]][16]*1;
            }
            
            /* Calculate the market share for browsers on this page */
            var income = 0;
            for (var i=iStart ; i<iEnd ; i++)
            {
                 income+= aaData[aiDisplay[i]][14]*1;
            }
            
            var profitability = 0;
            var profitability_count = 0;
            for (var i=iStart ; i<iEnd ; i++ )
            {
                 profitability+= aaData[i][17]*1;
                 if ( aaData[i][17]*1 != ''&&aaData[aiDisplay[i]][17]*1 != '0') profitability_count++;
            }
            
            var profitability_percent = 0;
            var profitability_percent_count = 0;
            for (var i=iStart ; i<iEnd ; i++)
            {
                 profitability_percent+= aaData[aiDisplay[i]][18]*1;
                 if ( aaData[i][18]*1 != ''&&aaData[aiDisplay[i]][18]*1 != '0') profitability_percent_count++;
            }
            
            /*var income = 0;
            for ( var i=0 ; i<aaData.length ; i++ )
            {
                 income+= aaData[i][14]*1;
            }*/
            
            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('th');
            //nCells[16].innerHTML = parseInt(iPageMarket * 100)/100 +'% ('+ parseInt(iTotalMarket * 100)/100 +'% total)';
            nCells[16].innerHTML = costs;
            nCells[14].innerHTML = income;
            if (profitability_count) nCells[17].innerHTML = Math.round(profitability/profitability_count);
            if (profitability_percent_count) nCells[18].innerHTML = profitability_percent/profitability_percent_count;
        }
        
        
    } );

    //new FixedHeader(oTable); 
 
    $(".filter_organization").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(5) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 5 );
        } );
    } );
    $(".filter_claimtype").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(4) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 4 );
        } );
    } );
  
    
    $(".filter_region").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(6) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 6 );
        } );
    } );
    $(".filter_departments").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(8) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 8 );
        } );
    } );
    $(".filter_city").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(7) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 7 );
        } );
    } );
   $(".filter_importance").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(9) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 9 );
        } );
    } );
   $(".filter_status").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(10) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 10 );
        } );
    } );

} );
 

function fnShowHide( iCol )
{
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var oTable = $('#example').dataTable();
    
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

(function($) {
/*
 * Function: fnGetColumnData
 * Purpose:  Return an array of table values from a particular column.
 * Returns:  array string: 1d data array 
 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
 *           int:iColumn - the id of the column to extract the data from
 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
 */
$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return new Array();
    
    // by default we only wany unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;
    
    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;
    
    // by default we do not wany to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
    
    // list of rows which we're going to loop through
    var aiRows;
    
    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay; 
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers

    // set up data array    
    var asResultData = new Array();
    
    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var aData = this.fnGetData(iRow);
        var sValue = aData[iColumn];
        
        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;

        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
        
        // else push the value onto the result data array
        else asResultData.push(sValue);
    }
    
    return asResultData;
}}(jQuery));


function fnCreateSelect( aData )
{
    var r='<select><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r+'</select>';
}
</script>    
<a href="javascript:void(0);" onclick="fnShowHide(0);" >Номер</a> |
<a href="javascript:void(0);" onclick="fnShowHide(1);" >MPK</a> |
<a href="javascript:void(0);" onclick="fnShowHide(2);" >Дата создания</a> |
<a href="javascript:void(0);" onclick="fnShowHide(3);" >Дата закрытия</a> |
<a href="javascript:void(0);" onclick="fnShowHide(4);" >Отдел</a> |
<a href="javascript:void(0);" onclick="fnShowHide(5);" >Организация</a> |
<a href="javascript:void(0);" onclick="fnShowHide(6);" >Область</a> |
<a href="javascript:void(0);" onclick="fnShowHide(7);" >Город</a> |
<a href="javascript:void(0);" onclick="fnShowHide(8);">Oтделения</a> |
<a href="javascript:void(0);" onclick="fnShowHide(9);">Важность</a> |
<a href="javascript:void(0);" onclick="fnShowHide(10);">Статус</a> |
<a href="javascript:void(0);" onclick="fnShowHide(11);">Список работ</a> |
<a href="javascript:void(0);" onclick="fnShowHide(12);">Стоимость для клиента</a> |
<a href="javascript:void(0);" onclick="fnShowHide(13);">Наши затраты</a> |<br />

<?php echo __('Filters')?> <br />
Отдел: <div class="filter_claimtype"></div>
Организация: <div class="filter_organization"></div>
Область: <div class="filter_region"></div>
Город: <div class="filter_city"></div> 
Отделение: <div class="filter_departments"></div>  
Важность: <div class="filter_importance"></div>
Статус: <div class="filter_status"></div>

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
      <th>Доход с НДС</th>
      <th>Затраты с НДС</th> 
<!--      <th>Доход (без НДС)</th>
      <th>Доход (с НДС)</th>  -->
<!--      <th>Затраты</th>
      <th>Статус</th> -->
      <th>Смета</th>
      <th>Документы по доходам</th>
      <th>Документы по затратам</th>
      <th>Рентабельность</th>
      <th>% Рентабельности</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $claim): ?>
    <tr class="claim_border">
      <td><a href="<?php echo url_for('messages/show')."/claimid/".$claim->getId();?>"><?php echo $claim->getId() ?></a></td>
      <td><?php echo $claim->getDepartments()->getMpk() ?></td> 
      <td ><?php echo $claim->getCreatedatetimeGood() ?></td>
      <td ><?php echo $claim->getClosedatetimeGood() ?></td>
      <td ><?php echo $claim->getClaimtype() ?></td>
      <td><?php echo $claim->getOrganization() ?></td>
      <td><?php echo $claim->getDepartments()->getCity()->getRegion()?></td>
      <td><?php echo $claim->getDepartments()->getCity() ?></td>
      <td><?php echo $claim->getDepartments()->getName() ?></td>
      <td><?php echo $claim->getImportance() ?></td>
      <td><?php echo $claim->getStatus() ?></td>
      <td><?php echo htmlspecialchars_decode(str_replace(' &lt;br /&gt;',' ', $claim->getWorkList()))?></td>
      <td><?php echo $claim->showTotalIncomeString();//echo $claim->getDescription() ?></td>
      <td><?php echo $claim->showTotalCostsString();//echo $claim->getOurcosts() ?></td>
      
<!--      <td><?php //echo $claim->getFinanceClaim()?round($claim->getFinanceClaim()->getIncomeNonnds(),2):''; ?></td>
      <td><?php //echo $claim->getFinanceClaim()?round($claim->getFinanceClaim()->getIncomeNds(),2):''; ?></td> -->
<!--      <td><?php //echo $claim->showTotalCostsString(); ?></td>
      <td> 
         <?php //echo get_component('claim', 'fstatus',array('claim'=>$claim))?>
      </td>   -->
      <td><?php echo get_component('claim', 'documents',array('documents'=>$claim->getDocumentHolder(sfConfig::get('dcotype_smeta'))))?></td>
      <td>
         <?php //echo get_component('claim', 'documents',array('documents'=>$claim->getDocumentHolder(sfConfig::get('dcotype_akt_income'))))?>
         <?php //echo get_component('claim', 'documents',array('documents'=>$claim->getDocumentHolder(sfConfig::get('dcotype_nakl_income'))))?>
      
      </td>
      <td>
         <?php //echo get_component('claim', 'documents',array('documents'=>$claim->getDocumentHolder(sfConfig::get('dcotype_akt_costs'))))?>
         <?php //echo get_component('claim', 'documents',array('documents'=>$claim->getDocumentHolder(sfConfig::get('dcotype_nakl_costs'))))?>
      
      </td>
      <td><?php echo $claim->getProfitability();//echo $claim->getFinanceClaim()?round($claim->getFinanceClaim()->getProfitability(),2):''; ?></td>
      <td>
         <?php echo $claim->getProfitabilityPersent();?>
         <?php //echo get_component('claim', 'fProfitability_persent',array('claim'=>$claim))?>  
         <?php //echo $claim->getFinanceClaim()?$claim->getFinanceClaim()->getProfitabilityResponse():''; ?>
      </td>
    </tr>

<!--    <tr >
      <td colspan="11" class="claim_border"><?php echo __('Work list')?>: <?php echo $claim->getStuffDescription()?></td>
    </tr> -->
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
<!--      <th></th>
      <th></th> -->
<!--      <th></th>
      <th></th> -->
      <th></th>
      <th></th>
    </tr>
  </tfoot>
</table>       



