
function anichange (obj) {
							var objName = $(obj).next();
							var objPrev = $(obj).prev();
							
								 if ( $(objName).css('display') == 'none' ) {
								 $(objName).animate({height: 'show'}, 400);
								 $(objPrev).css({'background-position':"-11px 0"});
								 } else {
								 $(objName).animate({height: 'hide'}, 200);
								 $(objPrev).css({'background-position':"0 0"});
								 }
								}

	 
	 $(document).ready(function(){
//Обработка нажатия на кнопку "Вверх"
$("#up").click(function(){
//Необходимо прокрутить в начало страницы
var curPos=$(document).scrollTop();
var scrollTime=curPos/1000;
$("body,html").animate({"scrollTop":0},scrollTime);
});

//Обработка нажатия на кнопку "Вниз"
$("#down").click(function(){
//Необходимо прокрутить в конец страницы
var curPos=$(document).scrollTop();
var height=$("body").height();
var scrollTime=(height-curPos)/100;
$("body,html").animate({"scrollTop":height},scrollTime);
});
});

	 
	 
	 
	$(document).ready(function(){
    $.fn.wait = function(time, type) {
        time = time || 1000;
        type = type || "fx";
        return this.queue(type, function() {
            var self = this;
            setTimeout(function() {
                $(self).dequeue();
            }, time);
        });
    };
    function runIt() {
      $("#blinkingText").wait()
              .animate({"opacity": 0.1},2000)
              .wait()
              .animate({"opacity": 1},1500,runIt);
    }
    runIt();
    });

	

// фильтр заказчика запчасти
$(document).ready(function(){

$("select#id_zakazchik").change(function(){
var id_zakazchik = $("select#id_zakazchik option:selected").val();
//alert (id_zakazchik);
	

	delete id_zakazchik;
	
	});
});
	
	


function ChangeWhere(id, where_id){
	var sel = document.getElementById(where_id); // Получаем наш список
	var where = sel.options[sel.selectedIndex].value; // Получаем текст нашей опции.
	$.post("changeWhereStat.php", { id_kvitancy:id, where_id:where })
	.done(function(data) {
	$('input#where_'+id+'').attr("class","status");
	$('input#where_'+id+'').val("Сохранил..");
});
}




	function GetMechanicId(id, meh_id){
	var sel = document.getElementById(meh_id); // Получаем наш список
	var meh_id = sel.options[sel.selectedIndex].value; // Получаем текст нашей опции
	$.post("changeMechanic.php", { id_kvitancy:id, meh_id:meh_id })
	.done(function(data) {
	
	$('input#meh_'+id+'').attr("class","status");
	$('input#meh_'+id+'').val("Сохранил..");
	$('div#update_'+id+'').empty();
	$('div#update_'+id+'').html(data);
	$('input#meh_'+id+'').val("Сохранить");

	//$('div#status_'+id+'').hide(2000);
	//$('div#status_'+id+'').empty();
	
	//alert(data);
	});
}


// поменять механика нью!
$(document).ready(function(){

$('select[id^=meh_]').change(function(){
var meh_id = $('#'+this.id+' option:selected').val();
var id_kvit = this.name;

	$.post("changeMechanic.php", { id_kvitancy:id_kvit, meh_id:meh_id })
		.done(function(data) {
			$("#meh_"+id_kvit+"").fadeOut("slow");
			 $("#meh_"+id_kvit+"").fadeIn();
		});
		
	delete meh_id;
	delete id_kvit;
	});
});


// смена ответцтвенного	в базе
$(document).ready(function(){
$('select[id^=resp_]').change(function(){
var resp_id = $('#'+this.id+' option:selected').val();
var id_kvit = this.name;
		
		//alert (resp_id);
		//alert (id_kvit);
		
		/*
		$.ajax({
		  url: "ajax.php?ajx/change_mechanic/"+status+"/"+id+"",
		  success: function(data) {
			
			 $("#meh_"+id+"").fadeOut("slow");
			 $("#meh_"+id+"").fadeIn();
		  }
		});
		*/
		
	$.post("changeMechanic.php", { id_kvitancy:id_kvit, resp_id:resp_id })
		.done(function(data) {
			$("#resp_"+id_kvit+"").fadeOut("slow");
			 $("#resp_"+id_kvit+"").fadeIn();
		});
		
	delete resp_id;
	delete id_kvit;
	});
});


