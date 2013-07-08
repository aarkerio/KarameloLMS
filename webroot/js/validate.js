// Validate.js
/*
* Generic JavaScript validator 1.0  
* Author: Vikas Bhagwagar. (B.E. Computer/NIT-Surat). Version 1.0
  Date: Aug 28, 2006
*/
var numberOfForms;
var numberOfElemOfForm = new Array();
var errorMsgArray = new Array();
var field;
var fieldName;
var prevFieldName;
var prevFieldType;
var fieldValue;
var fieldAttrib;
var fieldRequired;
var fieldType;
var fieldIndex;
var contCheckBoxLoop=true;
var checkBoxStack = new Array();
var checkBoxValueStack = new Array();
var checkBoxPropertyStack = new Array();


var checkBoxCounter = 0;
var radioStack = new Array();
var radioValueStack = new Array();
var radioPropertyStack = new Array();

var radioMsgStack = new Array();
var checkboxMsgStack = new Array();

var radioCounter = 0;
var checkboxTakeAction = 0;
var radioTakeAction = 0;
var userFunctionStack = new Array();
var userFunctionNameStack = new Array();

// Initialize the script.

window.onload = getFormDetails;

function register(functionName)
{
	try{
	userFunctionStack.push(functionName);
	}catch(e){
		alert("Function Register prob => "+e);
	}
}

function trim(s){
	while (s.substring(0,1) == ' '){
		s = s.substring(1,s.length);
	}
	while (s.substring(s.length-1,s.length) == ' '){
		s = s.substring(0,s.length-1);
	}
	return s;
}

function validatePrevControl()
{

	if(prevFieldType == "checkbox")
	{

		if(checkBoxStack.length > 1)
		{
			anyOneChecked = false;
			anyOneRequired = false;
			anyErrorMsg = false;
			
			for(j=0;j<checkBoxValueStack.length;j++)
			{
				if(checkBoxValueStack[j] == true)
				{
				anyOneChecked = true;
				}
			}

			for(q=0;q<checkBoxPropertyStack.length;q++){
			if(checkBoxPropertyStack[q] == "yes" || checkBoxPropertyStack[q] == "true")
			{
			anyOneRequired =true;	
			}
			}


			if(!anyOneChecked && anyOneRequired)
			{
			
// Show error here...
for(u=0;u<checkboxMsgStack.length;u++){
if(checkboxMsgStack[u] != null && checkboxMsgStack[u] != "null" && checkboxMsgStack[u] != ""){	anyErrorMsg = true;
	alert(checkboxMsgStack[u]);
}
}
if(anyErrorMsg == false){
alert("Please check one of the checkbox.");
}
//radioMsgStack
//checkboxMsgStack 	
				emptyCheckBoxStack();
				checkboxTakeAction = 0;
				return false;
			}
			else
			{
				emptyCheckBoxStack();
				checkboxTakeAction = 0;
				return true;
			}

		}
		else if(checkBoxStack.length == 1)
		{

if(checkBoxValueStack[0] == false && (checkBoxPropertyStack[0] == "yes" || checkBoxPropertyStack[0] == "true"))
{
				

if(checkboxMsgStack[0] != null && checkboxMsgStack[0] != "null" && checkboxMsgStack[0] != "")
			{
			alert(checkboxMsgStack[0]);
			}else{
			alert("Please select the checkbox.");
			
			}
				emptyCheckBoxStack();
				checkboxTakeAction = 0;
				return false;
}
			else
			{
				emptyCheckBoxStack();
				checkboxTakeAction = 0;
				return true;
			}

		}
		else
		{

			emptyCheckBoxStack();
			checkboxTakeAction = 0;
			return true;
		}
	}


	if(prevFieldType == "radio")
	{

		if(radioStack.length > 1)
		{
			anyOneChecked = false;
			anyOneRequired = false;
			anyErrorMsg = false;
			for(j=0;j<radioValueStack.length;j++)
			{
				if(radioValueStack[j] == true)
				{
				anyOneChecked = true;
				}
			}

			for(q=0;q<radioPropertyStack.length;q++){
			if(radioPropertyStack[q] == "yes" || radioPropertyStack[q] == "true")
				{
				anyOneRequired =true;	
				}
			}

				if(!anyOneChecked && anyOneRequired)
				{
					

// Show error here...
for(u=0;u<radioMsgStack.length;u++){
if(radioMsgStack[u] != null && radioMsgStack[u] != "null" && radioMsgStack[u] != ""){
anyErrorMsg = true
	alert(radioMsgStack[u]);
}
}

if(anyErrorMsg == false){
alert("Please select one of the options.");
}
					emptyRadioStack();

					radioTakeAction = 0;
					return false;
				}
				else
				{
					emptyRadioStack();
					radioTakeAction = 0;
					return true;
				}
		}
		
		else if(radioStack.length == 1)
		{
if(radioValueStack[0] == false && (radioPropertyStack[0] == "yes" || radioPropertyStack[0] == "true"))
			{
				
if(radioMsgStack[0] != null && radioMsgStack[0] != "null" && radioMsgStack[0] != "")
			{
			alert(checkboxMsgStack[0]);
			}else{
			alert("Please select the Option.");
			
			}				emptyRadioStack();
				radioTakeAction = 0;
				return false;
			}
			else
			{
				emptyRadioStack();
				radioTakeAction = 0;
				return true;
			}
		}
		else
		{
			emptyRadioStack();
			radioTakeAction = 0;
			return true;
		}
	}
}


