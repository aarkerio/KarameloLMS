/**************************************************
Trivantis (http://www.trivantis.com)
**************************************************/

// Inline Object
function ObjInline(n,a,x,y,w,h,v,z,c) {
  this.name = n
  this.altName = a
  this.x = x
  this.y = y
  this.w = w
  this.h = h
  if( v ) this.v = "inherit"
  else this.v = (is.ns4)? "hide" : "hidden"
  this.z = z
  this.bgColor = c
  this.obj = this.name+"Object"
  this.parmArray = new Array
  this.numParms = 0
  this.hrefPrompt = 'javascript:void(null);'
  eval(this.obj+"=this")
}

function ObjInlineAddParm( newParm ) {
  this.parmArray[this.numParms++] = newParm;
}

function ObjInlineActionGoTo( destURL, destFrame ) {
  this.objLyr.actionGoTo( destURL, destFrame );
}

function ObjInlineActionGoToNewWindow( destURL, name, props ) {
  this.objLyr.actionGoToNewWindow( destURL, name, props );
}

function ObjInlineActionPlay( ) {
  if( is.ie ) {
    eval( "document.swf" + this.name + ".Play()" )
  } else {
    this.objLyr.actionStop();
  }
}

function ObjInlineActionStop( ) {
  if( is.ie ) {
    eval( "document.swf" + this.name + ".Stop()" )
  } else {
    this.objLyr.actionStop();
  }
}

function ObjInlineActionShow( ) {
  this.objLyr.actionShow();
}

function ObjInlineActionHide( ) {
  this.objLyr.actionHide();
}

function ObjInlineActionLaunch( ) {
  this.objLyr.actionLaunch();
}

function ObjInlineActionExit( ) {
  this.objLyr.actionExit();
}

function ObjInlineActionChangeContents( value, align, fntId ) {
  var varValue = ''
  varValue += value
  if (arguments.length>1) {
    var div
    var fntName = this.objLyr.id + 'Font' + fntId
 
    if( varValue.split ) {
      var test = escape( varValue )
 
      var ca = test.split('%5Cr')
      if( ca.length ) {
        var newVarValue=''
    
        for(var i=0;i<ca.length;i++) {
          newVarValue += ca[i]
          if( i < ca.length-1 ) 
            newVarValue += '<br />'
        }
        varValue = newVarValue
      }
      
      test = varValue;
      
      var ca = test.split('%')
      if( ca.length ) {
        var newVarValue=''
    
        for(var i=0;i<ca.length;i++) {
          var tempStr, holdStr;
          var uni = 0;
          if( i )
          {
            if( ca[i].charAt( 0 ) == 'u' )
            {
              uni = 1;
              holdStr = ca[i].substring( 5 );
            }
            else
              holdStr = ca[i].substring( 2 );
          }
          else
            holdStr = ca[i];
            
          if( i && i < ca.length ) 
          {
            if( uni )
              tempStr = ca[i].substring( 1, 5 )
            else
              tempStr = ca[i].substring( 0, 2 )

            var hexValue = parseInt( tempStr, 16 )

            if( hexValue == 32 )
              newVarValue += ' '
            else
              newVarValue += '&#' + hexValue + ';'

            newVarValue += holdStr
          }
          else
            newVarValue += holdStr
        }
        varValue = newVarValue
      }
    }
    
    if( is.ns ){
      if( varValue == "~~~null~~~" ) div = '<span class="' + fntName + '">' + '</span>'
      else div = '<span class="' + fntName + '">' + varValue + '</span>'
    }
    else { 
      if( varValue == "~~~null~~~" ) div = '<div class="' + align + '"><span class="' + fntName + '">' + '</span></div>' 
      else div = '<div class="' + align + '"><span class="' + fntName + '">' + varValue + '</span></div>'
    }
    if( is.ns5 ) this.objLyr.ele.innerHTML = div
    else this.objLyr.write( div );
  }
  else {
    this.parmArray[1] = "<param name='movie' value='" + varValue + "'>";
    this.parmArray[3] = "<embed src='" + varValue + "' width='" + this.w + "'   height='" + this.h + "' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' name='" + this.name + "' swliveconnect='true'>";
    this.build();
    var str = "";
    for (var i=0; i < this.numParms; i++) str = str + this.parmArray[i]
    if( is.ns5 ) this.objLyr.ele.innerHTML = str
    else this.objLyr.write( str );
  }
}

function ObjInlineActionTogglePlay( ) {
  if( is.ie ) {
    if( eval( "document.swf" + this.name + ".Playing" ) ) {
        eval( "document.swf" + this.name + ".Stop()" );
    } else {
        eval( "document.swf" + this.name + ".Play()" );
    }
  } else {
    this.objLyr.actionTogglePlay();
  }
}

