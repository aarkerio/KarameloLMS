/*******************************************************************************
**
** FileName: APIWrapper.js
**
*******************************************************************************/

/*******************************************************************************
**
** Concurrent Technologies Corporation (CTC) grants you ("Licensee") a non-
** exclusive, royalty free, license to use, modify and redistribute this
** software in source and binary code form, provided that i) this copyright
** notice and license appear on all copies of the software; and ii) Licensee does
** not utilize the software in a manner which is disparaging to CTC.
**
** This software is provided "AS IS," without a warranty of any kind.  ALL
** EXPRESS OR IMPLIED CONDITIONS, REPRESENTATIONS AND WARRANTIES, INCLUDING ANY
** IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE OR NON-
** INFRINGEMENT, ARE HEREBY EXCLUDED.  CTC AND ITS LICENSORS SHALL NOT BE LIABLE
** FOR ANY DAMAGES SUFFERED BY LICENSEE AS A RESULT OF USING, MODIFYING OR
** DISTRIBUTING THE SOFTWARE OR ITS DERIVATIVES.  IN NO EVENT WILL CTC  OR ITS
** LICENSORS BE LIABLE FOR ANY LOST REVENUE, PROFIT OR DATA, OR FOR DIRECT,
** INDIRECT, SPECIAL, CONSEQUENTIAL, INCIDENTAL OR PUNITIVE DAMAGES, HOWEVER
** CAUSED AND REGARDLESS OF THE THEORY OF LIABILITY, ARISING OUT OF THE USE OF
** OR INABILITY TO USE SOFTWARE, EVEN IF CTC  HAS BEEN ADVISED OF THE POSSIBILITY
** OF SUCH DAMAGES.
**
*******************************************************************************/

/*******************************************************************************
** This file is part of the ADL Sample API Implementation intended to provide
** an elementary example of the concepts presented in the ADL Shareable
** Courseware Object Reference Model (SCORM).
**
** The purpose in wrapping the calls to the API is to (1) provide a 
** consistent means of finding the LMS API implementation within the window
** hierarchy and (2) to validate that the data being exchanged via the
** API conforms to the defined CMI data types.
** 
** This is just one possible example for implementing the API guidelines for
** runtime communication between an LMS and executable content components. 
** There are several other possible implementations.
**
** Usage: Executable course content can call the API Wrapper 
**        functions as follows:
**
**      javascript:
**              var result = LMSInitialize();
**              if (result != true) {
**                  //handle error
**                }
**      
**      authorware
**              result := ReadURL("javascript:apiWrapper.LMSInitialize()", 100)
** 
******************************************************************************************/

var _Debug = false;  // set this to false to turn debugging off
var flashDebug = false; //Used for debugging the flash interfaces
// and get rid of those annoying alert boxes.

// Define exception/error codes
var _NoError = 0;
var _GeneralException = 101; 
var _InvalidArgumentError = 201;
var _NotInitialized = 301;
var _NotImplementedError = 401;


// local variable definitions
var apiHandle = null;
var bFinishDone = false;
var starttime;


/******************************************************************************************
**
** Function: LMSInitialize()
** Inputs:  None
** Return:  CMIBoolean true if the initialization was successful, or
**          CMIBoolean false if the initialization failed.
**
** Description:
** Initialize communication with LMS by calling the LMSInitialize 
** function which will be implemented by the LMS, if the LMS is 
** compliant with the SCORM.
**
******************************************************************************************/
function LMSInitialize() 
{
   var api = getAPIHandle();
   if (api == null)
   {
      alert(lang000 + "\n" + lang001);
      return false;
   }
   // call the LMSInitialize function that should be implemented by the API
   var emptyString = "";
   var initResult = api.LMSInitialize(emptyString);
   if (initResult.toString() != "1" && initResult.toString() != "true")
   {
      // LMSInitialize did not complete successfully.

      // Note: An assumption is made that if LMSInitialize returns a non-true
      //         value, then and only then, an error was raised.

      var err = ErrorHandler();
   }
   else
   {
      bFinishDone = false;
   }
   return initResult;
   
} 

/******************************************************************************************
**
** Function LMSFinish()
** Inputs:  None
** Return:  None
**
** Description:
** Close communication with LMS by calling the LMSFinish 
** function which will be implemented by the LMS, if the LMS is 
** compliant with the SCORM.
**
******************************************************************************************/
function LMSFinish()
{
   if (bFinishDone == false)
   {
       var api = getAPIHandle();
       if (api == null)
       {
          alert(lang000 + "\n" + lang002);
       }
       else
       {
          // call the LMSInitialize function that should be implemented by the API
          var emptyString = "";
          var finResult = api.LMSFinish(emptyString);
          if (finResult == "false")
          {
             var err = ErrorHandler();
          }
          else
          {
             bFinishDone = true;
          }
       }   
   }
   return;
   
} 

