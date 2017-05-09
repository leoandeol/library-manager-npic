//**************** TEST DE FORMULAIRE ****************//

function surligne(field,error){
	if(error){
		champ.style.backgroundColor="#fba";
	}else{
		champ.style.backgroundColor="";		
	}
}

// Dates function

var daySelect = document.getElementById("day");
var monthSelect = document.getElementById("month");
var yearSelect = document.getElementById("year");

populateYears();
populateDays(monthSelect.value);

function populateDays(month){
	while(daySelect.firstChild){
		daySelect.removeChild(daySelect.firstChild);
	}
	var dayNum;
	 // 31 or 30 days?
	if(month === '01' | month === '03' | month === '05' | month === '07' | month === '08' | month === '10' | month === '12') {
		dayNum = 31;
	} else if(month === '04' | month === '06' | month === '09' | month === '11') {
		dayNum = 30;
	} else {
		// If month is February, calculate whether it is a leap year or not
		var year = yearSelect.value;
		(year - 2016) % 4 === 0 ? dayNum = 29 : dayNum = 28;
	}
	// inject the right number of new <option> elements into the day <select>
	for(i = 1; i <= dayNum; i++) {
		var option = document.createElement('option');
		option.textContent = i;
		daySelect.appendChild(option);
	}
	
	// if previous day has already been set, set daySelect's value
	// to that day, to avoid the day jumping back to 1 when you
	// change the year
	if(previousDay) {
		daySelect.value = previousDay;

		// If the previous day was set to a high number, say 31, and then
		// you chose a month with less total days in it (e.g. February),
		// this part of the code ensures that the highest day available
		// is selected, rather than showing a blank daySelect
		if(daySelect.value === "") {
		  daySelect.value = previousDay - 1;
		}

		if(daySelect.value === "") {
		  daySelect.value = previousDay - 2;
		}

		if(daySelect.value === "") {
		  daySelect.value = previousDay - 3;
		}
	}
}

function populateYears() {
  // get this year as a number
  var date = new Date();
  var year = date.getFullYear();

  // Make this year, and the 100 years before it available in the year <select>
  for(var i = 0; i <= 100; i++) {
    var option = document.createElement('option');
    option.textContent = year-i;
    yearSelect.appendChild(option);
  }
}

yearSelect.onchange = function() {
  populateDays(monthSelect.value);
}

monthSelect.onchange = function() {
  populateDays(monthSelect.value);
}

//preserve day selection
var previousDay;

// update what day has been set to previously
// see end of populateDays() for usage
daySelect.onchange = function() {
  previousDay = daySelect.value;
}

// EndOf Date functions

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

function testTel(input){
	var reg = new RegExp('(855)?[0-9]{8}');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}

function testName(input){
	var reg = new RegExp('[a-zA-Z]{2,25}');
	
	if(reg.test(input.value)){
		surligne(input,false);
		return true;
	}else{
		surligne(input,true);
		return false;
	}
}


//**************** FIN TEST FORMULAIRE ****************//