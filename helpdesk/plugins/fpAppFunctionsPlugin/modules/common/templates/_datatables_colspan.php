        <?php 
        $app = sfContext::getInstance()->getConfiguration()->getApplication(); 
        $module = $sf_request->getParameter('module');
        $non_colspan_app = array('dogovor', 'oper');
        $non_colspan_modules = array('departmentsorganization');
        
        
        if (!in_array($app, $non_colspan_app) && !in_array($module, $non_colspan_modules)) :?>
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
                        nTrs[i].parentNode.insertBefore( nGroup, nTrs[i].nextSibling );
                        sLastGroup = sGroup;
                    }
                }
            },
            "aoColumnDefs": [
                { "bVisible": false, "aTargets": [ 0 ] }
            ],
            <?php endif;?>