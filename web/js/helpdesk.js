$(document).ready(function() {
   $("#tabs").tabs();
});
$('#client_organization_id').live('change', function(event, ui){
   var dep_list = $("#client_departments_list").css("display","block"); 
   dep_list.html('Загрузка данных')
   dep_list.load('/admin.php/departments/list/orgid/'+$(this).val())
   
   return false;
});

var clientOrganizationRequest;

$('#client_organizations_list').live('change', function(event, ui){
  event.preventDefault();

  if (clientOrganizationRequest)
  {
    clientOrganizationRequest.abort();
  }

  var organizationIds = $(this).val();
  var url = $(this).data('url');
  var clientId = $(this).data('client_id');
  var target = $('#client_departments_list');

  clientOrganizationRequest = $.ajax({
    type: 'POST',
    url: url,
    data:{
      organizationIds : organizationIds,
      clientId : clientId
    },
    beforeSend: function(){
      target.css('opacity', '0.5');
    },
    success: function(response){
      target.css('opacity', '1');
      target.replaceWith(response);
    }
  });
});



$('#dispatcher_show_history').live('click', function(event, ui){
    edit_link = $(this).attr("href");
    var target = $('#result');
    target.html('Загрузка данных...');
    target.load(edit_link);
    if(!target.dialog()){
        target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog({autoOpen:true,bgiframe:true,modal:true,resizable:true,width:500,height:500,position:['center', 'center'],draggable:true});
   return false;
});

$('.departmentslist_for_stuff_btn').live('click', function(event, ui){
   
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var target = $("#departmentslist_for_stuff_table_id_"+ex);
    if (target.css("display") == 'none') target.css("display","block"); else target.css("display","none");  
}); 

$(document).find('a.page_loader_link').live('click', function(event, ui){ 
   //$('#wrapper').find('.FixedHeader_Header').addClass('loading'); 
   $(document).find('.FixedHeader_Header').css('display','none'); 
   $('#wrapper').before('<div class="page_loader"><h1>Загрузка</h1></div>');
    
   //alert("xxx");
});
$(document).find('form.page_loader_link').live('submit', function(event, ui){ 
   //$('#wrapper').find('.FixedHeader_Header').addClass('loading'); 
   $(document).find('.FixedHeader_Header').css('display','none'); 
   $('#wrapper').before('<div class="page_loader"><h1>Загрузка</h1></div>');
    
   //alert("xxx");
});

$('.delete_record_form').live('submit', function(e){
  e.preventDefault();
  if (!confirm($(this).data('confirm_text')))
  {
    return false;
  }
  
  var self = $(this);
  
  var parents_tag = $(this).data('parents_tag') || $(this).parent('td').parent('tr');
  
  $(this).ajaxSubmit({
    beforeSubmit: function (){
      parents_tag.addClass('loading');
    },
    success: function (results){
      parents_tag.remove();
      
      if (self.data('ref_functions'))
      {
        var ref_functions = self.data('ref_functions');
        for (key in ref_functions)
        {
          var target = $(key);
          
          target.load(ref_functions[key]);
        }
      }
    }
  })
})

$('.ajax_field_edit_btn').live('click', function(e){
  e.preventDefault();
  
  var parent_holder = $(this).parents('.ajax_field_container');
  
  var value_holder = parent_holder.find('.ajax_field_value');
  
  var edit_holder = parent_holder.find('.ajax_field_edit');
  
  value_holder.hide();
  edit_holder.hide();
  
  var url = parent_holder.data('url');
  
  var edit_form_holder = $('<div></div>').addClass('ajax_field_form_edit');
  
  parent_holder.append(edit_form_holder);
  
  var params = parent_holder.data('params'); 
  
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      params: params
    },
    beforeSend: function(){
      edit_form_holder.html('Loading...');
      parent_holder.css('opacity', '0.5');
    },  
    success: function(response)
    {
      edit_form_holder.html(response);
      parent_holder.css('opacity', '1');
    }
  })
});

