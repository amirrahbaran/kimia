<!-- cloak

//Kissing trail- By dij8 (dij8@dij8.com)
//Modified by Dynamic Drive for bug fixes
//Visit http://www.dynamicdrive.com for this script

kisserCount = 15 //maximum number of images on screen at one time
curKisser = 0 //the last image DIV to be displayed (used for timer)
kissDelay = 1000 //duration images stay on screen (in milliseconds)
kissSpacer = 50 //distance to move mouse b4 next heart appears
theimage = "./components/kiss/lips_small.gif" //the 1st image to be displayed
theimage2 = "./components/kiss/small_heart.gif" //the 2nd image to be displayed


//Browser checking and syntax variables
var docLayers = (document.layers) ? true:false;
var docId = (document.getElementById) ? true:false;
var docAll = (document.all) ? true:false;
var docbitK = (docLayers) ? "document.layers['":(docId) ? "document.getElementById('":(docAll) ? "document.all['":"document."
var docbitendK = (docLayers) ? "']":(docId) ? "')":(docAll) ? "']":""
var stylebitK = (docLayers) ? "":".style"
var showbitK = (docLayers) ? "show":"visible"
var hidebitK = (docLayers) ? "hide":"hidden"
var ns6=document.getElementById&&!document.all
//Variables used in script
var posX, posY, lastX, lastY, kisserCount, curKisser, kissDelay, kissSpacer, theimage
lastX = 0
lastY = 0
//Collection of functions to get mouse position and place the images
function doKisser(e) {

  posX = getMouseXPos(e)
  posY = getMouseYPos(e)
  if (posX>(lastX+kissSpacer)||posX<(lastX-kissSpacer)||posY>(lastY+kissSpacer)||posY<(lastY-kissSpacer)) {
    showKisser(posX,posY)
    lastX = posX
    lastY = posY
  }
}
// Get the horizontal position of the mouse
function getMouseXPos(e) {
  if (document.layers||ns6) {
    return parseInt(e.pageX+10)
  } else {
    return (parseInt(event.clientX+10) + parseInt(document.body.scrollLeft))
  }
}
// Get the vartical position of the mouse
function getMouseYPos(e) {
  if (document.layers||ns6) {
    return parseInt(e.pageY)
  } else {
    return (parseInt(event.clientY) + parseInt(document.body.scrollTop))
  }
}
//Place the image and start timer so that it disappears after a period of time
function showKisser(x,y) {
  var processedx=ns6? Math.min(x,window.innerWidth-75) : docAll? Math.min(x,document.body.clientWidth-55) : x
  if (curKisser >= kisserCount) {curKisser = 0}
  eval(docbitK + "kisser" + curKisser + docbitendK + stylebitK + ".left = " + processedx)
  eval(docbitK + "kisser" + curKisser + docbitendK + stylebitK + ".top = " + y)
  eval(docbitK + "kisser" + curKisser + docbitendK + stylebitK + ".visibility = '" + showbitK + "'")
  if (eval("typeof(kissDelay" + curKisser + ")")=="number") {
    eval("clearTimeout(kissDelay" + curKisser + ")")
  }
  eval("kissDelay" + curKisser + " = setTimeout('hideKisser(" + curKisser + ")',kissDelay)")
  curKisser += 1
}
//Make the image disappear
function hideKisser(knum) {
  eval(docbitK + "kisser" + knum + docbitendK + stylebitK + ".visibility = '" + hidebitK + "'")
}

function kissbegin(){
//Let the browser know when the mouse moves
if (docLayers) {
  document.captureEvents(Event.MOUSEMOVE)
  document.onMouseMove = doKisser
} else {
  document.onmousemove = doKisser
}
}
window.onload=kissbegin
// decloak -->