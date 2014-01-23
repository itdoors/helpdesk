$(document).ready(function() {
   show_version_menu();
}); 

function show_version_menu(){
  var status_list = $('.content_status');
  status_list.html('Loading...');   
  status_list.load('version/statuslist #statuslist')  
}
function refresh_content_right()
{
    $('.content_right').load('version_to_total/index #sf_admin_content')
}

$('#version_confirm').live('submit', function(event, ui){
   $(this).ajaxSubmit();
   var status_list = $('.content_status');
   status_list.html('Loading...');   
   status_list.load('version/statuslist #statuslist'); 
   refresh_content_right();
   var refresh = jQuery('#contractors');
   refresh.html('Loading...');
   refresh.load('calculation/reglist'); 
   return false;
});

$('li.sf_admin_action_edit').live('click', function(event, ui){
    var target = jQuery('div#result'); 
    var edit_link = $(this).find('a').attr("href");
    target.html('Loading...');
    target.load(edit_link+'  #sf_admin_content'); 
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');
    return false;
});

$('#calculation_new').live('click', function(event, ui){
    var target = jQuery('div#result'); 
    var edit_link = $(this).attr("href");
    target.html('Loading...');
    target.load(edit_link+''); 
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');
    return false;
});

$('#contractor_new').live('click', function(event, ui){
    var target = jQuery('div#result'); 
    var edit_link = $(this).attr("href");
    target.html('Loading...');
    target.load(edit_link+''); 
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');
    return false;
});


$('#delete_contractor').live('click', function(event, ui){
    $(this).ajaxSubmit();
    var refresh = jQuery('#contractors');
    refresh.html('Loading...');
    refresh.load('calculation/reglist'); 
    return false;
});


$('#calculation_description_open').live('click', function(event, ui){
    var target = $("#calculation_description");
    if (target.is(":hidden")) {
       target.slideDown();
    } else {
        target.hide();
    };
});
  
$('.sf_admin_form_calculation').find('form').live('submit', function(event, ui){
    $(this).ajaxSubmit();
    var target = $('div#result'); 
    target.dialog('close');
    var refresh = jQuery('#contractors');
    refresh.html('Loading...');
    refresh.load('calculation/reglist'); 
    return false;
}); 

$('.sf_admin_form_contractor').find('form').live('submit', function(event, ui){
    $(this).ajaxSubmit();
    var target = $('div#result'); 
    target.dialog('close');
    var refresh = jQuery('#contractors');
    refresh.html('Loading...');
    refresh.load('calculation/reglist'); 
    return false;
}); 


$('.region_list').live('click', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var target = $("#regiondiv_"+ex);
    target.html('Loading...');
    target.load('contractor/contrlist/region_id/'+ex+'');
    return false;
}); 

$('.contractor_list').live('click', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var target = $("#contrdiv_"+ex);
    target.html('Loading...');
    target.load('calculation/calclist/contr_id/'+ex+'');
    return false;
});   

$('.calculation_list').live('click', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    $(".content_right").html('Loading...');
    $(".content_right").load('calculation_temp/VertionByCalculation/calc_id/'+ex+' #sf_admin_content');
    return false;
});    

/*$('#contractors').find('a').live('click', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    $(".content_right").html('Loading...');
    $(".content_right").load('calculation_temp/VertionByCalculation/calc_id/'+ex+' #sf_admin_content');
    return false;
}); */   

$('.new_version').live('click', function(event, ui){
    var target = jQuery('#version_list'); 
    target.html('Loading...');
    target.load('version/newfast #version_list'); 
    return false;
});

$('#version_list').find('form').live('submit', function(event, ui){
    $(this).ajaxSubmit();
    var refresh = jQuery('.content_right');
    refresh.html('Loading...');
    refresh.load('stuff_version/addstuff'); 
    show_version_menu();  
    return false;
});  

$('.calculation_element').live('click', function(event, ui){
    var target = jQuery('.content_right');
    var edit_link = $(this).attr("href"); 
    target.html('Loading...');
    target.load(edit_link+'/index');
    return false;
});

