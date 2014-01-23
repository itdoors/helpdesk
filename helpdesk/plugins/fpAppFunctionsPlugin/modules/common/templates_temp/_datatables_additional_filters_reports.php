 $(".filter1").each( function ( i ) {
    $('select', this).change( function () {
        oTable.fnFilter( $(this).val(), 0, true, true );
    } );
 });

 $('#fini').datepicker({ 
     dateFormat: 'dd.mm.yy',
     beforeShow: function()
      {
           setTimeout(function()
           {
               $(".ui-datepicker").css("z-index", 1000);
           }, 10); 
      }

});
$('#ffin').datepicker(
 { 
     dateFormat: 'dd.mm.yy',
     beforeShow: function()
      {
           setTimeout(function()
           {
               $(".ui-datepicker").css("z-index", 1000);
           }, 10); 
      }
 });

  

$('#fini').live('change', function() { oTable.fnDraw(); } );
$('#ffin').live('change', function() { oTable.fnDraw(); } );