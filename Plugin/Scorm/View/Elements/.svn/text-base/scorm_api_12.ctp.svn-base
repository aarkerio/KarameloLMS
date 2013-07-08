<html><body>
<?php
# Check if student is resuming this SCO
#die(debug($initVals));
echo $this->Html->script('jquery-min');  #  jQuery min library
?>
<script language="javascript">

// SCORM API 1.2 
function SCORMapi1_2() 
{ 
  // Standard Data Type Definition (Moodle Implementation )
  CMIString256    = '^[\\u0000-\\uffff]{0,255}$';
  CMIString4096   = '^[\\u0000-\\uffff]{0,4096}$';
  CMITime         = '^([0-2]{1}[0-9]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})(\.[0-9]{1,2})?$';
  CMITimespan     = '^([0-9]{2,4}):([0-9]{2}):([0-9]{2})(\.[0-9]{1,2})?$';
  CMIInteger      = '^\\d+$';
  CMISInteger     = '^-?([0-9]+)$';
  CMIDecimal      = '^-?([0-9]{0,3})(\.[0-9]{1,2})?$';
  CMIIdentifier   = '^\\w{1,255}$';
  CMIFeedback     = CMIString256;    // This must be redefined
  CMIIndex        = '[._](\\d+).';   // dot or underscore follow for one or more numbers 
  // Vocabulary Data Type Definition
  CMIStatus       = '^passed$|^completed$|^failed$|^incomplete$|^browsed$';
  CMIStatus2      = '^passed$|^completed$|^failed$|^incomplete$|^browsed$|^not attempted$';
  CMIExit         = '^time-out$|^suspend$|^logout$|^$';
  CMIType         = '^true-false$|^choice$|^fill-in$|^matching$|^performance$|^sequencing$|^likert$|^numeric$';
  CMIResult       = '^correct$|^wrong$|^unanticipated$|^neutral$|^([0-9]{0,3})?(\.[0-9]{1,2})?$';
  NAVEvent        = '^previous$|^continue$';
  // Children lists
  cmi_children                = 'core, suspend_data, launch_data, comments, objectives, student_data, student_preference, interactions';
  core_children               = 'student_id, student_name, lesson_location,credit,lesson_status,entry,score,total_time,lesson_mode, exit,session_time';
  score_children              = 'raw, max, min';
  comments_children           = 'content, location, time';
  objectives_children         = 'id, score, status';
  student_data_children       = 'mastery_score, max_time_allowed, time_limit_action';
  student_preference_children = 'audio, language, speed, text';
  interactions_children       = 'id, objectives, time, type, correct_responses, weighting, student_response, result, latency';
  correct_responses_children  = 'pattern';
  // Data ranges
  score_range     = '0#100';
  audio_range     = '-1#100';
  speed_range     = '-100#100';
  weighting_range = '-100#100';
  text_range      = '-1#1'; 
  
  // Hash table
  // The SCORM 1.2 data model
  var datamodel =  {
        'cmi._children':{'defaultvalue':cmi_children, 'mod':'r', 'writeerror':'402'},
        'cmi._version':{'defaultvalue':'3.4', 'mod':'r', 'writeerror':'402'},
        'cmi.core._children':{'defaultvalue':core_children, 'mod':'r', 'writeerror':'402'},
        // my Vars
        'cmi.core.student_id':{'defaultvalue':'<?php echo $initVals['cmi.core.student_id']; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.core.student_name':{'defaultvalue':'<?php echo $initVals['cmi.core.student_name']; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.core.lesson_location':{'defaultvalue':'<?php echo $initVals['cmi.core.lesson_location']; ?>', 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.credit':{'defaultvalue':'<?php echo $initVals['cmi.core.credit']; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.core.lesson_status':{'defaultvalue':'<?php echo $initVals['cmi.core.lesson_status']; ?>', 'format':CMIStatus, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.entry':{'defaultvalue':'<?php echo $initVals['cmi.core.entry']; ?>', 'mod':'r', 'writeerror':'403'},
        // SCORE
        'cmi.core.score._children':{'defaultvalue':score_children, 'mod':'r', 'writeerror':'402'},
        'cmi.core.score.raw':{'defaultvalue':'<?php echo $initVals['cmi.core.score.raw']; ?>', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.score.max':{'defaultvalue':'<?php echo $initVals['cmi.core.score.max']; ?>', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.score.min':{'defaultvalue':'<?php echo $initVals['cmi.core.score.min']; ?>', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.total_time':{'defaultvalue':'<?php echo $initVals['cmi.core.total_time']; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.core.lesson_mode':{'defaultvalue':'<?php echo $initVals['cmi.core.lesson_mode']; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.core.exit':{'defaultvalue':'<?php echo $initVals['cmi.core.exit']; ?>', 'format':CMIExit, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.core.session_time':{'format':CMITimespan, 'mod':'w', 'defaultvalue':'00:00:00', 'readerror':'404', 'writeerror':'405'},
        'cmi.suspend_data':{'defaultvalue':'<?php echo $initVals['cmi.suspend_data']; ?>', 'format':CMIString4096, 'mod':'rw', 'writeerror':'405'},
        'cmi.launch_data':{'defaultvalue':'<?php echo $initVals['cmi.launch_data']; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.comments':{'defaultvalue':'<?php echo $initVals['cmi.comments']; ?>', 'format':CMIString4096, 'mod':'rw', 'writeerror':'405'},
         // deprecated evaluation attributes
        'cmi.evaluation.comments._count':{'defaultvalue':'0', 'mod':'r', 'writeerror':'402'},
        'cmi.evaluation.comments._children':{'defaultvalue':comments_children, 'mod':'r', 'writeerror':'402'},
        'cmi.evaluation.comments.n.content':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.evaluation.comments.n.location':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.evaluation.comments.n.time':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMITime, 'mod':'rw', 'writeerror':'405'},
        'cmi.comments_from_lms':{'mod':'r', 'writeerror':'403'},
        'cmi.objectives._children':{'defaultvalue':objectives_children, 'mod':'r', 'writeerror':'402'},
        'cmi.objectives._count':{'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.objectives.n.id':{'pattern':CMIIndex, 'format':CMIIdentifier, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.score._children':{'pattern':CMIIndex, 'mod':'r', 'writeerror':'402'},
        'cmi.objectives.n.score.raw':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.score.min':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.score.max':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.status':{'pattern':CMIIndex, 'format':CMIStatus2, 'mod':'rw', 'writeerror':'405'},
        // Student data
        'cmi.student_data._children':{'defaultvalue':student_data_children, 'mod':'r', 'writeerror':'402'},
        'cmi.student_data.mastery_score':{'defaultvalue':'<?php echo $initVals['cmi.student_data.mastery_score'] ; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.student_data.max_time_allowed':{'defaultvalue':'<?php echo $initVals['cmi.student_data.max_time_allowed'] ; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.student_data.time_limit_action':{'defaultvalue':'<?php echo $initVals['cmi.student_data.time_limit_action'] ; ?>', 'mod':'r', 'writeerror':'403'},
        'cmi.student_preference._children':{'defaultvalue':student_preference_children, 'mod':'r', 'writeerror':'402'},
        'cmi.student_preference.audio':{'defaultvalue':'0', 'format':CMISInteger, 'range':audio_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_preference.language':{'defaultvalue':'', 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_preference.speed':{'defaultvalue':'0', 'format':CMISInteger, 'range':speed_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_preference.text':{'defaultvalue':'0', 'format':CMISInteger, 'range':text_range, 'mod':'rw', 'writeerror':'405'},
        // Interaction section
        'cmi.interactions._children':{'defaultvalue':interactions_children, 'mod':'r', 'writeerror':'402'},
        'cmi.interactions._count':{'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.interactions.n.id':{'pattern':CMIIndex, 'format':CMIIdentifier, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.objectives._count':{'pattern':CMIIndex, 'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.interactions.n.objectives.n.id':{'pattern':CMIIndex, 'format':CMIIdentifier, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.time':{'pattern':CMIIndex, 'format':CMITime, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.type':{'pattern':CMIIndex, 'format':CMIType, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.correct_responses._count':{'pattern':CMIIndex, 'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.interactions.n.correct_responses.n.pattern':{'pattern':CMIIndex, 'format':CMIFeedback, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.weighting':{'pattern':CMIIndex, 'format':CMIDecimal, 'range':weighting_range, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.student_response':{'pattern':CMIIndex, 'format':CMIFeedback, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.result':{'pattern':CMIIndex, 'format':CMIResult, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.latency':{'pattern':CMIIndex, 'format':CMITimespan, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'nav.event':{'defaultvalue':'', 'format':NAVEvent, 'mod':'w', 'readerror':'404', 'writeerror':'405'}
 };

 // Datamodel (children stuff) inizialization 
 var cmi                 = new Object();
 cmi.core                = new Object();
 cmi.core.score          = new Object();
 cmi.objectives          = new Object();
 cmi.student_data        = new Object();
 cmi.student_preference  = new Object();
 cmi.interactions        = new Object();
 // deprecated evaluation attributes
 cmi.evaluation          = new Object();
 cmi.evaluation.comments = new Object();
 // Navigation Object
 var nav                 = new Object();

 // loop datamodel in order to initialize and/or set default values if not set yet
 for (element in datamodel) 
 { 
   if (element.match(/\.n\./) == null)   // "n" kinds of element
   { 
      if ((typeof eval('datamodel["'+element+'"].defaultvalue')) != 'undefined') // actually implemented
      {
           eval(element+' = datamodel["'+element+'"].defaultvalue;');
      } else {
           eval(element+' = "";');
      }
    }
 }

 //alert();
 //console.debug(datamodel['cmi.core.student_name'].defaultvalue); 
 var Initialized = false;   // RTE boolean flag 
 var _debug      = true;

 // ====================================================
 // Execution State
 //
 // Initialize
 // According to SCORM 1.2 reference :
 //    - arg must be "" (empty string)
 //    - return value : true or false
 function LMSInitialize(arg)
 {
  if (_debug) alert("I am in LMSInitialize function");
  if ( arg == "" )
  {
     if (!Initialized) 
     {
       Initialized = true;
       errorCode   = '0';
       return 'true';
     } 
     else 
     {
       // alert('General Exception');
       errorCode = "101"; // General Exception
     }
  } 
  else 
  {
      if (_debug) alert('error_code 201:  ' + arg);
      errorCode = "201"; // Invalid argument error
  }
  return 'true';
 }

 // Finish
 // According to SCORM 1.2 reference
 //    - arg must be "" (empty string)
 //    - return value : true or false
 function LMSFinish(param) 
 {
     if (_debug) alert("I am in LMSFinish function");
     errorCode = "0";
     if (param == "") 
     {
         if (Initialized) 
         {
             Initialized = false;
             if (nav.event != '') 
             {
                 if (nav.event == 'continue') 
                 {
                     setTimeout('top.document.location=top.next;',500);
                 } 
                 else 
                 {
                     setTimeout('top.document.location=top.prev;',500);
                 }
             } 
             else 
             {
                 if (<?php echo '9'; ?> == 1) //  $scorm->auto  echo $scorm->auto ?? 
                 {
                     setTimeout('top.document.location=top.next;',500);
                 }
             }    
             if (_debug) alert("Finished SCORM 1.2");
             
             return "true";
         }
         else 
         {
             errorCode = "301";
         }
     }
     else 
     {
         errorCode = "201";
     }
     if (_debug)  alert('225. LMSFinish ' + param + ' ' + errorCode);
   
     return 'false';
 }
 
// ------------------------------------------
//   SCORM RTE Functions - Getting and Setting Values
// ------------------------------------------
 function LMSGetValue(element) 
 {
   if (_debug) alert("241. I am in LMSGetValue method and I am getting : \n" + element);
   errorCode = '0';
   if (Initialized) 
   {
      if (element != "") 
      {
         expression   = new RegExp(CMIIndex,'g');  // http://www.javascriptkit.com/jsref/regexp.shtml  .  'g' = Global search for all occurrences of a pattern
          // get the generic name for this element (e.g. convert 'cmi.interactions.1.id' to 'cmi.interactions.n.id')
         elementmodel = String(element).replace(expression,'.n.'); 
         if (_debug) alert('I am in LMSGetValue method and elementmodel after RegExp:  ' + elementmodel);

         // check if the current element exists in the datamodel
         if ((typeof eval('datamodel["'+elementmodel+'"]')) != 'undefined') // really is Implemented in data model
         {
             if (eval('datamodel["'+elementmodel+'"].mod') != 'w')  // Is not readonly 
             {
                 element = String(element).replace(expression, "_$1.");  // remove the n + $number section 
                 elementIndexes = element.split('.');                    // split
                 subelement = 'cmi';
                 i = 1;
                 while ((i < elementIndexes.length) && (typeof eval(subelement) != "undefined")) 
                 {
                     subelement += '.'+elementIndexes[i++];  
                 }
                 if (subelement == element) 
                 {
                     errorCode = "0"; 
                     if (_debug)  alert(element+": "+eval(element));
                     
                     return eval(element); // all is fine, return value and finish method
                 } 
                 else 
                 {
                     errorCode = "0"; // Need to check if it is the right errorCode
                 }
             } 
             else 
             {
                 errorCode = eval('datamodel["'+elementmodel+'"].readerror'); // Read only element and rise error
             }
         } 
         else //  generally send not implemented error, next lines will chek if is a multi element 
         {
             childrenstr = '._children';
             countstr    = '._count';
             if (elementmodel.substr(elementmodel.length-childrenstr.length,elementmodel.length) == childrenstr) // is children kind element?
             {
                 parentmodel = elementmodel.substr(0,elementmodel.length-childrenstr.length);
                 if ((typeof eval('datamodel["'+parentmodel+'"]')) != 'undefined') // error 401: not implemented 
                 {
                     errorCode = "202"; // Element cannot have children
                 } 
                 else
                 {
                     errorCode = "201"; // Invalid Argument Error
                 }
             } 
             else if (elementmodel.substr(elementmodel.length-countstr.length,elementmodel.length) == countstr) //determine the number of elements in array
             {
                 parentmodel = elementmodel.substr(0,elementmodel.length-countstr.length);
                 if ((typeof eval('datamodel["'+parentmodel+'"]')) != "undefined") 
                 {
                     errorCode = "203"; // error: Element not an array.  Cannot have count
                 } 
                 else    
                 {
                     errorCode = "201";  // Invalid Argument Error
                 }
             } 
             else 
             {
                 errorCode = "201";
             }
         }
    } 
    else 
    {
       errorCode = "201";
    }
   } 
   else 
   {
       errorCode = "301"; // Not initialized
   }
   return "";
 }
 
 function LMSSetValue(element, value)
 {
   if (_debug) alert ("Line 334. I am in LMSSetValue method: \n" + element +" "+ value);
   errorCode = "0";
   if (Initialized) 
   {
     if (element != "") 
     {
        expression = new RegExp(CMIIndex,'g');
        elementmodel = String(element).replace(expression,'.n.');
        if ((typeof eval('datamodel["'+elementmodel+'"]')) != "undefined") // actually implemented 
        {
         // make sure this is not a read only element
         if (eval('datamodel["'+elementmodel+'"].mod') != 'r')  // Element is not read only 
         {
              expression = new RegExp(eval('datamodel["'+elementmodel+'"].format')); // Scorm Data Type
              value = value+''; // ??
              matches = value.match(expression);
              if (matches != null) // Match!! 
              {
                    if (element != elementmodel)   // Create dynamic data model element
                    {
                          elementIndexes = element.split('.');
                          subelement     = 'cmi';
                          for (i=1;i < elementIndexes.length-1;i++) 
                          {
                                 elementIndex = elementIndexes[i];
                                 if (elementIndexes[i+1].match(/^\d+$/)) 
                                 {
                                        if ((typeof eval(subelement+'.'+elementIndex)) == 'undefined') 
                                        {
                                            eval(subelement+'.'+elementIndex+' = new Object();');
                                            eval(subelement+'.'+elementIndex+'._count = 0;'); // array is 0
                                        }
                                        
                                        if (elementIndexes[i+1] == eval(subelement+'.'+elementIndex+'._count')) 
                                        {
                                            eval(subelement+'.'+elementIndex+'._count++;');
                                        } 
                                        if (elementIndexes[i+1] > eval(subelement+'.'+elementIndex+'._count')) 
                                        {
                                            errorCode = "201";
                                        }
                                        subelement = subelement.concat('.'+elementIndex+'_'+elementIndexes[i+1]);
                                        i++;
                                  } 
                                  else 
                                  {
                                        subelement = subelement.concat('.'+elementIndex);
                                  }

                                  if ((typeof eval(subelement)) == "undefined") 
                                  {
                                        eval(subelement+' = new Object();');
                                        if (subelement.substr(0,14) == 'cmi.objectives') 
                                        {
                                            eval(subelement+'.score = new Object();');
                                            eval(subelement+'.score._children = score_children;');
                                            eval(subelement+'.score.raw = "";');
                                            eval(subelement+'.score.min = "";');
                                            eval(subelement+'.score.max = "";');
                                        }
                                        if (subelement.substr(0,16) == 'cmi.interactions')
                                        {
                                            eval(subelement+'.objectives = new Object();');
                                            eval(subelement+'.objectives._count = 0;');
                                            eval(subelement+'.correct_responses = new Object();');
                                            eval(subelement+'.correct_responses._count = 0;');
                                        }
                                }
                            }
                            element = subelement.concat('.'+elementIndexes[elementIndexes.length-1]);
                        }
                        //Store data
                        if (errorCode == "0") 
                        {
                                if ((typeof eval('datamodel["'+elementmodel+'"].range')) != "undefined") // if element have range statement
                                {
                                    range  = eval('datamodel["'+elementmodel+'"].range');
                                    ranges = range.split('#');
                                    value  = value*1.0; // get positive value
                                    if ((value >= ranges[0]) && (value <= ranges[1])) // Check if range is valid
                                    {
                                        eval(element+'=value;'); // build url chain
                                        // update the element default to reflect the current committed value
                                        datamodel[elementmodel].defaultvalue=value;
                                        errorCode = "0";
                                        if (_debug)  alert('403. I am in LMSSetValue in StoreData section: element and value:   ' + element+":= "+value);
               
                                        return "true";
                                    } 
                                    else 
                                    {
                                        errorCode = eval('datamodel["'+elementmodel+'"].writeerror'); // range is wrong
                                    }

                                } 
                                else // no range
                                {
                                    if (element == 'cmi.comments') 
                                    {
                                        cmi.comments = cmi.comments + value;
                                    }
                                    else 
                                    {
                                        eval(element+'=value;'); // build url chain
                                        datamodel[elementmodel].defaultvalue=value;
                                    }
                                    errorCode = "0";
                                    
                                    if (_debug) alert(element+":= "+value);
               
                                    return "true";
                                }
                            }
                        } else {
                            errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                        }
                    } else {
                        errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                    }
                } else {
                    errorCode = "201"
                }
            } else {
                errorCode = "201"; // 
            }
        } else {
            errorCode = "301"; // Not implemented
        }
    return "false";
 }

 function LMSCommit(param) 
 {
   result    = false;
   errorCode = "0";
   if (param == "") 
   {
     if (Initialized) 
     {
         result = doCommit();
         if (_debug)  alert("Data Commited: " + result);
         return "true";
     } 
     else 
     {
         errorCode = '301';
     }
   } 
   else 
   {
     errorCode = '201';
   }

   if (result){
       return "true";
   }else{
       return "false";
   }
 }

 // ====================================================
 // State Management
 function LMSGetLastError() 
 {
    if (_debug) alert(' LMSGetLastError: ' + errorCode);
    return errorCode;
 }    

 function LMSGetErrorString(param) 
 {
  if (param != "") 
  {
      var errorString = new Array();
      errorString["0"]   = "No error";
      errorString["101"] = "General exception";
      errorString["201"] = "Invalid argument error";
      errorString["202"] = "Element cannot have children";
      errorString["203"] = "Element not an array - cannot have count";
      errorString["301"] = "Not initialized";
      errorString["401"] = "Not implemented error";
      errorString["402"] = "Invalid set value, element is a keyword";
      errorString["403"] = "Element is read only";
      errorString["404"] = "Element is write only";
      errorString["405"] = "Incorrect data type";
      return errorString[param];
   } 
   else 
   {
      return "";
   }
 }
    
 function LMSGetDiagnostic(param) 
 {
  if (param == "") 
  {
    param = errorCode;
  }  
  return param;
 }

 // jQuery to save in Model
 // void boolean
 function doCommit()
 {
  if (datamodel['cmi.core.lesson_status'].defaultvalue == 'not attempted') 
  {
      datamodel['cmi.core.lesson_status'].defaultvalue = 'completed';
  }
  if (datamodel['cmi.core.lesson_mode'].defaultvalue == 'normal') 
  {
      if (datamodel['cmi.core.credit'].defaultvalue == 'credit') 
      {
          if ( datamodel['cmi.student_data.mastery_score'].defaultvalue != '' && datamodel['cmi.core.score.raw'].defaultvalue != '') 
          {
              if (parseFloat(datamodel['cmi.core.score.raw'].defaultvalue) >= parseFloat(datamodel['cmi.student_data.mastery_score'].defaultvalue)) 
              {
                            datamodel['cmi.core.lesson_status'].defaultvalue  = 'passed';
              } else {
                            datamodel['cmi.core.lesson_status'].defaultvalue  = 'failed';
              }
          }
      }
  }
  if (datamodel['cmi.core.lesson_mode'].defaultvalue == 'browse') 
  {
      if (datamodel['cmi.core.lesson_status'].defaultvalue == '' && datamodel['cmi.core.lesson_status'].defaultvalue == 'not attempted') 
      {
           datamodel['cmi.core.lesson_status'].defaultvalue = 'browsed';
      }
  }
 
  var d = new Date();
  // we want to store the values from the form input box, then send via ajax below
  var data  = "lesson_location=" + datamodel['cmi.core.lesson_location'].defaultvalue;
      data += '&sco_id=<?php echo $initVals['sco_id']; ?>';
      data += '&scorm_id=<?php echo $initVals['scorm_id']; ?>';
      data += '&vclassroom_id=<?php echo $initVals['vclassroom_id']; ?>';
      data += '&code='+d.getTime();
      data += "&lesson_status="   + datamodel['cmi.core.lesson_status'].defaultvalue; 
      data += "&lesson_mode="     + datamodel['cmi.core.lesson_mode'].defaultvalue;
      data += "&entry="           + datamodel['cmi.core.entry'].defaultvalue;
      data += "&raw="             + datamodel['cmi.core.score.raw'].defaultvalue;
      data += "&credit="          + datamodel['cmi.core.credit'].defaultvalue;
      data += "&mastery_score="   + datamodel['cmi.student_data.mastery_score'].defaultvalue;
      data += "&total_time="      + datamodel['cmi.core.total_time'].defaultvalue;
      data += "&session_time="    + datamodel['cmi.core.session_time'].defaultvalue;
      data += "&suspend_data="    + datamodel['cmi.suspend_data'].defaultvalue;
      data += "&scoreMin="        + datamodel['cmi.core.score.min'].defaultvalue;
      data += "&scoreMax="        + datamodel['cmi.core.score.max'].defaultvalue;
       
  //$('div.success').fadeIn();
  $.ajax({
              type: "POST",
              url: "/scorm/scorms/save",
              data: data,
              success: function(){
              //$('form#submit').hide();
              $('#scoframe1', parent.document).attr('src', '/scorm/scorms/finish/');
              //$('#scoframe1', parent.document).html(data);
          }
      });
  return true;
 }
 
 this.LMSInitialize     = LMSInitialize;
 this.LMSFinish         = LMSFinish;
 this.LMSGetValue       = LMSGetValue;
 this.LMSSetValue       = LMSSetValue;
 this.LMSCommit         = LMSCommit;
 this.LMSGetLastError   = LMSGetLastError;
 this.LMSGetErrorString = LMSGetErrorString;
 this.LMSGetDiagnostic  = LMSGetDiagnostic;
}
 var API = new SCORMapi1_2();
  parent.setApi(API);
</script>
</body>
</html>