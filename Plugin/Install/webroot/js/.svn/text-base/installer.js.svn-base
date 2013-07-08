// Karamelo Installer functions

 function validateDatabaseconfig()
 {
   var form     = document.getElementById('installform_db')
   var fields   = form.elements
   var required = document.getElementsByName('required')
   var validate = true
   var regexnum = /^\d+$/

   //Check if a Database type is selected
   if (fields[2].value == 'Select')
   {
        validate = false   
        required[0].innerHTML = ' You must select a database type'
   } else { 
       required[0].innerHTML = '' 
   }

   //Check if the fields are empty
   for(i=3; i< fields.length-2; i++)
   {
        if (fields[i].value == ''){
            validate = false   
            required[i-2].innerHTML = 'This field must not be empty'
        }else{
            required[i-2].innerHTML = ''
        }    
    }

    //Check only numbers if there is not empty
    if(fields[7].value != ''){
        if(!regexnum.test(fields[7].value)){
            validate = false   
            required[5].innerHTML = 'Only numbers are accepted'
        }else{
            required[5].innerHTML = ''
        }   
    }else{ required[5].innerHTML = ''}

    return validate
 }

 function validateUser()
 {
  var email             = document.getElementById('email');
  var username          = document.getElementById('admin');
  var name              = document.getElementById('name');
  var pwd               = document.getElementById('pwd');
  var required          = document.getElementsByName('required')
  var regex_email       = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/
  var regex_specialchar = /^[a-zA-Z]+[a-zA-Z0-9\.\_]*[a-zA-Z0-9]+$/;
  var space             = username.value.indexOf(" ");
  var validate          = true;
	
	//Validate an email with regexpr
	if (!regex_email.test(email.value))
    {
		validate = false
		required[0].innerHTML = 'Not a valid email'
	} else { 
        required[0].innerHTML = '' 
    }
	
	//Validate Username not empty and no special characters
	if (username.value.length < 5){
		validate = false
		required[1].innerHTML = 'Username must have five letters at least'
	}else if(!regex_specialchar.test(username.value)){
		validate = false
		required[1].innerHTML = 'No special characters or spaces in username'
	}else{ required[1].innerHTML = '' }
	
	// Validate Name not empty
	if (name.value.length < 5){
		validate = false
		required[2].innerHTML = 'Name and last name must have five letters at least'
	}else{ required[2].innerHTML = '' }
	
	// Validate Name not empty
	if (pwd.value.length < 6){
		validate = false
		required[3].innerHTML = 'Password must have at least 6 characters'
	}else{ required[3].innerHTML = '' }
	
	return validate
}

function  setPort() {
   var Index        = document.getElementById("pgormy").selectedIndex;
   var port         = document.getElementById("port");
   var chosenoption = document.getElementById("pgormy").options[Index].value;

   // alert(chosenoption);
   if ( chosenoption == 'pgsql')
   {
     port.value = '5432';
   } else {
     port.value = '3306';
   }
}


