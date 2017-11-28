/*
 +-------------------------------------------------------------------+
 |                    J S - L O A D E R   (v1.7)                     |
 |                          P a r t   I                              |
 |                                                                   |
 | Copyright Gerd Tentler               www.gerd-tentler.de/tools    |
 | Created: Mar. 26, 2002               Last modified: Dec. 15, 2007 |
 +-------------------------------------------------------------------+
 | This program may be used and hosted free of charge by anyone for  |
 | personal purpose as long as this copyright notice remains intact. |
 |                                                                   |
 | Obtain permission before selling the code for this program or     |
 | hosting this software on a commercial website or redistributing   |
 | this software over the Internet or in any other medium. In all    |
 | cases copyright must remain intact.                               |
 +-------------------------------------------------------------------+

======================================================================================================
 This script was tested with the following systems and browsers:

 - Windows XP: IE 6, NN 7, Opera 7 + 9, Firefox 2
 - Mac OS X:   IE 5

 If you use another browser or system, this script may not work for you - sorry.

 NOTE: Safari 1 (Mac OS X) does not support "document.images[].complete", so the progress bar will
       not be shown.
======================================================================================================
*/
//----------------------------------------------------------------------------------------------------
// Configuration
//----------------------------------------------------------------------------------------------------

  var boxText = "Loading ... please wait!";   // dialog box message
  var boxFont = "bold 14px Arial,Helvetica";  // dialog box font (CSS spec: "style size family")
  var boxFontColor = "#D00000";               // dialog box font color
  var boxWidth = 250;                         // dialog box width (pixels)
  var boxHeight = 100;                        // dialog box height (pixels)
  var boxBGColor = "#FFFFD0";                 // dialog box background color
  var boxBorder = "2px outset #E0E0E0";       // dialog box border (CSS spec: "size style color")

  var barLength = 200;                        // progress bar length (pixels)
  var barHeight = 15;                         // progress bar height (pixels)
  var barColor = "#D00000";                   // progress bar color
  var barBGColor = "#E0D0C0";                 // progress bar background color

  var fadeInSpeed = 20;                       // content fade-in speed (0 - 30; 0 = no fading)*
  var contentOpacity = 20;                    // content opacity during loading (0 - 100)*

// * Fading and content opacity were successfully tested on Windows XP with IE 6, NN 7, Firefox 2
//   and Opera 9. Other browsers may not support these features, but the script should work anyway.

//----------------------------------------------------------------------------------------------------
// Build dialog box and progress bar
//----------------------------------------------------------------------------------------------------

  var safari = (navigator.userAgent.indexOf('Safari') != -1) ? true : false;

  if((document.all || document.getElementById) && !safari) {
    document.write('<style> .clsBox { ' +
                   'position:absolute; top:50%; left:50%; ' +
                   'width:' + boxWidth + 'px; ' +
                   'height:' + boxHeight + 'px; ' +
                   'margin-top:-' + Math.round(boxHeight / 2) + 'px; ' +
                   'margin-left:-' + Math.round(boxWidth / 2) + 'px; ' +
                   (boxBGColor ? 'background-color:' + boxBGColor + '; ' : '') +
                   (boxBorder ? 'border:' + boxBorder + '; ' : '') +
                   'z-index:69; ' +
                   '} .clsBarBG { ' +
                   'width:' + (barLength + 4) + 'px; ' +
                   'height:' + (barHeight + 4) + 'px; ' +
                   'background-color:' + barBGColor + '; ' +
                   'border-top:1px solid black; border-left:1px solid black; ' +
                   'border-bottom:1px solid silver; border-right:1px solid silver; ' +
                   'margin:0px; padding:0px; ' +
                   'text-align: left; ' +
                   '} .clsBar { ' +
                   'width:0px; height:' + barHeight + 'px; ' +
                   'background-color:' + barColor + '; ' +
                   'border-top:1px solid silver; border-left:1px solid silver; ' +
                   'border-bottom:1px solid black; border-right:1px solid black; ' +
                   'margin:1px; padding:0px; ' +
                   'font-size:1px; ' +
                   '} .clsText { ' +
                   'font:' + boxFont + '; ' +
                   'color:' + boxFontColor + '; ' +
                   '} </style> ' +
                   '<div id="divBox" class="clsBox">' +
                   '<table border=0 cellspacing=0 cellpadding=0><tr>' +
                   '<td width=' + boxWidth + ' height=' + boxHeight + ' align=center>' +
                   (boxText ? '<p class="clsText" align=center>' + boxText + '</p>' : '') +
                   '<table border=0 cellspacing=0 cellpadding=0><tr><td width=' + barLength + '>' +
                   '<div id="divBarBG" class="clsBarBG"><div id="divBar" class="clsBar"></div></div>' +
                   '</td></tr></table>' +
                   '</td></tr></table></div>' +
                   '<div id="Content" style="width:100%; visibility:hidden">');
  }

//----------------------------------------------------------------------------------------------------