/******************************************************************************************
**
** Function LMSGetValue(name) 
** Inputs:  name - string representing the cmi data model defined category or 
**                 element (e.g. cmi.core.student_id)
** Return:  The value presently assigned by the LMS to the cmi data model 
**          element defined by the element or category identified by the name
**          input value.
**
** Description: 
** Wraps the call to the LMS LMSGetValue method
**
******************************************************************************************/
function LMSGetValue(name)
{

	if (bFinishDone == false)
	{
		var api = getAPIHandle();
		if (api == null)
		{
			alert(lang000 + "\n" + lang003);
			return null;
		}
		else
		{
			var value = api.LMSGetValue(name);
			if (value == "")
			{
				var err =  ErrorHandler();
				// if  an error was encountered, then return null,   
				// else return the retrieved value
				if (err != _NoError)
				{
					return null;
				}
				else
				{
					return "";
				}
			}
			else
			{
				return value.toString();
			}
		}       
	}
}
/******************************************************************************************
**
** Function LMSSetValue(name, value) 
** Inputs:  name - string representing the cmi data model defined category or element
**          value - the value that the named element or category will be assigned
** Return:  None
**
** Description:
** Wraps the call to the LMS LMSSetValue method
**
******************************************************************************************/
function LMSSetValue(name, value) 
{   
   if (bFinishDone == false)
   {
       var api = getAPIHandle();
       if (api == null)
       {
          alert(lang000 + "\n" + lang004);
       }
       else
       {
          var setRet = api.LMSSetValue(name, value);
		  if (setRet != "true")
		  {
	          var err = ErrorHandler();
		  }
       }   
    }
    return;
}

/******************************************************************************************
**
** Function LMSCommit() 
** Inputs:  None
** Return:  None
**
** Description:
** Call the LMSCommit function which will be implemented by the LMS, 
** if the LMS is compliant with the SCORM.
**
******************************************************************************************/
function LMSCommit()
{
    
   if (bFinishDone == false)
   {
       var api = getAPIHandle();
       if (api == null)
       {
          alert(lang000 + "\n" + lang005);
       }
       else
       {
          // call the LMSCommit function that should be implemented by the API
          var emptyString = "";
          var comRet = api.LMSCommit(emptyString);
		  if (comRet == "false")
		  {
		  }
          var err = ErrorHandler();
       }   
    }
    return;
} 

/******************************************************************************************
**
** Function LMSGetLastError() 
** Inputs:  None
** Return:  The error code (integer format) that was set by the last LMS function call
**
** Description:
** Call the LMSGetLastError function which will be implemented by the LMS, 
** if the LMS is compliant with the SCORM.
**
******************************************************************************************/
function LMSGetLastError() 
{
   var api = getAPIHandle();
   if (api == null)
   {
      alert(lang000 + "\n" + lang006);
      //since we can't get the error code from the LMS, return a general error
      return _GeneralError;
   }
   return api.LMSGetLastError().toString();
} 

/******************************************************************************************
**
** Function LMSGetErrorString(errorCode)
** Inputs:  errorCode - Error Code(integer format)
** Return:  The textual description that corresponds to the input error code 
**
** Description:
** Call the LMSGetErrorString function which will be implemented by the LMS, 
** if the LMS is compliant with the SCORM.
**
******************************************************************************************/
function LMSGetErrorString(errorCode) 
{
   var api = getAPIHandle();
   if (api == null)
   {
      alert(lang000 + "\n" + lang007);
   }

   return api.LMSGetErrorString(errorCode).toString();
   
} 

/******************************************************************************************
**
** Function LMSGetDiagnostic(errorCode) 
** Inputs:  errorCode - Error Code(integer format), or null
** Return:  The vendor specific textual description that corresponds to the input error code 
**
** Description:
** Call the LMSGetDiagnostic function which will be implemented by the LMS, 
** if the LMS is compliant with the SCORM.
**
******************************************************************************************/
function LMSGetDiagnostic(errorCode) 
{
   var api = getAPIHandle();
   if (api == null)
   {
      alert(lang000 + "\n" + lang008);
   }

   return api.LMSGetDiagnostic(errorCode).toString();
   
} 