function clearAllStacks(){

			for(j=0 ; j<radioStack.length ; j++)
			{
				radioStack.pop();
			}

			for(j=0 ; j<radioValueStack.length ; j++)
			{
				radioValueStack.pop();
			}

			for(j=0 ; j<checkBoxPropertyStack.length ; j++)
			{
				checkBoxPropertyStack.pop();
			}
			
			for(j=0 ; j<checkBoxStack.length ; j++)
			{
				checkBoxStack.pop();
			}

			for(j=0 ; j<checkBoxValueStack.length ; j++)
			{
				checkBoxValueStack.pop();
			}
			
			for(j=0 ; j<radioPropertyStack.length ; j++)
			{
				radioPropertyStack.pop();
			}
}

function emptyCheckBoxStack()
{
		try{

		var numOfCheckBoxes = parseInt(checkBoxStack.length);


		for(k=0 ; k < numOfCheckBoxes ; k++)
			{
				checkBoxStack.pop();
			}		
		for(m=0 ; m < numOfCheckBoxes ; m++)
			{
				checkBoxValueStack.pop();
			}
		for(n=0 ; n < numOfCheckBoxes ; n++)
			{
				checkBoxPropertyStack.pop();
			}
		for(n=0 ; n < numOfCheckBoxes ; n++)
			{
				checkboxMsgStack.pop();
			}		
		
		}catch(e){
			alert("Empty checkbox error " + e);
		}
}



function emptyRadioStack()
{
		try{

		var numOfRadioButton = parseInt(radioStack.length);

		for(l=0 ; l < numOfRadioButton ; l++)
			{
				radioStack.pop();
			}
		for(n=0 ; n < numOfRadioButton ; n++)
			{
				radioValueStack.pop();
			}
		for(j=0 ; j< numOfRadioButton ; j++)
			{
				radioPropertyStack.pop();
			}
		for(j=0 ; j< numOfRadioButton ; j++)
			{
				radioMsgStack.pop();
			}

		}catch(e){
		alert("Empty Radio error " + e);
		}
}

function pushCheckBox()
{
		try{
		checkBoxStack.push(fieldName);
		checkBoxValueStack.push(fieldValue);
		checkBoxPropertyStack.push(fieldRequired);	
		checkboxMsgStack.push(fieldMsg);	

		checkboxTakeAction = 1;
		}
		catch(e){
		alert("Checkbox pushing error : " + e);
		}
}

