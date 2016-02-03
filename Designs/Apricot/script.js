var winOnLoad = window.onload;
window.onload = null;

/* begin Page */

/* Generated with Artisteer version 2.1.0.16091, file checksum is CA778DCC. */

var artEventHelper = {
	'bind': function(obj, evt, fn) {
		if (obj.addEventListener)
			obj.addEventListener(evt, fn, false);
		else if (obj.attachEvent)
			obj.attachEvent('on' + evt, fn);
		else
			obj['on' + evt] = fn;
	}
};

var userAgent = navigator.userAgent.toLowerCase();
var browser = {
	version: (userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
	safari: /webkit/.test(userAgent) && !/chrome/.test(userAgent),
	chrome: /chrome/.test(userAgent),
	opera: /opera/.test(userAgent),
	msie: /msie/.test(userAgent) && !/opera/.test(userAgent),
	mozilla: /mozilla/.test(userAgent) && !/(compatible|webkit)/.test(userAgent)
};

var artLoadEvent = (function() {
	

	var list = [];

	var done = false;
	var ready = function() {
		if (done) return;
		done = true;
		for (var i = 0; i < list.length; i++)
			list[i]();
	};

	if (document.addEventListener && !browser.opera)
		document.addEventListener('DOMContentLoaded', ready, false);

	if (browser.msie && window == top) {
		(function() {
			try {
				document.documentElement.doScroll('left');
			} catch (e) {
				setTimeout(arguments.callee, 10);
				return;
			}
			ready();
		})();
	}

	if (browser.opera) {
		document.addEventListener('DOMContentLoaded', function() {
			for (var i = 0; i < document.styleSheets.length; i++) {
				if (document.styleSheets[i].disabled) {
					setTimeout(arguments.callee, 10);
					return;
				}
			}
			ready();
		}, false);
	}

	if (browser.safari) {
		var numStyles;
		(function() {
			if (document.readyState != 'loaded' && document.readyState != 'complete') {
				setTimeout(arguments.callee, 10);
				return;
			}
			if ('undefined' == typeof numStyles) {
				numStyles = document.getElementsByTagName('style').length;
				var links = document.getElementsByTagName('link');
				for (var i = 0; i < links.length; i++) {
					numStyles += (links[i].getAttribute('rel') == 'stylesheet') ? 1 : 0;
				}
				if (document.styleSheets.length != numStyles) {
					setTimeout(arguments.callee, 0);
					return;
				}
			}
			ready();
		})();
	}

	artEventHelper.bind(window, 'load', ready);

	return ({
		add: function(f) {
			list.push(f);
		}
	})
})();

(function() {
	// fix ie blinking
	var m = document.uniqueID && document.compatMode && !window.XMLHttpRequest && document.execCommand;
	try { if (!!m) { m("BackgroundImageCache", false, true); } }
	catch (oh) { };
})();

function xGetElementsByClassName(clsName, parentEle, tagName) {
	var elements = null;
	var found = [];
	var s = String.fromCharCode(92);
	var re = new RegExp('(?:^|' + s + 's+)' + clsName + '(?:$|' + s + 's+)');
	if (!parentEle) parentEle = document;
	if (!tagName) tagName = '*';
	elements = parentEle.getElementsByTagName(tagName);
	if (elements) {
		for (var i = 0; i < elements.length; ++i) {
			if (elements[i].className.search(re) != -1) {
				found[found.length] = elements[i];
			}
		}
	}
	return found;
}

var styleUrlCached = null;
function GetStyleUrl() {
	if (null == styleUrlCached) {
		var ns;
		styleUrlCached = '';
		ns = document.getElementsByTagName('link');
		for (var i = 0; i < ns.length; i++) {
			var l = ns[i];
			if (l.href && /style\.css(\?.*)?$/.test(l.href)) {
				return styleUrlCached = l.href.replace(/style\.css(\?.*)?$/, '');
			}
		}

		ns = document.getElementsByTagName('style');
		for (var i = 0; i < ns.length; i++) {
			var matches = new RegExp('import\\s+"([^"]+\\/)style\\.css"').exec(ns[i].innerHTML);
			if (null != matches && matches.length > 0)
				return styleUrlCached = matches[1];
		}
	}
	return styleUrlCached;
}

function fixPNG(element) {
	if (/MSIE (5\.5|6).+Win/.test(navigator.userAgent)) {
		var src;
		if (element.tagName == 'IMG') {
			if (/\.png$/.test(element.src)) {
				src = element.src;
				element.src = GetStyleUrl() + "Images/spacer.gif";
			}
		}
		else {
			src = element.currentStyle.backgroundImage.match(/url\("(.+\.png)"\)/i);
			if (src) {
				src = src[1];
				element.runtimeStyle.backgroundImage = "none";
			}
		}
		if (src) element.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "')";
	}
}

function artHasClass(el, cls) {
    return (el && el.className && (' ' + el.className + ' ').indexOf(' ' + cls + ' ') != -1);
}/* end Page */


function artButtonsSetupJsHover(className, parent) {
    if (!parent) parent = document;
	var tags = ["input", "a", "button"];
	for (var j = 0; j < tags.length; j++){
		var buttons = xGetElementsByClassName(className, parent, tags[j]);
		for (var i = 0; i < buttons.length; i++) {
			var button = buttons[i];
			if (!button.tagName || !button.parentNode) return;
			if (!artHasClass(button.parentNode, 'button-wrapper')) {
				if (!artHasClass(button, 'button')) button.className += ' button';
				var wrapper = document.createElement('span');
				wrapper.className = "button-wrapper";
				if (artHasClass(button, 'active')) wrapper.className += ' active';
				var spanL = document.createElement('span');
				spanL.className = "button-l";
				spanL.innerHTML = " ";
				wrapper.appendChild(spanL);
				var spanR = document.createElement('span');
				spanR.className = "button-r";
				spanR.innerHTML = " ";
				wrapper.appendChild(spanR);
				button.parentNode.insertBefore(wrapper, button);
				wrapper.appendChild(button);
			}
			artEventHelper.bind(button, 'mouseover', function(e) {
				e = e || window.event;
				wrapper = (e.target || e.srcElement).parentNode;
				wrapper.className += " hover";
			});
			artEventHelper.bind(button, 'mouseout', function(e) {
				e = e || window.event;
				button = e.target || e.srcElement;
				wrapper = button.parentNode;
				wrapper.className = wrapper.className.replace(/hover/, "");
				if (!artHasClass(button, 'active')) wrapper.className = wrapper.className.replace(/active/, "");
			});
			artEventHelper.bind(button, 'mousedown', function(e) {
				e = e || window.event;
				button = e.target || e.srcElement;
				wrapper = button.parentNode;
				if (!artHasClass(button, 'active')) wrapper.className += " active";
			});
			artEventHelper.bind(button, 'mouseup', function(e) {
				e = e || window.event;
				button = e.target || e.srcElement;
				wrapper = button.parentNode;
				if (!artHasClass(button, 'active')) wrapper.className = wrapper.className.replace(/active/, "");
			});
			if (button.tagName.toLowerCase() == "input" && (browser.chrome || browser.mozilla)) button.style.margin = "0 -3px";
		}
	}
}





artLoadEvent.add(function() { artButtonsSetupJsHover("Button"); });

artLoadEvent.add(function() {
    if (typeof window.AjaxPanelEvents == "undefined") window.AjaxPanelEvents = [];
    window.AjaxPanelEvents.push({
        eventName: "afterUpdate",
        func: function(updatePanel) {
            artButtonsSetupJsHover("Button", updatePanel);
        }
    });
});

artLoadEvent.add(function() {
    // select all tables with table class
    var tables = document.getElementsByTagName('table');
    var formTables = [];
    for (var i = 0; i < tables.length; i++) {
        var table = tables[i];
        if (-1 != table.className.indexOf(' table') || -1 != table.className.indexOf(' article'))
            formTables[formTables.length] = table;
    }
});

if (winOnLoad) artLoadEvent.add(winOnLoad);

// menu

artLoadEvent.add(function() {
    var uls = document.getElementsByTagName('ul');
    for (var i = 0; i < uls.length; i++) {
        var ul = uls[i];
        if (-1 != ul.className.indexOf('menu')) {
            if (typeof ul.spansExtended == "undefined") {
                ArtMenu_SpansSetup(ul);
                ul.spansExtended = true;
            }
        }
    }
});

function ArtMenu_GetElement(e, name) {
    name = name.toLowerCase();
    for (var n = e.firstChild; null != n; n = n.nextSibling)
        if (1 == n.nodeType && name == n.nodeName.toLowerCase())
        return n;
    return null;
}

function ArtMenu_GetElements(e, name) {
    name = name.toLowerCase();
    var elements = [];
    for (var n = e.firstChild; null != n; n = n.nextSibling)
        if (1 == n.nodeType && name == n.nodeName.toLowerCase())
        elements[elements.length] = n;
    return elements;
}

function ArtMenu_SpansSetup(menuUL) {
    var menuULLI = ArtMenu_GetElements(menuUL, 'li');
    for (var i = 0; i < menuULLI.length; i++) {
        var li = menuULLI[i];
        if ('separator' == li.className) continue;
        var a = ArtMenu_GetElement(li, 'a');
        if (null == a) continue;
        if (isIncluded(a.href, window.location.href)) {
            a.className = 'active';
        }
        var spant = document.createElement('span');
        spant.className = 't';
        while (a.firstChild)
            spant.appendChild(a.firstChild);
        a.appendChild(document.createElement('span')).className = 'l';
        a.appendChild(document.createElement('span')).className = 'r';
        a.appendChild(spant);
    }
}

// isIncluded the same as in Functions.js if this script is used independently
function isIncluded(href1, href2) {
    if (href1 == null || href2 == null)
        return href1 == href2;
    if (href1.indexOf("?") == -1 || href1.split("?")[1] == "")
        return href1.split("?")[0] == href2.split("?")[0];
    if (href2.indexOf("?") == -1 || href2.split("?")[1] == "")
        return href1.replace("?", "") == href2.replace("?", "");
    if (href1.split("?")[0] != href2.split("?")[0])
        return false;
    var params = href1.split("?")[1];
    params = params.split("&");
    var i, par1, par2, nv;
    par1 = new Array();
    for (i in params) {
        if (typeof (params[i]) == "function")
            continue;
        nv = params[i].split("=");
        if (nv[0] != "FormFilter")
            par1[nv[0]] = nv[1];
    }
    params = href2.split("?")[1];
    params = params.split("&");
    par2 = new Array();
    for (i in params) {
        if (typeof (params[i]) == "function")
            continue;
        nv = params[i].split("=");
        if (nv[0] != "FormFilter")
            par2[nv[0]] = nv[1];
    }
    /*if (par1.length != par2.length)
    return false;*/
    for (i in par1)
        if (par1[i] != par2[i])
        return false;
    return true;
}
// set vmenu active link
/* begin VMenu */
jQuery(function() {
    if (!jQuery('html').hasClass('ie7')) return;
    jQuery('ul.vmenu li:not(:first-child),ul.vmenu li li li:first-child,ul.vmenu>li>ul').each(function () { jQuery(this).append('<div class="vmenu-separator"> </div><div class="vmenu-separator-bg"> </div>'); });
});


/* end VMenu */

/* begin VMenuItem */


jQuery(function() {
    jQuery('ul.vmenu a.submenu').click(function () {
        var a = jQuery(this);
        a.parents('ul.vmenu').find("ul, a").removeClass('active');
        a.parent().children('ul').addClass('active');
        a.parents('ul.vmenu ul').addClass('active');
        a.parents('ul.vmenu li').children('a').addClass('active');
		return false;
    });
});
/* end VMenuItem */