/*******************************************************************************
**
** Function LMSIsInitialized() 
** Inputs:  none
** Return:  true if the LMS API is currently initialized, otherwise false 
**
** Description:
** Determines if the LMS API is currently initialized or not.
**
*******************************************************************************/
function LMSIsInitialized()
{
   // there is no direct method for determining if the LMS API is initialized
   // for example an LMSIsInitialized function defined on the API so we'll try
   // a simple LMSGetValue and trap for the LMS Not Initialized Error
   
   var api = getAPIHandle();
   if (api == null)
   {
      alert(lang000 + "\n" + lang009);
      // no choice but to return false.
      return false;
   }
   else
   {
      var value = api.LMSGetValue("cmi.core.student_name");
      var errCode = api.LMSGetLastError().toString();
      if (errCode == _NotInitialized)
      {
         return false;
      }
      else
      {
         return true;
      }
   }   
}

/******************************************************************************************
** APIWrapper Private function implementations
** Note: This is javascript so there is no way to really prevent someone 
**     from calling the other methods in this file, but they are really 
**     intended to be private methods.  Only the methods above
**       are intended to be called directly by the learning 
**       content components.
******************************************************************************************/

/******************************************************************************************
**
** Function ErrorHandler()
** Inputs:  None
** Return:  The current value of the LMS Error Code
**
** Description:
** Determines if an error was encountered by the previous API call
** and if so, displays a message to the user.  If the error code
** has associated text it is displayed.  
**
** Side Effects: Displays an alert window with the appropriate error information
**
******************************************************************************************/
function ErrorHandler() 
{
   var errCode = 0;

   if (bFinishDone == false)
   {
       var api = getAPIHandle();
       if (api == null)
       {
          alert(lang000 + "\n" + lang010);
          return;
       }

       // check for errors caused by or from the LMS
       errCode = api.LMSGetLastError().toString();

       if (errCode != _NoError)
       {
          // an error was encountered so display the error description
          var errDescription = api.LMSGetErrorString(errCode);

          if (_Debug == true)
          {
             errDescription += "\n";
             errDescription += api.LMSGetDiagnostic(null);
             // by passing null to LMSGetDiagnostic, we get any available diagnostics
             // on the previous error.
          }
          if (errCode != _NotImplementedError)
          {
             alert(errDescription);
          }
       }
   }
   return errCode;
}

/******************************************************************************************
**
** Function getAPIHandle()
** Inputs:  None
** Return:  value contained by APIHandle
**
** Description:
** Returns the handle to API object if it was previously set, 
** otherwise it returns null
**
******************************************************************************************/
function getAPIHandle() 
{
   if (apiHandle == null)
   {
      apiHandle = getAPI();
   } 
   return apiHandle;
}

function checkInFrames(win)
{

	for (var count=0; count < win.frames.length; count++)
	{
		if (win.frames[count].API != null)
		{
			//found API in this frame
			return result;
		}
		else
		{
			//Look in child frames
			checkInFrames(win.frames[count]);
		}
	}
	return null;
}

var findAPITries = 0;
function findAPI(win)
{			   
	findAPITries++;
	if (findAPITries > 7)
	{
	   alert("Error finding API -- too deeply nested.");
	   return null;
	}
	else
	{
		if (win.API != null)
		{
   			return win.API;
		}
		else if ((win.parent != null) && (win.parent != win))
		{
			//Look in parent object
			return findAPI(win.parent);
		}
		else
		{
			//Look in this object's frames.
			return checkInFrames(win);
		}
	}		
}

function getAPI()
{
   //first look for the API within this window
   var theAPI = findAPI(window);

   //If it's not found in this window, and the opener exists then look in there 
   if ((theAPI == null) && (top.opener != null) && (typeof(top.opener) != "undefined"))
   {
      theAPI = findAPI(top.opener);
   }
   if (theAPI == null)
   {
      alert("Unable to find an API adapter");
   }
   return theAPI;
}

function LZ(x)
{
   return(x<0||x>9?"":"0")+x;
}

function startTimer()
{
   return new Date();
}

function endTimer(starttime)
{
   var endtime=new Date();
   var totaltime=(endtime - starttime)/1000;
   var totalhours=Math.floor(totaltime/3600);
   var totalminutes=Math.floor((totaltime%3600)/60);
   var totalseconds=Math.floor(totaltime%60);
   return LZ(totalhours)+":"+LZ(totalminutes)+":"+LZ(totalseconds);
}

