/**
 * ------------------------------------------------------------------------
 * JA Magz II Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */

// Switch tool
// ---------------
var jActions = {};

(function($){
    // Switch tool
    jActions.switchClass = function ($btn) {
        var action = $btn.data('action'),
            target = $btn.data('target'),
            value = $btn.data('value'),
            key = $btn.data('key'),
            $target = $btn.parents(target);
        if (!$target.length) $target = $(target);
        // get all class to remove
        $target.find ('[data-action="' + action + '"]').not($btn).each(function(){
            $(this).removeClass ('active');
            $target.removeClass ($(this).data('value'));
        });
        $target.addClass (value);
        $btn.addClass ('active');
        // store into cookie
        $.cookie (action + '-' + key, $btn.data('cookie') != 'no' ? value : '', {path: '/'});
    };

    jActions.switchClassInit = function ($btn) {
        var action = $btn.data('action'),
            target = $btn.data('target'),
            defaultValue = $btn.data('value'),
            key = $btn.data('key'),
            cookieValue = $.cookie(action + '-' + key),
            value = cookieValue ? cookieValue : defaultValue,
            $target = $btn.parents(target);
        if (!$target.length) $target = $(target);
        // get all class to remove
        $target.find ('[data-action="' + action + '"]').each(function(){
            var $this = $(this);
            if ($this.data('value') == value) {
                $target.addClass (value);
                $this.addClass ('active');
            } else {
                $this.removeClass ('active');
                $target.removeClass ($this.data('value'));
            }
        });
        // store into cookie
        $.cookie (action + '-' + key, $btn.data('cookie') != 'no' ? value : '', {path: '/'});
    };


    // Switch tool
    jActions.onOff = function ($btn) {
        var action = $btn.data('action'),
            target = $btn.data('target'),
            cls = $btn.data('value'),
            key = $btn.data('key'),
            $target = $btn.parents(target),
            value = '';
        if (!$target.length) $target = $(target);
        value = $target.hasClass (cls) ? 'off' : 'on';
        // get all class to remove
        if (value == 'off') {
            $target.removeClass (cls);
            $btn.removeClass('on').addClass ('off');
        } else {
            $target.addClass (cls);
            $btn.removeClass('off').addClass ('on');
        }
        $.cookie (action + '-' + key, $btn.data('cookie') != 'no' ? value : '', {path: '/'});
    };
    
    
    
    jActions.onOffInit = function ($btn) {
        var action = $btn.data('action'),
            target = $btn.data('target'),
            cls = $btn.data('value'),
            defaultValue = $btn.data('default'),
            key = $btn.data('key'),
            cookieValue = $.cookie(action + '-' + key),
            value = cookieValue ? cookieValue : defaultValue,
            $target = $btn.parents(target);
        if (!$target.length) $target = $(target);
        // get all class to remove
        if (value == 'on') {
            $target.addClass (cls);
            $btn.addClass ('on');
        } else {
            $btn.addClass ('off');
        }
        // store into cookie
        $.cookie (action + '-' + key, $btn.data('cookie') != 'no' ? value : '', {path: '/'});
    };


    // next-prev actions tool
    jActions.nextPrev = function ($btn) {
        var action = $btn.data('action'),
            target = $btn.data('target'),
            prop = $btn.data('key'),
            value = parseInt($btn.data('value')),
            $target = $btn.parents(target),
            values = $btn.parent().data(prop + 's').split(','),
            curVal = $.cookie(action + '-' + prop),
            curValIdx = $.inArray(curVal, values),
            newValIdx = curValIdx + value;
        if (!$target.length) $target = $(target);
        if (!$btn.parent().data('loop') && (newValIdx < 0 || newValIdx >= values.length)) {
            return ;
        }
        newValIdx = newValIdx < 0 ? values.length-1 : (newValIdx >= values.length ? 0 : newValIdx);
        if (newValIdx != curValIdx) {
            $target.removeClass(prop + '-' + curVal.replace(' ', '-').toLowerCase()).addClass(prop + '-' + values[newValIdx].replace(' ', '-').toLowerCase());
            if ($btn.data('cookie') != 'no') $.cookie(action + '-' + prop, values[newValIdx], {path: '/'});
            $btn.parent().find ('strong').html (values[newValIdx]);
        }
    };
    jActions.nextPrevInit = function ($btn) {
        var action = $btn.data('action'),
            target = $btn.data('target'),
            prop = $btn.data('key'),
            defaultValue = $btn.data('default'),
            $target = $btn.parents(target),
            cookieValue = $.cookie(action + '-' + prop),
            value = cookieValue ? cookieValue : defaultValue;
        if (!$target.length) $target = $(target);
        if (value) {
            $target.addClass(prop + '-' + value.replace(' ', '-').toLowerCase());
            if ($btn.data('cookie') != 'no') $.cookie(action + '-' + prop, value, {path: '/'});
            $btn.parent().find ('strong').html (value);
        }
    };

    jActions.loadModuleNextPage = function(link, modid, container, callback) {
        var btn = $(link);
        var curPage = parseInt(btn.attr('data-page'));
        if(!curPage) curPage = 1;

        btn.attr('disabled', 'disabled');
        btn.find('.fa-spin').show();

        var url = btn.data('link');
        url += (url.indexOf('?') == -1 ? '?' : '&') + 't3action=module&style=raw&mid='+modid+'&_module_page=' + (curPage + 1);
        $.ajax({
            url: url,
            method: 'POST',
            success: function(data) {
                $(link).find('.fa-spin').hide();
                if(data && data.replace(/^\s+|\s+$/gm,'') != '') {
                    $('#'+container).append(data);
                    btn.attr('data-page', curPage + 1);
                    if(btn.data('maxpage') && curPage + 1 < btn.data('maxpage')) {
                        btn.removeAttr('disabled');
                    } else {
                        btn.html(Joomla.JText._('TPL_LOAD_MODULE_AJAX_DONE'));
                    }
                    if(typeof(callback) == 'function') {
                        callback();
                    }
                    $(data).find("script").each(function(i) {
                        eval($(this).text());
                    });
                } else {
                    btn.html(Joomla.JText._('TPL_LOAD_MODULE_AJAX_DONE'));
                }
            }
        });
        return false;
    };
})(jQuery);

