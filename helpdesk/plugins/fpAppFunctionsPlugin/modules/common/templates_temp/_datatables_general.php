<?php 
$prefix  = (isset($prefix)) ? '_'.$prefix : '';
$filters_data  = (isset($filters_data)) ? $filters_data : null;
$full_path = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR."fpAppFunctionsPlugin".DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;
$date_sorting = isset($date_sorting) ? $date_sorting : null;
?>
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

function fnCreateSelect( aData )
{
    var r='<select><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r+'</select>';
}


<?php  
$app = sfContext::getInstance()->getConfiguration()->getApplication();
if ($app == 'finance')
(file_exists($full_path.'_datatables_additional_functions'.$prefix.'.php')) ? include_partial('common/datatables_additional_functions'.$prefix) : null?>

$(document).ready(function(){
   <?php (file_exists($full_path.'_datatables_before'.$prefix.'.php')) ? include_partial('common/datatables_before'.$prefix) : null?>
    var oTable = $('#example').dataTable({
            <?php (file_exists($full_path.'_datatables_language'.$prefix.'.php')) ?  include_partial('common/datatables_language'.$prefix) : null?>
            <?php (file_exists($full_path.'_datatables_colspan'.$prefix.'.php')) ? include_partial('common/datatables_colspan'.$prefix) : null?>
            <?php (file_exists($full_path.'_datatables_settings'.$prefix.'.php')) ? include_partial('common/datatables_settings'.$prefix, array('date_sorting' => $date_sorting)): null?>
    });
    <?php (file_exists($full_path.'_datatables_additional_functions'.$prefix.'.php')) ?  include_partial('common/datatables_after'.$prefix) : null?>  
    
    
    <?php (file_exists($full_path.'_datatables_filters'.'.php')) ?  include_partial('common/datatables_filters', array('filters'=> $filters, 'filters_data'=>$filters_data, 'prefix'=>$prefix)) : null?>
    
    <?php 
    if ($app == 'finance') 
    (file_exists($full_path.'_datatables_additional_filters'.$prefix.'.php')) ? include_partial('common/datatables_additional_filters'.$prefix) : null?>
        
    
    
});
</script>
<?php // обязательно partial подключать с запятой вконце!!!!!?>