$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {

        var iFini = document.getElementById('fini').value;
        var iFfin = document.getElementById('ffin').value;
        var iStartDateCol = 19;
        var iEndDateCol = 19;
        
        iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2)
        iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2)         
        
        var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
        var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);
        
        if ( iFini == "" && iFfin == "" )
        {
            return true;
        }
        else if ( iFini <= datofini && iFfin == "")
        {
            return true;
        }
        else if ( iFfin >= datoffin && iFini == "")
        {
            return true;
        }
        else if (iFini <= datofini && iFfin >= datoffin)
        {
            return true;
        }
        return false;
    }
    
);

function str_replace_reg(haystack, needle, replacement) { 
    var r = new RegExp(needle, 'g'); 
    return haystack.replace(r, replacement); 
}

function calculate_date(date) {
    if (date == '') return 0;
    var date = date.replace(" ", "");
     
    if (date.indexOf('.') > 0) {
        /*date a, format dd.mn.(yyyy) ; (year is optional)*/
        var eu_date = date.split('.');
    } else {
        /*date a, format dd/mn/(yyyy) ; (year is optional)*/
        var eu_date = date.split('/');
    }
     
    /*year (optional)*/
    if (eu_date[2]) {
        var year = eu_date[2];
    } else {
        var year = 0;
    }
     
    /*month*/
    var month = eu_date[1];
    if (month.length == 1) {
        month = 0+month;
    }
     
    /*day*/
    var day = eu_date[0];
    if (day.length == 1) {
        day = 0+day;
    }
     
    return (year + month + day) * 1;
}
 
jQuery.fn.dataTableExt.oSort['eu_date-asc'] = function(a, b) {
    x = calculate_date(a);
    y = calculate_date(b);
     
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['eu_date-desc'] = function(a, b) {
    x = calculate_date(a);
    y = calculate_date(b);
     
    return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};