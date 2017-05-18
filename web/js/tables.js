$("div[class^='row'").hover(function(){
		$(this).css("backgroundColor","#5D95AC");
	}, function(){
		$(this).css("backgroundColor","");
	}
);

$("div[class^='row'").click(function(){
	window.location=Routing.generate('readitem', {'id': this.id});
});