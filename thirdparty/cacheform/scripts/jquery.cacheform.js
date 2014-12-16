/*
* jQuery Cacheform - A plugin to cache form data to a cookie.
*
* Version: 0.0.1
*
* Copyright (c) 2010 Ron Valstar
*
* Dual licensed under the MIT and GPL licenses:
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*
* description
*   - A plugin to cache form data to a cookie.
*
* Usage:
*   simply add js to page
*
* Change default like so:
*   $.cacheform.defaults.order = "desc";
*
* in this update:
*
* in last update:
*
* Todos
*	- fix to work with multiple forms / similar names
*   - add hidden field handling
*	- add hidden field option
*
*/
;(function($) {
	var bDebug = !true;
	var oSave = {};
	var oSettings;
	$.cacheform = {
		 id: "CacheForm"
		,version: "0.0.1"
		,defaults: {
			 foo: "bar"
			,find: "textarea,select,input[type=text],input[type=checkbox],input[type=radio],input[type=hidden]"
		}
	};
	// init
	$(function() {
		trace($.cacheform.id+" "+$.cacheform.version+" init");
		//$.fn.cacheform({});
	});
	// call
	$.fn.extend({
		cacheform: function(_settings) {
			trace($.cacheform.id+" "+$.cacheform.version+" call");
			oSettings = $.extend({}, $.cacheform.defaults, _settings);
			//
			// node onto which operation is called
			var mParent = $(this);
			var mNamedAfter = mParent[0].nodeName=="FORM"?mParent:mParent.parent("form:first");
			//
			trace("mNamedAfter: "
				+mParent[0].nodeName
				+" "+mNamedAfter.length
				+" "+mNamedAfter[0].nodeName
				+" "+mNamedAfter.attr("id")
				+" "+mNamedAfter.attr("action"));
			//
			var sCookieName = md5(String(window.location).split("#")[0]+mNamedAfter.attr("id")+mNamedAfter.attr("action"));
			var oCookie = invokeCookie(sCookieName,"{}");
			if (bDebug) {
				for (var s in oCookie) {
					var o = oCookie[s];
					trace("\t- "+o.id+o.name+": "+o.val+" "+o.checked);
				}
			}
			//
			// traverse through all editable form elements
			mParent.find(oSettings.find).each(function(i,e) {
			//$("form textarea,form select,form input[type=text],form input[type=checkbox],form input[type=radio]").each(function(i,e) {
				var mNode = $(this);
				var oNode = checkNode(this);
				var sObj = oNode.id+oNode.name;
				if (sObj!="") { // node heeft naam en/of id
					if (bDebug) trace(sObj+": "+oNode.node+oNode.type);
					if (oCookie[sObj]) { // cookie heeft data dus set value
						var oNewO = oCookie[sObj];
						switch (oNode.node+oNode.type) {
							case "TEXTAREAtextarea":	mNode.html(oNewO.val); break;
							case "INPUTcheckbox":		mNode.attr("checked", oNewO.checked); break;
							case "INPUTradio":			mNode.attr("checked", oNewO.val==oNode.val); break;
							default:					mNode.val(oNewO.val); // INPUTtext SELECTselect
						}
					} else { // cookie heeft geen data dus save value
						setNode(this,sCookieName,oCookie);
					}
				}
				mNode.change(function(e){setNode(e.currentTarget,sCookieName,oCookie)});
			});
			return this;
		}
	});
	//
	// setNode
	function setNode(n,s,o) {
		var oNode = checkNode(n);
		var sObj = oNode.id+oNode.name;
		if (sObj!="") {
			if (oNode.type=="radio") {
				if (oNode.checked) o[sObj] = oNode;
			} else {
				o[sObj] = oNode;
			}
			createCookie(s,JSON.stringify(o),3650);
		}
	}
	//
	// checkNode
	function checkNode(node) {
		var mNode = $(node);
		var oObj = {
			 id:		mNode.attr('id')
			,name:		mNode.attr('name')
			,node:		mNode[0].nodeName
			,type:		mNode.attr('type')
			,val:		mNode.val()
			,checked:	mNode.attr('checked')||mNode.attr('selected')=="selected"
		};
		return oObj;
	}
	//
	// invokeCookie
	function invokeCookie(name,defval,fn) {
		var oReturn;
		var sCookie = readCookie(name);
		var bSet = sCookie!=null;
		try {
			if (bSet) oReturn = JSON.parse(sCookie);
			trace("cookie parsed: '"+name+"'");
		} catch (e) {
			trace("cookie parse error: '"+name+"' "+e+"\n\tdata:"+sCookie);
			bSet = false;
		}
		if (!bSet&&defval) {
			trace("cookie '"+name+"' reverting to default data");
			oReturn = JSON.parse(defval);
			if (fn) fn(oReturn);
			else createCookie(name,defval,3650);
		}
		return oReturn;
	}
	//
	///////////////////
	//
	// createCookie
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = 	name+"="+value+expires+"; path=/";
	}
	// readCookie
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	// eraseCookie
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}
	// trace
	function trace(o,v) {
		if ((v||bDebug)&&window.console&&window.console.log) {
			if (typeof(o)=="string")	window.console.log(o);
			else						for (var prop in o) window.console.log(prop+":\t"+String(o[prop]).split("\n")[0]);
		}
	}
})(jQuery);