(function($){
  $(document).ready(function(){
    $('[data-action]').each (function() {
        // check & init default
        var $this = $(this),
            action = $this.data('action');
        if (jActions[action]) {
            $this.on('click', function() {
                jActions[action]($this);
                return false;
            });
        }
        if ($this.data('default') != undefined && jActions[action + 'Init']) {
            jActions[action + 'Init'] ($this);
        }
    });

    // prev / next article in reading-mode
    $('.pagenav li a').on ('click', function() {
        if ($('html').hasClass ('reading-mode')) {
            $.cookie ('onOff-reading-mode', 'on', {path: '/'});
        }
    });
  });
})(jQuery);

(function($){
  $(document).ready(function(){
    ////////////////////////////////
    // equalheight for col
    ////////////////////////////////
    var ehArray = ehArray2 = [],
      i = 0;

    $('.equal-height').each (function(){
      var $ehc = $(this);
      if ($ehc.has ('.equal-height')) {
        ehArray2[ehArray2.length] = $ehc;
      } else {
        ehArray[ehArray.length] = $ehc;
      }
    });
    for (i = ehArray2.length -1; i >= 0; i--) {
      ehArray[ehArray.length] = ehArray2[i];
    }

    var equalHeight = function() {
      for (i = 0; i < ehArray.length; i++) {
        var $cols = ehArray[i].children().filter('.col'),
          maxHeight = 0,
          equalChildHeight = ehArray[i].hasClass('equal-height-child');

      // reset min-height
      
        if (equalChildHeight) {
          $cols.each(function(){$(this).children().first().css('min-height', 0)});
        } else {
          $cols.css('min-height', 0);
        }
        $cols.each (function() {
          maxHeight = Math.max(maxHeight, equalChildHeight ? $(this).children().first().innerHeight() : $(this).innerHeight());
        });
        if (equalChildHeight) {
          $cols.each(function(){$(this).children().first().css('min-height', maxHeight)});
        } else {
          $cols.css('min-height', maxHeight);
        }
      }
      // store current size
      $('.equal-height > .col').each (function(){
        var $col = $(this);
        $col.data('old-width', $col.width()).data('old-height', $col.innerHeight());
      });
    };

    equalHeight();

    // monitor col width and fire equalHeight
    setInterval(function() {
      $('.equal-height > .col').each(function(){
        var $col = $(this);
        if (($col.data('old-width') && $col.data('old-width') != $col.width()) ||
            ($col.data('old-height') && $col.data('old-height') != $col.innerHeight())) {
          equalHeight();
          // break each loop
          return false;
        }
      });
    }, 500);

    // Search Cpanel
    $('.btn-search').click(function() {
      if($('.t3-header-wrap').hasClass('cpanel-close')) {
        $('.t3-header-wrap').addClass('cpanel-open');
        $('.t3-header-wrap').removeClass('cpanel-close');
      } else {
        $('.t3-header-wrap').removeClass('cpanel-open');
        $('.t3-header-wrap').addClass('cpanel-close');
      }
      
    });

  });
})(jQuery);