// смена где техника находится в базе
$(document).ready(function(){

$('select[id^=id_where_]').change(function(){
var id_where = $('#'+this.id+' option:selected').val();
var id_kvit = this.name;

	$.post("changeWhereStat.php", { id_kvitancy:id_kvit, id_where:id_where })
		.done(function(data) {
			$("#id_where_"+id_kvit+"").fadeOut("slow");
			 $("#id_where_"+id_kvit+"").fadeIn();
		});
		
	delete id_where;
	delete id_kvit;
	});
});


// смена статуса нью
$(document).ready(function(){

$('select[id^=status_]').change(function(){
var status_id = $('#'+this.id+' option:selected').val();
var id_kvit = this.name;

	$.post("changeStatus.php", { id_kvitancy:id_kvit, status_id:status_id})
		.done(function(data) {
			$("#status_"+id_kvit+"").fadeOut("slow");
			 $("#status_"+id_kvit+"").fadeIn();
			 
			 if 		(status_id == 1) {$('span#app_'+id_kvit+'').attr('class','vrabote');}
	else if (status_id == 2) {$('span#app_'+id_kvit+'').attr('class','gotov'); }
	else if (status_id == 3) {$('span#app_'+id_kvit+'').attr('class','detal'); }
	else if (status_id == 4) {$('span#app_'+id_kvit+'').attr('class','aktspisaniya'); }
	else if (status_id == 5) {$('span#app_'+id_kvit+'').attr('class','bezremonta'); }
	else if (status_id == 6) {$('span#app_'+id_kvit+'').attr('class','gotov'); }
	else if (status_id == 7) {$('span#app_'+id_kvit+'').attr('class','vidansremontom'); }
	else if (status_id == 8) {$('span#app_'+id_kvit+'').attr('class','vidanbezremonta'); }
	else if (status_id == 9) {$('span#app_'+id_kvit+'').attr('class','aktspisaniya'); }
	else if (status_id == 10) {$('span#app_'+id_kvit+'').attr('class','soglasovat'); }
	else if (status_id == 17) {$('span#app_'+id_kvit+'').attr('class','test'); }
	else if (status_id == 18) {$('span#app_'+id_kvit+'').attr('class','soglasovat2'); }
	
	
	else {$('[id*='+id_kvit+']').attr('class','vrabote'); }
			 
		});
		
	delete status_id;
	delete id_kvit;
	});
});


// смена отвецтвенного в складе
$(document).ready(function(){

$('select[id^=id_resp_store_]').change(function(){
var id_resp = $('#'+this.id+' option:selected').val();
var id = this.name;
var user_id = this.title;


if ((id_resp != '') && (id != '')) {


	$.post("changeMechanicStore.php", { id:id, id_resp:id_resp, user_id })
		.done(function(data) {
			$("#id_resp_store_"+id+"").fadeOut("slow");
			 $("#id_resp_store_"+id+"").fadeIn();
		});
		
	delete id_resp;
	delete id;
	delete user_id;
	
	}else{alert('Что-то не выбрано!');}
	});
});

// смена отвецтвенного в запчастях
$(document).ready(function(){

$('select[id^=id_resp_zap_]').change(function(){
var id_resp = $('#'+this.id+' option:selected').val();
var id = this.name;
var user_id = this.title;


if ((id_resp != '') && (id != '')) {


	$.post("changeMechanicZap.php", { id:id, id_resp:id_resp, user_id })
		.done(function(data) {
			$("#id_resp_zap_"+id+"").fadeOut("slow");
			 $("#id_resp_zap_"+id+"").fadeIn();
		});
		
	delete id_resp;
	delete id;
	delete user_id;
	
	}else{alert('Что-то не выбрано!');}
	});
});

// смена где запчасть находится в складе
$(document).ready(function(){

$('select[id^=store_id_where_]').change(function(){
var id_where = $('#'+this.id+' option:selected').val();
var id = this.name;
var user_id = this.title;


if ((id_where != '') && (id != '')) {


	$.post("changeWhereStore.php", { id:id, id_where:id_where, user_id })
		.done(function(data) {
			$("#store_id_where_"+id+"").fadeOut("slow");
			 $("#store_id_where_"+id+"").fadeIn();
		});
		
	delete id_where;
	delete id;
	delete user_id;
	
	}else{alert('Что-то не выбрано!');}
	});
});

