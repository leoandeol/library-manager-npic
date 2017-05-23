/*jshint eqnull:true */
$(document).ready(function(){
	
	function tableFunction(){
		$("div[class^='row'").hover(function(){
			$(this).css("backgroundColor","#5D95AC");
		}, function(){
			$(this).css("backgroundColor","");
		});
		$("div[class^='row'").click(function(){
			window.location=Routing.generate('readitem', {'id': this.id});
		});
	}

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
					alert("Connected");
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
	
	// CHANGE PASS
	$("#changePassForm").submit(function(e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url 	: Routing.generate('changedpass'),
			data 	: $(this).serialize(),
			dataType: "json",
			success	: function(response){
				if(response['data'] == 'Success'){
					alert("Password changed successfully");
					window.location = Routing.generate('account');
				}else{
					alert(response['data']);
				}
			},
			error	: function(jqXHR, textStatus, errorThrown){
				alert(textStatus, errorThrown);
			}
		});
	});
	
	// BOOK AN ITEM
	var article = $("article");
	var table = $('.table');
	
	table.on('click','.bookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url 	: Routing.generate('bookitem',{'id':this.value}),
			dataType: "json",
			success : function(response){
				if(response['data'] == 'Success'){
					window.location = Routing.generate('bookings');
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
	
	$('.sortingForm').submit(function(e){
		var data = $(this).serialize();
		sortItems(1,e,data);
	});
	
	article.on('click','.sortingButton',function(e){
		var data = $('.sortingForm').serialize();
		sortItems(this.value,e,data);
	});	
	
	function sortItems(page,e,datas){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('itemlist',{'page':page}),
			data	: datas,
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
				subject.innerHTML = "Category";
				
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
				
				header.appendChild(title);
				header.appendChild(author);
				header.appendChild(subject);
				header.appendChild(lang_name);
				header.appendChild(publication_year);
				header.appendChild(bookable);
				header.appendChild(note);
				header.appendChild(total_unit);
				
				table.appendChild(header);
				$.each(response['items'],function(i,item){
					// row to add
					var row = document.createElement("div");	
					row.setAttribute("class","row toSelect");
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
					var butt = document.createElement("button");
					butt.setAttribute('value',item.code);
					butt.setAttribute('class','bookingButton');
					butt.innerHTML = "Book";
					
					button.appendChild(butt);
					row.appendChild(title);
					row.appendChild(author);
					row.appendChild(subject);
					row.appendChild(lang_name);
					row.appendChild(publication_year);
					row.appendChild(bookable);
					row.appendChild(note);
					row.appendChild(total_unit);
					row.appendChild(button);
					
					table.appendChild(row);
				});
				var article = $("article");
				var prev = document.getElementById('prev');
				var next = document.getElementById('next');
				
				if(prev != null){
						article.find('#prev')[0].remove();
				}
				if(response['page']>1){
					var prev = document.createElement("button");
					prev.setAttribute("class","InputAddOn-item sortingButton");
					prev.setAttribute("id","prev");
					prev.setAttribute("value",response['page']-1);
					prev.innerHTML = "Previous";
					article.append(prev);
				}
				if(next != null){
					article.find('#next')[0].remove();
				}
				if(response['page']<response['page_max']){
					var next = document.createElement("button");
					next.setAttribute("class","InputAddOn-item sortingButton");
					next.setAttribute("id","next");
					next.setAttribute("value",parseInt(response['page'],10)+1);
					next.innerHTML = "Next";
					article.append(next);
				}
			},
			error	: function(jqXHR, textStatus, errorThrown){
				alert('error');
			}
		});
	}
});

