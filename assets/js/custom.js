// Instafeed
(function(){var e;e=function(){function e(e,t){var n,r;this.options={target:"instafeed",get:"popular",resolution:"thumbnail",sortBy:"none",links:!0,mock:!1,useHttp:!1};if(typeof e=="object")for(n in e)r=e[n],this.options[n]=r;this.context=t!=null?t:this,this.unique=this._genKey()}return e.prototype.hasNext=function(){return typeof this.context.nextUrl=="string"&&this.context.nextUrl.length>0},e.prototype.next=function(){return this.hasNext()?this.run(this.context.nextUrl):!1},e.prototype.run=function(t){var n,r,i;if(typeof this.options.clientId!="string"&&typeof this.options.accessToken!="string")throw new Error("Missing clientId or accessToken.");if(typeof this.options.accessToken!="string"&&typeof this.options.clientId!="string")throw new Error("Missing clientId or accessToken.");return this.options.before!=null&&typeof this.options.before=="function"&&this.options.before.call(this),typeof document!="undefined"&&document!==null&&(i=document.createElement("script"),i.id="instafeed-fetcher",i.src=t||this._buildUrl(),n=document.getElementsByTagName("head"),n[0].appendChild(i),r="instafeedCache"+this.unique,window[r]=new e(this.options,this),window[r].unique=this.unique),!0},e.prototype.parse=function(e){var t,n,r,i,s,o,u,a,f,l,c,h,p,d,v,m,g,y,b,w,E,S,x,T,N,C,k,L,A,O,M,_,D;if(typeof e!="object"){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"Invalid JSON data"),!1;throw new Error("Invalid JSON response")}if(e.meta.code!==200){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,e.meta.error_message),!1;throw new Error("Error from Instagram: "+e.meta.error_message)}if(e.data.length===0){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"No images were returned from Instagram"),!1;throw new Error("No images were returned from Instagram")}this.options.success!=null&&typeof this.options.success=="function"&&this.options.success.call(this,e),this.context.nextUrl="",e.pagination!=null&&(this.context.nextUrl=e.pagination.next_url);if(this.options.sortBy!=="none"){this.options.sortBy==="random"?M=["","random"]:M=this.options.sortBy.split("-"),O=M[0]==="least"?!0:!1;switch(M[1]){case"random":e.data.sort(function(){return.5-Math.random()});break;case"recent":e.data=this._sortBy(e.data,"created_time",O);break;case"liked":e.data=this._sortBy(e.data,"likes.count",O);break;case"commented":e.data=this._sortBy(e.data,"comments.count",O);break;default:throw new Error("Invalid option for sortBy: '"+this.options.sortBy+"'.")}}if(typeof document!="undefined"&&document!==null&&this.options.mock===!1){m=e.data,A=parseInt(this.options.limit,10),this.options.limit!=null&&m.length>A&&(m=m.slice(0,A)),u=document.createDocumentFragment(),this.options.filter!=null&&typeof this.options.filter=="function"&&(m=this._filter(m,this.options.filter));if(this.options.template!=null&&typeof this.options.template=="string"){f="",d="",w="",D=document.createElement("div");for(c=0,N=m.length;c<N;c++){h=m[c],p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);E=p.width,y=p.height,b="square",E>y&&(b="landscape"),E<y&&(b="portrait"),v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),d=this._makeTemplate(this.options.template,{model:h,id:h.id,link:h.link,type:h.type,image:v,width:E,height:y,orientation:b,caption:this._getObjectProperty(h,"caption.text"),likes:h.likes.count,comments:h.comments.count,location:this._getObjectProperty(h,"location.name")}),f+=d}D.innerHTML=f,i=[],r=0,n=D.childNodes.length;while(r<n)i.push(D.childNodes[r]),r+=1;for(x=0,C=i.length;x<C;x++)L=i[x],u.appendChild(L)}else for(T=0,k=m.length;T<k;T++){h=m[T],g=document.createElement("img"),p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),g.src=v,this.options.links===!0?(t=document.createElement("a"),t.href=h.link,t.appendChild(g),u.appendChild(t)):u.appendChild(g)}_=this.options.target,typeof _=="string"&&(_=document.getElementById(_));if(_==null)throw o='No element with id="'+this.options.target+'" on page.',new Error(o);_.appendChild(u),a=document.getElementsByTagName("head")[0],a.removeChild(document.getElementById("instafeed-fetcher")),S="instafeedCache"+this.unique,window[S]=void 0;try{delete window[S]}catch(P){s=P}}return this.options.after!=null&&typeof this.options.after=="function"&&this.options.after.call(this),!0},e.prototype._buildUrl=function(){var e,t,n;e="https://api.instagram.com/v1";switch(this.options.get){case"popular":t="media/popular";break;case"tagged":if(!this.options.tagName)throw new Error("No tag name specified. Use the 'tagName' option.");t="tags/"+this.options.tagName+"/media/recent";break;case"location":if(!this.options.locationId)throw new Error("No location specified. Use the 'locationId' option.");t="locations/"+this.options.locationId+"/media/recent";break;case"user":if(!this.options.userId)throw new Error("No user specified. Use the 'userId' option.");t="users/"+this.options.userId+"/media/recent";break;default:throw new Error("Invalid option for get: '"+this.options.get+"'.")}return n=e+"/"+t,this.options.accessToken!=null?n+="?access_token="+this.options.accessToken:n+="?client_id="+this.options.clientId,this.options.limit!=null&&(n+="&count="+this.options.limit),n+="&callback=instafeedCache"+this.unique+".parse",n},e.prototype._genKey=function(){var e;return e=function(){return((1+Math.random())*65536|0).toString(16).substring(1)},""+e()+e()+e()+e()},e.prototype._makeTemplate=function(e,t){var n,r,i,s,o;r=/(?:\{{2})([\w\[\]\.]+)(?:\}{2})/,n=e;while(r.test(n))s=n.match(r)[1],o=(i=this._getObjectProperty(t,s))!=null?i:"",n=n.replace(r,""+o);return n},e.prototype._getObjectProperty=function(e,t){var n,r;t=t.replace(/\[(\w+)\]/g,".$1"),r=t.split(".");while(r.length){n=r.shift();if(!(e!=null&&n in e))return null;e=e[n]}return e},e.prototype._sortBy=function(e,t,n){var r;return r=function(e,r){var i,s;return i=this._getObjectProperty(e,t),s=this._getObjectProperty(r,t),n?i>s?1:-1:i<s?1:-1},e.sort(r.bind(this)),e},e.prototype._filter=function(e,t){var n,r,i,s,o;n=[],r=function(e){if(t(e))return n.push(e)};for(i=0,o=e.length;i<o;i++)s=e[i],r(s);return n},e}(),function(e,t){return typeof define=="function"&&define.amd?define([],t):typeof module=="object"&&module.exports?module.exports=t():e.Instafeed=t()}(this,function(){return e})}).call(this);
// Cookie
!function(e){if("function"==typeof define&&define.amd)define(e);else if("object"==typeof exports)module.exports=e();else{var n=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=n,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var t=arguments[e];for(var o in t)n[o]=t[o]}return n}function n(t){function o(n,r,i){var c;if(arguments.length>1){if(i=e({path:"/"},o.defaults,i),"number"==typeof i.expires){var s=new Date;s.setMilliseconds(s.getMilliseconds()+864e5*i.expires),i.expires=s}try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(a){}return r=t.write?t.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=encodeURIComponent(String(n)),n=n.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),n=n.replace(/[\(\)]/g,escape),document.cookie=[n,"=",r,i.expires&&"; expires="+i.expires.toUTCString(),i.path&&"; path="+i.path,i.domain&&"; domain="+i.domain,i.secure?"; secure":""].join("")}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var f=p[u].split("="),l=f[0].replace(d,decodeURIComponent),m=f.slice(1).join("=");'"'===m.charAt(0)&&(m=m.slice(1,-1));try{if(m=t.read?t.read(m,l):t(m,l)||m.replace(d,decodeURIComponent),this.json)try{m=JSON.parse(m)}catch(a){}if(n===l){c=m;break}n||(c[l]=m)}catch(a){}}return c}return o.get=o.set=o,o.getJSON=function(){return o.apply({json:!0},[].slice.call(arguments))},o.defaults={},o.remove=function(n,t){o(n,"",e(t,{expires:-1}))},o.withConverter=n,o}return n(function(){})});

