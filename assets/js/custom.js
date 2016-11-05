// Instafeed
(function(){var e;e=function(){function e(e,t){var n,r;this.options={target:"instafeed",get:"popular",resolution:"thumbnail",sortBy:"none",links:!0,mock:!1,useHttp:!1};if(typeof e=="object")for(n in e)r=e[n],this.options[n]=r;this.context=t!=null?t:this,this.unique=this._genKey()}return e.prototype.hasNext=function(){return typeof this.context.nextUrl=="string"&&this.context.nextUrl.length>0},e.prototype.next=function(){return this.hasNext()?this.run(this.context.nextUrl):!1},e.prototype.run=function(t){var n,r,i;if(typeof this.options.clientId!="string"&&typeof this.options.accessToken!="string")throw new Error("Missing clientId or accessToken.");if(typeof this.options.accessToken!="string"&&typeof this.options.clientId!="string")throw new Error("Missing clientId or accessToken.");return this.options.before!=null&&typeof this.options.before=="function"&&this.options.before.call(this),typeof document!="undefined"&&document!==null&&(i=document.createElement("script"),i.id="instafeed-fetcher",i.src=t||this._buildUrl(),n=document.getElementsByTagName("head"),n[0].appendChild(i),r="instafeedCache"+this.unique,window[r]=new e(this.options,this),window[r].unique=this.unique),!0},e.prototype.parse=function(e){var t,n,r,i,s,o,u,a,f,l,c,h,p,d,v,m,g,y,b,w,E,S,x,T,N,C,k,L,A,O,M,_,D;if(typeof e!="object"){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"Invalid JSON data"),!1;throw new Error("Invalid JSON response")}if(e.meta.code!==200){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,e.meta.error_message),!1;throw new Error("Error from Instagram: "+e.meta.error_message)}if(e.data.length===0){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"No images were returned from Instagram"),!1;throw new Error("No images were returned from Instagram")}this.options.success!=null&&typeof this.options.success=="function"&&this.options.success.call(this,e),this.context.nextUrl="",e.pagination!=null&&(this.context.nextUrl=e.pagination.next_url);if(this.options.sortBy!=="none"){this.options.sortBy==="random"?M=["","random"]:M=this.options.sortBy.split("-"),O=M[0]==="least"?!0:!1;switch(M[1]){case"random":e.data.sort(function(){return.5-Math.random()});break;case"recent":e.data=this._sortBy(e.data,"created_time",O);break;case"liked":e.data=this._sortBy(e.data,"likes.count",O);break;case"commented":e.data=this._sortBy(e.data,"comments.count",O);break;default:throw new Error("Invalid option for sortBy: '"+this.options.sortBy+"'.")}}if(typeof document!="undefined"&&document!==null&&this.options.mock===!1){m=e.data,A=parseInt(this.options.limit,10),this.options.limit!=null&&m.length>A&&(m=m.slice(0,A)),u=document.createDocumentFragment(),this.options.filter!=null&&typeof this.options.filter=="function"&&(m=this._filter(m,this.options.filter));if(this.options.template!=null&&typeof this.options.template=="string"){f="",d="",w="",D=document.createElement("div");for(c=0,N=m.length;c<N;c++){h=m[c],p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);E=p.width,y=p.height,b="square",E>y&&(b="landscape"),E<y&&(b="portrait"),v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),d=this._makeTemplate(this.options.template,{model:h,id:h.id,link:h.link,type:h.type,image:v,width:E,height:y,orientation:b,caption:this._getObjectProperty(h,"caption.text"),likes:h.likes.count,comments:h.comments.count,location:this._getObjectProperty(h,"location.name")}),f+=d}D.innerHTML=f,i=[],r=0,n=D.childNodes.length;while(r<n)i.push(D.childNodes[r]),r+=1;for(x=0,C=i.length;x<C;x++)L=i[x],u.appendChild(L)}else for(T=0,k=m.length;T<k;T++){h=m[T],g=document.createElement("img"),p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),g.src=v,this.options.links===!0?(t=document.createElement("a"),t.href=h.link,t.appendChild(g),u.appendChild(t)):u.appendChild(g)}_=this.options.target,typeof _=="string"&&(_=document.getElementById(_));if(_==null)throw o='No element with id="'+this.options.target+'" on page.',new Error(o);_.appendChild(u),a=document.getElementsByTagName("head")[0],a.removeChild(document.getElementById("instafeed-fetcher")),S="instafeedCache"+this.unique,window[S]=void 0;try{delete window[S]}catch(P){s=P}}return this.options.after!=null&&typeof this.options.after=="function"&&this.options.after.call(this),!0},e.prototype._buildUrl=function(){var e,t,n;e="https://api.instagram.com/v1";switch(this.options.get){case"popular":t="media/popular";break;case"tagged":if(!this.options.tagName)throw new Error("No tag name specified. Use the 'tagName' option.");t="tags/"+this.options.tagName+"/media/recent";break;case"location":if(!this.options.locationId)throw new Error("No location specified. Use the 'locationId' option.");t="locations/"+this.options.locationId+"/media/recent";break;case"user":if(!this.options.userId)throw new Error("No user specified. Use the 'userId' option.");t="users/"+this.options.userId+"/media/recent";break;default:throw new Error("Invalid option for get: '"+this.options.get+"'.")}return n=e+"/"+t,this.options.accessToken!=null?n+="?access_token="+this.options.accessToken:n+="?client_id="+this.options.clientId,this.options.limit!=null&&(n+="&count="+this.options.limit),n+="&callback=instafeedCache"+this.unique+".parse",n},e.prototype._genKey=function(){var e;return e=function(){return((1+Math.random())*65536|0).toString(16).substring(1)},""+e()+e()+e()+e()},e.prototype._makeTemplate=function(e,t){var n,r,i,s,o;r=/(?:\{{2})([\w\[\]\.]+)(?:\}{2})/,n=e;while(r.test(n))s=n.match(r)[1],o=(i=this._getObjectProperty(t,s))!=null?i:"",n=n.replace(r,""+o);return n},e.prototype._getObjectProperty=function(e,t){var n,r;t=t.replace(/\[(\w+)\]/g,".$1"),r=t.split(".");while(r.length){n=r.shift();if(!(e!=null&&n in e))return null;e=e[n]}return e},e.prototype._sortBy=function(e,t,n){var r;return r=function(e,r){var i,s;return i=this._getObjectProperty(e,t),s=this._getObjectProperty(r,t),n?i>s?1:-1:i<s?1:-1},e.sort(r.bind(this)),e},e.prototype._filter=function(e,t){var n,r,i,s,o;n=[],r=function(e){if(t(e))return n.push(e)};for(i=0,o=e.length;i<o;i++)s=e[i],r(s);return n},e}(),function(e,t){return typeof define=="function"&&define.amd?define([],t):typeof module=="object"&&module.exports?module.exports=t():e.Instafeed=t()}(this,function(){return e})}).call(this);
// Cookie
!function(e){if("function"==typeof define&&define.amd)define(e);else if("object"==typeof exports)module.exports=e();else{var n=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=n,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var t=arguments[e];for(var o in t)n[o]=t[o]}return n}function n(t){function o(n,r,i){var c;if(arguments.length>1){if(i=e({path:"/"},o.defaults,i),"number"==typeof i.expires){var s=new Date;s.setMilliseconds(s.getMilliseconds()+864e5*i.expires),i.expires=s}try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(a){}return r=t.write?t.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=encodeURIComponent(String(n)),n=n.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),n=n.replace(/[\(\)]/g,escape),document.cookie=[n,"=",r,i.expires&&"; expires="+i.expires.toUTCString(),i.path&&"; path="+i.path,i.domain&&"; domain="+i.domain,i.secure?"; secure":""].join("")}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var f=p[u].split("="),l=f[0].replace(d,decodeURIComponent),m=f.slice(1).join("=");'"'===m.charAt(0)&&(m=m.slice(1,-1));try{if(m=t.read?t.read(m,l):t(m,l)||m.replace(d,decodeURIComponent),this.json)try{m=JSON.parse(m)}catch(a){}if(n===l){c=m;break}n||(c[l]=m)}catch(a){}}return c}return o.get=o.set=o,o.getJSON=function(){return o.apply({json:!0},[].slice.call(arguments))},o.defaults={},o.remove=function(n,t){o(n,"",e(t,{expires:-1}))},o.withConverter=n,o}return n(function(){})});
// Scooch
!function(t){if("function"==typeof define&&define.amd)define(["$"],t);else{var e=window.Mobify&&window.Mobify.$||window.Zepto||window.jQuery;t(e)}}(function($){var t=function($){var t={},e=navigator.userAgent,i=$.support=$.support||{};$.extend($.support,{touch:"ontouchend"in document}),t.events=i.touch?{down:"touchstart",move:"touchmove",up:"touchend"}:{down:"mousedown",move:"mousemove",up:"mouseup"},t.getCursorPosition=i.touch?function(t){return t=t.originalEvent||t,{x:t.touches[0].clientX,y:t.touches[0].clientY}}:function(t){return{x:t.clientX,y:t.clientY}},t.getProperty=function(t){for(var e=["Webkit","Moz","O","ms",""],i=document.createElement("div").style,n=0;n<e.length;++n)if(void 0!==i[e[n]+t])return e[n]+t},$.extend(i,{transform:!!t.getProperty("Transform"),transform3d:!(!(window.WebKitCSSMatrix&&"m11"in new WebKitCSSMatrix)||/android\s+[1-2]/i.test(e))});var n=t.getProperty("Transform");i.transform3d?t.translateX=function(t,e){"number"==typeof e&&(e+="px"),t.style[n]="translate3d("+e+",0,0)"}:i.transform?t.translateX=function(t,e){"number"==typeof e&&(e+="px"),t.style[n]="translate("+e+",0)"}:t.translateX=function(t,e){"number"==typeof e&&(e+="px"),t.style.left=e};var s=t.getProperty("Transition"),o=t.getProperty("TransitionDuration");return t.setTransitions=function(t,e){e?t.style[o]="":t.style[o]="0s"},t.requestAnimationFrame=function(){var t=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(t){window.setTimeout(t,1e3/60)},e=function(){t.apply(window,arguments)};return e}(),t}($),e=function($,t){var e={dragRadius:10,moveRadius:20,animate:!0,autoHideArrows:!1,rightToLeft:!1,classPrefix:"m-",classNames:{outer:"scooch",inner:"scooch-inner",item:"item",center:"center",touch:"has-touch",dragging:"dragging",active:"active",inactive:"inactive",fluid:"fluid"}},i=$.support,n=function(t,e){this.setOptions(e),this.initElements(t),this.initOffsets(),this.initAnimation(),this.bind(),this._updateCallbacks=[]};return n.defaults=e,n.prototype.setOptions=function(t){var i=this.options||$.extend({},e,t);i.classNames=$.extend({},i.classNames,t.classNames||{}),this.options=i},n.prototype.initElements=function(t){this._index=1,this.element=t,this.$element=$(t),this.$inner=this.$element.find("."+this._getClass("inner")),this.$items=this.$inner.children(),this.$start=this.$items.eq(0),this.$sec=this.$items.eq(1),this.$current=this.$items.eq(this._index-1),this._length=this.$items.length,this._alignment=this.$element.hasClass(this._getClass("center"))?.5:0,this._isFluid=this.$element.hasClass(this._getClass("fluid"))},n.prototype.initOffsets=function(){this._offsetDrag=0},n.prototype.initAnimation=function(){this.animating=!1,this.dragging=!1,this._needsUpdate=!1,this._enableAnimation()},n.prototype._getClass=function(t){return this.options.classPrefix+this.options.classNames[t]},n.prototype._enableAnimation=function(){this.animating||(t.setTransitions(this.$inner[0],!0),this.$inner.removeClass(this._getClass("dragging")),this.animating=!0)},n.prototype._disableAnimation=function(){this.animating&&(t.setTransitions(this.$inner[0],!1),this.$inner.addClass(this._getClass("dragging")),this.animating=!1)},n.prototype.refresh=function(){this.$items=this.$inner.children("."+this._getClass("item")),this.$start=this.$items.eq(0),this.$sec=this.$items.eq(1),this._length=this.$items.length,this.update()},n.prototype.update=function(e){if("undefined"!=typeof e&&this._updateCallbacks.push(e),!this._needsUpdate){this._needsUpdate=!0;var i=this;t.requestAnimationFrame(function(){i._update(),setTimeout(function(){for(var t=0,e=i._updateCallbacks.length;e>t;t++)i._updateCallbacks[t].call(i);i._updateCallbacks=[]},10)})}},n.prototype._update=function(){if(this._needsUpdate){var e=this.$current,i=this.$start,n=e.prop("offsetLeft")+e.prop("clientWidth")*this._alignment,s=i.prop("offsetLeft")+i.prop("clientWidth")*this._alignment,o=Math.round(-(n-s)+this._offsetDrag);e.prop("offsetParent")&&t.translateX(this.$inner[0],o),this._needsUpdate=!1}},n.prototype.bind=function(){function e(e){i.touch||e.preventDefault(),r=!0,h=!1,l=t.getCursorPosition(e),u=0,c=0,m=!1,f._disableAnimation(),_=1==f._index,y=f._index==f._length}function n(e){if(r&&!h){var i=t.getCursorPosition(e),n=f.$element.width();u=l.x-i.x,c=l.y-i.y,m||a(u)>a(c)&&a(u)>d?(m=!0,e.preventDefault(),_&&0>u?u=u*-n/(u-n):y&&u>0&&(u=u*n/(u+n)),f._offsetDrag=-u,f.update()):a(c)>a(u)&&a(c)>d&&(h=!0)}}function s(t){r&&(r=!1,f._enableAnimation(),!h&&a(u)>v.moveRadius?v.rightToLeft?0>u?f.next():f.prev():u>0?f.next():f.prev():(f._offsetDrag=0,f.update()))}function o(t){m&&t.preventDefault()}var a=Math.abs,r=!1,h=!1,d=this.options.dragRadius,l,u,c,m,f=this,p=this.$element,g=this.$inner,v=this.options,_=!1,y=!1,w=$(window).width();g.on(t.events.down+".scooch",e).on(t.events.move+".scooch",n).on(t.events.up+".scooch",s).on("click.scooch",o).on("mouseout.scooch",s),p.on("click","[data-m-slide]",function(t){t.preventDefault();var e=$(this).attr("data-m-slide"),i=parseInt(e,10);isNaN(i)?f[e]():f.move(i)}),p.on("afterSlide",function(t,e,i){f.$items.eq(e-1).removeClass(f._getClass("active")),f.$items.eq(i-1).addClass(f._getClass("active")),f.$element.find("[data-m-slide='"+e+"']").removeClass(f._getClass("active")),f.$element.find("[data-m-slide='"+i+"']").addClass(f._getClass("active")),v.autoHideArrows&&(f.$element.find("[data-m-slide=prev]").removeClass(f._getClass("inactive")),f.$element.find("[data-m-slide=next]").removeClass(f._getClass("inactive")),1===i&&f.$element.find("[data-m-slide=prev]").addClass(f._getClass("inactive")),i===f._length&&f.$element.find("[data-m-slide=next]").addClass(f._getClass("inactive")))}),$(window).on("resize orientationchange",function(t){w!=$(window).width()&&(f._disableAnimation(),w=$(window).width(),f.update())}),p.trigger("beforeSlide",[1,1]),p.trigger("afterSlide",[1,1]),f.update()},n.prototype.unbind=function(){this.$inner.off()},n.prototype.destroy=function(){this.unbind(),this.$element.trigger("destroy"),this.$element.remove(),this.$element=null,this.$inner=null,this.$start=null,this.$current=null},n.prototype.move=function(t,e){var i=this.$element,n=this.$inner,s=this.$items,o=this.$start,a=this.$current,r=this._length,h=this._index;e=$.extend({},this.options,e),1>t?t=1:t>this._length&&(t=r),t==this._index,e.animate?this._enableAnimation():this._disableAnimation(),i.trigger("beforeSlide",[h,t]),this.$current=a=s.eq(t-1),this._offsetDrag=0,this._index=t,e.animate?this.update():this.update(function(){this._enableAnimation()}),i.trigger("afterSlide",[h,t])},n.prototype.next=function(){this.move(this._index+1)},n.prototype.prev=function(){this.move(this._index-1)},n}($,t);$.fn.scooch=function(t,i){var n=$.extend({},$.fn.scooch.defaults);return"object"==typeof t&&($.extend(n,t,!0),i=null,t=null),i=Array.prototype.slice.apply(arguments),this.each(function(){var s=$(this),o=this._scooch;o||(o=new e(this,n)),t&&(o[t].apply(o,i.slice(1)),"destroy"===t&&(o=null)),this._scooch=o}),this},$.fn.scooch.defaults={}});
// Parallax
$(function(){ParallaxScroll.init()});var ParallaxScroll={showLogs:!1,round:1e3,init:function(){return this._log("init"),this._inited?(this._log("Already Inited"),void(this._inited=!0)):(this._requestAnimationFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(a,t){window.setTimeout(a,1e3/60)}}(),void this._onScroll(!0))},_inited:!1,_properties:["x","y","z","rotateX","rotateY","rotateZ","scaleX","scaleY","scaleZ","scale"],_requestAnimationFrame:null,_log:function(a){this.showLogs&&console.log("Parallax Scroll / "+a)},_onScroll:function(a){var t=$(document).scrollTop(),e=$(window).height();this._log("onScroll "+t),$("[data-parallax]").each($.proxy(function(i,o){var s=$(o),r=[],n=!1,l=s.data("style");void 0==l&&(l=s.attr("style")||"",s.data("style",l));var d=[s.data("parallax")],c;for(c=2;s.data("parallax"+c);c++)d.push(s.data("parallax-"+c));var v=d.length;for(c=0;v>c;c++){var m=d[c],u=m["from-scroll"];void 0==u&&(u=Math.max(0,$(o).offset().top-e)),u=0|u;var h=m.distance,p=m["to-scroll"];void 0==h&&void 0==p&&(h=e),h=Math.max(0|h,1);var w=m.easing,x=m["easing-return"];if(void 0!=w&&$.easing&&$.easing[w]||(w=null),void 0!=x&&$.easing&&$.easing[x]||(x=w),w){var g=m.duration;void 0==g&&(g=h),g=Math.max(0|g,1);var f=m["duration-return"];void 0==f&&(f=g),h=1;var _=s.data("current-time");void 0==_&&(_=0)}void 0==p&&(p=u+h),p=0|p;var y=m.smoothness;void 0==y&&(y=30),y=0|y,(a||0==y)&&(y=1),y=0|y;var A=t;A=Math.max(A,u),A=Math.min(A,p),w&&(void 0==s.data("sens")&&s.data("sens","back"),A>u&&("back"==s.data("sens")?(_=1,s.data("sens","go")):_++),p>A&&("go"==s.data("sens")?(_=1,s.data("sens","back")):_++),a&&(_=g),s.data("current-time",_)),this._properties.map($.proxy(function(a){var t=0,e=m[a];if(void 0!=e){"scale"==a||"scaleX"==a||"scaleY"==a||"scaleZ"==a?t=1:e=0|e;var i=s.data("_"+a);void 0==i&&(i=t);var o=(e-t)*((A-u)/(p-u))+t,l=i+(o-i)/y;if(w&&_>0&&g>=_){var d=t;"back"==s.data("sens")&&(d=e,e=-e,w=x,g=f),l=$.easing[w](null,_,d,e,g)}l=Math.ceil(l*this.round)/this.round,l==i&&o==e&&(l=e),r[a]||(r[a]=0),r[a]+=l,i!=r[a]&&(s.data("_"+a,r[a]),n=!0)}},this))}if(n){if(void 0!=r.z){var X=m.perspective;void 0==X&&(X=800);var Y=s.parent();Y.data("style")||Y.data("style",Y.attr("style")||""),Y.attr("style","perspective:"+X+"px; -webkit-perspective:"+X+"px; "+Y.data("style"))}void 0==r.scaleX&&(r.scaleX=1),void 0==r.scaleY&&(r.scaleY=1),void 0==r.scaleZ&&(r.scaleZ=1),void 0!=r.scale&&(r.scaleX*=r.scale,r.scaleY*=r.scale,r.scaleZ*=r.scale);var Z="translate3d("+(r.x?r.x:0)+"px, "+(r.y?r.y:0)+"px, "+(r.z?r.z:0)+"px)",q="rotateX("+(r.rotateX?r.rotateX:0)+"deg) rotateY("+(r.rotateY?r.rotateY:0)+"deg) rotateZ("+(r.rotateZ?r.rotateZ:0)+"deg)",F="scaleX("+r.scaleX+") scaleY("+r.scaleY+") scaleZ("+r.scaleZ+")",S=Z+" "+q+" "+F+";";this._log(S),s.attr("style","transform:"+S+" -webkit-transform:"+S+" "+l)}},this)),window.requestAnimationFrame?window.requestAnimationFrame($.proxy(this._onScroll,this,!1)):this._requestAnimationFrame($.proxy(this._onScroll,this,!1))}};