function pushRadio()
{
		try{

		radioStack.push(fieldName);
		radioValueStack.push(fieldValue);
		radioPropertyStack.push(fieldRequired);
		radioMsgStack.push(fieldMsg);
		
		radioTakeAction = 1;
		}catch(e){
		alert("Radio button pushing error : " + e);
		}
}


function getFormDetails()
{
	numberOfForms = document.forms.length;
	if(numberOfForms!=0)setUpValidation();
	else return;
}


function setUpValidation()
{

	for(j = 0 ; j < numberOfForms ; j++)
	{

		try{
		numberOfElemOfForm[j] = document.forms[j].elements.length;
		}catch(e){
		alert(e);
		}
		try{
		document.forms[j].onsubmit = validate;
		document.forms[j].setAttribute('formNumber',j);
		}catch(e){
			alert(e);
		}		
	}
	try{
	document.forms[0].elements[0].focus();
	}catch(e){}
}


function _date()
{
	var regex = /^[\d]{2}[\-|\/\.][\d]{2}[\-|\/\.][\d]{4}$/;
	if(!regex.test(fieldValue))
	{
		alert("Invalid Date format");
		__setFocus();
		return false;
	}
	else
	{
		var dd = parseInt(fieldValue.substring(0,2), 10);
		var mm = parseInt(fieldValue.substring(3,5), 10);
		var yy = parseInt(fieldValue.substring(6,10), 10);
	
		if(dd == 0 || mm == 0 || yy==0){
		alert("Invalid Date...");
		return false;
		}
			if(mm <= 12){
			switch(mm) {
				case 4:
				case 6:
				case 9:
				case 11:
					if (dd > 30) 
					{
						alert("This month has 30 days");
						return false;
					}
					
				break;
			}
			}else{
				alert("Invalid Months...\n\nMakesure date format must be one of the following...\n\n[1] dd-mm-yyyy\n[2] dd/mm/yyyy\n[3] dd.mm.yyyy");
				return false;
			}
	
			if ((yy % 4) == 0) {
				if ((mm == 2) && (dd > 29)) {
						alert("Invalid days in February for leap year");
						return false;
				}
			}
			else {
				if ((mm == 2) && (dd > 28)) {
						alert("Invalid days in February for non leap year.");
						return false;
				}
			}
	}
	return true;
}


