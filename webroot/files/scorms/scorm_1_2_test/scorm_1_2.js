function Scorm() {
}

Scorm.prototype = {

// Define exception/error codes
// Codes currently not handled are commented
OK : 0,
NOT_INITIALIZED : 301,					/* changed in SCORM 2004 */
NOT_IMPLEMENTED : 401,					/* changed in SCORM 2004 */

// OWN ERROR CODES
NOT_COMMITTED : 1001,
NOT_FINISHED : 1002,
NO_API_FOUND : 1003,
NO_ADAPTER_FOUND : 1004,
ERROR_GETVALUE : 1005,
ERROR_SETVALUE : 1006,
   
/* Object. The SCORM API adapter of the LMS */  
api : null,
startDate : 0,
exitPageStatus : "",

// METHODS

/**
 * Commits the message queue to the API adapter
 */
commit : function(){
   try{
       var result = this.api.LMSCommit("");
       if (result.toString() != "true")
			throw this.NOT_COMMITED;
       else
           return result.toString();
   }catch(e){
		if (e == this.NOT_COMMITED)
          alert("Unable to commit the LMS.\nLMSCommit was not successful.");
       return "false";
   }    
},

/**
 * this method used for computing the session time of the student.
 */
computeTime : function(){
	var newTime;
	if (this.startDate>0){
		var curDate = new Date().getTime();
		var elapsed = (curDate-this.startDate)/1000;
		newTime = this.convertTotalSeconds(elapsed);
	}
   this.setValue("cmi.core.session_time",newTime||"00:00:00.0");
},

/**
 * this method will convert seconds into hours, minutes, and seconds in
 * CMITimespan type format - HHHH:MM:SS.SS (Hours has a max of 4 digits &
 * Min of 2 digits)
 *
 * @param {real} ts
 *		time in seconds
 * @return CMITimespan type format - HHHH:MM:SS.SS
 */
convertTotalSeconds : function(ts){
   var sec = (ts % 60);
   ts -= sec;
   var tmp = (ts % 3600);  //# of seconds in the total # of minutes
   ts -= tmp;              //# of seconds in the total # of hours

   // convert seconds to conform to CMITimespan type (e.g. SS.00)
   sec = Math.round(sec*100)/100;

   var strSec = new String(sec);
   var strWholeSec = strSec;
   var strFractionSec = "";

   if (strSec.indexOf(".") != -1){
      strWholeSec =  strSec.substring(0, strSec.indexOf("."));
      strFractionSec = strSec.substring(strSec.indexOf(".")+1, strSec.length);
   }

   if (strWholeSec.length < 2)
      strWholeSec = "0" + strWholeSec;
   strSec = strWholeSec;

   if (strFractionSec.length)
      strSec = strSec+ "." + strFractionSec;

   var hour = (ts % 3600) ? 0 : (ts / 3600);
   var min = (tmp % 60) ? 0 : (tmp / 60);

   if ((new String(hour)).length < 2)
      hour = "0"+hour;
   if ((new String(min)).length < 2)
      min = "0"+min;

   return hour+":"+min+":"+strSec;
},

/**
 * Looks for an object named API in all window objects of the current Frame
 * If an API object is found, it's returned, otherwise null is returned.
 *
 * @param win the window object, on which LMS's API initializes
 * @return an API object or null.
 */
findAPI : function(win){
	try{
		var tries = 0;
		while ((win.API == null) && (win.parent != null) && (win.parent != win)){
			// Note: 7 is an arbitrary number, but should be more than sufficient
			if (tries++ > 7)
				throw this.NO_API_FOUND;
			win = win.parent;
		}
		return win.API;
	}
	catch(e) {
		if (e == this.NO_API_FOUND)
			alert("Error finding API -- too deeply nested.");
        return null;
	}
},

/**
 * Closes communication with LMS by calling the LMSFinish.
 *
 * @return CMIBoolean true if successful CMIBoolean false if failed.
 */
finish : function(){
   try{
   	if (this.api) {
	   var result = this.api.LMSFinish("");           
	   if (result.toString() != "true")
		   throw this.NOT_FINISHED;
	   else
		   return result.toString();
	}
   }
   catch(e) {
		if (e == this.NOT_FINISHED)
           alert("Unable to finish the LMS.\nLMSFinish was not successful.");
        return "false";
   }
},

/**
 * Looks for an object named API, first in the current window's
 * frame hierarchy and then, if necessary, in the current window's opener window
 * hierarchy (if there is an opener window).
 * If an API object is found, it's returned, otherwise null is returned.
 */
getAPI : function(){
	try{
		var theAPI = this.findAPI(window);
		if (!theAPI && window.opener)
			theAPI = this.findAPI(window.opener);
		if (theAPI)
			return theAPI;
       else
			throw this.NO_ADAPTER_FOUND;
	}
	catch(e) {
		if (e == this.NO_ADAPTER_FOUND)
			alert("Unable to find an API adapter");
	}
	return null;
},

/**
 * this method used for calling the LMSGetErrorString function of LMS's API.
 *
 * @param Error Code(integer format), or null
 * @return The textual description that corresponds to the input error code.
 */
getErrorString : function(errorCode){
   try{
       if (!this.api) throw this.NOT_IMPLEMENTED;
       else
           return this.api.LMSGetErrorString(errorCode).toString();
   }catch(e){
       if (e == this.NOT_IMPLEMENTED){
           alert("Unable to locate the LMS's API Implementation.\nLMSGetErrorString was not successful.");
           return null;
       }
   }
},

/**
 *
 */
getUser : function(){
	var name = this.getValue("cmi.core.student_name")||",";
	var nameArray = name.split(",");
	var fName = nameArray[1]||"";
	var lName = nameArray[0]||"";
	return {firstName : fName, lastName:lName};
},

/**
 * this method used for calling the LMSGetLastError function of LMS's API.
 *
 * @return The error code that was set by the last LMS function call.
 */
getLastError : function(){
	return this.api.LMSGetLastError().toString();
},

/**
 *
 */
getProgress : function(){
   try{
   		var val = this.getValue("cmi.suspend_data");

		// rebuild single and double quotes
		// saved with escape because quotes are handled wrong in moodle 1.6 
   		if (val)
   			val = unescape(val);
        return val;
   }catch(e){
       alert("No data was saved in the LMS.");
   }
},

setProgress : function(val) {
	this.setValue("cmi.suspend_data",escape(val));
},

     
/**
 * Calls the LMSGetValue function of the LMS's API.
 *
 * @param name string representing the cmi data model defined category or
 *             element (e.g. cmi.core.student_id)
 * @return The value presently assigned by the LMS to the cmi data model
 *         element defined by the element or category identified by the name
 *         input value.
 */
getValue : function(name){
   try{
       if (!this.api) throw this.NOT_IMPLEMENTED;
       else{
            var value = this.api.LMSGetValue(name);
            var errCode = this.api.LMSGetLastError().toString();
            // an error was encountered so display the error description
            if (errCode != this.OK) throw this.ERROR_GETVALUE;
            else
                return value.toString();
       }
   }catch(e){
       if (e == this.NOT_IMPLEMENTED){
           alert("Unable to locate the LMS's API Implementation.\nLMSGetValue was not successful.");
           return "";
       }
       else if (e == this.ERROR_GETVALUE){
           alert("LMSGetValue("+name+") failed. \n"+ this.api.LMSGetErrorString(this.api.LMSGetLastError().toString()));
           return "";
       }
   }
},

/**
 * Initializing communication with LMS by calling
 * the LMSInitialize function which has to be implemented by the LMS.
 *
 * @return CMIBoolean true if the initialization was successful, or
 *         CMIBoolean false if the initialization failed.
 */
initialize : function(){
   try{
       var api = this.getAPI();
       if (!api) throw this.NOT_IMPLEMENTED;
		// don't call the LMSInitialize method twice. It could return false.
		if (api == this.api) return "true";
       var result = api.LMSInitialize("");
       if (result.toString() != "true") throw this.NOT_INITIALIZED;
       else{
           this.api = api;
           return result.toString();
       }    
   }catch(e){
       if (e == this.NOT_IMPLEMENTED)
           alert("Unable to locate the LMS's API Implementation.\nLMSInitialize was not successful.");
       else if (e == this.NOT_INITIALIZED)
           alert("Unable to initialize the LMS.\nLMSInitialize was not successful.");
   }
   return "false";
},


/**
 * this method used for initializing SCO and starting session timer.
 */
load : function(){
	if (this.initialize() == "true") {
		var status = this.getValue("cmi.core.lesson_status");
		// the student is now attempting the lesson
		if (status == "not attempted")
			this.setValue("cmi.core.lesson_status", "incomplete");
		this.exitPageStatus = false;
		this.startTimer();
	}
},

/**
 * this method used for leaving the whole course.
 *
 * @param status the status of the current lesson
 */
quit : function(progress,status){
	this.computeTime();
	this.exitPageStatus = true;
	this.setValue("cmi.core.lesson_status", status);
	if (progress)
		this.setValue("cmi.core.exit","suspend");
	// escape the value because quotes are handled wrong in moodle 1.6
	// shouldn't we use encodeURI instead?
	this.setProgress(progress);
	this.commit();
	// NOTE: LMSFinish will unload the current SCO.  All processing
	//       relative to the current page must be performed prior
	//		 to calling LMSFinish.
	this.finish();
},

  
/**
 *
 */
setScore : function(value, max, min){
	this.setValue("cmi.core.score.min",min);                      
	this.setValue("cmi.core.score.max",max);
	// Important: set the raw value after setting min max as otherwise some LMS' might
	// throw an error due to wrong calculations (example: globalteach)
	this.setValue("cmi.core.score.raw",value);
	this.commit();                   
},

    
/**
 * Calls the LMSSetValue function of the LMS's API.
 *
 * @param {String} name
 * 		representing the data model defined category or element
 * @param {String} value
 *		the value that the named element or category will be assigned
 * @return CMIBoolean true if successful, CMIBoolean false if failed.
 */
setValue : function(name, value){
   try{
       //var result = api.LMSSetValue(name, value);
       var result = this.api.LMSSetValue(name,value);
       if (result.toString() != "true")
           throw this.ERROR_SETVALUE;
   }
   catch(e){
       if (e == this.ERROR_SETVALUE)
           alert("LMSSetValue("+name+","+value+") failed. \nResult: " + result);
       return "false";
   }
   return "true";
},

/**
 * Initializing the start time of the student.
 */
startTimer : function(){
	this.startDate = new Date().getTime();
},

/**
 * Determine SCO and close communication between LMS and SCO.
 *
 * @param status the ending status of the lesson
 */
unload : function(status){
	if (this.exitPageStatus != true)
		this.quit(status);
	 // NOTE:  don't return anything that resembles a javascript
	 //		  string from this function or IE will take the
	 //		  liberty of displaying a confirm message box.
}

};
// End Scorm prototype
