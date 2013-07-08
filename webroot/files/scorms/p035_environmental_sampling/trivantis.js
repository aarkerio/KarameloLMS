/**************************************************
Trivantis (http://www.trivantis.com)
**************************************************/

function ObjLayer(id,pref,frame) {
  if (!ObjLayer.bInit && !frame) InitObjLayers()
  this.frame = frame || self
  if (is.ns) {
    if (is.ns5) {
      this.ele = this.event = document.getElementById(id)
      this.styObj = this.ele.style
      this.doc = document
      this.x = this.ele.offsetLeft
      this.y = this.ele.offsetTop
      this.w = this.ele.offsetWidth
      this.h = this.ele.offsetHeight
    }
    else if (is.ns4) {
      if (!frame) {
        if (!pref) var pref = ObjLayer.arrPref[id]
        this.styObj = (pref)? eval("document."+pref+".document."+id) : document.layers[id]
      }
      else this.styObj = (pref) ? eval("frame.document."+pref+".document."+id) : frame.document.layers[id]
      this.ele = this.event = this.styObj
      this.doc = this.styObj.document
      this.x = this.styObj.left
      this.y = this.styObj.top
      this.w = this.styObj.clip.width
      this.h = this.styObj.clip.height
    }
  }
  else if (is.ie) {
    this.ele = this.event = this.frame.document.all[id]
    this.styObj = this.frame.document.all[id].style
    this.doc = document
    this.x = this.ele.offsetLeft
    this.y = this.ele.offsetTop
    this.w = this.ele.offsetWidth
    this.h = this.ele.offsetHeight
  }
  this.id = id
  this.pref = pref
  this.obj = id + "ObjLayer"
  eval(this.obj + "=this")
}

function ObjLayerMoveTo(x,y) {
  if (x!=null) {
    this.x = x
    this.styObj.left = this.x
  }
  if (y!=null) {
    this.y = y
    this.styObj.top = this.y
  }
}

function ObjLayerMoveBy(x,y) {
  this.moveTo(this.x+x,this.y+y)
}

function ObjLayerShow() {
  this.styObj.visibility = "inherit"
}

function ObjLayerHide() {
  this.styObj.visibility = (is.ns4)? "hide" : "hidden"
}

function ObjLayerActionGoTo( destURL, destFrame, subFrame, bFeed ) {
  var targWind = null
  var bFeedback = bFeed != null ? bFeed : true
  if( destFrame ) {
    if( destFrame == "_top" ) targWind = eval( "parent" ) 
    else if(destFrame == "NewWindow" ) targWind = open( destURL, 'NewWindow' )
    else {
      var parWind = eval( "parent" )
      var index=0
      while( index < parWind.length ) {
        if( parWind.frames[index].name == destFrame ) {
          targWind = parWind.frames[index]
          break;
        }
        index++;
      }
      if( subFrame ) {
        index=0
        parWind = targWind
        while( index < parWind.length ) {
          if( parWind.frames[index].name == subFrame ) {
            targWind = parWind.frames[index]
            break;
          }
          index++;
        }
      }
      if( targWind.trivExitPage ) {
        targWind.trivExitPage( destURL, bFeedback )
        return
      }
    }
  }
  if( !targWind ) targWind = window
  targWind.location.href = destURL;
}

function ObjLayerActionGoToNewWindow( destURL, name, props ) {
  var targWind
  targWind = open( destURL, name, props, false )
  targWind.focus()
}

function ObjLayerActionPlay( ) {
}

function ObjLayerActionStop( ) {
}

function ObjLayerActionShow( ) {
    this.show();
}

function ObjLayerActionHide( ) {
    this.hide();
}

function ObjLayerActionLaunch( ) {
}

function ObjLayerActionExit( ) {
    window.top.close()
}

function ObjLayerActionChangeContents( ) {
}

function ObjLayerActionTogglePlay( ) {
}

function ObjLayerActionToggleShow( ) {
  if( this.styObj.visibility == "hide" || this.styObj.visibility == "hidden" ) this.show();
  else this.hide();
}

{ // Setup prototypes
var p=ObjLayer.prototype
p.moveTo = ObjLayerMoveTo
p.moveBy = ObjLayerMoveBy
p.show = ObjLayerShow
p.hide = ObjLayerHide
p.actionGoTo = ObjLayerActionGoTo
p.actionGoToNewWindow = ObjLayerActionGoToNewWindow
p.actionPlay = ObjLayerActionPlay
p.actionStop = ObjLayerActionStop
p.actionShow = ObjLayerActionShow
p.actionHide = ObjLayerActionHide
p.actionLaunch = ObjLayerActionLaunch
p.actionExit = ObjLayerActionExit
p.actionChangeContents = ObjLayerActionChangeContents
p.actionTogglePlay = ObjLayerActionTogglePlay
p.actionToggleShow = ObjLayerActionToggleShow
p.slideInit = new Function()
p.slideTo = ObjLayerSlideTo
p.slideBy = ObjLayerSlideBy
p.slideStart = ObjLayerSlideStart
p.slide = ObjLayerSlide
p.onSlide = new Function()
p.onSlideEnd = ObjLayerSlideEnd
p.clipInit = ObjLayerClipInit
p.clipTo = ObjLayerClipTo
p.write = ObjLayerWrite
}

