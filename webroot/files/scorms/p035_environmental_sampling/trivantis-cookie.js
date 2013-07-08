/**************************************************
Trivantis (http://www.trivantis.com)
**************************************************/
function saveVariable(name,value,days,title) {
  var titleMgr = getTitleMgrHandle();
  var expires = ""
  
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000))
    expires = "; expires="+date.toGMTString()
  }
  
  var encValue = escape( value )
  
  // Find the cookie
  var myCookie = (days ? 'LectoraPermCookie' : 'LectoraTempCookie' )
  if( title )
    myCookie += '_' + title
    
  var nameEQ = '|' + name + "="
  var ca = document.cookie.split(';')
  var i,j
  var last = 0
  var lastVal = null
  var saveId = -1

  for(i=0;i<ca.length;i++) 
  {
    var c = ca[i];
    for( j = 0;j<c.length;j++)
    {
      if( c.charAt(j) != ' ' )
        break
    }
    c = c.substring(j);
    if( c.indexOf(myCookie) == 0 )
    {
      var ce=c.indexOf('=')
      last = parseInt( c.substring( myCookie.length, ce ))
      var vo = c.indexOf(nameEQ) 
      if( vo >= 0 )
      {
        var start=c.substring(ce+1,vo)
        var mid=c.substring(vo+nameEQ.length)
        var end=mid.indexOf( '|' )
        mid = mid.substring( end )
        lastVal = start + mid
        saveId = last
        break
      }
      else
      {
        lastVal = c.substring( ce + 1 )
      }
    }
  }
  
  if( titleMgr )
  {
    titleMgr.setVariable(name,value,days)
    if( !document.TitleMgr )
      return
  }
  
  var newVal = nameEQ+encValue+"|"
  if( lastVal != null && (lastVal.length + newVal.length < 4000) )
  {
      if( lastVal )
        lastVal = lastVal.substring( 0, lastVal.length - 1 )
      if( days < 0 )
        newVal = null
      var cookieName = myCookie + last
      document.cookie = cookieName+"="+lastVal+newVal+expires+"; path=/"
  }
  else
  {
      if( lastVal != null && saveId != -1 ) {
        var oldCookie = myCookie + saveId
        document.cookie = oldCookie+"="+lastVal+expires+"; path=/"
      }
      var cookieName = myCookie + (last+1)
      document.cookie = cookieName+"="+newVal+expires+"; path=/"
  }
}

function readVariable(name,defval,days,title) {
  var titleMgr = getTitleMgrHandle();
  if( titleMgr == null || titleMgr.findVariable( name ) < 0 )
  {
    var myCookie = (days ? 'LectoraPermCookie' : 'LectoraTempCookie' )
    if( title )
      myCookie += '_' + title
    var nameEQ = '|' + name + "="
    var ca = document.cookie.split(';')
    var i,j
  
    for(i=0;i<ca.length;i++) 
    {
      var c = ca[i];
      for( j = 0;j<c.length;j++)
      {
        if( c.charAt(j) != ' ' )
          break
      }
      c = c.substring(j);
      if( c.indexOf(myCookie) == 0 )
      {
        var vo = c.indexOf(nameEQ) 
        if( vo >= 0 )
        {
          var val=c.substring(vo+nameEQ.length)
          var ve =val.indexOf( '|' )
  
          val = unescape( val.substring(0,ve) )
        
          if( titleMgr )
            titleMgr.setVariable(name,val,days)
          return val
        }
      }
    }
  }
  
  if( titleMgr ) {
    var res = new String( titleMgr.getVariable(name,defval,days) )
    return unescape( res )
  }
  return defval
}

function cleanupTitle( title ) {
  if( window.name.indexOf( 'Trivantis_' ) == -1 ) {
    var date = new Date();
    date.setTime(date.getTime()+(-1*24*60*60*1000))
    var expires = "; expires="+date.toGMTString()

    var myCookie = 'LectoraTempCookie'
    if( title )
      myCookie += '_' + title
    for( var i = 1; i < 21; i++ )
    {
      var name = myCookie + i
      if( readCookie( name, '' ) != '' )
        document.cookie = name + "=" + expires + "; path=/"
      else
        break
    }
    return 1;
  }
  else
    return 0;
}

