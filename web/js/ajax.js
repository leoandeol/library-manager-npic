/*jshint eqnull:true */
$(document).ready(function(){
    
    function addDays(startDate,numberOfDays)
    {
	var returnDate = new Date(
	    startDate.getFullYear(),
	    startDate.getMonth(),
	    startDate.getDate()+numberOfDays,
	    startDate.getHours(),
	    startDate.getMinutes(),
	    startDate.getSeconds());
	return returnDate;
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
		    if(response['data']['res'] == 'Success'){
			alert("Password changed successfully");
			window.location = Routing.generate('logout');
		    }else{
			alert(response['data']['res']);
		    }
		},
		error	: function(jqXHR, textStatus, errorThrown){
		    alert(textStatus, errorThrown);
		}
	    });
	});
    
    // BOOK AN ITEM
	var tbody = $('tbody')[0];
	var container = $('.container');
	var ajaxButtons = $('.ajaxButtons');
    
    container.on('click','.bookingButton',function(e){
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
	
	// SET MOTD
	
	container.on('click','.toSelectMotd',function(e){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url 	: Routing.generate('setMotd',{'id':this.id}),
			dataType: "json",
			success : function(response){	
			if(response == 'Success'){
				alert('New message of the day set');
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
    
    ajaxButtons.on('click','.sortingButton',function(e){
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
		while(tbody.firstChild){
		    tbody.firstChild.remove();
		}
		$.each(response['items'],function(i,item){
		    // row to add
		    var row = document.createElement("tr");	
		    row.setAttribute("class","toSelect toSelectItem");
		    row.setAttribute("id",item.code);
		    // row's divs
		    var title = document.createElement("td");
		    title.innerHTML = item.title;
		    
		    var author = document.createElement("td");
		    author.innerHTML = item.author;
		    
		    var subject = document.createElement("td");
		    subject.innerHTML = item.subject;
		    
		    var lang_name = document.createElement("td");
		    lang_name.innerHTML = item.lang_name;
		    
		    var publication_year = document.createElement("td");
		    publication_year.innerHTML = item.publication_year;
		    
		    var bookable = document.createElement("td");
		    bookable.innerHTML = item.bookable;
		    
		    var note = document.createElement("td");
		    note.innerHTML = item.note;
		    
		    var total_unit = document.createElement("td");
		    total_unit.innerHTML = item.total_unit;
		    
		    var button = document.createElement("td");
		    var butt = document.createElement("button");
		    butt.setAttribute('value',item.code);
		    butt.setAttribute('class','bookingButton btn btn-primary');
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
		    
		    tbody.appendChild(row);
		});
		var prev = $('.previous');
		var next = $('.next');
		
		if(prev != null){
		    ajaxButtons.find('.previous').remove();
		}
		if(response['page']>1){
		    var prev = document.createElement("button");
			prev.setAttribute("class","btn btn-primary center-block sortingButton previous");
		    prev.setAttribute("value",response['page']-1);
		    prev.innerHTML = "<span class='glyphicon glyphicon-backward'></span> Previous";
			ajaxButtons.append(prev);
		}
		if(next != null){
		    ajaxButtons.find('.next').remove();
		}
		if(response['page']<response['page_max']){
		    var next = document.createElement("button");
		    next.setAttribute("class","btn btn-primary center-block sortingButton next");
		    next.setAttribute("value",parseInt(response['page'],10)+1);
		    next.innerHTML = "<span class='glyphicon glyphicon-forward'></span> Next";
			ajaxButtons.append(next);
		}
	    },
	    error	: function(jqXHR, textStatus, errorThrown){
		alert('error');
	    }
	});
    }
    
    // MEMBER LIST
    
    ajaxButtons.on('click','.checkMemberButton',function(e){
		var data = $('.checkMemberForm').serialize();
		checkAllMembers(this.value,e,data)
    });
	
	$('.checkMemberForm').submit(function(e){
		var data = $(this).serialize();
		checkAllMembers(1,e,data);
	});
    
    function checkAllMembers(page,e,datas){
	e.preventDefault();
	$.ajax({
	    type	: "POST",
		
	    url		: Routing.generate('checkalluser',{'page':page}),
		data	: datas,
	    datatype: "json",
	    success	: function(response){
		while(tbody.firstChild){
		    tbody.firstChild.remove();
		}
		$.each(response['members'],function(i,member){
		    // row to add
		    var row = document.createElement("tr");	
		    row.setAttribute("class","toSelect toSelectUser");
		    row.setAttribute("id",member.code);
		    // row's divs
		    var code = document.createElement("td");
		    code.innerHTML = member.code;
		    
		    var fname = document.createElement("td");
		    fname.innerHTML = member.first_name;
		    
		    var lname = document.createElement("td");
		    lname.innerHTML = member.last_name;
		    
		    var activity = document.createElement("td");
		    if(member.disable == 0){
			activity.innerHTML = "<span class='label label-success'>Active</span>";
		    }else{
			activity.innerHTML = "<span class='label label-warning'>Inactive</span>";
		    }
		    
		    var button = document.createElement("td");
		    var butt = document.createElement("button");
		    butt.setAttribute('value',member.code);
		    butt.setAttribute('class','checkBookingButton btn btn-primary');
		    butt.innerHTML = "Check bookings";
		    
		    button.appendChild(butt);
		    row.appendChild(code);
		    row.appendChild(fname);
		    row.appendChild(lname);
		    row.appendChild(activity);
		    row.appendChild(button);
		    tbody.appendChild(row);
		});
		var prev = $('.previous');
		var next = $('.next');
		
		if(prev != null){
		    ajaxButtons.find('.previous').remove();
		}
		if(response['page']>1){
		    var prev = document.createElement("button");
			prev.setAttribute("class","btn btn-primary center-block checkMemberButton previous");
		    prev.setAttribute("value",response['page']-1);
		    prev.innerHTML = "<span class='glyphicon glyphicon-backward'></span> Previous";
			ajaxButtons.append(prev);
		}
		if(next != null){
		    ajaxButtons.find('.next').remove();
		}
		if(response['page']<response['page_max']){
		    var next = document.createElement("button");
		    next.setAttribute("class","btn btn-primary center-block checkMemberButton next");
		    next.setAttribute("value",parseInt(response['page'],10)+1);
		    next.innerHTML = "<span class='glyphicon glyphicon-forward'></span> Next";
			ajaxButtons.append(next);
		}
	    },
	    error	: function(jqXHR, textStatus, errorThrown){
		alert('error');
	    }
	});
    }
    
    ajaxButtons.on('click','.checkLibButton',function(e){
		var data = $(this).serialize();
		checkAllLibs(this.value,e,data);
    });
	
	$('.checkLibForm').submit(function(e){
		var data = $('.checkLibForm').serialize();
		checkAllLibs(1,e,data);
	});
    
    function checkAllLibs(page,e,datas){
	e.preventDefault();
	$.ajax({
	    type	: "POST",
	    url		: Routing.generate('checkalllib',{'page':page}),
		data 	: datas,
	    datatype: "json",
	    success	: function(response){
			
		while(tbody.firstChild){
		    tbody.firstChild.remove();
		}

		$.each(response['libs'],function(i,lib){
		    // row to add
		    var row = document.createElement("tr");	
		    row.setAttribute("class","toSelect toSelectUser");
		    row.setAttribute("id",lib.username);
		    // row's divs
		    var code = document.createElement("td");
		    code.innerHTML = lib.username;
		    
		    var fname = document.createElement("td");
		    fname.innerHTML = lib.first_name;
		    
		    var lname = document.createElement("td");
		    lname.innerHTML = lib.last_name;
		    
		    var activity = document.createElement("td");
		    if(lib.disable == 0){
			activity.innerHTML = "<span class='label label-success'>Active</span>";
		    }else{
			activity.innerHTML = "<span class='label label-warning'>Inactive</span>";
			}
		    
		    row.appendChild(code);
		    row.appendChild(fname);
		    row.appendChild(lname);
		    row.appendChild(activity);
		    tbody.appendChild(row);
		});
		var prev = $('.previous');
		var next = $('.next');
		
		if(prev != null){
		    ajaxButtons.find('.previous').remove();
		}
		if(response['page']>1){
		    var prev = document.createElement("button");
			prev.setAttribute("class","btn btn-primary center-block checkLibButton previous");
		    prev.setAttribute("value",response['page']-1);
		    prev.innerHTML = "<span class='glyphicon glyphicon-backward'></span> Previous";
			ajaxButtons.append(prev);
		}
		if(next != null){
		    ajaxButtons.find('.next').remove();
		}
		if(response['page']<response['page_max']){
		    var next = document.createElement("button");
		    next.setAttribute("class","btn btn-primary center-block checkLibButton next");
		    next.setAttribute("value",parseInt(response['page'],10)+1);
		    next.innerHTML = "<span class='glyphicon glyphicon-forward'></span> Next";
			ajaxButtons.append(next);
		}
	    },
	    error	: function(jqXHR, textStatus, errorThrown){
		alert('error');
	    }
	});
    }
    
    // CHECK LOGS
    
    $('.logsForm').submit(function(e){
	var data = $(this).serialize();
	checkLogs(1,e,data);
    });
    
    ajaxButtons.on('click','.checkLogsButton',function(e){
	var data = $('.logsForm').serialize();
	checkLogs(this.value,e,data);
    });	
    
    function checkLogs(page,e,datas){
	e.preventDefault();
	$.ajax({
	    type	: "POST",
	    url		: Routing.generate('checkLogs',{'page':page}),
		data	: datas,
	    datatype: "json",
	    success	: function(response){
		var table = document.getElementById('table');
		
		while(tbody.firstChild){
		    tbody.firstChild.remove();
		}
		
		$.each(JSON.parse(response['logs']),function(i,log){
		    // row to add
		    var row = document.createElement("tr");	
		    row.setAttribute("class","toSelect toSelectLog");
		    row.setAttribute("id",log['id']);
		    // row's divs
		    var code = document.createElement("td");
		    code.innerHTML = log['id'];
		    
		    var fname = document.createElement("td");
		    if(!("librarian_username" in log)){
			fname.innerHTML = log['member_code'];
		    }else{
			fname.innerHTML = log['librarian_username'];
		    }
		    var lname = document.createElement("td");
		    lname.innerHTML = log['log_date'];
		    
		    var activity = document.createElement("td");
		    activity.innerHTML = log['action'];
		    
		    row.appendChild(code);
		    row.appendChild(fname);
		    row.appendChild(lname);
		    row.appendChild(activity);
		    tbody.appendChild(row);
		});
		var prev = $('.previous');
		var next = $('.next');
		
		if(prev != null){
		    ajaxButtons.find('.previous').remove();
		}
		if(response['page']>1){
		    var prev = document.createElement("button");
			prev.setAttribute("class","btn btn-primary center-block checkLibButton previous");
		    prev.setAttribute("value",response['page']-1);
		    prev.innerHTML = "<span class='glyphicon glyphicon-backward'></span> Previous";
			ajaxButtons.append(prev);
		}
		if(next != null){
		    ajaxButtons.find('.next').remove();
		}
		if(response['page']<response['page_max']){
		    var next = document.createElement("button");
		    next.setAttribute("class","btn btn-primary center-block checkLibButton next");
		    next.setAttribute("value",parseInt(response['page'],10)+1);
		    next.innerHTML = "<span class='glyphicon glyphicon-forward'></span> Next";
			ajaxButtons.append(next);
		}
	    },
	    error	: function(jqXHR, textStatus, errorThrown){
		alert('error');
	    }
	});
    }
    
    // CHECK BOOKINGS
    
    $('.bookingsForm').submit(function(e){
	var data = $(this).serialize();
	checkBookings(1,e,data);
    });
    
    ajaxButtons.on('click','.checkBookingsButton',function(e){
	var data = $('.bookingsForm').serialize();
	checkBookings(this.value,e,data);
    });	
    
    function checkBookings(page,e,datas){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('checkBookings',{'page':page}),
			data	: datas,
			datatype: "json",
			success	: function(response){
			
				while(tbody.firstChild){
					tbody.firstChild.remove();
				}
				
				$.each(JSON.parse(response['trans']),function(i,tr){
					// row to add
					var row = document.createElement("tr");	
					row.setAttribute("class","toSelect toSelectTrans");
					row.setAttribute("id",tr.id);
					// row's divs
					var code = document.createElement("td");
					code.innerHTML = tr.id;
					
					var fname = document.createElement("td");
					fname.innerHTML = tr.member.code;

					var lname = document.createElement("td");
					lname.innerHTML = tr.item.title;
					
					var bdate = document.createElement("td");
					sBDate = tr.bookedDate.split('T')[0];
					ssBDate = sBDate.split('-');
					okBDate = ssBDate[2]+'-'+ssBDate[1]+'-'+ssBDate[0];
					bdate.innerHTML = okBDate;

					var rdate = document.createElement("td");
					if(tr.borrowDate == null){
						okRDate = 'Not borrowed yet';
					}else{
						sRDate = tr.borrowDate.split('T')[0];
						ssRDate = sRDate.split('-');
						okRDate = ssRDate[2]+'-'+ssRDate[1]+'-'+ssRDate[0];
					}
					rdate.innerHTML = okRDate;
					
					var activity = document.createElement("td");
					activity.innerHTML = tr.state;
					
					row.appendChild(code);
					row.appendChild(fname);
					row.appendChild(lname);
					row.appendChild(bdate);
					row.appendChild(rdate);
					row.appendChild(activity);
					tbody.appendChild(row);
				});
				var prev = $('.previous');
				var next = $('.next');
				
				if(prev != null){
					ajaxButtons.find('.previous').remove();
				}
				if(response['page']>1){
					var prev = document.createElement("button");
					prev.setAttribute("class","btn btn-primary center-block checkLibButton previous");
					prev.setAttribute("value",response['page']-1);
					prev.innerHTML = "<span class='glyphicon glyphicon-backward'></span> Previous";
					ajaxButtons.append(prev);
				}
				if(next != null){
					ajaxButtons.find('.next').remove();
				}
				if(response['page']<response['page_max']){
					var next = document.createElement("button");
					next.setAttribute("class","btn btn-primary center-block checkLibButton next");
					next.setAttribute("value",parseInt(response['page'],10)+1);
					next.innerHTML = "<span class='glyphicon glyphicon-forward'></span> Next";
					ajaxButtons.append(next);
				}
			},
			error	: function(jqXHR, textStatus, errorThrown){
			alert('error');
			}
		});
    }
	
	// PERSONNAL MEMBER'S BOOKINGS
	
	
    $('.MemberBookingsForm').submit(function(e){
	var data = $(this).serialize();
	checkMemberBookings(1,$(this)[0][0].value,e,data);
    });
    
    ajaxButtons.on('click','.checkMemberBookingsButton',function(e){
	var data = $('.MemberBookingsForm').serialize();
	checkMemberBookings(this.value,$('.MemberBookingsForm')[0][0].value,e,data);
    });	
    
    function checkMemberBookings(page,member_code,e,datas){
		e.preventDefault();
		$.ajax({
			type	: "POST",
			url		: Routing.generate('bookings',{'id':member_code,'page':page}),
			data	: datas,
			datatype: "json",
			success	: function(response){
				while(tbody.firstChild){
					tbody.firstChild.remove();
				}
				
				$.each(JSON.parse(response['bookings']),function(i,tr){
					// row to add
					var row = document.createElement("tr");	
					row.setAttribute("class","toSelect toSelectTrans");
					row.setAttribute("id",tr.id);
					// row's divs
					var mem_code = document.createElement("option");
					mem_code.setAttribute("id","memberCodeTransaction");
					mem_code.setAttribute("value",response['member_code']);
					
					var code = document.createElement("td");
					code.innerHTML = tr.id;

					var lname = document.createElement("td");
					lname.innerHTML = tr.item.title;
					
					var bdate = document.createElement("td");
					sBDate = tr.bookedDate.split('T')[0];
					ssBDate = sBDate.split('-');
					okBDate = ssBDate[2]+'-'+ssBDate[1]+'-'+ssBDate[0];
					bdate.innerHTML = okBDate;

					var rdate = document.createElement("td");
					if(tr.borrowDate == null){
						okRDate = 'Not borrowed yet';
					}else{
						sRDate = tr.borrowDate.split('T')[0];
						ssRDate = sRDate.split('-');
						okRDate = ssRDate[2]+'-'+ssRDate[1]+'-'+ssRDate[0];
					}
					rdate.innerHTML = okRDate;
					
					var activity = document.createElement("td");
					activity.innerHTML = tr.state;
					
					row.appendChild(mem_code);
					row.appendChild(code);
					row.appendChild(lname);
					row.appendChild(bdate);
					row.appendChild(rdate);
					row.appendChild(activity);
					tbody.appendChild(row);
				});
				var prev = $('.previous');
				var next = $('.next');
				
				if(prev != null){
					ajaxButtons.find('.previous').remove();
				}
				if(response['page']>1){
					var prev = document.createElement("button");
					prev.setAttribute("class","btn btn-primary center-block checkLibButton previous");
					prev.setAttribute("value",response['page']-1);
					prev.innerHTML = "<span class='glyphicon glyphicon-backward'></span> Previous";
					ajaxButtons.append(prev);
				}
				if(next != null){
					ajaxButtons.find('.next').remove();
				}
				if(response['page']<response['page_max']){
					var next = document.createElement("button");
					next.setAttribute("class","btn btn-primary center-block checkLibButton next");
					next.setAttribute("value",parseInt(response['page'],10)+1);
					next.innerHTML = "<span class='glyphicon glyphicon-forward'></span> Next";
					ajaxButtons.append(next);
				}
			},
			error	: function(jqXHR, textStatus, errorThrown){
			alert('error');
			}
		});
    }
});