$(document).ready(function(){
$('select[id^=zakaz_id_aparat_1]').change(function(){
	//alert (this.id);
	id_aparat = $('#'+this.id+' option:selected').val();
		$('#'+this.id+'').next().load("ajaxApparat_p.php", { id_aparat: $('#'+this.id+' option:selected').val() });
	
	});
});

$(document).ready(function(){
$('select[id^=sklad_id_aparat_1]').change(function(){
	//alert (this.id);
	id_aparat = $('#'+this.id+' option:selected').val();
		$('#'+this.id+'').next().load("ajaxApparat_p.php", { id_aparat: $('#'+this.id+' option:selected').val() });
	
	});
});

$(document).ready(function(){
$('a[id^=show_comments_]').click(function(){
	

						var objName = $(this).next();
							var objPrev = $(this).prev();
							
								 if ( $(objName).css('display') == 'none' ) {
								 $(objName).animate({height: 'show'}, 100);
								
	var id_kvitancy = this.name;
	//alert (this.name);
	$('#'+this.id+'').next().load("addComment.php", { show_comments: true, id_kvitancy: id_kvitancy });
	
								 } else {
								 $(objName).animate({height: 'hide'}, 100);
								
								 }
								 
	
	
	});
});

$(document).ready(function(){
$('a[id^=show_zapchasti_]').click(function(){
	

						var objName = $(this).next();
							var objPrev = $(this).prev();
							
								 if ( $(objName).css('display') == 'none' ) {
								 $(objName).animate({height: 'show'}, 100);
								
	var nomer_kvitancy = this.name;
	var id_proizvod = this.title;
	var id_aparat = this.lang;
	
	//alert (id_aparat);exit
	$('#'+this.id+'').next().load("showZap.php?nomer_kvitancy="+nomer_kvitancy+"&id_proizvod="+id_proizvod+"&id_aparat="+id_aparat+"", { nomer_kvitancy: nomer_kvitancy });
	
								
								 } else {
								 $(objName).animate({height: 'hide'}, 100);
								
								 }
								 
	
	
	});
});


$(document).ready(function(){
$('a[id^=show_info_]').click(function(){
	

						var objName = $(this).next();
							var objPrev = $(this).prev();
							
								 if ( $(objName).css('display') == 'none' ) {
								 $(objName).animate({height: 'show'}, 100);
								
	var id_kvitancy = this.name;
	
	user_id_Obj = $(this).next(); 
	
	var user_id = $(user_id_Obj).attr("name");
	//alert (user_id);
	$('#'+this.id+'').next().load("showInfo.php?id_kvitancy="+id_kvitancy+"&user_id="+user_id+"", { id_kvitancy: id_kvitancy, user_id: user_id });
	
								
								 } else {
								 $(objName).animate({height: 'hide'}, 100);
								
								 }
								 
	
	
	});
});


$(document).ready(function(){
$('a[id^=show_store_]').click(function(){
	

						var objName = $(this).next();
							var objPrev = $(this).prev();
							
								 if ( $(objName).css('display') == 'none' ) {
								 $(objName).animate({height: 'show'}, 100);
								
	var nomer_kvitancy = this.name;
	//alert (this.name);
	$('#'+this.id+'').next().load("showSpis.php?nomer_kvitancy="+nomer_kvitancy+"", { nomer_kvitancy: nomer_kvitancy });
	
								
								 } else {
								 $(objName).animate({height: 'hide'}, 100);
								
								 }
								 
	
	
	});
});

function GetStatusId(id, status_id){
	var sel = document.getElementById(status_id); // Получаем наш список
	var status_id = sel.options[sel.selectedIndex].value; // Получаем текст нашей опции.
	$.post("changeStatus.php", { id_kvitancy:id, status_id:status_id })
	.done(function(data) {
	$('input#status_'+id+'').attr("class","status");
	$('input#status_'+id+'').val("Сохранил..");
	//$('div#save_'+id+'').empty();
	//$('div#save_'+id+'').html(data);
	//$('div#save_'+id+'').hide(3000);
	//$('input#status_'+id+'').empty();
	if 		(status_id == 1) {$('span#app_'+id+'').attr('class','vrabote');}
	else if (status_id == 2) {$('span#app_'+id+'').attr('class','gotov'); }
	else if (status_id == 3) {$('span#app_'+id+'').attr('class','detal'); }
	else if (status_id == 4) {$('span#app_'+id+'').attr('class','aktspisaniya'); }
	else if (status_id == 5) {$('span#app_'+id+'').attr('class','bezremonta'); }
	else if (status_id == 6) {$('span#app_'+id+'').attr('class','gotov'); }
	else if (status_id == 7) {$('span#app_'+id+'').attr('class','vidansremontom'); }
	else if (status_id == 8) {$('span#app_'+id+'').attr('class','vidanbezremonta'); }
	else if (status_id == 9) {$('span#app_'+id+'').attr('class','aktspisaniya'); }
	else if (status_id == 10) {$('span#app_'+id+'').attr('class','soglasovat'); }
	else if (status_id == 17) {$('span#app_'+id+'').attr('class','test'); }
	
	else {$('[id*='+id+']').attr('class','vrabote'); }
	
	//$('[id*='+id+']');
	

	//$('div#status_'+id+'').hide(2000);
	//$('div#status_'+id+'').empty();
	});
}