$('.list_checkbox').live('click', function(event, ui){
    var id = $(this).attr("id");
    var eneble_item = "list_checkbox_"+id+"_values";
    if ($(this).is(':checked') ){
        $("#"+eneble_item).css("display","block");
        $("#"+eneble_item).addClass('required');
    } else{
         $("#"+eneble_item).css("display","none");
         $("#"+eneble_item).removeClass('required');
    }     
});

$('.list_add_form').find('form').live('submit', function(event, ui){
    $(this).ajaxSubmit();
    var title = $('.list_add_form').attr("title");
    var target = jQuery('div#result'); 
    target.dialog('close');
    var refresh = jQuery('#sf_admin_content');
    refresh.html('Loading...');
    refresh.load(title+'/index #sf_admin_content'); 
    return false;
});
 
$('#version_to_list').live('click', function(event, ui){
    var target = jQuery('div#result'); 
    var edit_link = $(this).attr("href");
    target.html('Loading...');
    target.load(edit_link+''); 
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');
    return false;
});

$('#delete_item').live('click', function(event, ui){
    if (confirm("Do you really want this subscription?"))
    {
        var target = jQuery('#sf_admin_content');
        var edit_link = $(this).attr("href");
        target.html('Loading...');
        target.load(edit_link+" #sf_admin_content");
    }
    return false;
});

$('.version_stuff_31').live('keyup', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var v21 = $('#version_stuff_21_'+ex);
    var v31 = $('#version_stuff_31_'+ex);
    var v41 = $('#version_stuff_41_'+ex);
    var v51 = $('#version_stuff_51_'+ex);
    var v71 = $('#version_stuff_71_'+ex);
    $('#version_stuff_41_'+ex).val(v31.val()*v21.val());
    $('#version_stuff_61_'+ex).val(v51.val()*v41.val());
    $('#version_stuff_81_'+ex).val((v51.val()+v71.val())*v41.val());
});

$('.version_stuff_71').live('keyup', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var v21 = $('#version_stuff_21_'+ex);
    var v31 = $('#version_stuff_31_'+ex);
    var v41 = $('#version_stuff_41_'+ex);
    var v51 = $('#version_stuff_51_'+ex);
    var v71 = $('#version_stuff_71_'+ex);
    $('#version_stuff_41_'+ex).val(v31.val()*v21.val());
    $('#version_stuff_61_'+ex).val(v51.val()*v41.val());
    $('#version_stuff_81_'+ex).val((v51.val()+v71.val())*v41.val());
});

$('#stuff_version').find('form').live('submit', function(event, ui){
    $(this).ajaxSubmit();
    var refresh = jQuery('.content_right');
    refresh.html('Loading...');
    refresh.load('version_stuff/index #sf_admin_content');  
    return false;
});  

$('#params_tooltip').live('click', function(event, ui){
    var target = $('#params_tooltip_div');
    target.html('Loading...');
    if(!target.dialog('isOpen')){
       target.dialog({autoOpen:true,bgiframe:true,modal:false,resizable:true,width:500,height:300,position:['center', 'center'],draggable:true})
    }; target.dialog('open');
    target.load('version_stuff/allParams #sf_admin_content'); 
});

$('#version_expenses_firstkey').live('keyup', function(event, ui){
    var at = $('#admin_transpart').val();
    var op = $('#operac_manager').val();
    var tp = $('#total_price').val();
    var ve = $(this).val();
    if (ve == '') ve = 0;
    $('#total_calculation').val(parseFloat(at)+parseFloat(op)+parseFloat(tp)+parseFloat(ve));
    var target = $('#version_rentable_value');
    var total =  parseFloat($('#total_calculation').val());
    var persents = parseFloat($('#version_rentable_persents').val());
    var s_all = $('#s_all').val();
    var s_prileg = $('#s_prileg').val();
    target.val(persents/100*total);
    $('#version_nds').html(((persents/100*total+total)*2).toFixed(2));
    $('#version_without_nds').html(($(this).val()/100*total+total).toFixed(2));
    $('#version_with_nds').html((($(this).val()/100*total+total)*1.2).toFixed(2)); 
    if ((parseFloat(s_all)+parseFloat(s_prileg)) == 0 || total==0) $('#total_per_metr').html(0)
    else 
    $('#total_per_metr').html(((($(this).val()/100*total+total)*1.2)/(parseFloat(s_all)+parseFloat(s_prileg))).toFixed(2));
});   

