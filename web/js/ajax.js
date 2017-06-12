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
			window.location = Routing.generate('account',{'code':response['data']['id']});
		    }else{
			alert(response['data']['res']);
		    }
		},
		error	: function(jqXHR, textStatus, errorThrown){
		    alert(textStatus, errorThrown);
		}
	    });
	});
    });
    
    // BOOK AN ITEM
    var article = $("article");
    var table = $('.table');
	var tbody = $('tbody')[0];
	var container = $('.container');
	var ulpager = $('ul.pager');
    
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
    
    ulpager.on('click','.sortingButton',function(e){
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
		    ulpager.find('.previous').remove();
		}
		if(response['page']>1){
		    var prev = document.createElement("button");
			prev.setAttribute("class","sortingButton");
		    prev.setAttribute("value",response['page']-1);
		    prev.innerHTML = "Previous";
			var span = document.createElement("span");
			span.setAttribute("class","glyphicon glyphicon-backward");
			
		    prev.append(span);
			
			var li = document.createElement("li");
			li.setAttribute("class","previous");
			
			li.append(prev);
			ulpager.append(li);
		}
		if(next != null){
		    ulpager.find('.next').remove();
		}
		if(response['page']<response['page_max']){
		    var next = document.createElement("button");
		    next.setAttribute("class","sortingButton");
		    next.setAttribute("value",parseInt(response['page'],10)+1);
		    next.innerHTML = "Next";
			var span = document.createElement("span");
			span.setAttribute("class","glyphicon glyphicon-forward");
			
		    next.append(span);
			
			var li = document.createElement("li");
			li.setAttribute("class","next");
			
			li.append(next);
			ulpager.append(li);
		}
	    },
	    error	: function(jqXHR, textStatus, errorThrown){
		alert('error');
	    }
	});
    }
    
    // MEMBER LIST
    
    ulpager.on('click','.checkMemberButton',function(e){
	checkAllMembers(this.value,e)
    });
    
    function checkAllMembers(page,e){
	e.preventDefault();
	$.ajax({
	    type	: "POST",
		
	    url		: Routing.generate('checkalluser',{'page':page}),
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
			activity.innerHTML = "Active";
		    }else{
			activity.innerHTML = "Inactive";
		    }
		    
		    var button = document.createElement("td");
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
		var prev = document.getElementById('prev');
		var next = document.getElementById('next');
		
		if(prev != null){
		    ulpager.find('.previous').remove();
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
		    prev.setAttribute("class","InputAddOn-item checkLibButton");
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
		    next.setAttribute("class","InputAddOn-item checkLibButton");
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
    
    $('.logsForm').submit(function(e){
	var data = $(this).serialize();
	checkLogs(1,e,data);
    });
    
    article.on('click','.checkLogsButton',function(e){
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
		fname.innerHTML = "User ID";
		
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
		    if(!("librarian_username" in log)){
			fname.innerHTML = log['member_code'];
		    }else{
			fname.innerHTML = log['librarian_username'];
		    }
		    var lname = document.createElement("div");
		    lname.setAttribute("class","cell");
		    lname.innerHTML = log['log_date'];
		    
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
    
    // CHECK BOOKINGS
    
    $('.bookingsForm').submit(function(e){
	var data = $(this).serialize();
	checkBookings(1,e,data);
    });
    
    article.on('click','.checkBookingsButton',function(e){
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
		var table = document.getElementById('table');
		while(table.firstChild){
		    table.firstChild.remove();
		}
		var header = document.createElement("div");
		header.setAttribute("class","header row");
		
		var code = document.createElement("div");
		code.setAttribute("class","cell");
		code.innerHTML = "Transaction ID";
		
		var fname = document.createElement("div");
		fname.setAttribute("class","cell");
		fname.innerHTML = "Member code";
		
		var lname = document.createElement("div");
		lname.setAttribute("class","cell");
		lname.innerHTML = "Item title";
		
		var bdate = document.createElement("div");
		bdate.setAttribute("class","cell");
		bdate.innerHTML = "Booked date";
		
		var rdate = document.createElement("div");
		rdate.setAttribute("class","cell");
		rdate.innerHTML = "Borrow date";
		
		var activity = document.createElement("div");
		activity.setAttribute("class","cell");
		activity.innerHTML = "State";
		
		
		header.appendChild(code);
		header.appendChild(fname);
		header.appendChild(lname);
		header.appendChild(bdate);
		header.appendChild(rdate);
		header.appendChild(activity);
		table.appendChild(header);
		
		$.each(JSON.parse(response['trans']),function(i,tr){
		    // row to add
		    var row = document.createElement("div");	
		    row.setAttribute("class","row toSelect toSelectTrans");
		    row.setAttribute("id",tr.id);
		    // row's divs
		    var code = document.createElement("div");
		    code.setAttribute("class","cell");
		    code.innerHTML = tr.id;
		    
		    var fname = document.createElement("div");
		    fname.setAttribute("class","cell");
		    fname.innerHTML = tr.member.code;

		    var lname = document.createElement("div");
		    lname.setAttribute("class","cell");
		    lname.innerHTML = tr.item.title;
		    
		    var bdate = document.createElement("div");
		    bdate.setAttribute("class","cell");
			sBDate = tr.bookedDate.split('T')[0];
			ssBDate = sBDate.split('-');
			okBDate = ssBDate[2]+'-'+ssBDate[1]+'-'+ssBDate[0];
		    bdate.innerHTML = okBDate;

		    var rdate = document.createElement("div");
		    rdate.setAttribute("class","cell");
			if(tr.borrowDate == null){
				okRDate = 'Not borrowed yet';
			}else{
				sRDate = tr.borrowDate.split('T')[0];
				ssRDate = sRDate.split('-');
				okRDate = ssRDate[2]+'-'+ssRDate[1]+'-'+ssRDate[0];
			}
		    rdate.innerHTML = okRDate;
		    
		    var activity = document.createElement("div");
		    activity.setAttribute("class","cell");
		    activity.innerHTML = tr.state;
		    
		    row.appendChild(code);
		    row.appendChild(fname);
		    row.appendChild(lname);
		    row.appendChild(bdate);
		    row.appendChild(rdate);
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
		    prev.setAttribute("class","InputAddOn-item checkBookingsButton");
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
		    next.setAttribute("class","InputAddOn-item checkBookingsButton");
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
	
	// PERSONNAL MEMBER'S BOOKINGS
	
	
    $('.MemberBookingsForm').submit(function(e){
	var data = $(this).serialize();
	checkMemberBookings(1,$(this)[0][0].value,e,data);
    });
    
    article.on('click','.checkMemberBookingsButton',function(e){
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
		console.log(response);
		var table = document.getElementById('table');
		while(table.firstChild){
		    table.firstChild.remove();
		}
		var header = document.createElement("div");
		header.setAttribute("class","header row");
		
		var code = document.createElement("div");
		code.setAttribute("class","cell");
		code.innerHTML = "Transaction ID";
		
		var lname = document.createElement("div");
		lname.setAttribute("class","cell");
		lname.innerHTML = "Item title";
		
		var bdate = document.createElement("div");
		bdate.setAttribute("class","cell");
		bdate.innerHTML = "Booked date";
		
		var rdate = document.createElement("div");
		rdate.setAttribute("class","cell");
		rdate.innerHTML = "Borrow date";
		
		var activity = document.createElement("div");
		activity.setAttribute("class","cell");
		activity.innerHTML = "State";
		
		
		header.appendChild(code);
		header.appendChild(lname);
		header.appendChild(bdate);
		header.appendChild(rdate);
		header.appendChild(activity);
		table.appendChild(header);
		
		$.each(JSON.parse(response['bookings']),function(i,tr){
		    // row to add
		    var row = document.createElement("div");	
		    row.setAttribute("class","row toSelect toSelectTrans");
		    row.setAttribute("id",tr.id);
		    // row's divs
			var mem_code = document.createElement("option");
			mem_code.setAttribute("id","memberCodeTransaction");
			mem_code.setAttribute("value",response['member_code']);
			
		    var code = document.createElement("div");
		    code.setAttribute("class","cell");
		    code.innerHTML = tr.id;

		    var lname = document.createElement("div");
		    lname.setAttribute("class","cell");
		    lname.innerHTML = tr.item.title;
		    
		    var bdate = document.createElement("div");
		    bdate.setAttribute("class","cell");
			sBDate = tr.bookedDate.split('T')[0];
			ssBDate = sBDate.split('-');
			okBDate = ssBDate[2]+'-'+ssBDate[1]+'-'+ssBDate[0];
		    bdate.innerHTML = okBDate;

		    var rdate = document.createElement("div");
		    rdate.setAttribute("class","cell");
			if(tr.borrowDate == null){
				okRDate = 'Not borrowed yet';
			}else{
				sRDate = tr.borrowDate.split('T')[0];
				ssRDate = sRDate.split('-');
				okRDate = ssRDate[2]+'-'+ssRDate[1]+'-'+ssRDate[0];
			}
		    rdate.innerHTML = okRDate;
		    
		    var activity = document.createElement("div");
		    activity.setAttribute("class","cell");
		    activity.innerHTML = tr.state;
		    
		    row.appendChild(mem_code);
		    row.appendChild(code);
		    row.appendChild(lname);
		    row.appendChild(bdate);
		    row.appendChild(rdate);
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
		    prev.setAttribute("class","InputAddOn-item checkMemberBookingsButton");
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
		    next.setAttribute("class","InputAddOn-item checkMemberBookingsButton");
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