// отправка смс
$(document).ready(function(){

$('input[id^=sms_]').click(function(){

var parts=new Array();
			var id = this.id;
			parts = id.split('_');
			
			var id_kvit = parts[1];
			

var app_name = $("#aparat_name_"+id_kvit+"").text();
var phone = $("#phone_"+id_kvit+"").text();

phone = phone.replace("-", "");
phone = phone.replace(" ", "");

//alert(phone);
alert('Эта функция пока не работает');
	});	
});

// добавить комментр
	function AddComment(id, comment_id, user_id, nomer){
	var text=document.getElementById('comment_'+id).value;
	$.post("addComment.php", { id_kvitancy:id, comment_id:text, user_id:user_id, nomer_kvitancy:nomer })
	.done(function(data) {
	$('div#new_com_'+id+' ul').prepend(data);
	$('#comment_'+id+'').val('');
	});
}

	function DellComment(id_comment){
	$.post("addComment.php", { id_comment:id_comment })
	.done(function(data) {
	$('#li_'+id_comment+'').remove();
	});
}

function destroy(id_comment)
{
  if (confirm("Хотите удалить? Восстановить будет не возможно!"))
    $.post("addComment.php", { id_comment:id_comment })
	.done(function(data) {
	$('#li_'+id_comment+'').remove();
	});
  else
    alert("не удалил..");
}


	function AddPrimechanie(id, primechanie_id, user_id){
	var text=document.getElementById(primechanie_id).value;
	$.post("AddPrimechanie.php", { id_kvitancy:id, primechanie_id:text, user_id:user_id })
	.done(function(data) {
	$('input#primechanie_'+id+'').attr("class","status");
	$('input#primechanie_'+id+'').val("Добавил..");
	$('input#primechanie_'+id+'').empty();

	//$('div#status_'+id+'').hide(2000);
	//$('div#status_'+id+'').empty();
	
	//alert(data);
	});
$('input#primechanie_'+id+'').val("Добавить");
}
   
