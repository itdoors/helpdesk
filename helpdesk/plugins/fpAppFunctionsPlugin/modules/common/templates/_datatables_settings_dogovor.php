        "sDom": 'T<"clear">lfrtip',
        "aaSorting": [],
        <?php $app = sfContext::getInstance()->getConfiguration()->getApplication();  
        if ($app == 'finance') : ?>
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "sType": "eu_date" },
            null,
            null,
            { "sType": "eu_date" },
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "sType": "eu_date" }
        ],
        <?php endif;?>  
        "bPaginate": false,
        "bSort": true,
        "bStateSave": false,
        "oTableTools": {
            "oFeatures": {
                "bCsv": false,
                "bXls": true,
                "bCopy": false,
                "bPrint": true
            },
        }
        <?php   
        if ($app == 'dogovor') : ?>
        ,
        
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

            var total = 0;                  
            
            for ( var i=iStart ; i<iEnd; i++ )
            {
                 total+= aaData[aiDisplay[i]][14].replace(',', '.')*1;
            }
            
            consloe.log('123');
            var nCells = $('#example ').getElementsByTagName('th');
            nCells[14].innerHTML = (total).toFixed(2);
        } <?php endif;?>
