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
           }
        }
        <?php   
        if ($app == 'finance') : ?>
        ,
        
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

            var costs_nonnds = 0;                  
            var costs_n = 0;                  
            var income_nonnds = 0;                  
           
            for ( var i=iStart ; i<iEnd; i++ )
            {
                 costs_nonnds+= aaData[aiDisplay[i]][12].replace(',', '.')*1;
            }
            
            for ( var i=iStart ; i<iEnd; i++ )
            {
                 costs_n+= aaData[aiDisplay[i]][13].replace(',', '.')*1;
            }
            
            for ( var i=iStart ; i<iEnd; i++ )
            {
                 income_nonnds+= aaData[aiDisplay[i]][15].replace(',', '.')*1;
            }
            


           
            var nCells = nRow.getElementsByTagName('th');
            nCells[12].innerHTML = (costs_nonnds).toFixed(2);
            nCells[13].innerHTML = (costs_n).toFixed(2);
            nCells[15].innerHTML = (income_nonnds).toFixed(2);
            profitability =  income_nonnds - (costs_nonnds+costs_n);
            nCells[16].innerHTML = (profitability).toFixed(2);
            if (income_nonnds) nCells[17].innerHTML = (profitability/income_nonnds*100).toFixed(2);  
            
        } <?php endif;?>
            
