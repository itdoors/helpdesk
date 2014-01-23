<?php use_helper('Text', 'Date') ?>    

<script>
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

(function($) { 
$.fn.dataTableExt.oApi.fnSortNeutral = function ( oSettings )
{
    /* Remove any current sorting */
    oSettings.aaSorting = [];
    
    /* Sort display arrays so we get them in numerical order */
    oSettings.aiDisplay.sort( function (x,y) {
        return x-y;
    } );
    oSettings.aiDisplayMaster.sort( function (x,y) {
        return x-y;
    } );
    
    /* Redraw */
    oSettings.oApi._fnReDraw( oSettings );
}
}(jQuery));


function fnCreateSelect( aData )
{
    var r='<select><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r+'</select>';
}


$(document).ready(function() {
    /* Initialise the DataTable */
    var oTable = $('#example').dataTable( {
        "bPaginate": false,
        "aaSorting": [[ 1, "desc" ]], 
        "oLengthMenu": false,
        "oLanguage": {
            "sSearch": "<?php echo __('Search')?>",
            "sLengthMenu": "<?php echo __('Show')?> _MENU_ <?php echo __('entries')?>",
            "sInfo": "<?php echo __('Showing')?> _START_ <?php echo __('to')?> _END_ <?php echo __('of')?> _TOTAL_ <?php echo __('entries')?>",
            "sInfoFiltered": "(<?php echo __('filtered from')?> _MAX_ <?php echo __('total entries')?>)",
            "sZeroRecords": "<?php echo __('No matching records found')?>",
            "sInfoEmpty": "<?php echo __('Showing')?> 0 <?php echo __('to')?> 0 <?php echo __('of')?> 0 <?php echo __('entries')?>",
        },
        "fnDrawCallback": function ( oSettings ) {
            if ( oSettings.aiDisplay.length == 0 )
            {
                return;
            }
            
            var nTrs = $('#example tbody tr');
            var iColspan = nTrs[0].getElementsByTagName('td').length;
            var sLastGroup = "";
            for ( var i=0 ; i<nTrs.length ; i++ )
            {
                var iDisplayIndex = oSettings._iDisplayStart + i;
                var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[0];
                if ( sGroup != sLastGroup )
                {
                    var nGroup = document.createElement( 'tr' );
                    var nCell = document.createElement( 'td' );
                    nCell.colSpan = iColspan;
                    nCell.className = "group";
                    nCell.innerHTML = sGroup;
                    nGroup.appendChild( nCell );
                    if (nTrs[i+1]) nTrs[i].parentNode.insertBefore( nGroup, nTrs[i+1] );
                    else nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] )
                    //else nTrs[i].parentNode.insertBefore( nGroup, nTrs[i-1] )
                    sLastGroup = sGroup;
                }
            }
        },               
        "aoColumnDefs": [
            { "bVisible": false, "aTargets": [ 0 ] }
        ], 
        "bStateSave": true,
        /*"fnInitComplete": function() {
                var oSettings = $('#example').dataTable().fnSettings();
                for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                    if(oSettings.aoPreSearchCols[3].sSearch.length>0){
                        //$(".filter_departments select").selected = oSettings.aoPreSearchCols[i].sSearch;
                        //$(".filter_departments select").className = "";
                    }
                }
            }  */
    
    } );
    new FixedHeader(oTable);    
    /* Add a select menu for each TH element in the table footer */
   
$("#clear_filter").live('click', function (){
    fnResetAllFilters();
    getStatus();
    getDepartments();
    getImportance();
})

function fnResetAllFilters() {
    var oSettings = oTable.fnSettings();
    for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
        oSettings.aoPreSearchCols[ iCol ].sSearch = '';
    }
    oTable.fnDraw();
    //console.log(oSettings);
}
function getDepartments()
{   
    $(".filter_departments").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(3) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 3 );
        } );
    } );
    
} 
function getStatus() 
{   
    $(".filter_status").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(5) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 5 );
        } );
    } );
}
function getImportance() 
{   
    $(".filter_importance").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(6) );
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), 6 );
        } );
    } );
}      

getStatus();
getDepartments();
getImportance();
} );
  
</script>

<div class="groupbox">Открытые заявки <div style="float:right;"><a href="<?php echo url_for('claimopened/new') ?>" class="add">Создать заявку</a></div></div>
<br />
<div class="filter_outer">Отделение: <div class="filter_departments"></div></div>
<div class="filter_outer">Статус: <div class="filter_status"></div></div>
<div class="filter_outer">Важность: <div class="filter_importance"></div></div>
<div class="filter_outer"><br /><input type="button" value="<?php echo __('Clear filter')?>" id="clear_filter"></div>      
<table cellspacing="0" width="100%" class="gray" id="example">  
  <thead>
    <tr>
      <th></th>
      <th>Номер №</th>
      <th>Отдел</th>
      <th>Отделение</th>
      <th>Дата создания</th>
      <th>Статус</th>
      <th>Важность</th>
      <th>Куратор</th>
      <th>Исполнитель</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($claimsopen as $claim): ?>
    <tr <?php if (!$claim->IsRead()) echo 'class="notread"'?>>
      <td class="<?php if (!$claim->IsRead()) echo 'notread'?>"><?php echo __('Work list')?>: <?php echo htmlspecialchars_decode(str_replace(' &lt;br /&gt;',' ', $claim->getWorkList()))?><span style="color:#F3F5F7; text-indent: -9999px;"><?php echo $claim->getId()?></span></td> 
      <td><?php echo $claim->getId() ?></td>
      <td><?php echo $claim->getClaimtype() ?></td>
      <td><?php echo $claim->getDepartments() ?></td>
      <td><?php echo $claim->getCreatedatetime() ?></td>
      <td><?php echo $claim->getStatus() ?></td>
      <td style="color: <?php echo $claim->getImportanceColor()?>;"><?php echo $claim->getImportance() ?></td>
      <td><?php echo $claim->getKurator() ?></td>
      <td><?php echo $claim->getStuff() ?></td>
      <td>
      <ul class="sf_admin_td_actions">
             <li class="sf_admin_action_view">
                 <a href="messages/show/claimid/<?php echo $claim->getId() ?>">Посмотреть переписку</a>
            </li>    
            <li class="sf_admin_action_delete">
                <a onclick="if (!confirm('Вы уверены что хотите закрыть заявку?')){return false}; " href="<?php echo url_for('claimopened/close').'/claimid/'.$claim->getId() ?>">Закрыть</a>
            </li>  
       </ul>
      
      </td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>       



