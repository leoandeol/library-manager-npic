
// $('.articleNote').on('mouseenter','.aEnter',function(e){
	// e.preventDefault();
	// GestionHover($(this).val(),5);
// });

// $('.articleNote').on('mouseleave','.divOut',function(e){
	// e.preventDefault();
	// GestionHover(-1,5);
// });

// Tableau de memorisation des notes pour chaque liste
var ArrListeEtoile = new Object();
document.getElementsByTagName('body')[0].onload = getNote($('#itemCode').val());

function GestionHover(code,indice, nbEtoile){
	for (i=1; i<= nbEtoile; i++)
	{
		var idoff = "staroff-" + i;
		var idon = "staron-" + i;
		
		if(indice == -1)
		{
			// Sortie du survol de la liste des etoiles
			if (ArrListeEtoile[code] >= i){
				document.getElementById(idoff).style.display ="none";
				document.getElementById(idon).style.display ="block";
			}
			else{
				document.getElementById(idoff).style.display ="block";
				document.getElementById(idon).style.display ="none";
			}
		}
		else
		{
			// Survol de la liste des etoiles
			if(i <= indice){
				document.getElementById(idoff).style.display ="none";
				document.getElementById(idon).style.display ="block";
			}
			else{
				document.getElementById(idoff).style.display ="block";
				document.getElementById(idon).style.display ="none";
			}
		}
	}
}

// NOTE AN ITEM
	
function note(code,note,e){
	e.preventDefault();
	$.ajax({
		type	: "POST",
		url		: Routing.generate('noteItem'),
		data	: 
		{
			'itemCode' : code,
			'note' 	   : note
		},
		dataType: "json",
		success	: function(response){
			if(response['data'] == 'Success'){
				alert("Thank you for noting.");
				ArrListeEtoile[code] = note;
			}else{
				alert(response['data']);
			}
		},
		error	: function(jqXHR, textStatus, errorThrown){
			alert(textStatus, errorThrown);
		}
	});
}
	


// GET NOTE OF AN ITEM

function getNote(code){
	$.ajax({
		type	: "POST",
		url		: Routing.generate('getNoteItem'),
		data	: 
		{
			'itemCode' : code
		},
		dataType: "json",
		success	: function(response){
			ArrListeEtoile[code] = response['data'];
		},
		error	: function(jqXHR, textStatus, errorThrown){
			alert(textStatus, errorThrown);
		}
	});
}



