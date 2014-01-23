            <?php 
            $date_sorting = isset($date_sorting) ? $date_sorting->getRawValue() : null;
            $app = sfContext::getInstance()->getConfiguration()->getApplication();
            $module = sfContext::getInstance()->getModuleName();
            ?>
            "aaSorting": [[ 1, 'desc' ]],
            "sDom": 'l<?php if ($app != 'client'):?>f<?php endif;?>r<"giveHeight"t>ip',
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "bStateSave": true
            <?php if ($date_sorting):?>
              ,"aoColumns": [
              <?php for ($i = 0; $i < $date_sorting['columns_count']; $i++):?>
                <?php if (in_array($i, $date_sorting['sort_columns'])):?>
                { "sType": "eu_date" }
                <?php else:?>
                null 
                <?php endif;?>
                <?php if ($i < $date_sorting['columns_count']-1) : ?>,<?php endif;?>
              <?php endfor;?>
              ]
            <?php endif; ?>
            <?php if ($summ_columns):?>
            ,"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

               var nCells = nRow.getElementsByTagName('th');
               <?php foreach($summ_columns as $column):?>
               var total = 0;                  
               var current_column = <?php echo $column?>;
                  
               for ( var i=iStart ; i<iEnd; i++ )
               {
                    total+= aaData[aiDisplay[i]][current_column].replace(',', '.')*1;
               }
               
               nCells[current_column].innerHTML = (total).toFixed(2);
               <?php endforeach;?>
            }
            <?php endif?> 