$('.ajax_field_form').live('submit', function (e){
  e.preventDefault();
  
  var parent_holder = $(this).parents('.ajax_field_container');
  
  var value_holder = parent_holder.find('.ajax_field_value');

  var edit_holder = parent_holder.find('.ajax_field_edit');
  
  var url = $(this).attr('action');
  
  var edit_form_holder = parent_holder.find('.ajax_field_form_edit');
  
  var params = parent_holder.data('params');

  var data = {
    params: params
  };
  
  var value_edit_holder = $(this).find('.form_value');
  
  value_edit_holder.each(function( index ) {
    data[$(this).attr('name')] = $(this).val();
  });
  
  var hidden_fields = $(this).find('input[type=hidden]');
  
  hidden_fields.each(function( index ) {
    data[$(this).attr('name')] = $(this).val();
  });
  
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'JSON',
    data: data,
    beforeSend: function(){
      parent_holder.css('opacity', '0.5');
    },
    success: function(response)
    {
      response = JSON.parse(response);
      if (response.error)
      {
        edit_form_holder.html(response.form_partial)
      }
      
      if (response.success)
      {
        value_holder.html(response.result);
        value_holder.show();
        edit_holder.find('.ajax_field_edit_btn').html(edit_holder.data('edit'));
        
        edit_holder.show();
        edit_form_holder.remove();

        if (params.ref_functions)
        {
          var ref_functions = params.ref_functions;
          for (key in ref_functions)
          {
            var target = $(key);

            target.css('opacity', '0.5');

            target.load(ref_functions[key], function (){
              target.css('opacity', '1');
            });
          }
        }

        if (params.ref_functions_names)
        {
          var ref_functions_names = params.ref_functions_names;

          for (key in ref_functions_names)
          {
            // if function with params
            if (typeof window[key] === 'function'){
              var funcParams = ref_functions_names[key];
              var funcName = key;
              formok = window[funcName](funcParams);
            }
            else // if function without params
            {
              var func_name = ref_functions_names[key];

              if (typeof window[func_name] === 'function'){
                formok = window[func_name]();
              }
            }
          }
        }

        //additional functions
      }
      
      parent_holder.css('opacity', '1');
    }
  })
});

$('.ajax_field_cancel_form').live('click', function (e){
  e.preventDefault();
  
  var parent_holder = $(this).parents('.ajax_field_container');

  var edit_holder = parent_holder.find('.ajax_field_edit');
  
  var value_holder = parent_holder.find('.ajax_field_value');
  
  var edit_form_holder = parent_holder.find('.ajax_field_form_edit');  
  
  value_holder.show();
  edit_holder.show();
  
  if (edit_form_holder.length)
  {
    edit_form_holder.remove();
  }
})

$('.history_link').live('click' , function (e){
  e.preventDefault();
  
  var params = $(this).data('params');
  
  var url = $(this).attr('href');
  
  var target = $('#history_holder_' + params.model_name + '_' + params.model_id);
  
  target.html('Loading...');
  
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      params: params
    },
    success: function (response){
      target.html(response);
      
    }
  });
  
  target.dialog({
    beforeClose: function (){},
    autoOpen:true,
    bgiframe:true,
    modal:true,
    resizable:true,
    width:810,
    height:500,
    position:['center', 'center'],
    draggable:true
  });
})

$('#grafik_date_change_form').live('submit', function(e){
  e.preventDefault();
  var data_holder = $('#grafik_holder');
  
  var department_id = data_holder.data('department_id');
  
  var url = $(this).attr('action');
  
  var people_list = $('#people_list');
  
  var month = $('#grafik_date_month').val();
  var year = $('#grafik_date_year').val();
  
  //ChangePeopleFormDefaults(month, year);
  
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      month: month,
      year: year,
      department_id: department_id
    },
    beforeSend: function(){
      people_list.css('opacity', '0.5');
    },
    success: function (response){
      people_list.css('opacity', '1');
      people_list.html(response);
      var month_holder = $('#month_holder');
      month_holder.data('month', month);
      month_holder.data('year', year);
      
      $('#people_form_holder').html('');
    }
    
  })
  
});
//there is init in template!!!
function ChangePeopleFormDefaults(month, year)
{
/*  var target = $('#editablepeople_form_holder a');

  if (!target.length)
  {
    return;
  }

  var href = target.attr('href');
  
  var new_href = href.replace(/year]=(\d+)/, 'year]='+year).replace(/month]=(\d+)/, 'month]='+month);
  
  target.attr('href', new_href);
  
  $('#department_people_year').val(year);
  $('#department_people_month').val(month);
  
  var parent_holder = $('#currentpeople_list');
  
  $('#currentpeople_list').find('input[name="default[year]"]').val(year);
  $('#currentpeople_list').find('input[name="default[month]"]').val(month);
  
  var ref_functions = $('#reffuncpeople_list li');
  
  ref_functions.each(function( index ) { 
    var url = $(this).data('url');
    var new_url = url.replace(/year\/(\d+)/, 'year/'+year).replace(/month\/(\d+)/, 'month/'+month);
    $(this).data('url', new_url);
  });*/
}