$('#version_rentable_persents').live('keyup', function(event, ui){
    var target = $('#version_rentable_value');
    var total =  parseFloat($('#total_calculation').val()); 
    target.val($(this).val()/100*total);
    var s_all = $('#s_all').val();
    var s_prileg = $('#s_prileg').val();
    $('#version_nds').html((($(this).val()/100*total+total)*0.2).toFixed(2));
    $('#version_without_nds').html(($(this).val()/100*total+total).toFixed(2));
    $('#version_with_nds').html((($(this).val()/100*total+total)*1.2).toFixed(2));
    $('#total_per_metr').html(((($(this).val()/100*total+total)*1.2)/(parseFloat(s_all)+parseFloat(s_prileg))).toFixed(2));
    return false;
});

$('#version_expenses_form').live('submit', function(event, ui){
    $(this).ajaxSubmit(function(){
       alert("Данные 'Дополнительные расходы' сахранены");   
    });
    var subfrom2 = jQuery('#version_rentable_form');
    subfrom2.ajaxSubmit(function() {
       alert("Данные 'Рентабельность по PF 1:' сахранены");
    });
    return false; 
});

$('#version_rentable_form').live('submit', function(event, ui){
    $(this).ajaxSubmit(function() {
       alert("Данные 'Рентабельность по PF 1:' сахранены"); 
    });
     return false;
});

$('#new_comments').live('click', function(event, ui){
    $('#comments_in_total').load('comments/new');
    return false;
});

$('#show_comments').live('click', function(event, ui){
    $('#comments_list_in_total').load('comments/list');
    return false;
});

$('.show_comments_from_versionlist').live('click', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var target = $("#comments_list_"+ex);
    target.html('Loading...');
    target.load('comments/idlist/verid/'+ex+'');
    return false;
});
 
$('#comments_form').live('submit', function(event, ui){
    //$(this).validate();  
    $(this).ajaxSubmit();
    alert("Комментарий добавлен");   
    $('#comments_list_in_total').load('comments/list');
    return false;
}); 

/*$('#comments_form').live('submit', function(event, ui){
     
    alert("xxx");
    $('#comments_form').validate();
      
/*    $(this).ajaxSubmit();
    alert("Комментарий добавлен");   
    $('#comments_list_in_total').load('comments/list'); 
    return false;
}); */

$('#new_comments_custom').live('click', function(event, ui){
    var target = jQuery('#comments_in_total'); 
    target.html('Loading...');
    target.load('comments/new'); 
    target.before("<scr"+"ipt >$(document).ready(function(){ $('#comments_form').validate();});</scr"+"ipt>");
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');
    //$('#comments_in_total').load('comments/new');
    return false;
});

$('.version_copy').live('click', function(event, ui){
    edit_id = $(this).attr("id");
    var reg = /[0-9]*$/i;
    var ex = reg.exec(edit_id);
    var target = jQuery('#version_list'); 
    target.html('Loading...');
    target.load('version/copy/vercopyid/'+ex); 
    return false;
});


/*$('#sf_admin_action_new').live('click', function(event, ui){
    var target = jQuery('#comments_in_total'); 
    target.html('Loading...');
    target.load('comments/new'); 
    target.after("<scr"+"ipt type='text/javascript' src='/jquery/validation.js'></scr"+"ipt>");
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');  
    
    return false;
});  */

/*$('li.sf_admin_action_new').live('click', function(event, ui){
    var target = jQuery('div#result'); 
    target.html('Loading...');
    target.load('country/new #sf_admin_content');
    //target.after("<scr"+"ipt>$(document).ready(function(){ $('.sf_admin_form').find('form').live('mouseover', function(ev ,ui){alert('xxx')});});</scr"+"ipt>"); 
    //target.after("<scr"+"ipt type='text/javascript' src='/jquery/griffin.js'></scr"+"ipt>"); 
    if(!target.dialog('isOpen')){
        target.dialog({autoOpen:false,bgiframe:true,modal:true,resizable:false,width:500,height:500,position:['center', 'center'],draggable:true})
    }; target.dialog('open');  

    return false;
})   */