// Variable Object
function Variable(name,defval,f,cm,frame,days,title) {
  this.origAICC = false
  this.bSCORM = false
  this.of=f
  this.f=f
  this.eTS=null
  this.tV=null
  this.aiccframe=frame
  this.aiccgroup=null
  this.aicccore=false
  this.exp=days
  this.defVal=defval
  this.cm=0
  this.title=title
  if( cm ) {
    this.cm = -1 * cm
    if(name=='CM_Course_ID')this.name='TrivantisCourse'
    else if(name=='CM_Course_Name')this.name='TrivantisCourseName'
    else if(name=='CM_Student_ID')this.name='TrivantisLogin'
    else if(name=='CM_Student_Name')this.name='TrivantisLoginName'
    else {
      this.name=name
      this.cm = cm
    }
  }
  else if( frame ) {
    var underPos = name.indexOf('AICC_')
    if( underPos == 0 ) {
      this.origAICC = true
      this.name=name.substring(5)
      if( frame == 'scorm' ) {
        this.bSCORM = true
        this.aiccgroup = 'cmi'
        this.name = this.name.toLowerCase()
        var core_check = this.name.substring(0,5)
        if( core_check == 'core_' ) this.name = this.name.substring(5)
        if(this.name=='lesson') this.name='cmi.suspend_data'
        else if(this.name=='vendor') this.name='cmi.launch_data'
        else if(this.name=='time') this.name='cmi.core.total_time'
        else if(this.name=='score') this.name='cmi.core.score.raw'
        else this.name = 'cmi.core.' + this.name
      }
      else if( frame == 'scorm2004' ) {
        this.bSCORM = true
        this.aiccgroup = 'cmi'
        this.name = this.name.toLowerCase()
        var core_check = this.name.substring(0,5)
        if( core_check == 'core_' ) this.name = this.name.substring(5)
        if(this.name=='lesson') this.name='cmi.suspend_data'
        else if(this.name=='vendor') this.name='cmi.launch_data'
        else if(this.name=='time') this.name='cmi.total_time'
        else if(this.name=='score') this.name='cmi.score.raw'
        else if(this.name=='course_id')this.name='cmi.evaluation.course_id'
        else if(this.name=='lesson_id')this.name='cmi.core.lesson_id'
        else if(this.name=='student_id')this.name='cmi.learner_id'
        else if(this.name=='student_name')this.name='cmi.learner_name'
        else if(this.name=='lesson_location')this.name='cmi.location'
        else if(this.name=='lesson_status')this.name='cmi.success_status'
        else this.name = 'cmi.' + this.name
      }
      else if(this.name=='Core_Lesson') {
        this.aiccgroup='[CORE_LESSON]'
      }
      else if(this.name=='Core_Vendor') {
        this.aiccgroup='[CORE_VENDOR]'
      }
      else if(this.name=='Course_ID') {
        this.aiccgroup='[EVALUATION]'
      }
      else {
        this.aiccgroup='[CORE]'
        this.aicccore=true
      }
      if( !this.bSCORM ) this.update()
    }
    else {
      if( frame == 'scorm' ) this.bSCORM = true
      if( name.indexOf('CMI_Core') == 0 ) {
        this.origAICC = true
        this.aiccgroup='cmi'
        if( name == 'CMI_Core_Entry' ) {
          this.name='cmi.core.entry'
          this.update()
        }
        else {
          this.name='cmi.core.exit'
          this.value=this.defVal
        }
      }
      else if ( name == 'CMI_Completion_Status' ) {
        if( frame == 'scorm2004' ) this.bSCORM = true
        this.origAICC = true
        this.aiccgroup='cmi'
        this.name='cmi.completion_status'
        this.update()
      }
      else {
        this.name = name
      }
    }
  }
  else {
    this.name=name;
  }
  if( this.f == 4 ) this.uDT()
}

