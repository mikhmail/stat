
	function GetStatusId(id, status_id){
	var sel = document.getElementById(status_id); // Получаем наш список
	var status_id = sel.options[sel.selectedIndex].value; // Получаем текст нашей опции (в нашем случае Яблоко).
	$.post("changeStatus.php", { id_kvitancy:id, status_id:status_id })
	.done(function(data) {
	$('input#status_'+id+'').attr("class","status");
	$('input#status_'+id+'').val("Сохранил..");
	$('div#save_'+id+'').empty();
	$('div#save_'+id+'').html(data);
	$('div#save_'+id+'').hide(3000);
	$('input#status_'+id+'').empty();
	if (status_id == 1) {$('[id*='+id+']').attr('class','vrabote');}
	else if (status_id == 2) {$('[id*='+id+']').attr('class','gotov'); }
	else if (status_id == 3) {$('[id*='+id+']').attr('class','detal'); }
	else if (status_id == 4) {$('[id*='+id+']').attr('class','aktspisaniya'); }
	else if (status_id == 5) {$('[id*='+id+']').attr('class','bezremonta'); }
	else if (status_id == 6) {$('[id*='+id+']').attr('class','gotov'); }
	else if (status_id == 7) {$('[id*='+id+']').attr('class','vidansremontom'); }
	else if (status_id == 8) {$('[id*='+id+']').attr('class','vidanbezremonta'); }
	else if (status_id == 9) {$('[id*='+id+']').attr('class','aktspisaniya'); }
	else {$('[id*='+id+']').attr('class','vrabote'); }
	
	//$('[id*='+id+']');
	

	//$('div#status_'+id+'').hide(2000);
	//$('div#status_'+id+'').empty();
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



	function AddComment(id, comment_id, user_id){
	var text=document.getElementById(comment_id).value;
	$.post("addComment.php", { id_kvitancy:id, comment_id:text, user_id:user_id })
	.done(function(data) {
	$('div#new_com_'+id+' ul').prepend(data);
	$('#comment_'+id+'').val('');
	});
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
   



	$(document).ready(function(){
		$('.btn-slide').each(function(){
			$(this).click(function(){
			$(this).next().slideToggle(100);
			$(this).toggleClass('active');
			return false;
			});
		});
	});