var is_loading_grafik_form = false;

$('.grafik_day_href').live('click', function (e){
  if (is_loading_grafik_form)
  {
    return;
  }

  e.preventDefault();

  var target = $('#grafik_day_holder');

  target.data('day', $(this).data('day'));
  target.data('people_id', $(this).data('people_id'));
  target.data('replacement_id', $(this).data('replacement_id'));

  var month_holder = $('#month_holder');

  var data = {};
  //var grafik_form_holder = $('#grafik_form_holder');

  data.year = month_holder.data('year');
  data.month = month_holder.data('month');
  data.day = $(this).data('day');
  data.department_people_id = $(this).data('people_id');
  data.department_people_replacement_id = $(this).data('replacement_id');
  data.department_id = $('#grafik_holder').data('department_id');

  var url = $('#grafik_holder').data('grafik_day_url');

  var targetRowId = '#' + data.year + '-' + data.month + '-' + data.department_id + '-' + data.department_people_id + '-' + data.department_people_replacement_id;

  //var targetRow = $(targetRowId);

  $.ajax({
    url : url,
    type: 'POST',
    data : {
      grafik: data
    },
    beforeSend: function(){
      is_loading_grafik_form = true;
      target.css('opacity', '0.5');

      target.dialog({
        beforeClose: function (){},
        autoOpen:true,
        bgiframe:true,
        modal:true,
        resizable:true,
        width:950,
        height:500,
        position:['center', 'center'],
        draggable:true,
        close: function()
        {
          updateGrafik(targetRowId);
        }
      });


    },
    success: function (response){
      target.css('opacity', '1')
      target.html(response);
      target.show();
      is_loading_grafik_form = false;
    }
  })

});

// Close grafik edit href where click add form href
$('#editablegrafik_form_day_list a.button').live('click', function(e){

  var editCancelBtn = $('#grafik_time_cancel_btn');

  if (editCancelBtn.length)
  {
    editCancelBtn.click();
  }
})

$('#grafik_time_cancel_btn').live('click', function(e){
  e.preventDefault();

  var parentTarget = $('#grafik_form_holder');

  parentTarget.html('');
  parentTarget.css('display', 'none');
});

$('.grafik_href').live('click', function (e){
  if (is_loading_grafik_form)
  {
    return;
  }

  // Close add form

  var addFromCancelBtn = $('#currentgrafik_form_day_list .cancel_form');

  if (addFromCancelBtn.length)
  {
    addFromCancelBtn.click();
  }
  
  e.preventDefault();
  var month_holder = $('#month_holder');

  var data = {};
  var grafik_form_holder = $('#grafik_form_holder');
  
  data.year = month_holder.data('year');
  data.month = month_holder.data('month');
  data.id = $(this).data('id');
  data.day = $(this).data('day');
  data.department_people_id = $(this).data('people_id');
  data.department_people_replacement_id = $(this).data('replacement_id');
  data.department_id = $('#grafik_holder').data('department_id');
  var url = $('#grafik_holder').data('grafik_time_form_url');
  
  var last_day_of_the_month = $('#grafik_holder').data('last_day_of_the_month');
  
  /*$('#grafik_year').val(year);
  $('#grafik_month').val(month);
  $('#grafik_day').val(day);*/
  
  $.ajax({
    url : url,
    type: 'POST',
    data : {
      grafik_time: data
    },
    beforeSend: function(){
      is_loading_grafik_form = true;
      grafik_form_holder.css('opacity', '0.5')
    },
    success: function (response){
      grafik_form_holder.css('opacity', '1')
      grafik_form_holder.html(response);
      grafik_form_holder.show();
      is_loading_grafik_form = false;
      
      $('#grafik_from_not_work').val(data.day);
      $('#grafik_to_not_work').val(last_day_of_the_month);
    }
  })
});