function _usPhoneNumber()
{
	var regex = /[\(][\d]{3}[\)][\d]{3}[\-][\d]{4}/
	if(!regex.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Please enter phone number into (xxx)xxx-xxxx pattern.");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	return true;
}

function _mobileNumber()
{
	var regex1 = /^[\d]{10}$/;
	var regex2 = /[\(][\+][\d]{2}[\)][\d]{10}/;

	if(!regex1.test(fieldValue) && !regex2.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Please enter phone number into (+xx)xxxxxxxxxx or xxxxxxxxxx pattern.");
		}else{
		alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	return true;
}


function _phoneNumber()
{
	if(fieldValue!="")
	{
	var regex = /^[\d]+$/;

	if(!regex.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Wrong phone number.");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}

function _specialChars()
{
	if(fieldValue!=""){
	var regex = /^[a-zA-Z0-9\ ]+$/;
	if(!regex.test(fieldValue))
	{

		if(!fieldMsg){
		alert("No Special charactors.");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}

function _specialCharsAndNumbers()
{
	if(fieldValue!=""){
	var regex = /^[a-zA-Z\ ]+$/;
	if(!regex.test(fieldValue))
	{
		if(!fieldMsg){
		alert("No Special charactors or Number allowed.");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}

function _email()
{
	if(fieldValue!=""){
	var regex = /^[\w]+(\.[\w]+)*@([\w\-]+\.)+[a-zA-Z]{2,7}$/ ;
	if(!regex.test(fieldValue))
	{

		if(!fieldMsg){
		alert("Invalid Email Address");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}

function _username()
{
	if(fieldValue!=""){
	var regex = /^[a-zA-Z]+[a-zA-Z0-9\.\_]*[a-zA-Z0-9]+$/;
	if(!regex.test(fieldValue))
	{

		if(!fieldMsg){
		alert("No Special charactors.");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}

function _flName()
{
	if(fieldValue!=""){
	var regex = /^[a-zA-Z]+$/;
	if(!regex.test(fieldValue))
	{

		if(!fieldMsg){
		alert("No Special charactors.");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}



function _currency()
{
	if(fieldValue!=""){

regex1 = /^[\d]+[\d\.]*[\d]+$/;
regex2 = /^[\d]+$/;

    if(!regex1.test(fieldValue) && !regex2.test(fieldValue)) {
		if(!fieldMsg){
		alert("Invalid Input");
		}else{
			alert(fieldMsg);
		}
		 return false;
    }
	}
	return true;
}

function _url()
{
	if(fieldValue!=""){

var regex1 = /^(www.|[a-zA-Z].)[a-zA-Z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk)(\:[0-9]+)*(\/($|[a-zA-Z0-9\.\,\;\?\'\\\+&%\$#\=~_\-]+))*$/;
var regex2 = /^(((http(s?))|(ftp))\:\/\/)?(www.|[a-zA-Z].)[a-zA-Z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk)(\:[0-9]+)*(\/($|[a-zA-Z0-9\.\,\;\?\'\\\+&%\$#\=~_\-]+))*$/;



	if(!regex1.test(fieldValue) && !regex2.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Not a valid url.");
		}else{
			alert(fieldMsg);
		}
		//alert("Not valid url.");
		__setFocus();
		return false;
	}
	}
	return true;
}

function _digits()
{

	var regex = /^[\d]+$/;

	if(!regex.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Invalid Digits");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	return true;
}

function _zip()
{
	if(fieldValue!=""){
	var regex1 = /^[\d]{5,6}$/;
	var regex2 = /^[A-Za-z]{1,2}[0-9A-Za-z]{1,2}[ ]?[0-9]{0,1}[A-Za-z]{2}$/; 

	if(!regex1.test(fieldValue) && !regex2.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Zipcode/Postcode Invalid");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	}
	return true;
}

function _custom()
{
//	alert("Custom Comparing");
	if(fieldValue!=""){
	
	if(fieldPattern != null){
	var num = eval("/"+fieldPattern+"/");
	if(!num.test(fieldValue))
	{
		if(!fieldMsg){
		alert("Error occured");
		}else{
			alert(fieldMsg);
		}
		__setFocus();
		return false;
	}
	
	}else{
		alert("Coding Error\n\nNo \"pattern\" attribute found in form field : \""+ fieldName +"\".");
		__setFocus();
		return false;
	}
	}

	return true;
}

function __setFocus()
{
		try{
			field.focus();
			field.select();
		}catch(e){
		}
}

function validate(e)
{
	try{
	if(e==null){
		// I.E.

		var eventIsFiredFromTheForm = event.srcElement.getAttribute('formNumber');
	}else{
		// Firefox

		if(e.target.tagName == "FORM"){
			var eventIsFiredFromTheForm = e.target.getAttribute('formNumber');
		}else{
		var eventIsFiredFromTheForm = e.target.form.getAttribute('formNumber');
	
		}

	}
	}catch(e)
	{
		alert("To Submit this form\n\nPlease click submit button.\n\nbecause of following error:\n"+e);
		return false;
	}
prevFieldName = "";
prevFieldType = "";
var numberOfUserFunctions = parseInt(userFunctionStack.length);

if(numberOfUserFunctions > 0){
for( d = 0 ; d < numberOfUserFunctions ; d++){
	try{
	if(!userFunctionStack[d]()){
		return false;
	}
	}catch(e){
		alert(e);
	}
}
}


for(i=0 ; i < document.forms[eventIsFiredFromTheForm].elements.length ; i++)
{

fieldIndex = i;
field = document.forms[eventIsFiredFromTheForm].elements[i];
fieldType = document.forms[eventIsFiredFromTheForm].elements[i].type;
fieldName = document.forms[eventIsFiredFromTheForm].elements[i].name;
fieldAttrib = document.forms[eventIsFiredFromTheForm].elements[i].getAttribute("authtype");
fieldRequired = document.forms[eventIsFiredFromTheForm].elements[i].getAttribute("required");
fieldPattern = field.getAttribute("pattern");
fieldMsg = field.getAttribute("errormsg");

if (fieldType == "hidden")
{
	fieldValue = document.forms[eventIsFiredFromTheForm].elements[i].value;
	if(prevFieldType == "radio" || prevFieldType == "checkbox")
	{	
		try{
	
			if(checkboxTakeAction == 1 && prevFieldType == "checkbox")
			{

				if(!validatePrevControl()){
					return false;
				}else{
					emptyCheckBoxStack();
				}
			}
			else if(radioTakeAction == 1 && prevFieldType == "radio")
			{
				if(!validatePrevControl()){
					return false;
				}else{
					emptyRadioStack();
				}
			}
			else
			{
				clearAllStacks();
			}



		}catch(e){
		}
	}
}
if(fieldType == "text" || fieldType == "textarea" || fieldType == "file" || fieldType == "password")
{


	fieldValue = document.forms[eventIsFiredFromTheForm].elements[i].value;
	if(prevFieldType == "radio" || prevFieldType == "checkbox")
	{	
		try{
	
			if(checkboxTakeAction == 1 && prevFieldType == "checkbox")
			{

				if(!validatePrevControl()){
					return false;
				}else{
					emptyCheckBoxStack();
				}
			}
			else if(radioTakeAction == 1 && prevFieldType == "radio")
			{
				if(!validatePrevControl()){
					return false;
				}else{
					emptyRadioStack();
				}
			}
			else
			{
				clearAllStacks();
			}



		}catch(e){
		}
	}

	
	if(fieldAttrib == null && fieldRequired == null){
	prevFieldName = fieldName;
	prevFieldType = fieldType;
	continue;
	}
	else if(fieldAttrib == null && fieldRequired != null){
	}
	else if(fieldAttrib != null && fieldRequired == null){
	}
	else if(fieldAttrib != null && fieldRequired != null){
		
		if(trim(fieldAttrib) == "" && trim(fieldRequired) == "")
		{
		prevFieldName = fieldName;
		prevFieldType = fieldType;
		continue;
		}
	}


	if(fieldRequired != null){
	if(fieldRequired.toLowerCase() == "yes" || fieldRequired.toLowerCase() == "required" || fieldRequired.toLowerCase() == "true")
	{
		
		if(trim(fieldValue) == "" && (fieldRequired.toLowerCase() == "yes" || fieldRequired.toLowerCase() == "required" || fieldRequired.toLowerCase() == "true"))
		{
			alert("Required field must not be left empty.");
			field.focus();
			return false;
		}

	}
	}
	
	if (fieldAttrib != null){
		if(fieldAttrib){
	
		try{
			functionStr = fieldAttrib;
			functionExec = eval(fieldAttrib);
			if(fieldAttrib){
			if(!functionExec()){
				return false;
			}

			}else{
				alert("Coding Error\n\nWrong \"authtype\" attribute in form field : \""+ fieldName +"\"\, unable to process the authtype = " + functionStr + "\n\nPlease check the function \"" + functionStr + "\" written perfectly or not...!!");
				return false;
			}

		}catch(e){
alert("Coding Error\n\nWrong \"authtype\" attribute in form  field : \""+ fieldName +"\"\, unable to process : authtype = \"" + functionStr + "\"\n\nPlease check the function \"" + functionStr + "\" written perfectly or not...!!");
return false;

		}

		}
	}
	
	}
	
if(fieldType == "submit" || fieldType == "button" || fieldType == "image")
{

	if(prevFieldType == "radio" || prevFieldType == "checkbox")
	{
		try{
	
			if(checkboxTakeAction == 1 && prevFieldType == "checkbox")
			{

				if(!validatePrevControl()){
					return false;
				}else{
					emptyCheckBoxStack();
				}
			}
			else if(radioTakeAction == 1 && prevFieldType == "radio")
			{
				if(!validatePrevControl()){
					return false;
				}else{
					emptyRadioStack();
				}
			}
			else
			{
				clearAllStacks();
			}



		}catch(e){
		}
	}
}

if(fieldType == "select-one")
{
	if(prevFieldType == "radio" || prevFieldType == "checkbox")
	{	

		try{
	
			if(checkboxTakeAction == 1 && prevFieldType == "checkbox")
			{

				if(!validatePrevControl()){
					return false;
				}else{
					emptyCheckBoxStack();
				}
			}
			else if(radioTakeAction == 1 && prevFieldType == "radio")
			{
				if(!validatePrevControl()){
					return false;
				}else{
					emptyRadioStack();
				}
			}
			else
			{
				clearAllStacks();
			}



		}catch(e){
		}
	}
	fieldValue = document.forms[eventIsFiredFromTheForm].elements[i].value;
	if(fieldRequired != null && trim(fieldRequired) != ""){
	if(fieldRequired.toLowerCase() == "yes")
	{
	if(trim(fieldValue) == "" && fieldRequired.toLowerCase() == "yes"){
			alert("Required field must not be left empty.");
		field.focus();
		return false;
	}
	}
	}
}



if(fieldType == "select-multiple")
{
		
	if(prevFieldType == "radio" || prevFieldType == "checkbox")
	{	

		try{
	
			if(checkboxTakeAction == 1 && prevFieldType == "checkbox")
			{

				if(!validatePrevControl()){
					return false;
				}else{
					emptyCheckBoxStack();
				}
			}
			else if(radioTakeAction == 1 && prevFieldType == "radio")
			{
				if(!validatePrevControl()){
					return false;
				}else{
					emptyRadioStack();
				}
			}
			else
			{
				clearAllStacks();
			}



		}catch(e){
		}
	}

	fieldValue = document.forms[eventIsFiredFromTheForm].elements[i].value;
	if(fieldRequired != null && trim(fieldRequired) != ""){
	if(fieldRequired.toLowerCase() == "yes" || fieldRequired.toLowerCase() == "true")
	{
	var noneSelected = true;
	var end = parseInt(field.options.length);
	for(z=0 ; z < end ; z++)
	{
		if(field.options[z].selected)
		{
			noneSelected = false;
		}
	}
	
	if(noneSelected){

	if(!fieldMsg){
		alert("Please select atleast one option from multi-select.");
		}else{
			alert(fieldMsg);
		}
		return false;
	}
	
	}
	}

}

if(fieldType == "checkbox")
{

	fieldValue = document.forms[eventIsFiredFromTheForm].elements[i].checked;

	if(checkboxTakeAction == 1 || radioTakeAction == 1)
	{
		if((fieldName == prevFieldName) && (fieldType == prevFieldType))
		{
			pushCheckBox();
		
		}
		else
		{	
			if(!validatePrevControl()){
					return false;
				}
			pushCheckBox();
		}
	}
	else
	{
		pushCheckBox();
	}
}


if(fieldType == "radio")
{
	fieldValue = document.forms[eventIsFiredFromTheForm].elements[i].checked;

	if(radioTakeAction == 1 || checkboxTakeAction == 1)
	{
		if((fieldName == prevFieldName) && (fieldType == prevFieldType))
		{
			pushRadio();
		}
		else
		{
			if(!validatePrevControl()){
				return false;
				}
			pushRadio();
		}
	}
	else
	{
		pushRadio();
	}
}

prevFieldName = fieldName;
prevFieldType = fieldType;

}
	return true;
}
