
<!-- saved from url=(0088)http://oku.edu.mie-u.ac.jp/repos/miemoodle/moodle16/mod/scorm/datamodels/scorm1_3.js.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"><style>.tooltiptrolol { position: relative; cursor: help; text-decoration: none;} .tooltiptrolol span { display: none; position: absolute; top: 15px; left: 10px; padding: 5px; z-index: 100; background: #000; color: #fff; border-radius: 5px; box-shadow: 2px 2px rgba(0, 0, 0, 0.1); text-align: center; line-width: 1000px; text-indent: 0; font: normal bold 10px/13px Tahoma,sans-serif; white-space: nowrap;} span:hover.tooltiptrolol { font-size: 99%; } .tooltiptrolol:hover span { display: block; } .md img { display:inline; } .rageface { visibility:visible; }</style></head><body><pre style="word-wrap: break-word; white-space: pre-wrap;">&lt;?php
    if (isset($userdata-&gt;status)) {
        if ($userdata-&gt;status == '') {
            $userdata-&gt;entry = 'ab-initio';
        } else {
            if (isset($userdata-&gt;{'cmi.exit'}) &amp;&amp; ($userdata-&gt;{'cmi.exit'} == 'suspend')) {
                $userdata-&gt;entry = 'resume';
            } else {
                $userdata-&gt;entry = '';
            }
        }
    }