function VarUpdateValue() {
  if( this.cm ) {
    if( this.cm < 0 ) {
      this.defVal=readCookie(this.name,this.defVal)
      this.cm *= -1
    }
    var titleMgr = getTitleMgrHandle();
    if( titleMgr ) this.value=titleMgr.getVariable(this.name,this.defVal,this.exp);
    else this.value=this.defVal
  }
  else if( this.aiccframe ) {
    var titleMgr = getTitleMgrHandle();
    if( this.origAICC ) {
      if( this.bSCORM ) {
        if( this.name=='cmi.evaluation.course_id' ) this.value=this.defVal
        else if( this.name=='cmi.core.lesson_id' ) this.value=this.defVal
        else if( this.name!='cmi.core.exit' && this.name != 'cmi.exit' ) this.value=LMSGetValue( this.name )
        if( titleMgr ) {
          titleMgr.setVariable(this.name,this.value,this.exp)
          if( this.name=='cmi.learner_id' ) titleMgr.setVariable('cmi.core.student_id',this.value,this.exp)
          if( this.name=='cmi.learner_name' ) titleMgr.setVariable('cmi.core.student_name',this.value,this.exp)
          if( this.name=='cmi.core.total_time' || this.name=='cmi.total_time' ) this.value = UpdateSCORMTotalTime( this.value )
        }
      }
      else if(this.name=='Core_Lesson') {
        this.value=getParam(this.aiccgroup)
      }
      else if(this.name=='Core_Vendor') {
        this.value=getParam(this.aiccgroup)
      }
      else if(this.name=='Course_ID') {
        this.value=getParam(this.name)
      }
      else {
        this.value=getParam(this.name)
      }
    }
    else {
      if( this.bSCORM ) {
        this.value=this.defVal
        if( titleMgr && titleMgr.findVariable( this.name ) != -1 ){
            this.value=titleMgr.getVariable(this.name,this.defVal,this.exp)
        } else {
          var data=LMSGetValue( 'cmi.suspend_data' )
          if( data == '' ) {
            if( titleMgr ) titleMgr.setVariable(this.name,this.value,this.exp)
          }
          else {
            var ca = data.split(';')
            for(var i=0;i<ca.length;i++) {
              var c = ca[i];
              if( c.indexOf('=') >= 0 ) {
                ce = c.split('=')
                if( this.name == ce[0] ) this.value = ce[1]
                if( titleMgr ) titleMgr.setVariable(ce[0],ce[1],this.exp)
              }
            }
          }
        }
      }
      else {
        if( titleMgr ) this.value=titleMgr.getVariable(this.name,this.defVal,this.exp)
        else this.value = this.defVal
      }
    }
  }
  else if( this.f > 0 ) {
    this.uDT()
  }
  else {
    var val = readVariable(this.name,this.defVal,this.exp,this.title)
    var subval = val ? val.substr( 0, 7 ) : null
    if( subval == "~~f=1~~" ) {
      this.tV = parseInt( val.substr( 7, val.length-7 ))
      this.f = 1
      this.uDTV()
    }
    else if( subval == "~~f=2~~" ) {
      this.tV = parseInt( val.substr( 7, val.length-7 ))
      this.f = 2
      this.uDTV()
    }
    else if( subval == "~~f=4~~" ) {
      var now = new Date()
      this.tV = parseInt( val.substr( 7, val.length-7 ))
      this.eTS = now.getTime() - this.tV
      this.f = 4
      this.uDTV()
    }
    else this.value=val
  }
  if( this.value == null || this.value == '' ) this.value = "~~~null~~~"
}

