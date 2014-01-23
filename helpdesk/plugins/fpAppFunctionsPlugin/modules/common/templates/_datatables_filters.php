$("#clear_filter").live('click', function (){
    fnResetAllFilters();
    <?php foreach ($filters as $key => $value):?>
         getFilter<?php echo $key?>();
    <?php endforeach;?>
})

function fnResetAllFilters() {
    var oSettings = oTable.fnSettings();
    for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
        oSettings.aoPreSearchCols[ iCol ].sSearch = '';
    }
    oTable.fnDraw();
    <?php if ($prefix) include_partial('common/datatables_additional_filters_clean'.$prefix);?>
}


<?php foreach ($filters as $key => $value):?>
function getFilter<?php echo $key?>()
{   
    $(".filter<?php echo $key?>").each( function ( i ) {
        <?php 
        if (!$filters_data) : ?>this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(<?php echo $key?>) );<?php endif;?>
        $('select', this).change( function () {
            oTable.fnFilter( $(this).val(), <?php echo $key;?> );
        } );
    } );
} 
<?php endforeach;?>
<?php foreach ($filters as $key => $value):?>
    getFilter<?php echo $key?>();
<?php endforeach;?>





