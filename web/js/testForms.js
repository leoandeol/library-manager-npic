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
    var reg = new RegExp('^NPIC-[0-9]{4}$');
    
    if(reg.test(input.value)){
	surligne(input,false);
	return true;
    }else{
	surligne(input,true);
	return false;
    }
}

function testCodeItem(input){
    var reg = new RegExp('^[0-9]{6}$');
    
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

function testTitle(input){
    var reg = new RegExp('^[a-zA-Z]+$');
    return true;
}

function testStudentYear(input){
    var reg = new RegExp('^[1-2-3-4-5]{1}$');
    return true;
    if(reg.test(input.value)){
	surligne(input,false);
	return true;
    }else{
	surligne(input,true);
	return false;
    }
}

function testName(input){
    var reg = new RegExp('^[a-zA-Z]{2,25}$');
    return true;
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

function testPubYear(input){
    var reg = new RegExp('^[0-9]{0-4}$');
    return true;
}

function testPostCode(input){
    var reg = new RegExp('^[0-9]{5}$');

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
    return true;
}

function testPrice(input){
    
    if(input.value > 0 ){
	surligne(input,false);
	return true;
    }else{
	surligne(input,true);
	return false;
    }
}

function checkFormItem(form){
    
    var codeOk = testCodeItem(form.code);
    var titleOk = testCity(form.title);
    var stitleOk = testCity(form.short_title);
    var authorOk = testName(form.author);
    var pubYearOk = testPubYear(form.publication_year);
    var publiOk = testName(form.publisher);
    var priceOk = testPrice(form.price);
    
    if(codeOk && titleOk && stitleOk && authorOk && pubYearOk && publiOk && priceOk){
	return true;
    }else{
	alert("Please fill in all fields correctly");
	return false;
    }
}

function checkForm(form){
    
    var fNameOk = testName(form.fname);
    var lNameOk = testName(form.lname);
    var codeOk = testCode(form.code);
    var nationalIdOk = testNationalID(form.nid);
    var cityOk = testCity(form.city);
    var pCodeOk = testPostCode(form.pcode);
    var emailOk = testMail(form.email);
    
    if(fNameOk && lNameOk && codeOk && nationalIdOk && cityOk && pCodeOk && emailOk){
	return true;
    }else{
	alert("Please fill in all fields correctly");
	return false;
    }
}
//**************** FIN TEST FORMULAIRE ****************//