function VarSave() {
  if(this.cm) {
    var titleMgr = getTitleMgrHandle();
    if( titleMgr ) titleMgr.setVariable(this.name,this.value,this.exp)
  }
  else if(this.aiccframe){
    var titleMgr = getTitleMgrHandle();
    if( this.bSCORM ) {
      if( this.name == 'cmi.core.total_time' || this.name == 'cmi.total_time' ) {
        if( this.aiccframe == 'scorm' ) {
          LMSSetValue( 'cmi.core.session_time', this.value )
          if( titleMgr ) titleMgr.setVariable('cmi.core.session_time',this.value,this.exp)
        }
        else {
          LMSSetValue( 'cmi.session_time', this.value )
          if( titleMgr ) titleMgr.setVariable('cmi.session_time',this.value,this.exp)
        }
      }
      else {
        if( titleMgr ) titleMgr.setVariable(this.name,this.value,this.exp)
        if( this.aiccgroup ) {
          LMSSetValue( this.name, this.value )
          if( this.name == 'cmi.score.raw' ){
            var scaled = this.value / 100
            LMSSetValue( 'cmi.score.scaled', scaled )
          }
        }
        else {
          var nameEQ = this.name + "="
          var newData= nameEQ + this.value + ';'
          var bErr = false;
          var data=LMSGetValue( 'cmi.suspend_data' )
          if( data != '' ) {
            var ca = data.split(';')
            for(var i=0;i<ca.length;i++) {
              var c = ca[i];
              if (c != '' && c.indexOf(nameEQ) != 0) {
                if( newData.length + c.length + 1 < 4096 )
                  newData = newData + c + ';'
                else
                  bErr = true;
              }
            }
          }
          if( bErr )
            alert( 'Some of the persistent data was not able to be stored' )
          LMSSetValue( 'cmi.suspend_data', newData )
        }
      }
    }
    else {
      if(this.aicccore) putParam(this.aiccgroup,this.name+'='+this.value,this.aiccframe)
      else if( this.aiccgroup ) putParam(this.aiccgroup,this.value,this.aiccframe)
      else {
        if( titleMgr ) titleMgr.setVariable(this.name,this.value,this.exp)
        saveVariable(this.name,this.value,this.exp,this.title)
      }
    }
  }
  else{
    if( this.f != 0 && this.tV >= 0 ) {
      if( this.f == 4 ) saveVariable( this.name, "~~f=4~~" + this.tV + '#' + this.value, this.exp, this.title )
      else if ( this.f == 2 ) saveVariable( this.name, "~~f=2~~" + this.tV + '#' + this.value, this.exp, this.title )
      else if ( this.f == 1 ) saveVariable( this.name, "~~f=1~~" + this.tV + '#' + this.value, this.exp, this.title )
    } 
    else if( this.value == null || this.value == "" ) saveVariable( this.name, "~~~null~~~", this.exp, this.title )
    else saveVariable(this.name,this.value,this.exp,this.title)
  }
}

function VarSet(setVal) {
  if( setVal == null || setVal == "" ) this.value = "~~~null~~~"
  else this.value=setVal 
  this.save() 
}

function VarSetVar(setVar) {
  if( setVar.f > 0 ) setVar.uDT()
  else setVar.update()
  this.value = setVar.value
  this.f = setVar.f
  this.eTS = setVar.eTS
  this.tV = setVar.tV
  this.save() 
}

function VarAdd(addVal) {
  this.update()
  if ( this.f > 0 && !isNaN( addVal )) { 
    this.tV += CalcTD( this.f, addVal )
    this.uDTV()             
  } 
  else if( this.value == "~~~null~~~" ) {
    this.f = 0
    if( addVal != null && addVal != "" ) this.value = addVal
  }
  else {
    this.f = 0
    if( addVal != null && addVal != "" ) {
      if(!isNaN(this.value)&&!isNaN(addVal)&&!isNaN( parseFloat(addVal))&&!isNaN( parseFloat(this.value)) ) {
        var val=parseFloat(this.value)+parseFloat(addVal)
        if( addVal.indexOf( "." ) != -1 && this.value.indexOf( "." ) != -1 )
            val = (parseInt(val*100000000))/100000000
        this.value=val.toString()
      }
      else this.value+=addVal;
    }
  }
  this.save()
}

function VarAddVar(addVar) {
  if( addVar.f > 0 ) {
    addVar.uDT()
    if( this.f > 0 ) {
      this.tV += addVar.tV
      if( addVar.f == 1 ) this.f = 1
        this.uDTV()
    }
    else this.add( addVar.value )
  }
  else {
    addVar.update()
    this.add( addVar.value )
  }
}

