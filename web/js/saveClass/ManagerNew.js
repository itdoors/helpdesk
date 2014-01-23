//Change city in client app 
$('#claim_city_list').live('change', function(event, ui){
   var dep_list = $("#claim_departments_id"); 
   dep_list.before('<div class="loading_image claim_new">Загрузка</div>');
   dep_link = '/index.php/ajaxdata/departments/cityid/'+$(this).val()+"/tempos/"+Math.random();
   dep_list.load(dep_link, function(){
     $('.loading_image').remove();
   });
   return false;
});