function ShowSklad(nomer_kvitancy){
	
	id_aparat = $("#sklad_id_aparat_"+nomer_kvitancy+" option:selected").val();
	id_aparat_p = $("#sklad_id_aparat_p_"+nomer_kvitancy+" option:selected").val();
	search_value = $('input#zap_search_'+nomer_kvitancy+'').val();
	
	if (search_value == '') { 
	
	if ((id_aparat_p != '') && (id_aparat != '')) {
			
			$.post("showSklad.php", { id_aparat:id_aparat, id_aparat_p:id_aparat_p, nomer_kvitancy:nomer_kvitancy })
				.done(function(data) {
					$('div#zap_rez_'+nomer_kvitancy+'').html(data);
				});
	}else {
	alert ('Надо выбрать раздел и запчасть!');
	}
} else {

$.post("showSklad.php", { search_value:search_value, nomer_kvitancy:nomer_kvitancy })
				.done(function(data) {
				if(data) {
						$('div#zap_rez_'+nomer_kvitancy+'').html(data);
					} else {
					$('div#zap_rez_'+nomer_kvitancy+'').html('ничего не найдено...');
					}
				});

	}
}



	function vernutSklad(nomer_kvitancy, id, user_id){
	
	if (confirm("Хотите вернуть на склад?")) {
		$.post("vernutSklad.php", { nomer_kvitancy:nomer_kvitancy, id:id, user_id:user_id })
			.done(function(data) {
			//$('input#spis_'+id+'').attr("class","status");
			//$('input#spis_'+id+'').val("Списал..");
			
			$('div#store_'+nomer_kvitancy+'').remove();
			alert("Вернул! Надо перезгрузить страничку.");
			});
	}
}



	$(document).ready(function(){
		$('.btn-slide').each(function(){
			$(this).click(function(){
			$(this).next().slideToggle(100);
			$(this).toggleClass('active');
			return false;
			});
		});
	});
	
	$(document).ready(function(){
		$('.inform').each(function(){
			$(this).click(function(){
			$(this).next().slideToggle(100);
			$(this).toggleClass('inform');
			return false;
			});
		});
	});
	
	
	$(document).ready(function(){
		$('.zapchasti').each(function(){
			$(this).click(function(){
			$(this).next().slideToggle(100);
			$(this).toggleClass('zapchasti');
			return false;
			});
		});
	});
	
	$(document).ready(function(){
		$('.sklad').each(function(){
			$(this).click(function(){
			$(this).next().slideToggle(100);
			$(this).toggleClass('sklad');
			return false;
			});
		});
	});
	
	
	$(document).ready(function(){

    $("#main").validate({

       rules:{

            id_aparat:{
                required: true,
					},
			
			id_proizvod:{
                required: true,
					},
            model:{
                required: true,
                minlength: 3,
               // maxlength: 20,
				},
			ser_nomer:{
                required: true,
                minlength: 3,
               // maxlength: 20,
				},
			neispravnost:{
                required: true,
                minlength: 10,
               // maxlength: 20,
				},
			vid:{
                required: true,
                minlength: 40,
               // maxlength: 20,
				},
			komplektnost:{
                required: true,
                minlength: 10,
               // maxlength: 20,
				},
			id_mechanic:{
                required: true,
                //minlength: 30,
               // maxlength: 20,
				},
			fam:{
                required: true,
                minlength: 3,
               // maxlength: 20,
				},
			imya:{
                required: true,
                minlength: 3,
               // maxlength: 20,
				},
			otch:{
                required: true,
                minlength: 7,
               // maxlength: 20,
				},
			
			
				
			phone:{
                required: true,
                minlength: 10,
                maxlength: 10,
				},
			gorod_id:{
                required: true,
                //minlength: 6,
               // maxlength: 20,
				},
			where_id:{
                required: true,
                //minlength: 6,
               // maxlength: 20,
				},
			login:{
                required: true,
                minlength: 3,
               maxlength: 20,
				},



			
       },

       messages:{
			
			primechaniya:{
                required: "Надо написать что с клиентом предварительно согсовано!",
                minlength: "primechaniya должна быть минимум 3 символа",
                maxlength: "Максимальное число символо - 16",
            },
			
            model:{
                required: "*",
                minlength: "Модель должна быть минимум 4 символа",
                maxlength: "Максимальное число символо - 16",
            },
			
			 vid:{
                required: "*",
                minlength: "Надо осмотреть аппарат и описать следы эксплуатации: царапины, потёртости, и тд.",
                maxlength: "Максимальное число символо - 16",
            },

            pswd:{
                required: "Это поле обязательно для заполнения",
                minlength: "Пароль должен быть минимум 6 символа",
                maxlength: "Пароль должен быть максимум 16 символов",
            },

       }

    });
});




$(document).ready(function(){


    $("#save").validate({

       rules:{

            login:{
                required: true,
					},
			password:{
                required: true,
					},
			fam:{
                required: true,
					},
            imya:{
                required: true,
                //minlength: 3,
               // maxlength: 20,
				},
			id_sc:{
                required: true,
                //minlength: 6,
               // maxlength: 20,
				},
			groups_dostupa:{
                required: true,
                //minlength: 30,
               // maxlength: 20,
				}	
       }


    });
});

/*
$(document).ready(function(){


    $("#store").validate({

       rules:{

            name:{
                required: true,
					},
			id_aparat:{
                required: true,
					},
			id_proizvod:{
                required: true,
					},
            id_where:{
                required: true,
                //minlength: 3,
               // maxlength: 20,
				},
			id_count:{
                required: true,
                //minlength: 6,
               // maxlength: 20,
				},
			price:{
                required: true,
                //minlength: 30,
               // maxlength: 20,
				},
			id_aparat_p: {
			required: true,
			}		
       }


    });
});

*/


$(document).ready(function(){
$("#login").change(function(){

login = $("#login").val();
		$.post("checkUserLogin.php", {login:login})
			.done(function(data) {
		
		if (data == 'false') {
		$("#add_user_save").attr("disabled", "disabled");
			$("#login").attr("class","inputRed");
				alert('Login: '+login+' уже занят!');
					$("#login").focus();
			}
		if (data == 'true') {
			$("#add_user_save").removeAttr("disabled");
				$("#login").attr("class","inputGreen");
			}

		});
	});
});