function VarSub(subVal) {
  this.update()
  if ( this.f > 0 && !isNaN( subVal )) {
    this.tV -= CalcTD( this.f, subVal )
    this.uDTV()            
  }
  else if( this.value == "~~~null~~~" ) {
    this.f = 0
    if( !isNaN(subVal)&&!isNaN(parseFloat(subVal) ) ) {
      var val=this.value=parseFloat("-"+subVal)
      this.value=val.toString()
    }
  }
  else {
    this.f = 0
    if( subVal != null && subVal != "" ) {
      if(!isNaN(this.value)&&!isNaN(subVal)&&!isNaN( parseFloat(subVal))&&!isNaN( parseFloat(this.value)) ) {
        var val=parseFloat(this.value)-parseFloat(subVal)
        if( subVal.indexOf( "." ) != -1 && this.value.indexOf( "." ) != -1 )
            val = (parseInt(val*100000000))/100000000
        this.value=val.toString()
      }    
      else if( this.value.length >= subVal.length && this.value.substr( this.value.length - subVal.length) == subVal ) {
        this.value=this.value.substr( 0, this.value.length - subVal.length )
      }
    }
  }
  this.save()
}

function VarSubVar(subVar) {
  if( subVar.f > 0 ) {
    subVar.uDT()
    if( this.f > 0 ) {
      this.tV -= subVar.tV
      if( subVar.f == 1 ) this.f = 1
      this.uDTV()
    }
    else this.sub( subVar.value )
  }
  else {
    subVar.update()
    this.sub( subVar.value )
  }
}

function VarMult(multVal) {
  this.update()
  if( this.value != "~~~null~~~" ) {
    if(!isNaN(this.value)&&!isNaN(multVal)&&!isNaN( parseFloat(multVal))&&!isNaN( parseFloat(this.value)) ) {
      var val=parseFloat(this.value)*parseFloat(multVal)
      if( multVal.indexOf( "." ) != -1 && this.value.indexOf( "." ) != -1 )
        val = (parseInt(val*100000000))/100000000
      this.value=val.toString()
    }
    this.save()
  }
}

function VarDiv(divVal) {
  this.update()
  if( this.value != "~~~null~~~" ) {
    if(!isNaN(this.value)&&!isNaN(divVal)&&!isNaN( parseFloat(divVal))&&!isNaN( parseFloat(this.value)) ) {
      if( parseFloat(divVal) != 0 ) {
        var val=parseFloat(this.value)/parseFloat(divVal)
        val = parseInt( val*100 )
        val = parseFloat( val/100 )
        if( divVal.indexOf( "." ) != -1 && this.value.indexOf( "." ) != -1 )
          val = (parseInt(val*100000000))/100000000
        this.value=val.toString()
      }
    }
    this.save()
  }
}

function VarCont(strCont) {
  this.update()
  if( this.value == "~~~null~~~" || this.value == "" ) return 0
  var src=this.value.toUpperCase()
  var test=strCont.toUpperCase()
  var result=src.indexOf( test )
  return (result >= 0)
}

function VarEQ(strEquals) {
  this.update()
  var src=this.value.toUpperCase()
  var test=strEquals.toUpperCase()
  return (src == test)
}

function VarLT(strTest) {
  this.update()
  if( this.value == "~~~null~~~" || this.value == "" ) {
    if( strTest == "~~~null~~~" || strTest == "" ) return 0
    else return 1
  }
  if(isNaN(this.value)||isNaN(strTest))return this.value<strTest
  else return parseFloat(this.value)<parseFloat(strTest)
}

function VarGT(strTest) {
  this.update()
  if( this.value == "~~~null~~~" || this.value == "" ) {
    if( strTest == "~~~null~~~" || strTest == "" ) return 1
    else return 0
  }
  if(isNaN(this.value)||isNaN(strTest))return this.value>strTest
  else return parseFloat(this.value)>parseFloat(strTest)
}