// TAB
// -----------------
/*(function($){
  $(document).ready(function(){
  	// fix tab for video content type page. it's duplicate the tab.
    if($('.nav.nav-tabs').length > 0){
		$('.nav.nav-tabs').each(function (i) {
			if (!$(this).hasClass('nav-stacked')) {
				$(this).find('a').each(function() {
					$(this).attr('href', $(this).attr('href')+'-'+i);
				});
				$(this).parent().find('#myTabContent').children('div').each(function() {
					$(this).attr('id', $(this).attr('id')+'-'+i);
				});
				$(this).find('a').click(function (e) {
				  e.preventDefault();
				  $(this).tab('show');
				});
			}
		})
     }
  });
})(jQuery);*/


// Header Scroll
// -----------------
(function($) {

    var scrollLastPos = 0,
        scrollDir = 0, // -1: up, 1: down
        scrollTimeout = 0;
	$(window).on ('scroll', function (e) {
        var st = $(this).scrollTop();
        //Determines up-or-down scrolling
        if (st < 80) {
            if (scrollDir != 0) {
                scrollDir = 0;
                scrollToggle();
            }
        } else if (st > scrollLastPos){
            //Replace this with your function call for downward-scrolling
            if (scrollDir != 1) {
                scrollDir = 1;
                scrollToggle();
            }
        } else if (st < scrollLastPos){
            //Replace this with your function call for upward-scrolling
            if (scrollDir != -1) {
                scrollDir = -1;
                scrollToggle();
            }
        }
        //Updates scroll position
        scrollLastPos = st;
    });

    $('.ja-header').on ('hover', function () {
        $('html').removeClass ('scrollDown scrollUp').addClass ('hover');
        scrollDir = 0;
    })

    scrollToggle = function () {
        $('html').removeClass ('hover');
        if (scrollDir == 1) {
            $('html').addClass ('scrollDown').removeClass ('scrollUp');
        } else if (scrollDir == -1) {
            $('html').addClass ('scrollUp').removeClass ('scrollDown');
        } else {
            $('html').removeClass ('scrollUp scrollDown');
        }
		$('html').addClass ('animating');
		setTimeout(function(){ $('html').removeClass ('animating'); }, 1000);
    }

})(jQuery);

// SEARCH FULL
// -----------------
jQuery(window).load(function(){
    jQuery('#t3-header .fa-search').click(function() {
      jQuery('.t3-wrapper').toggleClass('search-open search-close');
      jQuery('#mod-search-searchword').focus();
    });
    jQuery('.off-canvas-toggle').click(function(){
    	if (jQuery('.t3-wrapper').hasClass('search-open'))
    		jQuery('.t3-wrapper').toggleClass('search-open search-close');
    });
});

// VIDEO AFFIX
// -----------------
(function($){
  $(document).ready(function(){
    if($('.affix-video').length > 0) {
      $('.affix-video').affix({
            offset: {
                top: $('.affix-video').offset().top + $('#ja-main-player').outerHeight() - 60,
            }
        })
    }
  });
})(jQuery);

// Blog page - Use Infinitescroll
(function($){
    $(document).ready(function(){
        var $container = $('.ja-magz-item #item-container');
        if(!$container.length) return;   
    });
});

