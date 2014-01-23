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
        if ($app == 'dispatcher') : ?>
        ,
        
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

            var count = 0;                  
           
            for ( var i=iStart ; i<iEnd; i++ )
            {
                 count+= aaData[aiDisplay[i]][2]*1;
            }
            
            var nCells = nRow.getElementsByTagName('th');
            nCells[2].innerHTML = count;
           
            
        } <?php endif;?>    