function VarUDT() {
  var now = new Date()
  if( this.f == 1 ) {
    this.tV = now.getTime()
    this.value = FormatDS( now )
  }
  else if( this.f == 2 ) {
    this.tV = now.getTime()
    this.value = FormatTS( now )
  }
  else if( this.of == 4 ) {
    // Only the original Elapsed Time variable gets updated
    var dT = 0
    if( this.eTS == null ) {
      var val = readVariable( this.name, "~~f=4~~0", this.exp, this.title ) 
      dT = val ? val.substr( 7, val.length - 7 ) : 0
      this.eTS = now.getTime() - parseInt( dT )
    }
    this.tV = now.getTime() - this.eTS
    this.value = FormatETS( this.tV )
  }
  this.save()
 }

function VarUDTV() {
  if( this.f == 1 ) this.value = FormatDS( new Date( this.tV ))
  else if( this.f == 2 ) this.value = FormatTS( new Date( this.tV ))
  else if( this.f == 4 ) this.value = FormatETS( this.tV )
  this.save()
}

function VarGetValue() {
  this.update()
  return this.value
}

function VarMail() {
  this.update()
  ObjLayerActionGoTo( 'mailto:' + this.value )
}

{ // Setup protpotypes
var p=Variable.prototype
p.save=VarSave
p.set=VarSet
p.add=VarAdd
p.sub=VarSub
p.mult=VarMult
p.div=VarDiv
p.setByVar=VarSetVar
p.addByVar=VarAddVar
p.subByVar=VarSubVar
p.contains=VarCont
p.equals=VarEQ
p.lessThan=VarLT
p.greaterThan=VarGT
p.uDT=VarUDT
p.uDTV=VarUDTV
p.update=VarUpdateValue
p.getValue=VarGetValue
p.mailTo=VarMail
}

function saveTestScore( varTestName, score, title ) 
{
  saveVariable( varTestName, score, null, title )
}


var titleMgrHandle = null
var getFn = null

if( is.ns4 ) getFn = 'titleMgrHandle = getTitleMgr( window, 0 );'
else getFn = 'try { titleMgrHandle = getTitleMgr( window, 0 ); } catch(error){ titleMgrHandle = null }'

function getTitleMgrHandle()
{
   if( is.ieMac || (is.ns4 && is.nsMac))
       return titleMgrHandle
       
   if (titleMgrHandle == null)
   {
      titleMgrHandle = eval( getFn )
   }

   return titleMgrHandle;
}

function getTitleMgr( testWnd, level )
{
   if( !testWnd )
     return null

     if( testWnd.document.TitleMgr )
       return testWnd.document.TitleMgr;
     else
     {
       var target = eval( "parent.titlemgrframe" )
       if( !target )
          target = eval( "testWnd.parent.titlemgrframe" )
       if( target )
          return target.document.TitleMgr;
       else {
          if( testWnd.name.indexOf( 'Trivantis_' ) == 0 )
            return getTitleMgr( testWnd.opener, level+1 )
          else if( level < 2 )
            return getTitleMgr( testWnd.parent, level+1 )
       }
     }
       
   return null
}

function readCookie(name,defval) {
  var nameEQ = name + "="
  var ca = document.cookie.split(';')
  for(var i=0;i<ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1)
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length)
  }
  return defval
}

function afterProcessTest( score, name ) {
}

function UpdateSCORMTotalTime( currTime ) {
  var startDate = readVariable( 'TrivantisSCORMTimer', 0 )
  if ( startDate == 0 ) return currTime
  
  var currentDate = new Date().getTime();
  var elapsedMills = currentDate - startDate;
  var hours = parseInt( currTime )
  var loc   = currTime.indexOf( ':' )
  currTime  = currTime.substring( loc + 1 )
  var mins  = parseInt( currTime )
  loc       = currTime.indexOf( ':' )
  currTime  = currTime.substring( loc + 1 )
  var secs  = parseInt( currTime )
  loc       = currTime.indexOf( '.' )
  currTime  = currTime.substring( loc + 1 )
  var mills = parseInt( currTime ) * 100
  var total = (((hours * 60) + mins) * 60 + secs) * 1000 + mills
  return convertTotalMills( total + elapsedMills )
}