/////////////////////
function add_app_p(id, user_id, id_sc){
	
	var objPrev = $('#submit_add_id_aparat_p_'+id+'').prev();
	var app_p_name = $(objPrev).val();
	var id_aparat = $('select#zakaz_id_aparat_'+id+' option:selected').val();
	
	if (app_p_name != '' && id_aparat != '') {
	
			$.post("add_app.php", {aparat_p_name:app_p_name, id_aparat:id_aparat})
				.done(function(data) {
		
					if (data.match(/^[-\+]?\d+/) === null) {
					alert('Такое название уже есть в базе!');
					$(objPrev).focus();
						} else {
						$('select#zakaz_id_aparat_p_'+id+'').append('<option value="'+data+'" selected="selected">'+app_p_name+'</option>');
						
			}
		});
			} else { alert('Что-то не введено!'); }
	}
///////////////////////////////////

$(document).ready(function(){
	$("#add_aparat").click(function(){
		app = $("#add_aparat_name").val();
			if (app != '') {
			$.post("add_app.php", {aparat_name:app})
			.done(function(data) {
		
		if (data.match(/^[-\+]?\d+/) === null) {
		alert('Такой аппарат уже есть в базе!');
		$("#add_aparat_name").focus();
											} 
			else {
			select_app(app,data);
			}
		});
		}	else { alert('Надо ввести название!'); }
	});
});

function select_app(app,id){
	$("select#id_aparat").append('<option value="'+id+'" selected="selected">'+app+'</option>');
	$('#panel').hide();
	var aparat = $('#id_aparat option:selected').html();
	$('div#spisanie_'+nomer_kvitancy+'').html(data);
}


// добавить раздел в складе
$(document).ready(function(){
	$("#submit_add_id_aparat_p").click(function(){
		var app_p = $("#add_id_aparat_p").val();
		var id_aparat = $("#id_aparat option:selected").val();
		
		if (app_p != '' && id_aparat != '') {
			$.post("add_app.php", {aparat_p_name:app_p, id_aparat:id_aparat})
			.done(function(data) {
		
		if (data.match(/^[-\+]?\d+/) === null) {
		alert('Такое название уже есть в базе!');
		$("#add_id_aparat_p").focus();
											} 
			else {
			select_app_p(app_p,data);
			}
		});
		} else {alert('Надо ввести под раздел!');}
	});
});

function select_app_p(app,id){
	$("select#id_aparat_p").append('<option value="'+id+'" selected="selected">'+app+'</option>');
}


$(document).ready(function(){
	$("#add_proizvod").click(function(){
		app = $("#add_proizvod_name").val();
		if (app != '') {
			$.post("add_app.php", {name_proizvod:app})
			.done(function(data) {
		
		if (data.match(/^[-\+]?\d+/) === null) {
		alert('Такой бренд уже есть в базе!');
		$("#add_proizvod_name").focus();
											} 
			else {
			select_proidvod(app,data);
			}
		});
		} else { alert ('Надо ввести название!'); }
	});
});

function select_proidvod(app,id){
	$("select#id_proizvod").append('<option value="'+id+'" selected="selected">'+app+'</option>');
	$('#add_proizvod_name').hide();
	$('#add_proizvod').hide();
}

function AddZapchast2(nomer_kvitancy,user_id, id_sc) {

	name_zap =  $("#name_zap").val();
	nomer_kvit =  $("#nomer_kvit").val();
	
	kolvo =     $("#kolvo").val();
	id_aparat = $("#id_aparat option:selected").val();
	id_aparat_p = $("#id_aparat_p option:selected").val();
	id_proizvod = $("#id_proizvod option:selected").val();
	model = $("#model").val();
	
	if ((name_zap != '') && (nomer_kvit != '') && (id_aparat != '') && (id_aparat_p != '') && (id_proizvod != '') && (model != '')) {
	
				$.post("add_zapchast.php", {id_sc:id_sc,
									name_zap:name_zap,
									kolvo:kolvo,
									nomer_kvitancy:nomer_kvit,
									user_id:user_id,
									id_sc:id_sc,
									id_aparat:id_aparat,
									id_aparat_p:id_aparat_p,
									id_proizvod:id_proizvod,
									model:model
									
									})
								
			.done(function(data) {
			if (data == 'false') {
				alert ('Что-то не так!');
				
			}else {
			alert ('Добавил!');
			window.location.replace('parts.php')
			}
			});
	
	}else {
	alert ('Что-то не выбрано!');
	}
	
}