?&gt;
//
// SCORM 1.3 API Implementation
//
function SCORMapi1_3() {
    // Standard Data Type Definition
    CMIString200 = '^.{0,200}$';
    CMIString250 = '^.{0,250}$';
    CMIString1000 = '^.{0,1000}$';
    CMIString4000 = '^.{0,4000}$';
    CMITime = '^(\\d{4})(-\\d{2})(-\\d{2})(T[0-2]{1}[0-9]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})(\\.[0-9]{1,2})?(Z|(-?[0-1]{1}[0-9]{1})(:[0-5]{1}[0-9]{1})?)?$';
    CMITimespan = '^P(\\d+Y)?(\\d+M)?(\\d+D)?(T(\\d+H)?(\\d+M)?(\\d+(\.\\d{1,2})?S)?)?$';
    CMIInteger = '^\\d+$';
    CMISInteger = '^-?([0-9]+)$';
    CMIDecimal = '^-?([0-9]{0,3})(\\.[0-9]{1,7})?$';
    CMIIdentifier = '^\\w{1,200}$';
    CMILongIdentifier = '^\\w{1,4000}$';
    CMIFeedback = CMIString200; // This must be redefined
    CMIIndex = '[._](\\d+).';
    // Vocabulary Data Type Definition
    CMICStatus = '^completed$|^incomplete$|^not attempted$|^unknown$';
    CMISStatus = '^passed$|^failed$|^unknown$';
    CMIExit = '^time-out$|^suspend$|^logout$|^$';
    CMIType = '^true-false$|^choice$|^fill-in$|^matching$|^performance$|^sequencing$|^likert$|^numeric$';
    CMIResult = '^correct$|^wrong$|^unanticipated$|^neutral$|^([0-9]{0,3})?(\\.[0-9]{1,2})?$';
    NAVEvent = '^previous$|^continue$';
    // Children lists
    cmi_children = 'version, comments_from_learner, comments_from_lms, completion_status, credit, entry, exit, interactions, launch_data, learner_id, learner_name, learner_preference, location, max_time_allowed, mode, objectives, progress_measure, scaled_passing_score, score, session_time, success_status, suspend_data, time_limit_action, total_time';
    comments_children = 'comment, location, date_time';
    score_children = 'scaled, raw, min, max';
    objectives_children = 'id, score, success_status, completion_status, description';
    student_data_children = 'mastery_score, max_time_allowed, time_limit_action';
    student_preference_children = 'audio_level, language, delivery_speed, audio_caption';
    interactions_children = 'id, type, objectives, timestamp, correct_responses, weighting, learner_response, result, latency, description';
    // Data ranges
    scaled_range = '-1#1';
    audio_range = '0#*';
    speed_range = '0#*';
    text_range = '-1#1';
    progress_range = '0#1';
    // The SCORM 1.3 data model
    var datamodel =  {
        'cmi._children':{'defaultvalue':cmi_children, 'mod':'r'},
        'cmi.version':{'defaultvalue':'1.0', 'mod':'r'},
        'cmi.comments_from_learner._children':{'defaultvalue':comments_children, 'mod':'r'},
        'cmi.comments_from_learner._count':{'mod':'r', 'defaultvalue':'0'},
        'cmi.comments_from_learner.n.comment':{'format':CMIString4000, 'mod':'rw'},
        'cmi.comments_from_learner.n.location':{'format':CMIString250, 'mod':'rw'},
        'cmi.comments_from_learner.n.date_time':{'format':CMITime, 'mod':'rw'},
        'cmi.comments_from_lms._children':{'defaultvalue':comments_children, 'mod':'r'},
        'cmi.comments_from_lms._count':{'mod':'r', 'defaultvalue':'0'},
        'cmi.comments_from_lms.n.comment':{'format':CMIString4000, 'mod':'r'},
        'cmi.comments_from_lms.n.location':{'format':CMIString250, 'mod':'r'},
        'cmi.comments_from_lms.n.date_time':{'format':CMITime, 'mod':'r'},
        'cmi.completion_status':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.completion_status'})?$userdata-&gt;{'cmi.completion_status'}:'unknown' ?&gt;', 'format':CMICStatus, 'mod':'rw'},
        'cmi.completion_threshold':{'defaultvalue':&lt;?php echo isset($userdata-&gt;threshold)?'\''.$userdata-&gt;threshold.'\'':'null' ?&gt;, 'mod':'r'},
        'cmi.credit':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;credit)?$userdata-&gt;credit:'' ?&gt;', 'mod':'r'},
        'cmi.entry':{'defaultvalue':'&lt;?php echo $userdata-&gt;entry ?&gt;', 'mod':'r'},
        'cmi.exit':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.exit'})?$userdata-&gt;{'cmi.exit'}:'' ?&gt;', 'format':CMIExit, 'mod':'w'},
        'cmi.interactions._children':{'defaultvalue':interactions_children, 'mod':'r'},
        'cmi.interactions._count':{'mod':'r', 'defaultvalue':'0'},
        'cmi.interactions.n.id':{'pattern':CMIIndex, 'format':CMILongIdentifier, 'mod':'rw'},
        'cmi.interactions.n.type':{'pattern':CMIIndex, 'format':CMIType, 'mod':'rw'},
        'cmi.interactions.n.objectives._count':{'pattern':CMIIndex, 'mod':'r', 'defaultvalue':'0'},
        'cmi.interactions.n.objectives.n.id':{'pattern':CMIIndex, 'format':CMILongIdentifier, 'mod':'rw'},
        'cmi.interactions.n.timestamp':{'pattern':CMIIndex, 'format':CMITime, 'mod':'rw'},
        'cmi.interactions.n.correct_responses._count':{'defaultvalue':'0', 'pattern':CMIIndex, 'mod':'r'},
        'cmi.interactions.n.correct_responses.n.pattern':{'pattern':CMIIndex, 'format':CMIFeedback, 'mod':'rw'},
        'cmi.interactions.n.weighting':{'pattern':CMIIndex, 'format':CMIDecimal, 'mod':'rw'},
        'cmi.interactions.n.learner_response':{'pattern':CMIIndex, 'format':CMIFeedback, 'mod':'rw'},
        'cmi.interactions.n.result':{'pattern':CMIIndex, 'format':CMIResult, 'mod':'rw'},
        'cmi.interactions.n.latency':{'pattern':CMIIndex, 'format':CMITimespan, 'mod':'rw'},
        'cmi.interactions.n.description':{'pattern':CMIIndex, 'format':CMIString250, 'mod':'rw'},
        'cmi.launch_data':{'defaultvalue':&lt;?php echo isset($userdata-&gt;datafromlms)?'\''.$userdata-&gt;datafromlms.'\'':'null' ?&gt;, 'mod':'r'},
        'cmi.learner_id':{'defaultvalue':'&lt;?php echo $userdata-&gt;student_id ?&gt;', 'mod':'r'},
        'cmi.learner_name':{'defaultvalue':'&lt;?php echo addslashes($userdata-&gt;student_name) ?&gt;', 'mod':'r'},
        'cmi.learner_preference._children':{'defaultvalue':student_preference_children, 'mod':'r'},
        'cmi.learner_preference.audio_level':{'defaultvalue':'0', 'format':CMIDecimal, 'range':audio_range, 'mod':'rw'},
        'cmi.learner_preference.language':{'defaultvalue':'', 'format':CMIString250, 'mod':'rw'},
        'cmi.learner_preference.delivery_speed':{'defaultvalue':'0', 'format':CMIDecimal, 'range':speed_range, 'mod':'rw'},
        'cmi.learner_preference.audio_caption':{'defaultvalue':'0', 'format':CMISInteger, 'range':text_range, 'mod':'rw'},
       	'cmi.location':{'defaultvalue':&lt;?php echo isset($userdata-&gt;{'cmi.location'})?'\''.$userdata-&gt;{'cmi.location'}.'\'':'null' ?&gt;, 'format':CMIString1000, 'mod':'rw'},
        'cmi.max_time_allowed':{'defaultvalue':&lt;?php echo isset($userdata-&gt;maxtimeallowed)?'\''.$userdata-&gt;maxtimeallowed.'\'':'null' ?&gt;, 'mod':'r'},
        'cmi.mode':{'defaultvalue':'&lt;?php echo $userdata-&gt;mode ?&gt;', 'mod':'r'},
        'cmi.objectives._children':{'defaultvalue':objectives_children, 'mod':'r'},
        'cmi.objectives._count':{'mod':'r', 'defaultvalue':'0'},
        'cmi.objectives.n.id':{'pattern':CMIIndex, 'format':CMILongIdentifier, 'mod':'rw'},
        'cmi.objectives.n.score._children':{'pattern':CMIIndex, 'mod':'r'},
        'cmi.objectives.n.score.scaled':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':scaled_range, 'mod':'rw'},
        'cmi.objectives.n.score.raw':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'mod':'rw'},
        'cmi.objectives.n.score.min':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'mod':'rw'},
        'cmi.objectives.n.score.max':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'mod':'rw'},
        'cmi.objectives.n.success_status':{'defaultvalue':'unknown', 'pattern':CMIIndex, 'format':CMISStatus, 'mod':'rw'},
        'cmi.objectives.n.completion_status':{'defaultvalue':'unknown', 'pattern':CMIIndex, 'format':CMISStatus, 'mod':'rw'},
        'cmi.objectives.n.description':{'pattern':CMIIndex, 'format':CMIString250, 'mod':'rw'},
        'cmi.progress_measure':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.progess_measure'})?$userdata-&gt;{'cmi.progress_measure'}:'' ?&gt;', 'format':CMIDecimal, 'range':progress_range, 'mod':'rw'},
        'cmi.scaled_passing_score':{'defaultvalue':&lt;?php echo isset($userdata-&gt;mnm)?'\''.$userdata-&gt;mnm.'\'':'null' ?&gt;, 'format':CMIDecimal, 'range':scaled_range, 'mod':'r'},
        'cmi.score._children':{'pattern':CMIIndex, 'mod':'r'},
        'cmi.score.scaled':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.score.scaled'})?$userdata-&gt;{'cmi.score.scaled'}:'' ?&gt;', 'format':CMIDecimal, 'range':scaled_range, 'mod':'rw'},
        'cmi.score.raw':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.score.raw'})?$userdata-&gt;{'cmi.score.raw'}:'' ?&gt;', 'format':CMIDecimal, 'mod':'rw'},
        'cmi.score.min':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.score.min'})?$userdata-&gt;{'cmi.score.min'}:'' ?&gt;', 'format':CMIDecimal, 'mod':'rw'},
        'cmi.score.max':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.score.max'})?$userdata-&gt;{'cmi.score.max'}:'' ?&gt;', 'format':CMIDecimal, 'mod':'rw'},
        'cmi.session_time':{'format':CMITimespan, 'mod':'w', 'defaultvalue':'PT0H0M0S'},
        'cmi.success_status':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.success_status'})?$userdata-&gt;{'cmi.success_status'}:'unknown' ?&gt;', 'format':CMISStatus, 'mod':'rw'},
        'cmi.suspend_data':{'defaultvalue':&lt;?php echo isset($userdata-&gt;{'cmi.suspend_data'})?'\''.$userdata-&gt;{'cmi.suspend_data'}.'\'':'null' ?&gt;, 'format':CMIString4000, 'mod':'rw'},
        'cmi.time_limit_action':{'defaultvalue':&lt;?php echo isset($userdata-&gt;timelimitaction)?'\''.$userdata-&gt;timelimitaction.'\'':'null' ?&gt;, 'mod':'r'},
        'cmi.total_time':{'defaultvalue':'&lt;?php echo isset($userdata-&gt;{'cmi.total_time'})?$userdata-&gt;{'cmi.total_time'}:'PT0H0M0S' ?&gt;', 'mod':'r'},
        'nav.event':{'defaultvalue':'', 'format':NAVEvent, 'mod':'w'}
    };
    //
    // Datamodel inizialization
    //
    var cmi = new Object();
        cmi.comments_from_learner = new Object();
        cmi.comments_from_lms = new Object();
        cmi.interactions = new Object();
        cmi.learner_preference = new Object();
        cmi.objectives = new Object();
        cmi.score = new Object();

    // Navigation Object
    var nav = new Object();

    for (element in datamodel) {
        if (element.match(/\.n\./) == null) {
            if ((typeof eval('datamodel["'+element+'"].defaultvalue')) != 'undefined') {
                eval(element+' = datamodel["'+element+'"].defaultvalue;');
            } else {
                eval(element+' = "";');
            }
        }
    }