$(document).ready(function() {
  if ($('#grafik_until_the_end_of_the_month').length) 
  {
    var from_holder = $('#not_work_holder');
    var is_checked = $('#grafik_until_the_end_of_the_month').is(':checked');

    if (is_checked)
    {
      from_holder.show();
    }
    else
    {
      from_holder.hide();
    }
  }
  
   
});

$('#grafik_until_the_end_of_the_month').live('click', function(e){
  var from_holder = $('#not_work_holder');
  var is_checked = $(this).is(':checked');
  if (is_checked)
  {
    from_holder.show();
  }
  else
  {
    from_holder.hide();
  }
})

$('.people_href').live('click', function (e){
  if (is_loading_grafik_form)
  {
    return;
  }
  
  e.preventDefault();

  var grafikHolder = $('#grafik_holder');
  var monthHolder = $('#month_holder');

  var url = grafikHolder.data('people_month_info_form_url');
  var id = $(this).data('id');
  var replacement_id = $(this).data('replacement_id');
  var department_id = grafikHolder.data('department_id');
  var year = monthHolder.data('year');
  var month = monthHolder.data('month');

  var people_form_holder = $('#people_form_holder');

  var keyRow = $(this).data('key-row');

  $.ajax({
    url : url,
    type: 'POST',
    data : {
      id: id,
      replacement_id: replacement_id,
      department_id: department_id,
      year: year,
      month : month
    },
    beforeSend: function(){
      is_loading_grafik_form = true;
      people_form_holder.css('opacity', '0.5');
      people_form_holder.dialog({
        beforeClose: function (){},
        autoOpen:true,
        bgiframe:true,
        modal:true,
        resizable:true,
        width:500,
        height:600,
        position:['center', 'center'],
        draggable:true,
        close: function(){
          updateGrafik(keyRow);
        }
      });
    },
    success: function (response){
      people_form_holder.css('opacity', '1')
      people_form_holder.html(response);
      people_form_holder.show();
      is_loading_grafik_form = false;
    }
  })
})

$('#grafik_cancel_btn').live('click', function(e) {
  //$('#grafik_form_holder').hide();
  $(".ui-dialog-content").dialog("close");
});

$('#grafik_form').live('submit', function (e){
  e.preventDefault();
  
  var self = $(this);
  var url = self.attr('action');
  
  var form_holder = $('#grafik_general_form');
  var target = $('#grafik_day_holder');
  
  self.ajaxSubmit({
    beforeSubmit: function(){
    },
    success: function (response){
      response_json = JSON.parse(response);
      if (response_json.error){
        form_holder.html(response_json.content);
      }
      else
      {
        //form_holder.hide();
        target.dialog('close');
        //refresh_people_list();
        //refreshGrafikDayList();
      }
    }
  });

});

$('#people_form').live('submit', function (e){
  e.preventDefault();
  
  var self = $(this);
  var url = self.attr('action');
  
  var form_holder = $('#people_form_holder');

  self.ajaxSubmit({
    beforeSubmit: function(){
      
    },
    success: function (response){
      response_json = JSON.parse(response);
      if (response_json.error){
        form_holder.html(response_json.content);
      }
      else
      {
        //form_holder.hide();
        form_holder.dialog('close');
        refresh_people_list();
      }
    }
  });

});

function refresh_people_list()
{
  //$('#grafik_date_change_form').trigger('submit');
}

function refreshGrafikDayList()
{
  //refresh_people_list();

  var grafik_day_holder = $('#grafik_day_holder');
  var target = $('#grafik_day_list');

  var month_holder = $('#month_holder');

  var data = {};
  //var grafik_form_holder = $('#grafik_form_holder');

  data.year = month_holder.data('year');
  data.year = month_holder.data('year');
  data.month = month_holder.data('month');
  data.day = grafik_day_holder.data('day');
  data.department_people_id = grafik_day_holder.data('people_id');
  data.department_people_replacement_id = grafik_day_holder.data('replacement_id');
  data.department_id = $('#grafik_holder').data('department_id');

  var url = $('#grafik_holder').data('refresh_grafik_day_list_url');

  $.ajax({
    url : url,
    type: 'POST',
    data : {
      grafik: data
    },
    beforeSend: function(){
      is_loading_grafik_form = true;
      target.css('opacity', '0.5')
    },
    success: function (response){
      target.css('opacity', '1')
      target.html(response);
      target.show();
      is_loading_grafik_form = false;
    }
  })

}

