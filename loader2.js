/*
 +-------------------------------------------------------------------+
 |                    J S - L O A D E R   (v1.7)                     |
 |                          P a r t   II                             |
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
  function LOADER() {
    this.bar, this.iv, this.timer;
    this.imgAll = 0;
    this.opacity = contentOpacity;
    this.opName = '';

    this.getObj = function(id) {
      var obj;
      if(document.getElementById) obj = document.getElementById(id);
      else if(document.all) obj = document.all[id];
      return obj;
    }

    this.hasOpacity = function(obj) {
      if(obj) {
        if(typeof(obj.style.opacity) != 'undefined') return 'opacity';
        if(typeof(obj.style.MozOpacity) != 'undefined') return 'MozOpacity';
        if(typeof(obj.style.KhtmlOpacity) != 'undefined') return 'KhtmlOpacity';
        if(typeof(obj.style.filter) != 'undefined') return 'filter';
      }
      return false;
    }

    this.setOpacity = function(obj, opacity) {
      if(obj && !document.layers) {
        if(this.opName == 'filter') {
          obj.style.filter = 'alpha(opacity=' + opacity + ')';
        }
        else if(this.opName) {
          obj.style[this.opName] = opacity / 100;
        }
      }
    }

    this.fadeIn = function(id) {
      var obj = this.getObj(id);
      if(obj) {
        if(document.all) obj.style.position = 'absolute';
        obj.style.visibility = 'visible';
        if(fadeInSpeed && this.opacity < 100) {
          this.opacity += fadeInSpeed;
          if(this.opacity > 100) this.opacity = 100;
          this.setOpacity(obj, this.opacity);
          if(this.timer) clearTimeout(this.timer);
          this.timer = setTimeout("loader.fadeIn('" + id + "')", 1);
        }
        else {
          this.opacity = 100;
          this.setOpacity(obj, 100);
        }
      }
    }

    this.setBar = function() {
      if(this.imgAll < document.images.length) this.imgAll = document.images.length;
      for(var i = cnt = 0; i < this.imgAll; i++) {
        if(document.images[i] && document.images[i].complete) cnt++;
        else if(document.images[i].complete == null) cnt++;
      }
      var mul = barLength / this.imgAll;
      var len = Math.round(cnt * mul);
      if(len > barLength) len = barLength;
      this.bar.style.width = len + 'px';
      window.status = cnt + ' / ' + this.imgAll;
      if(cnt >= this.imgAll) {
        if(this.iv) clearInterval(this.iv);
        setTimeout('loader.loaded()', 100);
      }
    }

    this.init = function() {
      var content = this.getObj('Content');
      this.opName = this.hasOpacity(content);
      if(contentOpacity < 0) contentOpacity = 0;
      else if(contentOpacity > 100) contentOpacity = 100;
      this.setOpacity(content, contentOpacity);
      if(contentOpacity == 100 || (this.opName && contentOpacity)) {
        content.style.visibility = 'visible';
      }
      this.bar = this.getObj('divBar');
      if(document.images && document.images.length) {
        if(this.iv) clearInterval(this.iv);
        this.iv = setInterval('loader.setBar()', 100);
      }
      else this.loaded();
    }

    this.loaded = function() {
      window.status = '';
      this.fadeIn('Content');
      var obj = this.getObj('divBox');
      obj.style.visibility = 'hidden';
    }
  }

//----------------------------------------------------------------------------------------------------
// Show dialog box and progress bar
//----------------------------------------------------------------------------------------------------

  if((document.all || document.getElementById) && !safari) {
    document.write('</div>');
    var loader = new LOADER();
    loader.init();
  }

//----------------------------------------------------------------------------------------------------
