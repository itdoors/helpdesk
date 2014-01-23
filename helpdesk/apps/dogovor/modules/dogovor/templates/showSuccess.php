<script>
$(document).ready(function() {
   $("#claimtabs").tabs();
});
</script>
<div id="claimtabs">
   <ul>
      <li><a href="#tab1"><span>Основные данные</span></a></li>
      <li><a href="#tab2"><span>Дополнительные соглашения</span></a></li>
      <li><a href="#tab3"><span><?php echo __('Handling with status "SOLED"')?></span></a></li>
   </ul>
   <div id="tab1">
     <?php include_partial('general', array('dogovor'=>$dogovor))?>
   </div>
   <div id="tab2">
     <?php include_partial('dopdogovors', array('dopdogovors'=>$dopdogovors))?>
   </div>
</div>