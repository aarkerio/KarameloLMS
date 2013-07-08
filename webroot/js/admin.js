// Chipotle software(c) 2006-2012 GPLv3
window.onload = preloader;

// preload images in Control Panel
function preloader() 
{
 var de = document.getElementById('divimages');

 if (de) 
 {   
  // counter
  var i = 0;
  // create object
  imageObj = new Image();
  // set image list
  images = new Array();
  images[0]="/img/blog.png"
  images[1]="/img/myimages.png"
  images[2]="/img/static/chat_icon.png"
  images[3]="/img/static_pages.png"
  images[4]="/img/faq.png"
  images[5]="/img/Glossary.png"
  images[6]="/img/ipod.png"
  images[7]="/img/phorum.png"
  images[8]="/img/mmultimedia.png"
  images[9]="/img/ylinks.png"
  images[10]="/img/admin/tests.png"
  images[11]="/img/webquests.png"
  images[12]="/img/thunt.png"
  images[13]="/img/quotes.png"
  images[14]="/img/ecourses.png"
  images[15]="/img/static/forums.png"
  // start preloading
  for(i=0; i<=15; i++) 
  {
    imageObj.src=images[i];
  }
 }
} 

function addTag(tag)
{
  var newTag = tag + ', ';
  
  var t       = document.getElementById('EntryTags');
  var current = t.value;
  
  var check = current.search(tag);
  
  if (check != -1) 
  {
         alert('Tag already exist');
         return false;
  } 
  
  var forma = document.getElementById('forma');
  
  t.parentNode.removeChild(t);
  
  var upc =document.createElement("input");
      upc.type       ="text";
      upc.size       = 100;
      upc.maxlength  = 120;
      upc.value      = current + newTag;
      upc.name       = 'data[Entry][tags]';
      upc.id         = 'EntryTags'; 
      
      //forma.appendChild(upc);
      document.getElementById('nuevo').appendChild(upc);
      
      //alert(upc.value);
}


// Get student total points 
function tp(user_id, vclassroom_id) 
{
 url    = '/admin/vclassrooms/points/'+user_id +'/'+vclassroom_id;
 
 $.ajax({
          type : 'GET',
          url :  url,
          data: 
          {
            vclassroom_id : vclassroom_id
          },
          success : function(responseText)
          {
            $('#totalpoints').html(responseText, function() {
                                    $('#totalpoints').fadeIn();
                             });

          }
     });
}

// Get student webquests points
function tw(user_id, vclassroom_id) 
{
 url    = '/admin/webquests/points/'+user_id +'/'+vclassroom_id;
 
 $.ajax({
          type : 'GET',
          url :  url,
          data: 
          {
            vclassroom_id : vclassroom_id
          },
          success : function(responseText)
          {
            $('#totalpoints').html(responseText, function() {
                                    $('#totalpoints').fadeIn();
                             });

          }
     });


}

function reportError(request) 
{
  $F('totaloints') = "Error please contact support team";
}

function onok() {
		// Get the image tag field information
		var url		= this.fields.url.getValue();
		var alt		= this.fields.alt.getValue();
		var align	= this.fields.align.getValue();
		var title	= this.fields.title.getValue();
		var caption	= this.fields.caption.getValue();

		if (url != '') {
			// Set alt attribute
			if (alt != '') {
				var alt = "alt=\""+alt+"\" ";
			}
			// Set align attribute
			if (align != '') {
				align = "align=\""+align+"\" ";
			}
			// Set align attribute
			if (title != '') {
				title = "title=\""+title+"\" ";
			}
			// Set align attribute
			if (caption != '') {
				caption = 'class="caption"';
			}

			var tag = "<img src=\""+url+"\" "+alt+align+title+caption+" />";
		}

		window.parent.jInsertEditorText(tag);
		return false;
	}

// remove flash session messages
function timedMsg()
{
   if ( document.getElementById('flashMessage') )
   { 
     $('#flashMessage').slideDown('slow').delay(3000).fadeOut('slow'); 
   }
}

// http://swip.codylindley.com/jquery.popupWindow.js
// PopUp function
(function($){   
    $.fn.popupWindow = function(instanceSettings){
        
        return this.each(function(){
                
                $(this).click(function(){
                        
                        $.fn.popupWindow.defaultSettings = {
                            centerBrowser:0, // center window over browser window? {1 (YES) or 0 (NO)}. overrides top and left
                            centerScreen:0, // center window over entire screen? {1 (YES) or 0 (NO)}. overrides top and left
                            height:500, // sets the height in pixels of the window.
                            left:0, // left position when the window appears.
                            location:0, // determines whether the address bar is displayed {1 (YES) or 0 (NO)}.
                            menubar:0, // determines whether the menu bar is displayed {1 (YES) or 0 (NO)}.
                            resizable:0, // whether the window can be resized {1 (YES) or 0 (NO)}. Can also be overloaded using resizable.
                            scrollbars:0, // determines whether scrollbars appear on the window {1 (YES) or 0 (NO)}.
                            status:0, // whether a status line appears at the bottom of the window {1 (YES) or 0 (NO)}.
                            width:500, // sets the width in pixels of the window.
                            windowName:null, // name of window set from the name attribute of the element that invokes the click
                            windowURL:null, // url used for the popup
                            top:0, // top position when the window appears.
                            toolbar:0 // determines whether a toolbar (includes the forward and back buttons) is displayed {1 (YES) or 0 (NO)}.
                        };
                        
                        settings = $.extend({}, $.fn.popupWindow.defaultSettings, instanceSettings || {});
                        
                        var windowFeatures =    'height=' + settings.height +
                        ',width=' + settings.width +
                        ',toolbar=' + settings.toolbar +
                        ',scrollbars=' + settings.scrollbars +
                        ',status=' + settings.status + 
                        ',resizable=' + settings.resizable +
                        ',location=' + settings.location +
                        ',menuBar=' + settings.menubar;

                        settings.windowName = this.name || settings.windowName;
                        settings.windowURL = this.href || settings.windowURL;
                        var centeredY,centeredX;
                        
                        if(settings.centerBrowser){
                            
                            if ($.browser.msie) {//hacked together for IE browsers
                                centeredY = (window.screenTop - 120) + ((((document.documentElement.clientHeight + 120)/2) - (settings.height/2)));
                                centeredX = window.screenLeft + ((((document.body.offsetWidth + 20)/2) - (settings.width/2)));
                            }else{
                                centeredY = window.screenY + (((window.outerHeight/2) - (settings.height/2)));
                                centeredX = window.screenX + (((window.outerWidth/2) - (settings.width/2)));
                            }
                            window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
                        }else if(settings.centerScreen){
                            centeredY = (screen.height - settings.height)/2;
                            centeredX = (screen.width - settings.width)/2;
                            window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
                        }else{
                            window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + settings.left +',top=' + settings.top).focus();
                        }
                        return false;
                    });
                
            });
    };
})(jQuery);

// Clear a form in View/Questions/admin_answers.ctp
$.fn.clearAnswer = function() {
    // alert('sadsadsad');
    $(this).each (function() { this.reset(); });
};

$.fn.toggleDiv = function() {
    $(this).toggle('slow', function() {
    // Animation complete.
    });
};


// Just toggle a div
 function showDiv(div) {

 var tr = document.getElementById(div);

  if (tr.style.display == 'none')
  {
            tr.style.display = 'block';
  } else {
            tr.style.display = 'none';
  }
}