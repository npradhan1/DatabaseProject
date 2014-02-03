$return_val = true;

function formValidation(){
	//alert('clicked');
	var uid = document.registration.userId;
	var passid = document.registration.password;
	var fname = document.registration.firstName;
	var lname = document.registration.lastName;
	var line1 = document.registration.line1;
	var ucity = document.registration.city;
	var uzip = document.registration.zip;
	var ustate = document.registration.state;
	var uemail = document.registration.email;
	var dob = document.registration.dob;

	
	if(allLetter(fname)){
		if(allLetter(lname)){
			if(passid_validation(passid,7,12)){
				if(checkdate(dob)){
					if(ValidateEmail(uemail)){
						if(alphanumeric(line1)){ 
							if(allLetter(city)){
								if(allLetter(ustate)){
									if(allnumeric(uzip)){
										return true;
									}
								}
							} 
						}
					} 
				}
			}		
		}
	}
	return return_val;
} 


function passid_validation(passid,mx,my){
	var passid_len = passid.value.length;
	if (passid_len == 0 ||passid_len >= my || passid_len < mx)	{
		alert("Password should not be empty / length be between "+mx+" to "+my);
		passid.focus();
		return_val = false;
		return false;
	}
	return true;
}

function allLetterFname(fname){ 
	var letters = /^[A-Za-z]+$/;
	if(fname.value.match(letters)){
		return true;
	}else	{
		alert('First name must have alphabet characters only');
		fname.focus();
		return_val = false;
		return false;
	}
}

function allLetterLname(lname){ 
	var letters = /^[A-Za-z]+$/;
	if(lname.value.match(letters)){
		return true;
	}else	{
		alert('Last name must have alphabet characters only');
		lname.focus();
		return_val = false;
		return false;
	}
}

function allLetter(ustate){ 
	var letters = /^[A-Za-z]+$/;
	if(ustate.value.match(letters)){
		return true;
	}else	{
		alert('State name must have alphabet characters only');
		ustate.focus();
		return_val = false;
		return false;
	}
}

function alphanumeric(uadd){ 
	var letters = /^[0-9a-zA-Z ]+$/;
	if(uadd.value.match(letters)){
		return true;
	}else{
		alert('User address must have alphanumeric characters only');
		uadd.focus();
		return_val = false;
		return false;
	}
}


function allnumeric(uzip){ 
	var numbers = /^[0-9]+$/;
	if(uzip.value.match(numbers))	{
		return true;
	}
	else{
		alert('ZIP code must have numeric characters only');
		uzip.focus();
		return_val = false;
		return false;
	}
}

function ValidateEmail(uemail){
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(uemail.value.match(mailformat))	{
		return true;
	}else{
		alert("You have entered an invalid email address!");
		uemail.focus();
		return_val = false;
		return false;
	}
} 


/**--------------------------
//* Validate Date Field script- By JavaScriptKit.com
//* For this script and 100s more, visit http://www.javascriptkit.com
//* This notice must stay intact for usage
---------------------------**/

function checkdate(input){
	//alert(input.value);
	var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
	var returnval=false;
	if (!validformat.test(input.value)){
		alert("Invalid Date Format. Please correct and submit again.")
		dob.focus();
		return_val = false;
		return false;
	}
	else{ //Detailed check for valid date ranges
		var monthfield=input.value.split("/")[0]
		var dayfield=input.value.split("/")[1]
		var yearfield=input.value.split("/")[2]
		var dayobj = new Date(yearfield, monthfield-1, dayfield)
		if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)){
			alert("Invalid Day, Month, or Year range detected. Please correct and submit again.");
			return_val = false;
			return false;
		}else{
			return true;
		}
	}
	return true;
}