function secondsTimer(starttime) 
{
   var endtime=new Date();
   var totaltime=(endtime - starttime)/1000;
   return(totaltime);
}


//**********************************************************
// Flash specific functions
//**********************************************************


var testTimer;
var questionTimer;
var questionType;
var flashDebug = true;
var flashFinished = false;

//**********************************************************
//flashInit
//  Desc - Called at the start of a test from Flash
//
//  Language - Language value from XML file
//  QuestionCount - Total number of questions in the test
//  Return Values:
//       "ab-initio" - First time entering the test
//       "resume" - Test has been attempted but not finished
//       "" - Indicates all other conditions
//**********************************************************
function flashInit(Language, QuestionCount)
{
	try
	{
		var initResult = LMSInitialize();
		testTimer = startTimer();

		if (initResult.toString() == "1" || initResult.toString() == "true")
		{
			for (var ID = 1; ID <= QuestionCount; ID++)
				LMSSetValue("cmi.interactions." + (ID - 1) + ".id", ID);
			var status = LMSGetValue( "cmi.core.lesson_status" );
			if (status == "not attempted")
			{
				// the student is now attempting the lesson
				LMSSetValue( "cmi.core.lesson_status", "incomplete" );
			}
//			setFlashVariable("initResponse", "true");
			LMSSetValue("cmi.student_preference.language", Language);
			LMSSetValue("cmi.core.score.max", "100");
			LMSSetValue("cmi.core.score.min", "0");
			var entryValue = LMSGetValue("cmi.core.entry");
			if (entryValue != null)
				setFlashVariable("api_init", entryValue);
			else
				setFlashVariable("api_init", "");
			
		}
//		else
//		{
//			setFlashVariable("initResponse", "false");
//		}
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashInit:\n" + exception.toString());
	}
}


//**********************************************************
//flashBeginQuestion
//  Desc - Called at the start of each question from Flash
//
//  ID - ID value from XML file
//  Type - Type value from XML file
//  Correct_Response - Correct response value for question
//     Examples:  "true", "a", "the blank[,]the blanks",
//                "1[.]a[,]2[.]b[,]3[.]c"
//     Note:  Matching and choice can be letters or numbers
//  Weight - Weight value from XML file
//**********************************************************
function flashBeginQuestion(ID, Type, Correct_Response, Weight)
{
	try
	{
		questionTimer = startTimer();
		questionType = Type;
		var nID = ID - 1;
		switch(Type)
		{
			case "0":
				LMSSetValue("cmi.interactions." + nID + ".type", "true-false");
				break;
			case "1":
				LMSSetValue("cmi.interactions." + nID + ".type", "choice");
				break;
			case "2":
				LMSSetValue("cmi.interactions." + nID + ".type", "fill-in");
				break;
			case "3":
				LMSSetValue("cmi.interactions." + nID + ".type", "matching");
				break;
		}
		switch (Type)
		{
			case "0":
				LMSSetValue("cmi.interactions." + nID + ".correct_responses.0.pattern", Correct_Response.substring(0, 1).toLowerCase());
				break;
			case "1":
				LMSSetValue("cmi.interactions." + nID + ".correct_responses.0.pattern", Correct_Response);
				break;
			case "2":
				var aFillIns = Correct_Response.split("[,]");
				for (var i in aFillIns)
				{
					LMSSetValue("cmi.interactions." + nID + ".correct_responses." + i + ".pattern", aFillIns[i]);
				}
				break;
			case "3":
				LMSSetValue("cmi.interactions." + nID + ".correct_responses.0.pattern", xreplace(xreplace(Correct_Response, "[", ""), "]", ""));
				break;
		}
		LMSSetValue("cmi.interactions." + nID + ".weighting", Weight);
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashBeginQuestion:\n" + exception.toString());
	}
}


//**********************************************************
//flashEndQuestion
//  Desc - Called at the end of each question from Flash
//
//  ID - ID value from XML file
//  Result - Scoring result of student's response
//     Possible values - "correct", "incorrect", "neutral"
//  Student_Response - Response the student entered
//**********************************************************
function flashEndQuestion(ID, Result, Student_Response)
{
	try
	{
		var vDate = new Date();
		var nID = ID - 1;
		LMSSetValue("cmi.interactions." + nID + ".time", LZ(vDate.getHours())+":"+LZ(vDate.getMinutes())+":"+LZ(vDate.getSeconds()));
		if (Result.toLowerCase() == "incorrect")
			LMSSetValue("cmi.interactions." + nID + ".result", "wrong");
		else
			LMSSetValue("cmi.interactions." + nID + ".result", Result.toLowerCase());
		if (Student_Response != null && Student_Response != "")
			switch (questionType)
			{
				case "0":
					LMSSetValue("cmi.interactions." + nID + ".student_response", Student_Response.substring(0, 1).toLowerCase());
					break;
				case "3":
					LMSSetValue("cmi.interactions." + nID + ".student_response", xreplace(xreplace(Student_Response, "[", ""), "]", ""));
					break;
				default:
					LMSSetValue("cmi.interactions." + nID + ".student_response", Student_Response);
			}
		LMSSetValue("cmi.interactions." + nID + ".latency", endTimer(questionTimer));
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashEndQuestion:\n" + exception.toString());
	}
}


