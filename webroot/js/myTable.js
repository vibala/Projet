function unClearNoneUseDatableFrameWork()
{
	for(var i=1;i<=10;i++)
	{
	$('tbody').children("tr:nth-child("+ i +")").children('th').last().addClass("disapear");
	}
	$('thead').children('tr').children('th').last().addClass("disapear");
	$('tfoot').children('tr').children('th').last().addClass("disapear");
	
	$('#gameInterface_filter').addClass("disapear"); // delete the research 
	$('#gameInterface_length').addClass("disapear"); // delete the length define
	$('#gameInterface_info').addClass("disapear"); // delete info table
	$('#gameInterface_paginate').addClass("disapear"); // delete info table
}
function setFighterRadomly()
{
$('tbody').children('tr').children('th').addClass("setSize");
	
	radom_x = Math.floor(Math.random() * (15 - 1) + 1);
	radom_y = Math.floor((Math.random() * (10 - 1) + 1 ) );
	console.log('('+radom_x + ','+ radom_x+')');
	$('tbody').children("tr:nth-child("+radom_y+")").children("th:nth-child("+(radom_x)+")").append('<img id = "image" src="/WebArenaGoupSIA-00-00%20-%20Copie/WebArenaGoupSIA-00-00/img/pomme.jpg" >' + '</img>');

}

var Methods = {
	
	gameInterfaceInitialisation : function() {
    $('#gameInterface').DataTable({
	"columns": [
    { "width": "5%"},
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	{ "width": "5%" },
	null
  ]
	
	});
	
	setFighterRadomly();
	unClearNoneUseDatableFrameWork();
	
},	
	
	moveCombattant : function(e){
		coord_x = $('#image').parent().attr('id');
		coord_y = $('#image').parent().parent().attr('id');
		switch(e.keyCode )
		{
			case 37 :  // gauche
			coord_future_x = parseInt(coord_x) - 1;
			if(coord_future_x < 1) coord_future_x = 1;
			$('#image').remove();
			$('tbody').children("tr:nth-child("+coord_y+")").children("th:nth-child("+(coord_future_x)+")").append('<img id = "image" src="/WebArenaGoupSIA-00-00%20-%20Copie/WebArenaGoupSIA-00-00/img/pomme.jpg" >' + '</img>');
			break;
			
			case 38 :  // up
			coord_future_y = parseInt(coord_y) - 1;
			if(coord_future_y < 1) coord_future_y = 1;
			$('#image').remove();
			$('tbody').children("tr:nth-child("+coord_future_y+")").children("th:nth-child("+(coord_x)+")").append('<img id = "image" src="/WebArenaGoupSIA-00-00%20-%20Copie/WebArenaGoupSIA-00-00/img/pomme.jpg" >' + '</img>');
			break;
			
			case 39 :  // droite
			coord_future_x = parseInt(coord_x) + 1;
			if(coord_future_x > 15) coord_future_x = 15;
			$('#image').remove();
			$('tbody').children("tr:nth-child("+coord_y+")").children("th:nth-child("+(coord_future_x)+")").append('<img id = "image" src="/WebArenaGoupSIA-00-00%20-%20Copie/WebArenaGoupSIA-00-00/img/pomme.jpg" >' + '</img>');
			break;
			
			case 40:   // down
			coord_future_y = parseInt(coord_y) + 1;
			if(coord_future_y > 10) coord_future_y = 10;
			$('#image').remove();	
			$('tbody').children("tr:nth-child("+coord_future_y+")").children("th:nth-child("+(coord_x)+")").append('<img id = "image" src="/WebArenaGoupSIA-00-00%20-%20Copie/WebArenaGoupSIA-00-00/img/pomme.jpg" >' + '</img>');		
			break;
			
			default:
			console.log('other button');
			break;
		}
	}

};

$(document).ready(Methods.gameInterfaceInitialisation);
$('html').keydown(Methods.moveCombattant)

