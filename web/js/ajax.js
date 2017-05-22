$(document).ready(function(){
	// CONNEXION
	$("#loginForm").submit(function(e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('loggedin'),
			data	: $(this).serialize(),
			dataType: "json",
			success	: function(response) {
				if(response['data'] == 'Success'){
					alert("Connexion réussie");
					window.location = Routing.generate('home');
				}else{
					alert(response['data']);
				}
			},
			error	: function(jqXHR, textStatus, errorThrown){
				alert(textStatus, errorThrown);
			}
		});
	});
	
	// SORTING ITEMS
	$('#sortForm').submit(function(e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('itemlist'),
			data	: $(this).serialize(),
			datatype: "json",
			success	: function(response){
				var table = document.getElementById('table');
				while(table.firstChild){
					table.firstChild.remove();
				}
				var header = document.createElement("div");
					header.setAttribute("class","header row");
					
				var title = document.createElement("div");
					title.setAttribute("class","cell");
					title.innerHTML = "Title";
					
					var author = document.createElement("div");
					author.setAttribute("class","cell");
					author.innerHTML = "Author";
					
					var subject = document.createElement("div");
					subject.setAttribute("class","cell");
					subject.innerHTML = "Subject";
					
					var lang_name = document.createElement("div");
					lang_name.setAttribute("class","cell");
					lang_name.innerHTML = "Language";
					
					var publication_year = document.createElement("div");
					publication_year.setAttribute("class","cell");
					publication_year.innerHTML = "Year";
					
					var bookable = document.createElement("div");
					bookable.setAttribute("class","cell");
					bookable.innerHTML = "Availability";
					
					var note = document.createElement("div");
					note.setAttribute("class","cell");
					note.innerHTML = "Note";
					
					var total_unit = document.createElement("div");
					total_unit.setAttribute("class","cell");
					total_unit.innerHTML = "Total units";
					
					header.append(title);
					header.append(author);
					header.append(subject);
					header.append(lang_name);
					header.append(publication_year);
					header.append(bookable);
					header.append(note);
					header.append(total_unit);
					
					table.append(header);
				$.each(response['items'],function(i,item){
					// row to add
					var row = document.createElement("div");	
					row.setAttribute("class","row");
					row.setAttribute("id",item.code);
					// row's divs
					var title = document.createElement("div");
					title.setAttribute("class","cell");
					title.innerHTML = item.title;
					
					var author = document.createElement("div");
					author.setAttribute("class","cell");
					author.innerHTML = item.author;
					
					var subject = document.createElement("div");
					subject.setAttribute("class","cell");
					subject.innerHTML = item.subject;
					
					var lang_name = document.createElement("div");
					lang_name.setAttribute("class","cell");
					lang_name.innerHTML = item.lang_name;
					
					var publication_year = document.createElement("div");
					publication_year.setAttribute("class","cell");
					publication_year.innerHTML = item.publication_year;
					
					var bookable = document.createElement("div");
					bookable.setAttribute("class","cell");
					bookable.innerHTML = item.bookable;
					
					var note = document.createElement("div");
					note.setAttribute("class","cell");
					note.innerHTML = item.note;
					
					var total_unit = document.createElement("div");
					total_unit.setAttribute("class","cell");
					total_unit.innerHTML = item.total_unit;
					
					var button = document.createElement("div");
					button.setAttribute("class","cell");
					var link = document.createElement("a");
					link.href = "/item/book/"+item.code;
					link.innerHTML = "<button>Book</button>";
					
					button.append(link);
					row.append(title);
					row.append(author);
					row.append(subject);
					row.append(lang_name);
					row.append(publication_year);
					row.append(bookable);
					row.append(note);
					row.append(total_unit);
					row.append(button);
					
					table.append(row);
				});
			},
			error	: function(jqXHR, textStatus, errorThrown){
				alert('error');
			}
		});
	});
});