$('#department_people_month_info_type_id').live('change', function(e){
  $('#department_people_month_info_type_string').val($(this).find(":selected").text());

  var permanentTypeId = $(this).data('permanentTypeId');
  var replacementTypeId = $(this).data('replacementTypeId');
  var currentValue = $(this).val();
  var target = $('#department_people_replacement_id_holder');

  if (currentValue == replacementTypeId)
  {
    target.show();
  }
  else
  {
    target.hide();
  }
})

$('#grafik_date_year').live('change', function (e){
  var url = $('#grafik_holder').data('get_months_url'); 
  var department_id = $('#grafik_holder').data('department_id'); 
  var year = $(this).val();
  
  var target = $('#grafik_date_month') ;
  
  console.log(url);
  console.log(department_id);
  console.log($(this).val());
  
  $.ajax({
    url: url,
    data:{
      department_id : department_id,
      year : year
    },
    beforeSend: function ()
    {
      target.css('opacity', '0.5');
    },
    success: function (response){
      target.html(response);
      target.css('opacity', '1');
      $('#grafik_date_change_form').submit();
    }
    
  })
});


$('.delete_record_advanced_form').live('submit', function(e){
  e.preventDefault();
  if (!confirm($(this).data('confirm_text')))
  {
    return false;
  }
  
  var self = $(this);
  
  var parents_tag = $(this).data('parents_tag') || $(this).parent('td').parent('tr');
  
  $(this).ajaxSubmit({
    beforeSubmit: function (){
      if (parents_tag.length)
      {
        parents_tag.addClass('loading');
      }
    },
    success: function (results){
      if (parents_tag.length)
      {
        parents_tag.remove();
      }
      
      if (self.data('ref_functions'))
      {
        var ref_functions = self.data('ref_functions');
        for (key in ref_functions)
        {
          var target = $(key);

          target.css('opacity', '0.5');
          
          target.load(ref_functions[key], function (){
            target.css('opacity', '1');
          });
        }
      }
      
      if (self.data('ref_functions_names'))
      {
        var ref_functions_names = self.data('ref_functions_names');
        for (key in ref_functions_names)
        {
          var func_name = ref_functions_names[key];
          
          if (typeof window[func_name] === 'function'){
              formok = window[func_name]();
          }
        }
      }
    }
  })
})

$('#people_cancel_btn').live('click', function(e){
  
  $('#people_form_holder').dialog('close');
  $('#people_form_holder').html('');
})

function updatePeoplePist()
{
  $('#people_form_holder').html('');
  $('#grafik_date_change_form').submit();
}

function updateGrafik(targetRowId)
{
  $('#grafik_form_holder').html('');

  if (targetRowId)
  {
    updateGrafikRow(targetRowId);
  }
  else
  {
    $('#grafik_date_change_form').submit();
  }
}

function updateGrafikRow(targetRowId)
{
  var targetRow = $(targetRowId);

  if (!targetRow.length)
  {
    return false;
  }

  var month_holder = $('#month_holder');

  var data = {};

  data.year = month_holder.data('year');
  data.month = month_holder.data('month');
  data.department_people_id = targetRow.data('department_people_id');
  data.department_people_replacement_id = targetRow.data('department_people_replacement_id');
  data.department_id = $('#grafik_holder').data('department_id');

  var url = $('#grafik_holder').data('refresh_grafik_row_url');

  $.ajax({
    type: 'POST',
    url: url,
    data: data,
    beforeSend: function(){
      targetRow.css('opacity', '0.5');
    },
    success: function(response){
      targetRow.css('opacity', '1');
      targetRow.replaceWith(response);

      updateTotalHours();
    }
  })
}

