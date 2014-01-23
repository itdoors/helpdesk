<?php echo __('Documents search');?> 
<?php
   echo form_tag('docdocument/ajaxsearch', array('method'=>'post', 'class'=>'search'));
?>
<input type = "text" name = "search_documents"   class="search_documents" id="search_documents"/>
</form> <br /><br />
<div id="search_results"></div>
<script type="text/javascript">

// Create Delay Function
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


 

$('#search_documents').bind('keyup', function(e)
{ 
    
    delay(function(){
         
          if ($('#search_documents').val().length >= 3 )
          {
              $('#search_results').load(
              $('#search_documents').parents('form').attr('action'), 
              { 
                  search_documents: $('#search_documents').val(),
                  
              }
            );
          }  
      
    }, 1000 );    //end delay
      
});   




</script>