var move = {
	onMove: function() {
		move.fadeInText();
		move.slideUp();
		move.slideDown();
		move.slideInLeft();
		move.slideInRight();
		move.bubble();
		move.postBar();
		move.arrows();
	},
	isOnScreen: function(elem) {
		var item = jQuery(elem);
		var win = $(window);
	    var viewport = {
	        top : win.scrollTop(),
	        left : win.scrollLeft()
	    };
	    viewport.right = viewport.left + win.width();
	    viewport.bottom = viewport.top + win.height();
	 
	    var bounds = item.offset();
	    bounds.right = bounds.left + item.outerWidth();
	    bounds.bottom = bounds.top + item.outerHeight();
	 
	    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
	},
	fadeInText: function() {
		var fadeWrap = jQuery('*[data-animation="textFade"]');
		if(fadeWrap.length > 0) {
			fadeWrap.each(function(){
				var text = jQuery(this);
				if(move.isOnScreen(text)) {
					text.addClass("faded");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(text)) {
							text.addClass("faded");
						} else {
							text.removeClass("faded");
						}
					});
				}
			});
		}
	},
	slideInBar: function() {
		var fadeWrap = jQuery('.barwrap');
		if(fadeWrap.length > 0) {
			fadeWrap.each(function(){
				var text = jQuery(this);
				jQuery(window).scroll(function(){
					if(move.isOnScreen(text)) {
						text.addClass("slideIn");
					} else {
						text.removeClass("slideIn");
					}
				});
			});
		}
	},
	slideUp: function() {
		var slideDownWrap = jQuery('*[data-animation="slideUp"]');
		if(slideDownWrap.length > 0){
			slideDownWrap.each(function(){
				var slide = jQuery(this);
				if(move.isOnScreen(slide)) {
					slide.addClass("slideIn");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(slide)) {
							slide.addClass("slideIn");
						} else {
							slide.removeClass("slideIn");
						}
					});
				}
			});
		}
	},
	slideDown: function() {
		var slideDownWrap = jQuery('*[data-animation="slideDown"]');
		if(slideDownWrap.length > 0){
			slideDownWrap.each(function(){
				var slide = jQuery(this);
				if(move.isOnScreen(slide)) {
					slide.addClass("slideIn");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(slide)) {
							slide.addClass("slideIn");
						} else {
							slide.removeClass("slideIn");
						}
					});
				}
			});
		}
	},
	slideInLeft: function() {
		var wrap = jQuery('*[data-animation="slideInLeft"]');
		if(wrap.length > 0){
			wrap.each(function(){
				var section = jQuery(this);
				var parent = jQuery(this).parent();
				if(move.isOnScreen(parent)) {
					section.addClass("slide");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(parent)) {
							section.addClass("slide");
						} else {
							section.removeClass("slide");
						}
					});
				}
			});
		}
	},
	slideInRight: function() {
		var wrap = jQuery('*[data-animation="slideInRight"]');
		if(wrap.length > 0){
			wrap.each(function(){
				var section = jQuery(this);
				var parent = jQuery(this).parent();
				if(move.isOnScreen(parent)) {
					section.addClass("slide");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(parent)) {
							section.addClass("slide");
						} else {
							section.removeClass("slide");
						}
					});
				}
			});
		}
	},
	bubble: function() {
		var bubble = jQuery('*[data-animation="bubble"]');
		if(bubble.length > 0){
			bubble.each(function(){
				var section = jQuery(this);
				var parent = jQuery(this).parent();
				if(move.isOnScreen(parent)) {
					section.addClass("load");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(parent)) {
							section.addClass("load");
						} else {
							section.removeClass("load");
						}
					});
				}
			});
		}
	},
	postBar: function() {
		var barwrap = jQuery('*[data-animation="postBar"]');
		if(barwrap.length > 0){
			barwrap.each(function(){
				var section = jQuery(this);
				var parent = jQuery(this).parent();
				if(move.isOnScreen(parent)) {
					section.addClass("up");
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(parent)) {
							section.addClass("up");
						} else {
							section.removeClass("up");
						}
					});
				}
			});
		}
	},
	arrows: function() {
		var section = jQuery('.m-scooch');
		if(section.length) {
			section.each(function(){
				var scooch = jQuery(this);
				if(move.isOnScreen(scooch)) {
					setTimeout(
						function(){
							jQuery('.arrows').addClass("in");
						}, 250
					);
				} else {
					jQuery(window).scroll(function(){
						if(move.isOnScreen(scooch)) {
							setTimeout(
								function(){
									jQuery('.arrows').addClass("in");
								}, 250
							);
						}
					});
				}
			});
		}
	}
};
var init = {
	onReady: function() {
		init.videoModal();
		init.FixedHeader();
		init.contactBtn();
		init.openMenu();
		init.delayClass();
		init.BlogAjax();
		init.scooch();
		init.reviewStars();
		init.SVG();
	},
	SVG: function() {
	    jQuery('img.svg').each(function() {
	        var jQueryimg = jQuery(this);
	        var imgID = jQueryimg.attr('id');
	        var imgClass = jQueryimg.attr('class');
	        var imgURL = jQueryimg.attr('src');

	        jQuery.get(imgURL, function(data) {
	            // Get the SVG tag, ignore the rest
	            var jQuerysvg = jQuery(data).find('svg');

	            // Add replaced image's ID to the new SVG
	            if(typeof imgID !== 'undefined') {
	                jQuerysvg = jQuerysvg.attr('id', imgID);
	            }
	            // Add replaced image's classes to the new SVG
	            if(typeof imgClass !== 'undefined') {
	                jQuerysvg = jQuerysvg.attr('class', imgClass+' replaced-svg');
	            }

	            // Remove any invalid XML tags as per http://validator.w3.org
	            jQuerysvg = jQuerysvg.removeAttr('xmlns:a');

	            // Replace image with new SVG
	            jQueryimg.replaceWith(jQuerysvg);

	        }, 'xml');

	    });
	},
	reviewStars: function() {
		var ranking = jQuery('#review_ranking').val();
		console.log(ranking);
		if(ranking !== "") {
			jQuery('#ReviewRanking li[data-rating='+ranking+']').addClass("active");
			jQuery('#ReviewRanking li[data-rating='+ranking+']').prevAll().addClass("active");
		}
	},
	scooch: function() {
		jQuery('.m-scooch').scooch();
	},
	delayClass: function() {
		jQuery('.entry').each(function(index) {
           jQuery(this).delay(100*index).queue(function(){
                jQuery(this).addClass("load");
            });
        });
	},
	openMenu: function() {
		jQuery('.btn-menu').click(function(e){
			e.preventDefault();
	    	if(jQuery('header').hasClass("open")) {
	    		jQuery('header').removeClass("open");
	    		jQuery('.menu ul li').removeClass("in").dequeue();
	    	} else {
	    		jQuery('header').addClass("open");
	    		jQuery('.menu ul li').each(function(e){
	    			jQuery(this).delay(50*e).queue(function(){
	    				jQuery(this).addClass("in");
	    			});
	    		});
	    	}
	    });
	    jQuery('.menu-home-page-container').addClass("outer");
	},
	FixedHeader: function() {
		jQuery(window).scroll(function(){
			var sticky = jQuery('.sticky'),
			  	scroll = jQuery(window).scrollTop();

			if (scroll >= 431) {
				sticky.addClass('fixed');
			} else {
			 	sticky.removeClass('fixed');
		 	}
		});
	},
	videoModal: function() {
		// Handling The YouTube Videos play in modals. Basically refreshing the src using this jquery to reload the video
		jQuery('.singlevideo').click( function(e) {

			e.preventDefault();

			var videoID = jQuery(this).attr("data-video");
			var type = jQuery(this).attr("data-type");

			if(type === "vimeo") {
				var videoURL = 'https://player.vimeo.com/video/'+videoID;
			}
			if(type === "youtube") {
				var videoURL = 'https://www.youtube.com/embed/'+videoID;
			}
			jQuery('#videomodal .modal-body').html('<i class="fa fa-times-circle" data-dismiss="modal"></i><iframe src="'+videoURL+'?autoplay=1&quality=1080p" class="videoFrame" frameborder="0" allowfullscreen></iframe>');

			jQuery('#videomodal').on('hidden.bs.modal', function() {
		    	jQuery('iframe').remove();
		    });

		});
	},
	newsletterSubmit: function() {
		var Frm = jQuery('#newsletterfrm');
		var type = Frm.attr("data-form");
		console.log(type);
    	jQuery('form[data-form="'+type+'"] .btn-submit').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajaxbloglisting.ajaxurl,
            type: Frm.attr('method'),
            data: {
            	firstname: jQuery('#firstname').val(),
            	lastname: jQuery('#lastname').val(),
            	emailaddress: jQuery('#emailaddress').val(),
            	action: 'sendNewsletter'
            },
            dataType: 'html',
            beforeSubmit : function(arr, $form, options) {
	            arr.push( { "name" : "nonce", "value" : meta.nonce });
	        },
            success: function(data,type) {
            	init.contactResponse(data,type);
            }
        });
        return false;
	},
	contactSubmit: function() {
		var Frm = jQuery('#contactfrm');
		var type = Frm.attr("data-form");
    	jQuery('form[data-form="'+type+'"] .btn-submit').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajaxbloglisting.ajaxurl,
            type: Frm.attr('method'),
            data: {
            	firstname: jQuery('#firstname').val(),
            	lastname: jQuery('#lastname').val(),
            	emailaddress: jQuery('#emailaddress').val(),
            	message: jQuery('#message').val(),
            	action: 'sendContact'
            },
            dataType: 'html',
            beforeSubmit : function(arr, $form, options) {
	            arr.push( { "name" : "nonce", "value" : meta.nonce });
	        },
            success: function(data) {
            	init.contactResponse(data,type);
            }
        });
        return false;
	},
	contactResponse: function(response, frm) {
		console.log(response);
		console.log(frm);
        if (response === "Success") {
        	jQuery('form[data-form="'+frm+'"] .btn-submit').replaceWith('<button class="btn btn-submit success"><i class="fa fa-check"></i></button>');
            jQuery("input").val("");
            jQuery("textarea").val("");
            setTimeout(
            	function() {
            		jQuery('form[data-form="'+frm+'"] .btn-submit').replaceWith('<button class="btn btn-submit">Submit</button>');
            	}, 2500
        	);
        }
        if (response === "E") {
         	jQuery('form[data-form="'+frm+'"] .btn-submit').replaceWith('<button class="btn btn-submit error"><i class="fa fa-ban"></i></button>');
         	setTimeout(
            	function() {
            		jQuery('form[data-form="'+frm+'"] .btn-submit').replaceWith('<button class="btn btn-submit">Submit</button>');
            	}, 2500
        	);
        }
	},
	contactBtn: function() {
		jQuery('#contactfrm').submit(init.contactSubmit);
		jQuery('#newsletterfrm').submit(init.newsletterSubmit);
	},
	BlogLoadPosts: function() {

        var catID = jQuery('#listing').attr('data-id');

        jQuery.ajax({
            url: ajaxbloglisting.ajaxurl,
            type: "post",
            data: {
            	action: 'ajaxBlog',
            	pageNumber: ajaxbloglisting.page, 
            	cat : catID
            },
            dataType: "html",
            beforeSend : function(){
                if(ajaxbloglisting.page !== 1){
                    jQuery("#listing").append('<i id="temp_load" class="fa fa-spinner fa-spin"></i>');
                }
                ajaxbloglisting.loading = true;
            },
            success : function(data){
                var $data = jQuery(data);
                // add counts
                ajaxbloglisting.page++;
                if($data.length && ajaxbloglisting.page > 1){
                    // hide response data
                    $data.hide();
                    // add data to #blog-listing #content
                    jQuery("#listing").append($data);
                    // fade response data in
                    $data.fadeIn(200, function(){
                        jQuery("#temp_load").remove();
                        ajaxbloglisting.loading = false;
                    });
                    // progresively bubble in new posts
                    $data.find('.entry').each(function(index) {
                       jQuery(this).delay(100*index).queue(function(){
                            jQuery(this).addClass("load");
                        });
                    });
                } else {
                    // remove loader
                    jQuery("#temp_load").remove();
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                jQuery("#temp_load").remove();
                window.alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    },
    BlogAjax: function () {
        jQuery(window).scroll( function() {
            var totalHeight = (jQuery(window).scrollTop() + jQuery(window).height());
            var contentHeight = (jQuery("#listing").scrollTop() + jQuery("#listing").height() + 225);
            if(!ajaxbloglisting.loading && totalHeight > contentHeight) {
                ajaxbloglisting.loading = true;
                init.BlogLoadPosts();
            }
        });
    }
};
jQuery(document).ready(function() {

	move.onMove();
	init.onReady();
});