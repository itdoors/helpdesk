//Change organization in dispatcher app 
function auto_organization()
{
  var org_id = $('#claim_organization_list').val();

  console.log(org_id);
  
  console.log(org_id);
  var dep_list = $("#claim_departments_id");
  var city_list = $("#claim_city_list");
  var client_list = $("#claim_client_list");
  //var importance_list = $("#claim_contract_importance_id");
  var importance_list = $("#claim_organization_importance_id");
  
  dep_list.before('<div class="loading_image claim_new" id="claim_departments_id_loading">Загрузка</div>');
  city_list.before('<div class="loading_image claim_new" id="claim_city_list_loading">Загрузка</div>');
  client_list.before('<div class="loading_image claim_new" id="client_list_list_loading">Загрузка</div>');
  //importance_list.before('<div class="loading_image claim_new" id="claim_contract_importance_id_loading">Загрузка</div>');
  importance_list.before('<div class="loading_image claim_new" id="claim_organization_importance_id_loading">Загрузка</div>');
  dep_link = '/dispatcher.php/claimopened/departmentslist/orgid/'+org_id;
  city_link = '/dispatcher.php/ajaxdata/city/orgid/'+org_id;
  client_link = '/dispatcher.php/ajaxdata/clients/orgid/'+org_id;
  importance_link = '/dispatcher.php/ajaxdata/importance/orgid/'+org_id;
  //dep_list.html('');
  dep_list.load(dep_link, function(){
    $('#claim_departments_id_loading').remove();
  });
  city_list.load(city_link, function(){
    $('#claim_city_list_loading').remove();
  });
  importance_list.load(importance_link, function(){
    //$('#claim_contract_importance_id_loading').remove();
    $('#claim_organization_importance_id_loading').remove();
  });
  client_list.load(client_link, function(){
    $('#client_list_list_loading').remove();
  }); 
  
  return false;
}

function auto_organization_once()
{
  var org_id = $('#claim_organization_list').val(); 
  
  var dep_list = $("#claim_departments_id");
  var city_list = $("#claim_city_list");
  var client_list = $("#claim_client_list");
  //var importance_list = $("#claim_contract_importance_id");
  var importance_list = $("#claim_organization_importance_id");
  
  client_list.before('<div class="loading_image claim_new" id="client_list_list_loading">Загрузка</div>');
  importance_list.before('<div class="loading_image claim_new" id="claim_organization_importance_id_loading">Загрузка</div>');
 
  client_link = '/dispatcher.php/ajaxdata/clients/orgid/'+org_id;
  importance_link = '/dispatcher.php/ajaxdata/importance/orgid/'+org_id;
  //dep_list.html('');
  $('#autocomplete_claim_departments_id').data('extra', JSON.stringify({org_id: org_id, city_id: city_list.val()}));
  
  importance_list.load(importance_link, function(){
    $('#claim_organization_importance_id_loading').remove();
  });
  client_list.load(client_link, function(){
    $('#client_list_list_loading').remove();
  }); 
  
  return false;
}

function auto_city_once()
{
  var org_id = $('#claim_organization_list').val(); 
  var city_id = $("#claim_city_list").val();
  $('#autocomplete_claim_departments_id').data('extra', JSON.stringify({org_id: org_id, city_id: city_id}));
}

function auto_department_once()
{
  console.log('auto_department');
}

function departments_onSuccess(data)
{
  //console.log(empty(data));
  
  var target = $('#departments_result');
  if (!target.length)
  {
    var holder = $('#autocomplete_claim_departments_id');
    var target = $('<div>').attr('id', 'departments_result');
    target.insertAfter(holder);
  }
  
  target.html('');
  
  if ( !empty(data) )
  {
    return;
  }
  
  var org_id = $('#claim_organization_list').val(); 
  var city_id = $("#claim_city_list").val();
  
  if (!org_id || !city_id)
  {
    var error = 'Выберите';
    if (!org_id)
    {
      error += ' организацию';
      if (!city_id) error += ' и';
    }

    if (!city_id)
    {
      error += ' город';
    }    
    target.html(error);
    
    return;
  }

  //load department form

  var organizationHolder = $('#claim_organization_list');

  var url = organizationHolder.data('url_department_form');
  
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'JSON',
    data: {
      org_id: org_id, 
      city_id: city_id,
      q: $('#autocomplete_claim_departments_id').val()
    },
    success: function(returnVal)
    {
      var data = JSON.parse(returnVal);
      if (data.error)
      {
        target.html(data.form);
      }
      
    }
  });
  
}




function empty( mixed_var ) {  // Determine whether a variable is empty
  // 
  // +   original by: Philippe Baumann

  return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ||  ( $.isArray(mixed_var) && mixed_var.length === 0 ) );
}


$('#claim_city_list').live('change', function(event, ui){
   var dep_list = $("#claim_departments_id"); 
   var organization = $("#claim_organization_list");
   dep_list.before('<div class="loading_image claim_new" id="claim_departments_id_loading">Загрузка</div>');
   dep_link = '/dispatcher.php/ajaxdata/departments_by_org/cityid/'+$(this).val()+'/orgid/'+organization.val();
   dep_list.load(dep_link, function(){
     $('#claim_departments_id_loading').remove();
   });
    
   return false;
});