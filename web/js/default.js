function testMail(input){
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	var button = document.getElementsByClassName("InputAddOn submit-login")[0].childNodes[1];
		
	if(reg.test(input.value)){
		input.style.borderColor="green";
		button.disabled = false;
		button.style.borderColor="green";
	}else{
		input.style.borderColor="red";
		button.disabled = true;
		button.style.borderColor="red";
	}
}

function testTel(input){
	var reg = new RegExp('(855)?[0-9]{8}');
	var button = document.getElementsByClassName("InputAddOn submit-login")[0].childNodes[1];
	
	if(reg.test(input.value)){
		input.style.borderColor="green";
		button.disabled = false;
		button.style.borderColor="green";
	}else{
		input.style.borderColor="red";
		button.disabled = true;
		button.style.borderColor="red";
	}
}