/*
$(document).ready(function(){
 $("form#store").submit(function() {
    
	if (confirm("Сразу после отправки формы НАДО!!! нажать кнопку RESET, иначе при простом обновлениие f5 может добавиться дубликат запчасти...! \n \n Чтобы добавить запчасть НАЖМИТЕ ОТМЕНА.")) {
	return false;
	} else {
	return true;
	}
    });
});
*/

function AddZapchast(nomer_kvitancy,user_id, id_sc) {
	name_zap =  $("#name_zap_"+nomer_kvitancy+"").val();
	kolvo =     $("#kolvo_"+nomer_kvitancy+"").val();
	id_aparat = $("#zakaz_id_aparat_"+nomer_kvitancy+" option:selected").val();
	id_aparat_p = $("#zakaz_id_aparat_p_"+nomer_kvitancy+" option:selected").val();
	id_proizvod = $("#zakaz_id_proizvod_"+nomer_kvitancy+" option:selected").val();
	
	if ((name_zap != '') && (id_aparat != ''))
	{
		$.post("add_zapchast.php", {id_sc:id_sc,
									name_zap:name_zap,
									kolvo:kolvo,
									nomer_kvitancy:nomer_kvitancy,
									user_id:user_id,
									id_sc:id_sc,
									id_aparat:id_aparat,
									id_aparat_p:id_aparat_p,
									id_proizvod:id_proizvod
									})
								
			.done(function(data) {
			if (data == 'false') {
				alert ('Что-то не выбрано!');
				
			}else {
			  $('input#zakazat_'+nomer_kvitancy+'').attr("class","status");
			  $('input#zakazat_'+nomer_kvitancy+'').val("Заказал..");
			  $('div#zakazannie_'+nomer_kvitancy+'').html(data);
			}
			});
	} else {alert ('Что-то не выбрано!');}	
}

function AddPrice(nomer_kvitancy, name_proizvod, model) {
	work_zap =  $("#work_zap_"+nomer_kvitancy+"").val();
	work_price =     $("#work_price_"+nomer_kvitancy+"").val();
	
		$.post("add_work_price.php", {name_proizvod:name_proizvod, model:model, work_zap:work_zap, work_price:work_price})
	.done(function(data) {
	
	  $('input#otpravit_'+nomer_kvitancy+'').attr("class","status");
	  $('input#otpravit_'+nomer_kvitancy+'').val("Добавил..");
	 	});
}


function changeStatusZapchast(id_zap, name_zap, id_aparat, id_aparat_p, id_proizvod, kolvo) {
var price =     $("#price_"+id_zap+"").val();
var sklad =     $("#sklad_"+id_zap+"").val();
var id_sost =     $("#id_sost_"+id_zap+"").val();




var aparat =     $("#aparat_"+id_zap+"").text();

var model =     $("#model_"+id_zap+"").text();

var name = name_zap +' для '+ aparat;


if (confirm("Поставить на склад:\n [device]: '"+aparat+"' \n [text]: '"+name_zap+"' \n [price]: '"+price+" $.' [kol-vo]: '"+kolvo+" ?")) {

if (price != '' && sklad != '') {

$.post("add_zapchast.php", {model:model, id_zap:id_zap, name:name, price:price, id_sost:id_sost, id_where:sklad, id_aparat:id_aparat, id_aparat_p:id_aparat_p, id_proizvod:id_proizvod, kolvo:kolvo})
	.done(function(data) { 
	
	 $('tr#'+id_zap+'').remove();
	});
	}else{
	alert('Надо ввести цену, выбрать склад!');
	}
}

/*

*/

}




function DeleteZapchast(id_zap){

if (confirm("Хотите удалить? Может аппарат выдан, а запчасть не поставили на склад и забыли списать?"))
	$.post("delete_zapchast.php", { id_zap:id_zap})
	.done(function(data) {
	 
						
                        if(data) {
                                      $('tr#'+id_zap+'').remove();
                                        
                                }
                         
	});

	else
    alert("НЕ удалил...");

}

