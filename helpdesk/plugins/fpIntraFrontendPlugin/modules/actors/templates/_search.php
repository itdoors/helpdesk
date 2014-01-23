<?php echo __('Actors search');?>
<?php
   echo form_tag('actors/search', array('method'=>'post', 'class'=>'search'));
?>
<table>
<tr>
  <th>ФИО</th>
  <th>Должность</th>
  <th>Город</th>
</tr>

<tr>
    <td><input type = "text" name = "search_keywords_fio"   class="search_keywords" id="search_keywords_fio"/></td>
    <td><input type = "text" name = "search_keywords_position"  class="search_keywords" id="search_keywords_position"/></td>
    <td><input type = "text" name = "search_keywords_city"  class="search_keywords" id="search_keywords_city"/></td>
</tr>


</table>
</form>
 <br /><br />

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

// Usage:

 

$('.search_keywords').bind('keyup', function(e)
{ 
    delay(function(){
        
          
          if ($('#search_keywords_fio').val().length >= 3 ||$('#search_keywords_position').val().length > 3||$('#search_keywords_city').val().length >= 3)
          {
              $('#search_results').load(
              $('#search_keywords_fio').parents('form').attr('action'), 
              { 
                  search_keywords_fio: $('#search_keywords_fio').val(),
                  search_keywords_position: $('#search_keywords_position').val(),  
                  search_keywords_city: $('#search_keywords_city').val()  
              }
            );
          }  
      
    }, 1000 );    //end delay
      
});   




/*$('.searcht').live('submit', function(){
  if ($('#search_keywords').val().length > 3)
  {
        $('#search_results').load(
          $(this).attr('action'), { search_keywords: $(this).val() }
        )
  }
  return false;
}) */

</script>