// Chipotle software GPLv3 2006-2012
window.onload = init;
var logged = false;

function init() 
{
    //Check log
    if (!logged) 
    {   
        createCookie("karamelo_first", "first", 999999);
        return;   
    }
}
//cookie setting junk
function createCookie(name,value,days){
  if (days) 
  { 
     var date = new Date();
     date.setTime(date.getTime()+(days*24*60*60*1000));
     
     var expires="; expires="+date.toGMTString();
  }
  else
  { 
     expires="";
  }
  document.cookie=name+"="+value+expires+"; path=/; domain=mononeurona.org";
} 

function validateVote(vote) 
{
        
   valid = false;

   // Opera 5.05 Linux does not support for/in on this object
   for ( var i = 0; i <  vote.length; i++ ) 
   {
      if ( vote[i].checked ) 
      {
         valid = true;
         break;
      }
   }

   if ( ! valid ) 
   {
      alert("You must choose one");
   }
   return valid;
}

function showhide(a)
{
	var Div = document.getElementById(a);
  
 	if (Div.style.display == "none") {
   	     Div.style.display = "block";
 	}	else { 
   	    Div.style.display = "none";
  }
}

function showHiden(d) // Webquest add form
{
	var Div = document.getElementById(d);
    
    var img = document.getElementById('img_' + d);
    //alert(img);
 	if (Div.style.display == "none") {
   	     Div.style.display = "inline";
         img.src = '/img/actions/hide.gif';
 	}	else {
   	    Div.style.display = "none";
        img.src = '/img/actions/show.gif';
  }
  return false;
}

function mostrar(a)
{
  var List = document.getElementById(a);
  
  var Div = document.getElementById('invi_code');
  
  //alert(List.value);
  
 	if (List.value == 2) 
        {
   	     Div.style.display = "block";
 	}
        else 
        {  
            Div.style.display = "none";
        }
}

function ocultar()
{
  $('#cover').hide('slow');
  $('#loginpopup').hide('slow');  
}

function mod()
{
    if (!logged)
    {
        var c =  $("#cover");
        var c_offset = c.offset();
        var l  = $("#loginpopup");
        var l_offset = l.offset();
        c.show('slow');
        l.show('slow');
        return true;
    }
}

// Hide flash session messages
function timedMsg()
{
   if ( document.getElementById('flashMessage') )
   {
       $('#flashMessage').fadeIn().delay(3000).fadeOut('slow');
   }

   if ( document.getElementById('authMessage') )
   {
       $('#authMessage').fadeIn().delay(2000).fadeOut('slow');
   }
}