function spisatSklad(nomer, id, user_id){

if (nomer != '') {
	$.post("spisatSklad.php", { id:id, nomer:nomer, user_id:user_id })
	.done(function(data) {
	
	$('#tr_'+id+'').remove();
	
			$('input#spis_'+id+'').attr("class","status");
			$('input#spis_'+id+'').val("Списал..");
			
			$('div#spisanie_'+nomer+'').html(data);
			//alert(data);
	});
	}else alert ('Надо ввести номер квитанции');
}

function spisatStore(id, user_id){

var nomer = $("#id_kvit_"+id+"").val();

if (nomer != '') {
	$.post("spisatSklad.php", {id:id, nomer:nomer, user_id:user_id })
	.done(function(data) {
	
	$('#tr_'+id+'').remove();
	alert('Списал, надо проверить в базе.');
	});
	}else alert ('Надо ввести номер квитанции или под что списать?');
}


function DeleteFromStore(id, user_id, text){
//alert (name);exit;

var delete_it =1;

var reason = prompt('Укажите причину удаления', '');

if (reason) {

if (confirm("Хотите удалить запчасть из склада? \n Будет отослано письмо админу!")) {
	
	
	$.post("spisatSklad.php", { id:id, delete_it:delete_it, user_id:user_id, reason:reason, text:text })
	.done(function(data) {
	 
						
                        if(data) {
                                      $('#tr_'+id+'').remove();
                                        
                                }
                         
	});

	}else
   { alert("НЕ удалил..."); }
   }
}

function lookup(inputString) {
                if(inputString.length > 7) {
                        // Hide the suggestion box.
                        $('#suggestions').hide();
                } else {
                        $.post("ajaxSearch.php", {queryString: ""+inputString+""}, function(data){
                                if(data.length > 3) {
                                        $('#suggestions').show();
                                        $('#autoSuggestionsList').html(data);
                                }
                        });
                }
        } // lookup

function fill(thisValue) {
			
			var parts=new Array();
			var response = thisValue;
			
			parts = response.split('-');
			$('#user_id').val(parts[0]);
			$('#fam').val(parts[1]);
			$('#imya').val(parts[2]);
			$('#otch').val(parts[3]);
			$('#gorod').val(parts[4]);
			$('#adres').val(parts[5]);
			$('#phone').val(parts[6]);
			setTimeout("$('#suggestions').hide();", 200);
 }		


function look_apparat(inputString) {
                if(inputString.length > 10) {
                        // Hide the suggestion box.
                        $('#apparat_box').hide();
                } else {
                        $.post("ajaxApparat.php", {queryString: ""+inputString+""}, function(data){
                                if(data.length > 2) {
                                        $('#apparat_box').show();
                                        $('#apparat_list').html(data);
                                }
                        });
                }
        } // lookup

		
function fill_apparat(thisValue) {
			
			var parts=new Array();
			var response = thisValue;
			
			parts = response.split('-');
			$("select#id_aparat").append('<option value="'+parts[0]+'" selected="selected">'+parts[1]+'</option>');
			$("select#id_aparat").attr("class","status");
			
			setTimeout("$('#apparat_box').hide();", 200);
 }	
 
 
 
function look_proizvod(inputString) {
                if(inputString.length > 10) {
                        // Hide the suggestion box.
                        $('#proizvod_box').hide();
                } else {
                        $.post("ajaxProizvod.php", {queryString: ""+inputString+""}, function(data){
                                if(data.length > 2) {
                                        $('#proizvod_box').show();
                                        $('#proizvod_list').html(data);
                                }
                        });
                }
        } // lookup

		
function fill_proizvod(thisValue) {
			
			var parts=new Array();
			var response = thisValue;
			
			parts = response.split('-');
			$("select#id_proizvod").append('<option value="'+parts[0]+'" selected="selected">'+parts[1]+'</option>');
			$("select#id_proizvod").attr("class","status");
			
			
			setTimeout("$('#proizvod_box').hide();", 200);
 }



 
$(document).ready(function(){
  $("#id_aparat").change(function(){
		$("#id_aparat_p").load("ajaxApparat_p.php", { id_aparat: $("#id_aparat option:selected").val() });
	});
});

$(document).ready(function(){
  $("#store_id_aparat").change(function(){
		$("#store_id_aparat_p").load("ajaxApparat_p.php", { id_aparat: $("#store_id_aparat option:selected").val() });
	});
});

$(document).ready(function(){
  $("#zap_id_aparat").change(function(){
		$("#zap_id_aparat_p").load("ajaxApparat_p.php", { id_aparat: $("#zap_id_aparat option:selected").val() });
	});
});	