$(document).ready(function(){
	$('.table').on('mouseenter','.toSelect',function(e){
		$(this).css("backgroundColor","#5D95AC");
	});
	
	$('.table').on('mouseleave','.toSelect',function(e){
		$(this).css("backgroundColor","");
	});
	
	$('.table').on('click','.toSelectItem',function(){
		window.location=Routing.generate('readitem', {'id': this.id});
	});
	
	$('.table').on('click','.toSelectUser',function(){
		window.location=Routing.generate('general_infos', {'id': this.id});
	});
	
	$('.table').on('click','.toSelectTrans',function(){
		window.location=Routing.generate('bookingDetail', {'id': this.id, 'code':$('#memberCodeTransaction').val()});
	});
	
	$('.table').on('click','.checkBookingButton',function(e){
		e.stopPropagation()
		e.preventDefault();
		window.location = Routing.generate("bookings", {'id':this.value});
	});
});