function ObjInlineActionToggleShow( ) {
  this.objLyr.actionToggleShow();
}

{ // Setup prototypes
var p=ObjInline.prototype
p.addParm = ObjInlineAddParm
p.build = ObjInlineBuild
p.activate = ObjInlineActivate
p.up = ObjInlineUp
p.down = ObjInlineDown
p.over = ObjInlineOver
p.out = ObjInlineOut
p.capture = 0
p.onOver = new Function()
p.onOut = new Function()
p.onSelect = new Function()
p.onDown = new Function()
p.onUp = new Function()
p.actionGoTo = ObjInlineActionGoTo
p.actionGoToNewWindow = ObjInlineActionGoToNewWindow
p.actionPlay = ObjInlineActionPlay
p.actionStop = ObjInlineActionStop
p.actionShow = ObjInlineActionShow
p.actionHide = ObjInlineActionHide
p.actionLaunch = ObjInlineActionLaunch
p.actionExit = ObjInlineActionExit
p.actionChangeContents = ObjInlineActionChangeContents
p.actionTogglePlay = ObjInlineActionTogglePlay
p.actionToggleShow = ObjInlineActionToggleShow
p.writeLayer = ObjInlineWriteLayer
p.slideTo = ObjInlineSlideTo
p.moveTo = ObjInlineMoveTo
}

function ObjInlineBuild() {
  var other = '';
  if( this.capture & 4 && !is.ns4 ) other=' style="cursor:hand"'
  if( this.bgColor ) this.css = buildCSS(this.name,this.x,this.y,this.w,this.h,this.v,this.z,this.bgColor,other)
  else {
    var prefix=this.name.substring(3)
    if(prefix == 'tex') {
      var maxHeight = parseInt( this.h * 5 / 4)
      this.css = buildCSS(this.name,this.x,this.y,this.w,maxHeight,this.v,this.z,this.bgColor,other)
    }
    else if( is.ns4 ) {
      var right = this.w + this.x;
      if( right <= window.innerWidth + 4 ) this.css = buildCSS(this.name,this.x,this.y,this.w,null,this.v,this.z,this.bgColor,other)
      else this.css = buildCSS(this.name,this.x,this.y,this.w,this.h,this.v,this.z,this.bgColor,other)
    }
    else this.css = buildCSS(this.name,this.x,this.y,this.w,null,this.v,this.z,this.bgColor,other)
  }
  var divStart
  var divEnd
  divStart = '<div id="'+this.name+'"'
  if( this.altName ) divStart += ' alt="'+this.altName+'"'
  else { if( this.altName != null ) divStart += ' alt=""' }
  divStart += '><a name="'+this.name+'anc">'
  divEnd   = '</a></div>'
  if( is.ns4 && this.capture & 4 ) {
    divStart = divStart + '<A HREF="' +this.hrefPrompt+'">'
    divEnd   = '</A>' + divEnd 
  }
  this.div = divStart + '\n'
  for (var i=0; i < this.numParms; i++) this.div = this.div + this.parmArray[i]
  this.div = this.div + divEnd + '\n'
}

function ObjInlineActivate() {
  this.objLyr = new ObjLayer(this.name)
  if( this.objLyr && this.objLyr.styObj ) this.objLyr.styObj.visibility = this.v
  if( this.capture & 4 ) {
    if (is.ns4) this.objLyr.ele.captureEvents(Event.MOUSEDOWN | Event.MOUSEUP)
    this.objLyr.ele.onmousedown = new Function(this.obj+".down(); return false;")
    this.objLyr.ele.onmouseup = new Function(this.obj+".up(); return false;")
  }
  if( this.capture & 1 ) this.objLyr.ele.onmouseover = new Function(this.obj+".over(); return false;")
  if( this.capture & 2 ) this.objLyr.ele.onmouseout = new Function(this.obj+".out(); return false;")
}

function ObjInlineDown() {
  if( is.ie && event.button != 1 ) return
  this.onSelect()
  this.onDown()
}

function ObjInlineUp() {
  if (is.ie && event.button!=1) return true
  this.onUp()
}

function ObjInlineOver() {
  this.onOver()
}

function ObjInlineOut() {
  this.onOut()
}

function ObjInlineWriteLayer( newContents ) {
  if (this.objLyr) this.objLyr.write( newContents )
}

function ObjInlineSlideTo(ex,ey,amt,spd,fn) {
  if (this.objLyr) this.objLyr.slideTo(ex,ey,amt,spd,fn);
}

function ObjInlineMoveTo(x,y) {
  if (this.objLyr) this.objLyr.moveTo(x,y);
}

