$(document).ready(function(){
	$('.container').on('click','.deleteMotdButton',function(e){
		e.stopPropagation();
	});
	
	$('.table').on('mouseenter','.toSelect',function(e){
		e.stopPropagation()
		e.preventDefault();
		$(this).css("backgroundColor","#5D95AC");
	});
	
	$('.table').on('mouseleave','.toSelect',function(e){
		e.stopPropagation()
		e.preventDefault();
		$(this).css("backgroundColor","");
	});
	
	$('.table').on('click','.toSelectItem',function(e){
		e.stopPropagation()
		window.location=Routing.generate('readitem', {'id': this.id});
	});
	
	$('.table').on('click','.toSelectUser',function(e){
		e.stopPropagation()
		window.location=Routing.generate('account', {'code': this.id});
	});
	
	$('.table').on('click','.toSelectTrans',function(e){
		e.stopPropagation()
		window.location=Routing.generate('bookingDetail', {'id': this.id, 'code':$('#memberCodeTransaction').val()});
	});	
	
	$('.table').on('click','.checkBookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		window.location = Routing.generate("bookings", {'id':this.value});
	});
	
	$('.table').on('mouseenter','.checkBookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		$(this).css('backgroundColor','green');
	});
	
	$('.table').on('mouseleave','.checkBookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		$(this).css('backgroundColor','');
	});
	
	$('.table').on('mouseenter','.bookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		$(this).css('backgroundColor','green');
	});
	
	$('.table').on('mouseleave','.bookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		$(this).css('backgroundColor','');
	});
});