var move = {
	onMove: function() {
		move.fadeInText();
		move.slideUp();
		move.slideDown();
		move.slideInLeft();
		move.slideInRight();
		move.bubble();
		move.postBar();
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
	}
};
var init = {
	onReady: function() {
		init.videoModal();
		init.FixedHeader();
		init.NewsletterBtn();
		init.ContactBtn();
		init.openMenu();
		init.delayClass();
		init.BlogAjax();
	},
	delayClass: function() {
		jQuery('.entry').each(function(index) {
           jQuery(this).delay(200*index).queue(function(){
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

            if(type === "youtube") {
                var yt_URL = 'https://www.youtube.com/embed/'+videoID+'?autoplay=1';
                jQuery('.modal-body').append('<iframe class="videoFrame" src="'+yt_URL+'" width="853" height="480" frameborder="0" allowfullscreen></iframe>');
            }
            if(type === "vimeo") {
                var vimeo_URL = 'https://player.vimeo.com/video/'+videoID+'?autoplay=1';
                jQuery('.modal-body').append('<iframe class="videoFrame" src="'+vimeo_URL+'" width="853" height="480" frameborder="0" allowfullscreen></iframe>');
            }
            jQuery('#videomodal').modal('show');

            jQuery('#videomodal').on('hidden.bs.modal', function() {
                jQuery('.videoFrame').remove();
            });

        });
    },
	NewsletterSubmit: function() {
		var numb = jQuery(this).attr("data-form");
		var Frm = jQuery('#newsletter-frm-'+numb);
		var Btn = jQuery('.btn-submit', Frm);
    	jQuery('<i class="fa fa-spinner fa-spin"></i>').prependTo(Btn);
        jQuery.ajax({
            url: Frm.attr('action')+"?ajax=true&numb="+numb,
            type: Frm.attr('method'),
            data: Frm.serialize(),
            success: init.NewsletterResponse
        });
        return false;
	},
	NewsletterResponse: function(data, url) {
		var numb = this.url.substring(this.url.lastIndexOf('=') + 1);
		var Frm = jQuery('#newsletter-frm-'+numb);
        jQuery('.btn-submit i').remove();
        if (data === "Success") {
        	jQuery('.btn-submit', Frm).replaceWith('<button class="btn-custom btn-pink btn-submit success"><i class="fa fa-check"> Success</button>');
            jQuery("input[name='firstname_"+numb+"']").val( "" );
            jQuery("input[name='lastname_"+numb+"']").val( "" );
            jQuery("input[name='emailaddress_"+numb+"']").val( "" );
            setTimeout(
            	function() {
            		jQuery('.btn-submit', Frm).replaceWith('<button class="btn-custom btn-pink btn-submit">Subscribe</button>');
            	}, 2500
        	);
        }
        if (data === "E") {
         	jQuery('.btn-submit', Frm).replaceWith('<button class="btn-custom btn-pink btn-submit error">Please fill out all fields</button>');
         	setTimeout(
            	function() {
            		jQuery('.btn-submit', Frm).replaceWith('<button class="btn-custom btn-pink btn-submit">Subscribe</button>');
            	}, 2500
        	);
        }
	},
	NewsletterBtn: function() {
		jQuery('#newsletter-frm-1').submit(init.NewsletterSubmit);
		jQuery('#newsletter-frm-2').submit(init.NewsletterSubmit);
		jQuery('#newsletter-frm-3').submit(init.NewsletterSubmit);
		jQuery('#newsletter-frm-4').submit(init.NewsletterSubmit);
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
    },
    ContactSubmit: function() {
		var Frm = jQuery('#contactfrm');
    	jQuery('<i class="fa fa-spinner fa-spin"></i>').prependTo('.btn-submit');
        jQuery.ajax({
            url: Frm.attr('action')+"?ajax=true",
            type: Frm.attr('method'),
            data: Frm.serialize(),
            success: init.ContactResponse
        });
        return false;
	},
	ContactResponse: function(response) {
        jQuery('.btn-submit i').remove();
        if (response === "Success") {
        	jQuery('.btn-submit').replaceWith('<button class="btn-custom btn-pink btn-submit success"><i class="fa fa-check"></i> Success</button>');
            jQuery("input[name='firstname']").val( "" );
            jQuery("input[name='lastname']").val( "" );
            jQuery("input[name='emailaddress']").val( "" );
            jQuery("input[name='interest']").val( "" );
            jQuery('.btn-dropdown').replaceWith('<button type="button" class="btn btn-blue btn-block btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Me <i class="fa fa-caret-down"></i></button>');
            jQuery("textarea").val( "" );
            setTimeout(
            	function() {
            		jQuery('.btn-submit').replaceWith('<button class="btn-custom btn-pink btn-submit">Submit</button>');
            	}, 2500
        	);
        }
        if (response === "E") {
         	jQuery('.btn-submit').replaceWith('<button class="btn-custom btn-pink btn-submit error">Please fill out all fields</button>');
         	setTimeout(
            	function() {
            		jQuery('.btn-submit').replaceWith('<button class="btn-custom btn-pink btn-submit">Submit</button>');
            	}, 2500
        	);
        }
	},
	ContactBtn: function() {
		jQuery('#contactfrm').submit(init.ContactSubmit);
	},
};
jQuery(document).ready(function() {

	move.onMove();
	init.onReady();
});