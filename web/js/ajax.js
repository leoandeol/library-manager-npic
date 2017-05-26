/*jshint eqnull:true */
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
				if(response['data']['msg'] == 'Success'){
					window.location = Routing.generate('bookings',{'id':response['data']['code']});
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
					row.setAttribute("class","row toSelect toSelectItem");
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
	
	// MEMBER LIST
	
	article.on('click','.checkMemberButton',function(e){
		checkAllMembers(this.value,e)
	});
	
	function checkAllMembers(page,e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('checkalluser',{'page':page}),
			datatype: "json",
			success	: function(response){
				var table = document.getElementById('table');
				while(table.firstChild){
					table.firstChild.remove();
				}
				var header = document.createElement("div");
					header.setAttribute("class","header row");
					
				var code = document.createElement("div");
				code.setAttribute("class","cell");
				code.innerHTML = "Code";
				
				var fname = document.createElement("div");
				fname.setAttribute("class","cell");
				fname.innerHTML = "First name";
				
				var lname = document.createElement("div");
				lname.setAttribute("class","cell");
				lname.innerHTML = "Last name";
				
				var activity = document.createElement("div");
				activity.setAttribute("class","cell");
				activity.innerHTML = "Activity";
				
				
				header.appendChild(code);
				header.appendChild(fname);
				header.appendChild(lname);
				header.appendChild(activity);
				table.appendChild(header);

				$.each(response['members'],function(i,member){
					// row to add
					var row = document.createElement("div");	
					row.setAttribute("class","row toSelect toSelectUser");
					row.setAttribute("id",member.code);
					// row's divs
					var code = document.createElement("div");
					code.setAttribute("class","cell");
					code.innerHTML = member.code;
					
					var fname = document.createElement("div");
					fname.setAttribute("class","cell");
					fname.innerHTML = member.first_name;
					
					var lname = document.createElement("div");
					lname.setAttribute("class","cell");
					lname.innerHTML = member.last_name;
					
					var activity = document.createElement("div");
					activity.setAttribute("class","cell");
					if(member.disable == 0){
						activity.innerHTML = "Active";
					}else{
						activity.innerHTML = "Inactive";
					}
					
					var button = document.createElement("div");
					button.setAttribute("class","cell");
					var butt = document.createElement("button");
					butt.setAttribute('value',member.code);
					butt.setAttribute('class','checkBookingButton');
					butt.innerHTML = "Check bookings";
					
					button.appendChild(butt);
					row.appendChild(code);
					row.appendChild(fname);
					row.appendChild(lname);
					row.appendChild(activity);
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
					prev.setAttribute("class","InputAddOn-item checkMemberButton");
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
					next.setAttribute("class","InputAddOn-item checkMemberButton");
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
	
	article.on('click','.checkLibButton',function(e){
		checkAllLibs(this.value,e)
	});
	
	function checkAllLibs(page,e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('checkalllib',{'page':page}),
			datatype: "json",
			success	: function(response){
				var table = document.getElementById('table');
				while(table.firstChild){
					table.firstChild.remove();
				}
				var header = document.createElement("div");
					header.setAttribute("class","header row");
					
				var code = document.createElement("div");
				code.setAttribute("class","cell");
				code.innerHTML = "Username";
				
				var fname = document.createElement("div");
				fname.setAttribute("class","cell");
				fname.innerHTML = "First name";
				
				var lname = document.createElement("div");
				lname.setAttribute("class","cell");
				lname.innerHTML = "Last name";
				
				var activity = document.createElement("div");
				activity.setAttribute("class","cell");
				activity.innerHTML = "Activity";
				
				
				header.appendChild(code);
				header.appendChild(fname);
				header.appendChild(lname);
				header.appendChild(activity);
				table.appendChild(header);

				$.each(response['libs'],function(i,lib){
					// row to add
					var row = document.createElement("div");	
					row.setAttribute("class","row toSelect toSelectUser");
					row.setAttribute("id",lib.username);
					// row's divs
					var code = document.createElement("div");
					code.setAttribute("class","cell");
					code.innerHTML = lib.username;
					
					var fname = document.createElement("div");
					fname.setAttribute("class","cell");
					fname.innerHTML = lib.first_name;
					
					var lname = document.createElement("div");
					lname.setAttribute("class","cell");
					lname.innerHTML = lib.last_name;
					
					var activity = document.createElement("div");
					activity.setAttribute("class","cell");
					if(lib.disable == 0){
						activity.innerHTML = "Active";
					}else{
						activity.innerHTML = "Inactive";
					}
					
					row.appendChild(code);
					row.appendChild(fname);
					row.appendChild(lname);
					row.appendChild(activity);
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
					prev.setAttribute("class","InputAddOn-item checklibButton");
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
					next.setAttribute("class","InputAddOn-item checklibButton");
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
	
	// CHECK LOGS
	
	article.on('click','.checkLogsButton',function(e){
		checkLogs(this.value,e)
	});
	
	function checkLogs(page,e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('checkLogs',{'page':page}),
			datatype: "json",
			success	: function(response){
				var table = document.getElementById('table');
				while(table.firstChild){
					table.firstChild.remove();
				}
				var header = document.createElement("div");
					header.setAttribute("class","header row");
					
				var code = document.createElement("div");
				code.setAttribute("class","cell");
				code.innerHTML = "Log ID";
				
				var fname = document.createElement("div");
				fname.setAttribute("class","cell");
				fname.innerHTML = "Librarian ID";
				
				var lname = document.createElement("div");
				lname.setAttribute("class","cell");
				lname.innerHTML = "Date of the action";
				
				var activity = document.createElement("div");
				activity.setAttribute("class","cell");
				activity.innerHTML = "Action";
				
				
				header.appendChild(code);
				header.appendChild(fname);
				header.appendChild(lname);
				header.appendChild(activity);
				table.appendChild(header);

				$.each(JSON.parse(response['logs']),function(i,log){
					// row to add
					var row = document.createElement("div");	
					row.setAttribute("class","row toSelect toSelectLog");
					row.setAttribute("id",log['id']);
					// row's divs
					var code = document.createElement("div");
					code.setAttribute("class","cell");
					code.innerHTML = log['id'];
					
					var fname = document.createElement("div");
					fname.setAttribute("class","cell");
					fname.innerHTML = log['lib']['username'];
					
					var lname = document.createElement("div");
					lname.setAttribute("class","cell");
					lname.innerHTML = log['logDate'].split('T')[0]	;
					
					var activity = document.createElement("div");
					activity.setAttribute("class","cell");
					activity.innerHTML = log['action'];
					
					row.appendChild(code);
					row.appendChild(fname);
					row.appendChild(lname);
					row.appendChild(activity);
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
					prev.setAttribute("class","InputAddOn-item checkLogsButton");
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
					next.setAttribute("class","InputAddOn-item checkLogsButton");
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