function updateTotalHours()
{
  //return false;

  var targetTable = $('#grafik_table');

  var target = $('#grafik-table-total-info');

  var targetRows = targetTable.find('td.total-hours-info');

  var total = 0;
  var totalDays = 0;
  var totalEvening = 0;
  var totalNight = 0;
  var totalHolidays = 0;

  //Not Officially
  var totalNotOfficially = 0;
  var totalDaysNotOfficially = 0;
  var totalEveningNotOfficially = 0;
  var totalNightNotOfficially = 0;

  targetRows.each(function(index){
    total += $(this).data('total');
    totalDays += $(this).data('total-days');
    totalEvening += $(this).data('total-evening');
    totalNight += $(this).data('total-night');
    totalHolidays += $(this).data('total-holidays');

    totalNotOfficially += $(this).data('total_not_officially');
    totalDaysNotOfficially += $(this).data('total-days_not_officially');
    totalEveningNotOfficially += $(this).data('total-evening_not_officially');
    totalNightNotOfficially += $(this).data('total-night_not_officially');
  });

  var monthTotal = total + totalNotOfficially;
  var monthTotalDay = totalDays + totalDaysNotOfficially;
  var monthTotalEvening = totalEvening + totalEveningNotOfficially;
  var monthTotalNight = totalNight + totalNightNotOfficially;

  var value = '<span style="color: #008200">' +
                total.toFixed(2) + ' (' + totalDays + '/' + totalEvening + '/' + totalNight + '/' + totalHolidays + ')' +
              '</span>' + ' / ' +
              '<span style="color: #3366FF">' +
                totalNotOfficially.toFixed(2) + ' (' + totalDaysNotOfficially + '/' + totalEveningNotOfficially + '/' + totalNightNotOfficially + ')' +
              '</span>' + ' / '+
              '<span>' +
                monthTotal.toFixed(2) + ' (' + monthTotalDay + '/' + monthTotalEvening + '/' + monthTotalNight + '/' + totalHolidays + ')' +
              '</span>';

  target.html(target.data('text') + ': ' + value);
}

function deleteSelector(selectorId)
{
  var selector = $(selectorId);

  if (selector.length)
  {
    selector.remove();
  }
}

function updateLastRecord(targetId)
{
  var target = $('#' + targetId);

  if (!target.length)
  {
    target = $('.' + targetId);
  }

  if (!target.length)
  {
    return false;
  }

  var url = target.data('url-update-last-record');
  var departmentId = target.data('department_id');

  var tableHead = target.find("thead");

  $.ajax({
    type: 'POST',
    url: url,
    data: {
      department_id: departmentId,
      can_edit: 1,
      lastRecord: 1
    },
    success: function(response){
      $(response).insertAfter(tableHead);
    }
  })
}

function getCurrentGrafikData()
{
  var grafik_holder = $('#grafik_holder');
  
  var year = $('#grafik_date_year').val();
  var month = $('#grafik_date_month').val();
  var department_id = grafik_holder.data('department_id');
  
  var data = {
    year: year,
    month: month,
    department_id: department_id
  }
  
  return data;
}

$('.copy_permanent_staff').live('click', function (e){
  e.preventDefault();
  
  var data = getCurrentGrafikData();
  
  var url = $('#grafik_holder').data('copy_permanent_staff_url');
  var self = $(this);
  
  var loading_div = $('<div>');
      loading_div.addClass('loading_image');
      loading_div.css('display', 'block');
  $.ajax({
    url: url,
    data: data,
    beforeSend: function (){
     loading_div.insertAfter(self);
    },
    success: function (response){
      self.replaceWith(response);
      loading_div.remove();
    }
  });
})

// Create Delay Function
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$('#crm_organization_form_name').live('keyup', function(e){
  console.log('start key up');
  var self = $(this);
  var name = self.val();
  var url = self.data('url');
  var target = $('#organization_duplicate');

  delay(function(){
    if (name.length >= 3)
    {
      $.ajax({
        url: url,
        type: 'POST',
        data:{
          name: name
        },
        beforeSend: function(){
          target.html('Loading...');
          target.css('opacity', '0.5');
        },
        success: function(response){
          target.html(response);
          target.css('opacity', '1');
        }
      })
    }

  }, 1000 );
});

$('#grafik_time_form').live('submit', function (e){
  e.preventDefault();

  var self = $(this);
  var url = self.attr('action');

  var form_holder = $('#grafik_form_holder');

  self.ajaxSubmit({
    beforeSubmit: function(){
    },
    success: function (response){
      response_json = JSON.parse(response);
      if (response_json.error){
        form_holder.html(response_json.content);
      }
      else
      {
        form_holder.hide();
        //refresh_people_list();
        refreshGrafikDayList();
      }
    }
  });

});