&lt;?php
    $count = 0;
    $objectives = '';
    foreach($userdata as $element =&gt; $value){
        if (substr($element,0,14) == 'cmi.objectives') {
            preg_match('/.(\d+)./',$element,$matches);
            $element = preg_replace('/.(\d+)./',"_\$1.",$element);
            if ($matches[1] == $count) {
                $count++;
                $end = strpos($element,$matches[1])+strlen($matches[1]);
                $subelement = substr($element,0,$end);
                echo '    '.$subelement." = new Object();\n";
                echo '    '.$subelement.".score = new Object();\n";
                echo '    '.$subelement.".score._children = score_children;\n";
                echo '    '.$subelement.".score.scaled = '';\n";
                echo '    '.$subelement.".score.raw = '';\n";
                echo '    '.$subelement.".score.min = '';\n";
                echo '    '.$subelement.".score.max = '';\n";
            }
            echo '    '.$element.' = \''.$value."';\n";
        }
    }
    if ($count &gt; 0) {
        echo '    cmi.objectives._count = '.$count.";\n";
    }
?&gt;

    if (cmi.completion_status == '') {
        cmi.completion_status = 'not attempted';
    } 
    
    //
    // API Methods definition
    //
    var Initialized = false;
    var Terminated = false;
    var diagnostic = "";

    function Initialize (param) {
        errorCode = "0";
        if (param == "") {
            if ((!Initialized) &amp;&amp; (!Terminated)) {
                &lt;?php 
                    if (($CFG-&gt;debug &gt; 7) &amp;&amp; (isadmin())) {
                        echo 'alert("Initialized SCORM 1.3");';
                    }
                ?&gt;
                Initialized = true;
                errorCode = "0";
                return "true";
            } else {
                if (Initializated) {
                    errorCode = "103";
                } else {
                    errorCode = "104";
                }
            }
        } else {
            errorCode = "201";
        }
        return "false";
    }
    
    function Terminate (param) {
        errorCode = "0";
        if (param == "") {
            if ((Initialized) &amp;&amp; (!Terminated)) {
                &lt;?php 
                    if (($CFG-&gt;debug &gt; 7) &amp;&amp; (isadmin())) {
                        echo 'alert("Terminated SCORM 1.3");';
                    }
                ?&gt;
                Initialized = false;
                Terminated = true;
                result = StoreData(cmi,true);
                if (nav.event != '') {
                    if (nav.event == 'continue') {
                        setTimeout('top.nextSCO();',500);
                    } else {
                        setTimeout('top.prevSCO();',500);
                    }
                } else {
                    if (&lt;?php echo $scorm-&gt;auto ?&gt; == 1) {
                        setTimeout('top.nextSCO();',500);
                    }
                }    
                return "true";
            } else {
                if (Terminated) {
                    errorCode = "113";
                } else {
                    errorCode = "112";
                }
            }
        } else {
            errorCode = "201";
        }
        return "false";
    }
    
    function GetValue (element) {
        errorCode = "0";
        diagnostic = "";
        if ((Initialized) &amp;&amp; (!Terminated)) {
            if (element !="") {
                expression = new RegExp(CMIIndex,'g');
                elementmodel = element.replace(expression,'.n.');
                if ((typeof eval('datamodel["'+elementmodel+'"]')) != "undefined") {
                    if (eval('datamodel["'+elementmodel+'"].mod') != 'w') {
                        element = element.replace(expression, "_$1.");
                        elementIndexes = element.split('.');
                        subelement = 'cmi';
                        i = 1;
                        while ((i &lt; elementIndexes.length) &amp;&amp; (typeof eval(subelement) != "undefined")) {
                            subelement += '.'+elementIndexes[i++];
                        }
                        if (subelement == element) {
                            errorCode = "0";
                            &lt;?php 
                                if (($CFG-&gt;debug &gt; 7) &amp;&amp; (isadmin())) {
                                    echo 'alert(element+": "+eval(element));';
                                }
                            ?&gt;
                            return eval(element);
                        } else {
                            errorCode = "0"; // Need to check if it is the right errorCode
                        }
                    } else {
                        //errorCode = eval('datamodel["'+elementmodel+'"].readerror');
                        errorCode = "405";
                    }
                } else {
                    childrenstr = '._children';
                    countstr = '._count';
                    if (elementmodel.substr(elementmodel.length-childrenstr.length,elementmodel.length) == childrenstr) {
                        parentmodel = elementmodel.substr(0,elementmodel.length-childrenstr.length);
                        if ((typeof eval('datamodel["'+parentmodel+'"]')) != "undefined") {
                            errorCode = "301";
                            diagnostic = "Data Model Element Does Not Have Children";
                        } else {
                            errorCode = "401";
                        }
                    } else if (elementmodel.substr(elementmodel.length-countstr.length,elementmodel.length) == countstr) {
                        parentmodel = elementmodel.substr(0,elementmodel.length-countstr.length);
                        if ((typeof eval('datamodel["'+parentmodel+'"]')) != "undefined") {
                            errorCode = "301";
                            diagnostic = "Data Model Element Cannot Have Count";
                        } else {
                            errorCode = "401";
                        }
                    } else {
                        errorCode = "401";
                    }
                }
            } else {
                errorCode = "301";
            }
        } else {
            if (Terminated) {                
                errorCode = "123";
            } else {
                errorCode = "122";
            }
        }
        return "";
    }
    
    function SetValue (element,value) {
        errorCode = "0";
        diagnostic = "";
        if ((Initialized) &amp;&amp; (!Terminated)) {
            if (element != "") {
                expression = new RegExp(CMIIndex,'g');
                elementmodel = element.replace(expression,'.n.');
                if ((typeof eval('datamodel["'+elementmodel+'"]')) != "undefined") {
                    if (eval('datamodel["'+elementmodel+'"].mod') != 'r') {
                        expression = new RegExp(eval('datamodel["'+elementmodel+'"].format'));
                        value = value+'';
                        matches = value.match(expression);
                        if (matches != null) {
                            //Create dynamic data model element
                            if (element != elementmodel) {
                                elementIndexes = element.split('.');
                                subelement = 'cmi';
                                for (i=1;i &lt; elementIndexes.length-1;i++) {
                                    elementIndex = elementIndexes[i];
                                    if (elementIndexes[i+1].match(/^\d+$/)) {
                                        if ((typeof eval(subelement+'.'+elementIndex)) == "undefined") {
                                            eval(subelement+'.'+elementIndex+' = new Object();');
                                            eval(subelement+'.'+elementIndex+'._count = 0;');
                                        }
                                        if (elementIndexes[i+1] == eval(subelement+'.'+elementIndex+'._count')) {
                                            eval(subelement+'.'+elementIndex+'._count++;');
                                        } 
                                        if (elementIndexes[i+1] &gt; eval(subelement+'.'+elementIndex+'._count')) {
                                            errorCode = "351";
                                            diagnostic = "Data Model Element Collection Set Out Of Order";
                                        }
                                        subelement = subelement.concat('.'+elementIndex+'_'+elementIndexes[i+1]);
                                        i++;
                                    } else {
                                        subelement = subelement.concat('.'+elementIndex);
                                    }
                                    if ((typeof eval(subelement)) == "undefined") {
                                        eval(subelement+' = new Object();');
                                        if (subelement.substr(0,14) == 'cmi.objectives') {
                                            eval(subelement+'.score = new Object();');
                                            eval(subelement+'.score._children = score_children;');
                                            eval(subelement+'.score.scaled = "";');
                                            eval(subelement+'.score.raw = "";');
                                            eval(subelement+'.score.min = "";');
                                            eval(subelement+'.score.max = "";');
                                        }
                                        if (subelement.substr(0,16) == 'cmi.interactions') {
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
                            if (errorCode == "0") {
                                if ((typeof eval('datamodel["'+elementmodel+'"].range')) != "undefined") {
                                    range = eval('datamodel["'+elementmodel+'"].range');
                                    ranges = range.split('#');
                                    value = value*1.0;
                                    if (value &gt;= ranges[0]) {
                                        if ((ranges[1] == '*') || (value &lt;= ranges[1])) {
                                            eval(element+'="'+value+'";');
                                            errorCode = "0";
                                            &lt;?php 
                                                if (($CFG-&gt;debug &gt; 7) &amp;&amp; (isadmin())) {
                                                    echo 'alert(element+":= "+value);';
                                                }
                                            ?&gt;
                                            return "true";
                                        } else {
                                            errorCode = '407';
                                        }
                                    } else {
                                        errorCode = '407';
                                    }
                                } else {
                                    eval(element+'="'+value+'";');
                                    errorCode = "0";
                                    &lt;?php 
                                        if (($CFG-&gt;debug &gt; 7) &amp;&amp; (isadmin())) {
                                            echo 'alert(element+":= "+value);';
                                        }
                                    ?&gt;
                                    return "true";
                                }
                            }
                        } else {
                            //errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                            errorCode = "406";
                        }
                    } else {
                        //errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                        errorCode = "404";
                    }
                } else {
                    errorCode = "401"
                }
            } else {
                errorCode = "351";
            }
        } else {
            if (Terminated) {
                errorCode = "133";
            } else {
                errorCode = "132";
            }
        }
        return "false";
    }
    
    function Commit (param) {
        errorCode = "0";
        if (param == "") {
            if ((Initialized) &amp;&amp; (!Terminated)) {
                result = StoreData(cmi,false);
                &lt;?php 
                    if (($CFG-&gt;debug &gt; 7) &amp;&amp; (isadmin())) {
                        echo 'alert("Data Commited");';
                    }
                ?&gt;
                return "true";
            } else {
                if (Terminated) {
                    errorCode = "143";
                } else {
                    errorCode = "142";
                }
            }
        } else {
            errorCode = "201";
        }
        return "false";
    }
    
    function GetLastError () {
        return errorCode;
    }
    
    function GetErrorString (param) {
        if (param != "") {
            var errorString = new Array();
            errorString["0"] = "No error";
            errorString["101"] = "General exception";
            errorString["102"] = "General Inizialization Failure";
            errorString["103"] = "Already Initialized";
            errorString["104"] = "Content Instance Terminated";
            errorString["111"] = "General Termination Failure";
            errorString["112"] = "Termination Before Inizialization";
            errorString["113"] = "Termination After Termination";
            errorString["122"] = "Retrieve Data Before Initialization";
            errorString["123"] = "Retrieve Data After Termination";
            errorString["132"] = "Store Data Before Inizialization";
            errorString["133"] = "Store Data After Termination";
            errorString["142"] = "Commit Before Inizialization";
            errorString["143"] = "Commit After Termination";
            errorString["201"] = "General Argument Error";
            errorString["301"] = "General Get Failure";
            errorString["351"] = "General Set Failure";
            errorString["391"] = "General Commit Failure";
            errorString["401"] = "Undefinited Data Model";
            errorString["402"] = "Unimplemented Data Model Element";
            errorString["403"] = "Data Model Element Value Not Initialized";
            errorString["404"] = "Data Model Element Is Read Only";
            errorString["405"] = "Data Model Element Is Write Only";
            errorString["406"] = "Data Model Element Type Mismatch";
            errorString["407"] = "Data Model Element Value Out Of Range";
            errorString["408"] = "Data Model Dependency Not Established";
            return errorString[param];
        } else {
           return "";
        }
    }
    
    function GetDiagnostic (param) {
        if (param == "") {
            return diagnostic;
        }
        return param;
    }

    function AddTime (first, second) {
        var timestring = 'P';
        var matchexpr = /^P((\d+)Y)?((\d+)M)?((\d+)D)?(T((\d+)H)?((\d+)M)?((\d+(\.\d{1,2})?)S)?)?$/;
        var firstarray = first.match(matchexpr);
        var secondarray = second.match(matchexpr);
        if ((firstarray != null) &amp;&amp; (secondarray != null)) {
            var secs = parseFloat(firstarray[13],10)+parseFloat(secondarray[13],10);  //Seconds
            change = Math.floor(secs / 60);
            secs = secs - (change * 60);
            mins = parseInt(firstarray[11],10)+parseInt(secondarray[11],10)+change;   //Minutes
            change = Math.floor(mins / 60);
            mins = mins - (change * 60);
            hours = parseInt(firstarray[10],10)+parseInt(secondarray[10],10)+change;  //Hours
            change = Math.floor(hours / 24);
            hours = hours - (change * 24);
            days = parseInt(firstarray[6],10)+parseInt(secondarray[6],10)+change; // Days
            months = parseInt(firstarray[4],10)+parseInt(secondarray[4],10)
            years = parseInt(firstarray[2],10)+parseInt(secondarray[2],10)
        }
        if (years &gt; 0) {
            timestring += years + 'Y';
        }
        if (months &gt; 0) {
            timestring += months + 'M';
        }
        if (days &gt; 0) {
            timestring += days + 'D';
        }
        if ((hours &gt; 0) || (mins &gt; 0) || (secs &gt; 0)) {
            timestring += 'T';
            if (hours &gt; 0) {
                timestring += hours + 'H';
            }
            if (mins &gt; 0) {
                timestring += mins + 'M';
            }
            if (secs &gt; 0) {
                timestring += secs + 'S';
            }
        }
        return timestring;
    }

    function TotalTime() {
        total_time = AddTime(cmi.total_time, cmi.session_time);
        return '&amp;'+underscore('cmi.total_time')+'='+escape(total_time);
    }

    function CollectData(data,parent) {
        var datastring = '';
        for (property in data) {
            if (typeof data[property] == 'object') {
                datastring += CollectData(data[property],parent+'.'+property);
            } else {
                element = parent+'.'+property;
                expression = new RegExp(CMIIndex,'g');
                elementmodel = element.replace(expression,'.n.');
                if ((typeof eval('datamodel["'+elementmodel+'"]')) != "undefined") {
                    if (eval('datamodel["'+elementmodel+'"].mod') != 'r') {
                        elementstring = '&amp;'+underscore(element)+'='+escape(data[property]);
                        if ((typeof eval('datamodel["'+elementmodel+'"].defaultvalue')) != "undefined") {
                            if (eval('datamodel["'+elementmodel+'"].defaultvalue') != data[property]) {
                                datastring += elementstring;
                            }
                        } else {
                            datastring += elementstring;
                        }
                    }
                }
            }
        }
        return datastring;
    }

    function StoreData(data,storetotaltime) {
        if (storetotaltime) {
            if (cmi.mode == 'normal') {
                if (cmi.credit == 'credit') {
                    if ((cmi.completion_threshold != null) &amp;&amp; (cmi.progress_measure != '')) {
                        if (cmi.progress_measure &gt;= cmi.completion_threshold) {
                            cmi.completion_status = 'completed';
                        } else {
                            cmi.completion_status = 'incomplete';
                        }
                    }
                    if ((cmi.scaled_passed_score != null) &amp;&amp; (cmi.score.scaled != '')) {
                        if (cmi.score.scaled &gt;= cmi.scaled_passed_score) {
                            cmi.success_status = 'passed';
                        } else {
                            cmi.success_status = 'failed';
                        }
                    }
                }
            }
            datastring = CollectData(data,'cmi');
            datastring += TotalTime();
        } else {
            datastring = CollectData(data,'cmi');
        }
        datastring += '&amp;attempt=&lt;?php echo $attempt ?&gt;';
        datastring += '&amp;scoid=&lt;?php echo $sco-&gt;id ?&gt;';
        //popupwin(datastring);
        var myRequest = NewHttpReq();
        result = DoRequest(myRequest,"&lt;?php p($CFG-&gt;wwwroot) ?&gt;/mod/scorm/datamodel.php","id=&lt;?php p($id) ?&gt;&amp;sesskey=&lt;?php p($USER-&gt;sesskey) ?&gt;"+datastring);
        results = result.split('\n');
        errorCode = results[1];
        return results[0];
    }
    
    this.Initialize = Initialize;
    this.Terminate = Terminate;
    this.GetValue = GetValue;
    this.SetValue = SetValue;
    this.Commit = Commit;
    this.GetLastError = GetLastError;
    this.GetErrorString = GetErrorString;
    this.GetDiagnostic = GetDiagnostic;
}

var API_1484_11 = new SCORMapi1_3();
</pre></body></html>