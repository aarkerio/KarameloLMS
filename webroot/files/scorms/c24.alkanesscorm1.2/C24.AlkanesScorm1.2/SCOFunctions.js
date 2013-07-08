<!--SCOFunctions.js-->

/*******************************************************************************
**
** Concurrent Technologies Corporation (CTC) grants you ("Licensee") a non-
** exclusive, royalty free, license to use, modify and redistribute this
** software in source and binary code form, provided that i) this copyright
** notice and license appear on all copies of the software; and ii) Licensee
** does not utilize the software in a manner which is disparaging to CTC.
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
** OR INABILITY TO USE SOFTWARE, EVEN IF CTC  HAS BEEN ADVISED OF THE
** POSSIBILITY OF SUCH DAMAGES.
**
*******************************************************************************/
var startDate;
var scoTimer;
var exitPageStatus = false;
var bookmarkSupport = true;

function loadPage()
{
   LMSInitialize();
   var status = LMSGetValue( "cmi.core.lesson_status" );

   if (status == "not attempted")
   {
	  // the student is now attempting the lesson
	  LMSSetValue( "cmi.core.lesson_status", "incomplete" );
   }

   exitPageStatus = false;
   scoTimer = startTimer();
}

function showTrial()
{
}

function loadProducerPage()
{
   scoTimer = startTimer();
}

function doContinue( status )
{
   // Reinitialize Exit to blank
   LMSSetValue( "cmi.core.exit", "" );
   var mode = LMSGetValue( "cmi.core.lesson_mode" );
   //if cmi.core.lesson_mode is not implemented then mode will be returned as a null
   if ( mode != "review"  &&  mode != "browse" )
   {
      if(status == "completed")
      {
          var totalTime = secondsTimer(scoTimer);
          if(totalTime >=  10)
             LMSSetValue( "cmi.core.lesson_status", status );
      }
      else
          LMSSetValue( "cmi.core.lesson_status", status );
   }
   exitPageStatus = true;
   LMSSetValue("cmi.core.session_time", endTimer(scoTimer));
   LMSCommit();

	// NOTE: LMSFinish will unload the current AU.  All processing
	//       relative to the current page must be performed prior
	//		 to calling LMSFinish.   
   LMSFinish();

}

function doQuit()
{
   LMSSetValue( "cmi.core.exit", "" );

   exitPageStatus = true;   
   LMSSetValue("cmi.core.session_time", endTimer(scoTimer));
   LMSCommit();

	// NOTE: LMSFinish will unload the current AU.  All processing
	//       relative to the current page must be performed prior
	//		 to calling LMSFinish.   

   LMSFinish();
}


function unloadPage()
{
/*******************************************************************************
** The purpose of this function is to handle cases where the current AU may be 
** unloaded via some user action other than using the navigation controls 
** embedded in the content.   This function will be called every time an AU
** is unloaded.  If the user has caused the page to be unloaded through the
** preferred AU control mechanisms, the value of the "exitPageStatus" var
** will be true so we'll just allow the page to be unloaded.   If the value
** of "exitPageStatus" is false, we know the user caused to the page to be
** unloaded through use of some other mechanism... most likely the back
** button on the browser.  We'll handle this situation the same way we 
** would handle a "quit" - as in the user pressing the AU's quit button.
*******************************************************************************/

	if (exitPageStatus == false)
	{
		doQuit();
	}

	// NOTE:  don't return anything that resembles a javascript
	//		  string from this function or IE will take the
	//		  liberty of displaying a confirm message box.
	
}