function closePeopleDialog()
{
  var form_holder = $('#people_form_holder');
  if (form_holder.length)
  {
    form_holder.dialog('close');
  }
}

$('.add_handling').live('click', function (e){
  e.preventDefault();

  var self = $(this);
  var url = self.attr('href');
  var parents_tr = self.parent().parent();

  $.ajax({
    url: url,
    beforeSend: function (){

    },
    success: function (response){
      parents_tr.remove();
      //updateHandlingAddedList()
      $('#handling_added_list').html(response);
    }
  });

});

function updateHandlingAddedList()
{
  console.log('updateHandlingAddedList');
}

$('.show_more_info').live('click', function (e){
  e.preventDefault();

  var self = $(this);
  var url = self.attr('href');
  var target = $('#dialog_holder');

  $.ajax({
    url: url,
    beforeSend: function (){

    },
    success: function (response){
      target.html(response);
      target.dialog({
        beforeClose: function (){},
        autoOpen:true,
        bgiframe:true,
        modal:true,
        resizable:true,
        width:500,
        height:500,
        position:['center', 'center'],
        draggable:true,
        close: function(){}
      });
    }
  });
})

$('#department_people_month_info_employment_type_id').live('change', function(e){
  var aTypeId = $(this).data('aTypeId');
  var cTypeId = $(this).data('cTypeId');
  var bTypeId = $(this).data('bTypeId');
  var currentValue = $(this).val();
  var target = $('#is_clean_salary');

  if (currentValue == cTypeId || currentValue == bTypeId || currentValue == aTypeId)
  {
    target.show();
  }
  else
  {
    target.hide();
  }
})

$('#idea_total_email').live('click', function(e){
  e.preventDefault();

  var url = $(this).attr('href');
  var text = $(this).data('text');
  var sendingText = $(this).data('sending_text');
  var holder = $('#idea_total_email_holder');

  var self = $(this);

  $.ajax({
    url: url,
    beforeSend: function (){
      holder.html(sendingText);
    },
    success: function(response){
      holder.html(text);
    }
  })
});

var loadingDepartments;
var loadingImportance;

$('#client_claim_form_city_list').live('change', function(event, ui){
  event.preventDefault();

  if (loadingDepartments)
  {
    loadingDepartments.abort();
  }

  if (loadingImportance)
  {
    loadingImportance.abort();
  }

  var url = $(this).data('url_departments');
  var organizationIds = $(this).data('organization_ids');
  var cityId = $(this).val();

  var target = $('#client_claim_form_departments_id');

  loadingDepartments = $.ajax({
    type: 'POST',
    url: url,
    data: {
      cityId: cityId,
      organizationIds: organizationIds
    },
    beforeSend: function(){
      target.css('opacity', '0.5');
    },
    success: function(response){
      target.css('opacity', '1');
      target.replaceWith(response);
      loadImportanceForClient();
    }
  });
});

$('#client_claim_form_departments_id').live('change', function(e){
  e.preventDefault();
  loadImportanceForClient();
})

function loadImportanceForClient()
{
  var holder = $('#client_claim_form_city_list');
  var departmentHolder = $('#client_claim_form_departments_id');
  var url = holder.data('url_importance');
  var departmentId = departmentHolder.val();
  var target = $('#client_claim_form_organization_importance_id');

  loadingImportance = $.ajax({
    type: 'POST',
    url: url,
    data: {
      departmentId: departmentId
    },
    beforeSend: function(){
      target.css('opacity', '0.5');
    },
    success: function(response){
      target.css('opacity', '1');
      target.replaceWith(response);
    }
  });
}

$('.entity_excel_print').live('click', function(e){
  var text = $(this).data('text');
  var replaceElement = $('<div></div>')
    .addClass('loading_image')
    .css('display', 'block')
    .css('position', 'absolute')
    .css('top', '95px')
    .css('left', '490px')
    .css('margin-right', '12px');

  var replaceTextElementText = $('<div></div>')
    .css('display', 'block')
    .css('position', 'absolute')
    .css('top', '95px')
    .css('left', '510px')
    .html(text);

  $(this).replaceWith(replaceElement);
  replaceElement.after(replaceTextElementText);
});