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
});