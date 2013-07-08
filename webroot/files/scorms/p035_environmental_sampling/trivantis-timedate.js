/**************************************************
Trivantis (http://www.trivantis.com)
**************************************************/

//functions for realtime date/time
function FormatDS( now ) {
  var monthList = new Array('January','February','March','April','May','June','July','August','September','October','November','December')
  var year = now.getYear()
  if( year < 1900 ) year += 1900
  return monthList[now.getMonth()]+' '+now.getDate()+', '+year
}

function FormatTS( now ) {
  var newmin = now.getMinutes()
  if (newmin<10) newmin = "0"+newmin
  var hour = now.getHours()
  var ampm = 'AM'
  if (hour>12) {
    hour-=12
    ampm = 'PM'
  }
  else if (hour==0) hour = 12
  if (hour<10) hour = ' '+hour
  return hour+':'+newmin+' '+ampm
}

function FormatETS( eT ) {
  var mills = eT % 1000
  eT -= mills
  eT /= 1000
  var secs = eT % 60
  eT -= secs
  eT /= 60
  var mins = eT % 60
  eT -= mins
  eT /= 60
  var hours = eT
  if( hours < 10 ) hours = "0" + hours
  if( mins < 10 ) mins = "0" + mins
  if( secs < 10 ) secs = "0" + secs
  return hours + ':' + mins + ':' + secs
}

function CalcTD( f, val ) {
  var tV = 0
  if( f == 1 ) tV += 24 * 60 * 60 * 1000 * val
  else if( f == 2 ) tV += 60 * 1000 * val
  else if( f == 4 ) tV += 1000 * val
  return tV
}