//**********************************************************
//flashFinish
//  Desc - Called at the end of a test from Flash
//
//  Score - Raw score of student's responses (0-100)
//**********************************************************
function flashFinish(Score)
{
	try
	{
		flashFinished = true;
		LMSSetValue("cmi.core.session_time", endTimer(testTimer));
		// Reinitialize Exit to blank
		LMSSetValue( "cmi.core.exit", "" );
		var mode = LMSGetValue( "cmi.core.lesson_mode" );
		//if cmi.core.lesson_mode is not implemented then mode will be returned as a null
		if ( mode != "review"  &&  mode != "browse" )
		{
			LMSSetValue("cmi.core.score.raw", Score);
			LMSSetValue("cmi.core.lesson_status", "completed" );
		}
		LMSCommit();

		// NOTE: LMSFinish will unload the current AU.  All processing
		//       relative to the current page must be performed prior
		//		 to calling LMSFinish.
		LMSFinish();
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashFinish:\n" + exception.toString());
	}
}


//**********************************************************
//flashFinish
//  Desc - Called on unload of Viewer.htm
//**********************************************************
function flashUnloadPage()
{
	try
	{
		if (!flashFinished)
		{
			flashFinished = true;
			LMSSetValue("cmi.core.session_time", endTimer(testTimer));
			// Reinitialize Exit to blank
			LMSSetValue( "cmi.core.exit", "suspend" );
			var mode = LMSGetValue( "cmi.core.lesson_mode" );
			//if cmi.core.lesson_mode is not implemented then mode will be returned as a null
			if ( mode != "review"  &&  mode != "browse" )
			{
				LMSSetValue("cmi.core.lesson_status", "incomplete" );
			}
			LMSCommit();

			// NOTE: LMSFinish will unload the current AU.  All processing
			//       relative to the current page must be performed prior
			//		 to calling LMSFinish.
			LMSFinish();
		}
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashUnloadPage:\n" + exception.toString());
	}
}


//**********************************************************
//flashLessonMode
//  Desc - Returns the current lesson mode from the LMS
//
//  Return Values:
//       "browse" - Student is previewing the material
//       "normal" - Student is taking test normally
//       "review" - Student has taken test and is reviewing
//**********************************************************
function flashLessonMode()
{
	try
	{
		var lessonMode = LMSGetValue("cmi.core.lesson_mode");
		if (lessonMode != null)
			setFlashVariable("api_lesson_mode", lessonMode);
		else
			setFlashVariable("api_lesson_mode", "");
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashLessonMode:\n" + exception.toString());
	}
}


//**********************************************************
//flashGetResponse
//  Desc - Returns the student's response to a question
//
//  ID - ID value from XML file
//  Return Value - Response the student entered previously
//**********************************************************
function flashGetResponse(ID)
{
	try
	{
		var nID = ID - 1;
		var stuResponse = LMSGetValue("cmi.interactions." + nID + ".student_response");
		if (stuResponse != null)
			setFlashVariable("api_user_response", stuResponse);
		else
			setFlashVariable("api_user_response", "");
	}
	catch(exception)
	{
		if(flashDebug)
			alert("Exception in flashGetResponse:\n" + exception.toString());
	}
}




function setFlashVariable(varName, varValue)
{
	try
	{
		window.document.Viewer.SetVariable(varName, varValue);
	}
	catch(exception)
	{
		//Unable to set the variable in Flash
	   if(flashDebug)
		   alert("Exception in setFlashVariable:\n" + exception.toString());
	}
}

function xreplace(inString, toReplace, replaceWith)
{
	var temp = inString;
	var i = temp.indexOf(toReplace);
	while(i > -1)
	{
		temp = temp.replace(toReplace, replaceWith);
		i = temp.indexOf(toReplace);
	}
	return temp;
}