// InitObjLayers Function
function InitObjLayers(pref) {
  if (!ObjLayer.bInit) ObjLayer.bInit = true
  if (is.ns) {
    if (pref) ref = eval('document.'+pref+'.document')
    else {
      pref = ''
      if( is.ns5 ) {
        document.layers = document.getElementsByTagName("*")
        ref = document
      }
      else ref = document
    }
    for (var i=0; i<ref.layers.length; i++) {
      var divname
      if( is.ns5 ) {
        if( ref.layers[i] ) divname = ref.layers[i].tagName
        else divname = null
      }
      else divname = ref.layers[i].name
      if( divname ) {
        ObjLayer.arrPref[divname] = pref
        if (!is.ns5 && ref.layers[i].document.layers.length > 0) {
          ObjLayer.arrRef[ObjLayer.arrRef.length] = (pref=='')? ref.layers[i].name : pref+'.document.'+ref.layers[i].name
        }
      }
    }
    if (ObjLayer.arrRef.i < ObjLayer.arrRef.length) {
      InitObjLayers(ObjLayer.arrRef[ObjLayer.arrRef.i++])
    }
  }
  return true
}

ObjLayer.arrPref = new Array()
ObjLayer.arrRef = new Array()
ObjLayer.arrRef.i = 0
ObjLayer.bInit = false

function ObjLayerSlideEnd() {
  if( is.ns4 ) {
    this.hide()
    setTimeout( this.obj+".show()", 50 )
  }
}

function ObjLayerSlideTo(ex,ey,amt,spd,fn) {
  if (ex==null) ex = this.x
  if (ey==null) ey = this.y
  var dx = ex-this.x
  var dy = ey-this.y
  this.slideStart(ex,ey,dx,dy,amt,spd,fn)
}

function ObjLayerSlideBy(dx,dy,amt,spd,fn) {
  var ex = this.x + dx
  var ey = this.y + dy
  this.slideStart(ex,ey,dx,dy,amt,spd,fn)
}

function ObjLayerSlideStart(ex,ey,dx,dy,amt,spd,fn) {
  if (this.slideActive) return
  if (!amt) amt = 10
  if (!spd) spd = 20
  var num = Math.sqrt(Math.pow(dx,2) + Math.pow(dy,2))/amt
  if (num==0) { 
    if(fn) eval(fn) 
    return 
  }
  var delx = dx/num
  var dely = dy/num
  if (!fn) fn = null
  this.slideActive = true
  this.slide(delx,dely,ex,ey,num,1,spd,fn)
}

function ObjLayerSlide(dx,dy,ex,ey,num,i,spd,fn) {
  if (!this.slideActive) return
  if (i++ < num) {
    this.moveBy(dx,dy)
    this.onSlide()
    if (this.slideActive) setTimeout(this.obj+".slide("+dx+","+dy+","+ex+","+ey+","+num+","+i+","+spd+",\""+fn+"\")",spd)
    else this.onSlideEnd()
  }
  else {
    this.slideActive = false
    this.moveTo(ex,ey)
    this.onSlide()
    this.onSlideEnd()
    eval(fn)
  }
}

function ObjLayerClipInit(t,r,b,l) {
  if (!is.ns4) {
    if (arguments.length==4) this.clipTo(t,r,b,l)
    else this.clipTo(0,this.ele.offsetWidth,this.ele.offsetHeight,0)
  }
}

function ObjLayerClipTo(t,r,b,l) {
  if (is.ns4) {
    this.styObj.clip.top = t
    this.styObj.clip.right = r
    this.styObj.clip.bottom = b
    this.styObj.clip.left = l
  }
  else this.styObj.clip = "rect("+t+"px "+r+"px "+b+"px "+l+"px)"
}

function ObjLayerWrite(html) {
  if (is.ns4) {
    this.doc.open()
    this.doc.write(html)
    this.doc.close()
  }
  else this.event.innerHTML = html
}

function BrowserProps() {
  var name = navigator.appName
  
  if (name=="Netscape") name = "ns"
  else if (name=="Microsoft Internet Explorer") name = "ie"
  
  this.v = parseInt(navigator.appVersion)
  this.ns = (name=="ns" && this.v>=4)
  this.ns4 = (this.ns && this.v==4)
  this.ns5 = (this.ns && this.v==5)
  this.nsMac = (this.ns && navigator.platform.indexOf("Mac") >= 0 )
  this.ie = (name=="ie" && this.v>=4)
  this.ie5 = (this.ie && navigator.appVersion.indexOf('MSIE 5')>0)
  this.ieMac = (this.ie && navigator.platform.indexOf("Mac") >= 0 )
  this.min = (this.ns||this.ie)
}

is = new BrowserProps()

// CSS Function
function buildCSS(id,left,top,width,height,visible,zorder,color,other) {
  var str = (left!=null && top!=null)? '#'+id+' {position:absolute; left:'+left+'px; top:'+top+'px;' : '#'+id+' {position:relative;'
  if (arguments.length>=4 && width!=null) str += ' width:'+width+'px;'
  if (arguments.length>=5 && height!=null) {
    str += ' height:'+height+'px;'
    if (arguments.length<9 || other.indexOf('clip')==-1) str += ' clip:rect(0px '+width+'px '+height+'px 0px);'
  }
  if (arguments.length>=6 && visible!=null) str += ' visibility:'+visible+';'
  if (arguments.length>=7 && zorder!=null) str += ' z-index:'+zorder+';'
  if (arguments.length>=8 && color!=null) str += (is.ns4)? ' layer-background-color:'+color+';' : ' background:'+color+';'
  if (arguments.length==9 && other!=null) str += ' '+other
  str += '}\n'
  return str
}

function writeStyleSheets(str) {
  cssStr = '<style type="text/css">\n'
  cssStr += str
  cssStr += '</style>'
  document.write(cssStr)
}

function preload() {
  if (!document.images) return;
  var ar = new Array();
  for (var i = 0; i < arguments.length; i++) {
    ar[i] = new Image();
    ar[i].src = arguments[i];
  }
}
