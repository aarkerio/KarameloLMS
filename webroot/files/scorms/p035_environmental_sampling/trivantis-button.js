/**************************************************
Trivantis (http://www.trivantis.com)
**************************************************/

// Button Object
function ObjButton(n,a,x,y,w,h,v,z) {
  this.name = n
  this.altName = a
  this.x = x
  this.y = y
  this.w = w
  this.h = h
  if( v ) this.v = "inherit"
  else this.v = (is.ns4)? "hide" : "hidden"
  this.z = z
  this.obj = this.name+"Object"
  eval(this.obj+"=this")
}

function ObjButtonActionGoTo( destURL, destFrame ) {
  this.objLyr.actionGoTo( destURL, destFrame );
}

function ObjButtonActionGoToNewWindow( destURL, name, props ) {
  this.objLyr.actionGoToNewWindow( destURL, name, props );
}

function ObjButtonActionPlay( ) {
  this.objLyr.actionPlay();
}

function ObjButtonActionStop( ) {
  this.objLyr.actionStop();
}

function ObjButtonActionShow( ) {
  this.objLyr.actionShow();
}

function ObjButtonActionHide( ) {
  this.objLyr.actionHide();
}

function ObjButtonActionLaunch( ) {
  this.objLyr.actionLaunch();
}

function ObjButtonActionExit( ) {
  this.objLyr.actionExit();
}

function ObjButtonActionChangeContents( ) {
  this.objLyr.actionChangeContents();
}

function ObjButtonActionTogglePlay( ) {
  this.objLyr.actionTogglePlay();
}

function ObjButtonActionToggleShow( ) {
  this.objLyr.actionToggleShow();
}

{// Setup prototypes
var p=ObjButton.prototype
p.checkbox = false
p.setImages = ObjButtonSetImages
p.build = ObjButtonBuild
p.activate = ObjButtonActivate
p.down = ObjButtonDown
p.up = ObjButtonUp
p.over = ObjButtonOver
p.out = ObjButtonOut
p.change = ObjButtonChange
p.capture = 0
p.onDown = new Function()
p.onUp = new Function()
p.onOver = new Function()
p.onOut = new Function()
p.onSelect = new Function()
p.onDeselect = new Function()
p.actionGoTo = ObjButtonActionGoTo
p.actionGoToNewWindow = ObjButtonActionGoToNewWindow
p.actionPlay = ObjButtonActionPlay
p.actionStop = ObjButtonActionStop
p.actionShow = ObjButtonActionShow
p.actionHide = ObjButtonActionHide
p.actionLaunch = ObjButtonActionLaunch
p.actionExit = ObjButtonActionExit
p.actionChangeContents = ObjButtonActionChangeContents
p.actionTogglePlay = ObjButtonActionTogglePlay
p.actionToggleShow = ObjButtonActionToggleShow
p.writeLayer = ObjButtonWriteLayer
p.slideTo = ObjButtonSlideTo
p.moveTo = ObjButtonMoveTo
}

function ObjButtonSetImages(imgOff,imgOn,imgRoll,dir) {
  if (!dir) dir = ''
  this.imgOffSrc = imgOff?dir+imgOff:''
  this.imgOnSrc = imgOn?dir+imgOn:''
  this.imgRollSrc = imgRoll?dir+imgRoll:''
}

function ObjButtonBuild() {
  this.css = buildCSS(this.name,this.x,this.y,this.w,this.h,this.v,this.z)
  this.div = '<div id="'+this.name+'"><a name="'+this.name+'anc" href="javascript:'+this.name+'.up()"'
  if( this.altName ) this.div += ' title="'+this.altName+'"'
  else if( this.altName != null ) this.div += ' title=""'
  this.div += '>'
  this.div += '<img name="'+this.name+'Img" src="'+this.imgOffSrc
  if( this.altName ) this.div += '" alt="'+this.altName
  else if( this.altName != null ) this.div += '" alt="'
  this.div += '" width='+this.w+' height='+this.h+' border=0'
  if( !is.ns4 )  this.div += ' style="cursor:hand"'
  this.div += '></a></div>\n'
}

function ObjButtonKeyDown(e) {
    var keyVal = 0
    if( is.ns4 ) keyVal = e.which
    else {
        if( is.ie ) e = event
        keyVal = e.keyCode
    }
    if( keyVal == 13 || keyVal == 32 ) this.onUp()
}

function ObjButtonActivate() {
  this.objLyr = new ObjLayer(this.name)
  if( this.objLyr && this.objLyr.styObj ) this.objLyr.styObj.visibility = this.v
  if (is.ns4) this.objLyr.ele.captureEvents(Event.MOUSEDOWN | Event.MOUSEUP | Event.KEYDOWN )
  this.objLyr.ele.onUp = new Function(this.obj+".onUp(); return false;")
  this.objLyr.ele.onmousedown = new Function(this.obj+".down(); return false;")
  this.objLyr.ele.onmouseover = new Function(this.obj+".over(); return false;")
  this.objLyr.ele.onmouseout = new Function(this.obj+".out(); return false;")
  this.objLyr.ele.onkeydown = ObjButtonKeyDown
}

function ObjButtonDown() {
  if( is.ie && !is.ieMac && event && event.button != 1 ) return
  if (this.selected) {
    this.selected = false
    if (this.imgOnSrc) this.change(this.imgOnSrc)
    this.onDeselect()
  }
  else {
    if (this.checkbox) this.selected = true
    if (this.imgOnSrc) this.change(this.imgOnSrc)
    this.onSelect()
  }
  this.onDown()
}

function ObjButtonUp() {
  if (is.ie && !is.ieMac && event && event.button!=1) return true
  if (!this.selected) {
    if (this.imgRollSrc) this.change(this.imgRollSrc)
    else if (this.imgOnSrc) this.change(this.imgOffSrc)
  }
  this.onUp()
}

function ObjButtonOver() {
  if (this.imgRollSrc && !this.selected) this.change(this.imgRollSrc)
  this.onOver()
}

function ObjButtonOut() {
  if (this.imgRollSrc && !this.selected) this.change(this.imgOffSrc)
  this.onOut()
}

function ObjButtonChange(img) {
  if (this.objLyr) this.objLyr.doc.images[this.name+"Img"].src = img
}

function ObjButtonWriteLayer( newContents ) {
  if (this.objLyr) this.objLyr.write( newContents )
}

function ObjButtonSlideTo(ex,ey,amt,spd,fn) {
  if (this.objLyr) this.objLyr.slideTo(ex,ey,amt,spd,fn);
}

function ObjButtonMoveTo(x,y) {
  if (this.objLyr) this.objLyr.moveTo(x,y);
}