// These functions are in place to allow Producer created content to function
// without being modified
function doContinueNoFinish( status )
{
   // Reinitialize Exit to blank
   LMSSetValue( "cmi.core.exit", "" );
   var mode = LMSGetValue( "cmi.core.lesson_mode" );
   //if cmi.core.lesson_mode is not implemented then mode will be returned as a null
   if ( mode != "review"  &&  mode != "browse" )
   {
      if(status == "completed")
      {
          var totalTime = secondsTimer(scoTimer);
          if(totalTime >=  10)
             LMSSetValue( "cmi.core.lesson_status", status );
      }
      else
          LMSSetValue( "cmi.core.lesson_status", status );
   }
   exitPageStatus = true;
   LMSSetValue("cmi.core.session_time", endTimer(scoTimer));
   LMSCommit();

	// NOTE: LMSFinish will unload the current AU.  All processing
	//       relative to the current page must be performed prior
	//		 to calling LMSFinish.   
   //LMSFinish();

}

function doQuitNoFinish()
{
   LMSSetValue( "cmi.core.exit", "" );

   exitPageStatus = true;   
   LMSSetValue("cmi.core.session_time", endTimer(scoTimer));
   LMSCommit();

	// NOTE: LMSFinish will unload the current AU.  All processing
	//       relative to the current page must be performed prior
	//		 to calling LMSFinish.   

   //LMSFinish();
}

function rtnBookMark()
{
	if (bookmarkSupport)
	{
		var loc = LMSGetValue("cmi.core.lesson_location");
		if (loc != "" && loc != null)
		{
			try
			{
				//Try a PPT/word bookmark
				parent.frames[0].frames[1].location.href = loc;
			}
			catch(exception)
			{
				try
				{
					//try an html bookmark
					parent.frames[0].location.href = loc;
				}
				catch(exception)
				{
					alert(lang015);
				}
			}
		}
		else
		{
			var lastErr = LMSGetLastError();
			switch (lastErr)
			{
				case "0":    //0 = no error
					alert(lang016);
					break;
				case "401":
					alert(lang017);
					bookmarkSupport = false;
					break;
				default:
					alert(LMSGetErrorString(lastErr));
					break;
			}
		}
	}
	else
	{
		alert(lang017);
	}
}

function doBookMark()
{
	if (bookmarkSupport)
	{
		try{
			//Firstly attempt to get a PPT 2002+ Href for the current slide
			var sID = parent.frames[0].frames[1].GetSldId();
			try
			{
				var sID2 = parent.frames[0].location.href + "#" + sID;
				LMSSetValue("cmi.core.lesson_location", sID );
				if (checkBookmarkSupport())
				{
					LMSCommit();
				}
			}
			catch(exception)
			{
				//Bookmarks cannot be applied to a single page presentation
			}
		}
		catch(exception)
		{
			try
			{
				//Now try to get a PPT2000 Href for the current page
				var current = parent.frames[0].PPTSld.location.href;
				sId = current;
				LMSSetValue("cmi.core.lesson_location", sId );
				if (checkBookmarkSupport())
				{
					LMSCommit();
				}
			}
			catch(exception)
			{
				try
				{
					//Now try to get a Word Href for the current page
					var current = parent.frames[0].frames[1].location.href;
					sId = current;
					LMSSetValue("cmi.core.lesson_location", sId );
					if (checkBookmarkSupport())
					{
						LMSCommit();
					}
				}
				catch(exception)
				{

					try
					{
						//Now try to get just the href for the current page
						var current = parent.frames[0].location.href;
						sId = current;
						//var arrLoc = current.split("/");
						//var l = arrLoc.length;
						//var sId = arrLoc[l-1];
						LMSSetValue("cmi.core.lesson_location", sId );
						if (checkBookmarkSupport())
						{
							LMSCommit();
						}
					}
					catch(exception)
					{
						alert(lang018);
						//Bookmarks cannot be applied to a single page presentation
					}
				}
			}	
		}	
	}
	else
	{
		alert(lang017);
	}
}

function checkBookmarkSupport()
{
	//check the error status to see if it's supported.
	var lastErr = LMSGetLastError();
	var retVal = false;
	switch (lastErr)
	{
		case "0":    //0 = no error
			retVal = true; 
			break;
		case "401":
			alert(lang017);
			bookmarkSupport = false;
			break;
		default:
			alert(LMSGetErrorString(lastErr));
			break;
	}
	return retVal;
}

