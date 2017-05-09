//**************** TEST DE FORMULAIRE ****************//

function surligne(field,error){
	if(error){
		field.style.borderColor="red";
	}else{
		field.style.borderColor="";		
	}
}

function testMail(input){
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
		
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testCode(input){
	var reg = new RegExp('^[0-9]{10}$');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testTel(input){
	var reg = new RegExp('^(855)?[0-9]{8}$');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testStudentYear(input){
	var reg = new RegExp('^[1-2-3-4-5]{1}$');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testName(input){
	var reg = new RegExp('^[a-zA-Z][a-zA-Z]{0,23}[a-zA-Z]$');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testNationalID(input){
	var reg = new RegExp('^[0-9]+$');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testPostCode(input){
	var reg = new RegExp('[0-9]{5}');

	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testCity(input){
	var reg = new RegExp("^[a-zA-Z]([a-zA-Z]*[-.' ]?[a-zA-Z]+)*[a-zA-Z]$");
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function checkForm(form){
	
	var fNameOk = testName(form.fname);
	var lNameOk = testName(form.lname);
	var codeOk = testCode(form.code);
	var nationalIdOk = testNationalID(form.nid);
	var cityOk = testCity(form.city);
	var hPhoneOk = testTel(form.home_phone);
	var rPhoneOk = testTel(form.ref_phone);
	var mPhoneOk = testTel(form.mob_phone);
	var pCodeOk = testPostCode(form.pcode);
	var StreetOk = testCity(form.street);
	var emailOk = testMail(form.email);
	
	if(fNameOk && lNameOk && codeOk && nationalIdOk && cityOk && hPhoneOk &&
	rPhoneOk && mPhoneOk && pCodeOk && StreetOk && emailOk){
		return true;
	}else{
		alert("Please fill in all fields correctly");
		return false;
	}
}
//**************** FIN TEST FORMULAIRE ****************//