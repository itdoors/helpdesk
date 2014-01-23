<span class="session_counter_container">Сессия истечет через <span id="session_counter"></span></span>
<script>

// глобальная переменная интервала обновления счетчика
var session_interval;
// начальное значение счетчика (немного меньше, чем на сервере)
var session_counter;
var session_popup_viewed;




///////////////////////////////////////////////
// сброс счетчика
///////////////////////////////////////////////
function resetCounter(){
    
    if(session_interval) clearInterval(session_interval);
    
    // начальное значение счетчика (немного меньше, чем на сервере)
    session_counter=33;
    
    // интервал для счетчика
    session_interval=setInterval(function() {
        
        session_counter--;
        
        
        if(session_counter<=30 && !session_popup_viewed){
         /*   // информационное сообщение. Пользователь может просто обновить страницу
            draw_popup("confirm", 'Время сессии истекает', 'Время сессии истекает.<br /> Для дальнейшей работы обновите страницу', { 
                'button_yes_text':    "Обновить",
                'onSubmit':            function(){window.location.reload();}
                });
            session_popup_viewed=true;  */
            }
            
        
        if(session_counter<=0){
           /* clearInterval(session_interval);
            $('.session_counter_container').html('Время сессии истекло');
            
            // Пользователь должен перелогиниться
            draw_popup("confirm", 'Время сессии истекло', 'Время сессии истекло.<br /> '+
            'Для дальнейшей работы обновите страницу.'+
//            '<div class="vote" style="display:none;">'+
            '<div class="vote">'+
                '<b>Пожалуйста, оцените наш сервис</b>'+
                '<div class="widget" id="session_vote_statements"></div>'+
                '<div class="widget" id="session_vote_mobilepop_quickness"></div>'+
                '<div class="widget" id="session_vote_new_design"></div>'+
            '</div>', { 
                'button_yes_text':    "Обновить",
                'onSubmit':            function(){window.location.reload();},
                height:                400
                });
            
            //showVotiong();      */
            
            return;
            }
        
        // получим минуты и секунды
        var minutes=(session_counter<=0)?0:parseInt(session_counter/60);
        var seconds=(session_counter<=0)?0:session_counter - minutes*60;
        if(seconds<10) seconds='0'+seconds;
        
        $('#session_counter').html(minutes+':'+seconds);
        if(session_counter<=60) $('#session_counter').parent().addClass('critical');
        else if(session_counter<=120) $('#session_counter').parent().addClass('middle');
        else $('#session_counter').parent().removeClass('middle').removeClass('critical');
        
        }, 1000);
}


// при каждом успешном запросе к серверу будем сбрасывать счетчик 
$("#session_counter").ajaxSend(function(){
    resetCounter();
    });

    

// при загрузке страницы сбросим
resetCounter();

////////////////////////////////////////////
// Прорисовывает попап
////////////////////////////////////////////
function draw_popup (type, title, text, params){
    
    // Удалим старые попапы
    $(".popup").remove();
    
    // Установим начальные значения входных параметров
    if (typeof params == "undefined") params={};
    if (!params.button_text) params.button_text="ok";
    if (!params.button_yes_text) params.button_yes_text="Подтверждаю";
    if (!params.button_cancel_text) params.button_cancel_text="Отмена";
    
    if (!params.onCancel) params.onCancel=function(){};
    if (!params.onSubmit) params.onSubmit=function(){};
     
    var html='<div class="popup">' +
    '<div class="lighter"></div>' + 
        '<div class="popup_container" style="'+(params.width?'width:'+params.width+'px; margin-left:-'+(parseInt(params.width/2))+'px;':'')+(params.width?'height:'+params.height+'px; margin-top:-'+(parseInt(params.height/2))+'px;':'')+'">' + 
            '<div class="popup_container1">' + 
                '<div class="popup_header">' + 
                    '<a href="JavaScript:void(0)" class="popup_closer"></a>' +
                    '<div>'+(title || '')+'</div>'+
                '</div>'+
                '<div class="popup_text">'+(text || '')+'</div>'+
                '<div><div class="popup_button_container">';
                
                    if(type=="alert") html+='<a href="JavaScript:void(0)" class="popup_button">'+params.button_text+'</a>';
                    
                    else html+='<a href="JavaScript:void(0)" class="popup_button popup_button_yes">'+params.button_yes_text+'</a>'+ 
                    '<a href="JavaScript:void(0)" class="popup_button popup_button_cancel">'+params.button_cancel_text+'</a>'; 
                    
                html+='</div></div>'+
            '</div>'+
        '</div>'+
    '</div>';
        
    $(html).appendTo('body');
    
    var onClose=function(){
        if(params.onCancel()===false ) return;
        if(type=="alert") if(params.onSubmit()===false) return;
        $(".popup").remove();
        };
    
    if(type=="alert") 
        $(".popup .popup_button").bind("click", onClose);
    else {
        $(".popup .popup_button_cancel").bind("click", onClose);
        }
    $(".popup .popup_closer").bind("click", onClose);
    $(".popup .lighter").bind("click", onClose);
    
    $(".popup .popup_button_yes").bind("click", function(){
        if(params.onSubmit()===false) return;
                // @TODO убиить:
        if(!params.noCloseOnSubmit) $(".popup").remove();
        });

    // выставим поцентру страницы
    var height=$(".popup .popup_container").height();
    $(".popup .popup_container").css("margin-top", "-"+parseInt(height/2)+"px");
    
    // если окошко неумещается, то дадим возможность прокрутки
    if(height > $(window).height()) {
        $(".popup .popup_container").css("margin-top", "0").css("top", "50px").css("position", "absolute");
        }
}


</script>
