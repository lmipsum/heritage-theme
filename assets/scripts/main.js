/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
	  	var urlAndTitle = slider_metadatas;
        // JavaScript to be fired on all pages
		  function changeUrlPage(title, url, link, description) {
			  if (typeof (history.pushState) !== "undefined") {
				  var obj = { link: link, title: title, description: description};
				  document.title = title;
				  $('meta[name="description"]').attr('content', description);
				  history.pushState(obj, title, url);
			  } else {
				  alert("Browser does not support HTML5.");
			  }
		  }

		  function changeUrl(section, i, pathname) {
			  var section_array = [];
			  pathname = pathname || 0;
			  if ( pathname !== 0 ) {
				  i = 0;
				  section_array = urlAndTitle.filter(function(e){return e.url === pathname.toString()});
				  section_array = section_array.filter(function(e){return e.section === section.toString()});
			  } else {
				  section_array = urlAndTitle.filter(function(e){return e.section === section.toString()});
			  }
			  if ( typeof section_array[0] === "undefined" ) {
				  section_array = urlAndTitle;
			  }
			  if (typeof (history.pushState) !== "undefined") {
				  var obj = {
					  link: section,
					  title: section_array[i].title,
					  nthImage: section_array[i].nthImage,
					  description: section_array[i].description
				  };
				  document.title = obj.title;
				  $('meta[name="description"]').attr('content', obj.description);
				  history.pushState(obj, obj.title, section_array[i].url);
			  } else {
				  alert("Browser does not support HTML5.");
			  }
		  }

		  var footerCloseHelper = 1,
			  toggled = false;
		  function toggleFooter(){
			  if(!toggled){
				  toggled = true;
				  $(".footer-close-button").toggleClass("closed").css("pointer-events", "none");
				  $(".footer-top").css("pointer-events", "none");
				  $(".footer-main").slideToggle(1000);
				  $(".cycloneslider-template-thumbnails, .cycloneslider-caption-wrapper, .cycloneslider-template-default .cycloneslider-caption").toggleClass("closed");
				  $(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
					  $(this).css("top", (parseInt($(this).css("top")) + footerCloseHelper * 198) + "px");
				  });
				  footerCloseHelper *= -1;
				  setTimeout(function(){
					  $(".footer-close-button").css("pointer-events", "auto");
					  $(".footer-top").css("pointer-events", "auto");
					  toggled = false;
				  }, 1000);
				  if(Modernizr.mq("(min-width: 1200px)")){
					  if(! ($(".footer-close-button").hasClass("closed"))){
						  setTimeout(function(){
							  if(! ($(".footer-close-button").hasClass("closed"))){
								  if(! $("footer").is(":hover")){
									  toggleFooter();
									  $(".checkboxes").slideUp();
									  $("head").children('#headhack').remove();

								  }else{
									  $("footer").on("mouseleave", function(){
										  toggleFooter();
										  $(".checkboxes").slideUp();
										  $("head").children('#headhack').remove();
										  $("footer").off("mouseleave");
									  });
								  }
							  }
						  }, 4000);
					  }
				  }
			  }
		  }

		  var BrowserDetect = {
			  init: function () {
				  this.browser = this.searchString(this.dataBrowser) || "Other";
				  this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
			  },
			  searchString: function (data) {
				  for (var i = 0; i < data.length; i++) {
					  var dataString = data[i].string;
					  this.versionSearchString = data[i].subString;

					  if (dataString.indexOf(data[i].subString) !== -1) {
						  return data[i].identity;
					  }
				  }
			  },
			  searchVersion: function (dataString) {
				  var index = dataString.indexOf(this.versionSearchString);
				  if (index === -1) {
					  return;
				  }

				  var rv = dataString.indexOf("rv:");
				  if (this.versionSearchString === "Trident" && rv !== -1) {
					  return parseFloat(dataString.substring(rv + 3));
				  } else {
					  return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
				  }
			  },

			  dataBrowser: [
				  {string: navigator.userAgent, subString: "Edge", identity: "MS Edge"},
				  {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
				  {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
				  {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
				  {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
				  {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
				  {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
			  ]

		  };

		  var getUrlParameter = function getUrlParameter(sParam) {
			  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				  sURLVariables = sPageURL.split('&'),
				  sParameterName,
				  i;

			  for (i = 0; i < sURLVariables.length; i++) {
				  sParameterName = sURLVariables[i].split('=');

				  if (sParameterName[0] === sParam) {
					  return sParameterName[1] === undefined ? true : sParameterName[1];
				  }
			  }
		  };
		var	History = window.History;
				//State = History.getState();
		var newsSlideMarginLeft, newsSlideMarginRight, pathname, link;

		var newstitle = getUrlParameter('title');

		if(window.location.href.indexOf("&title") === -1){
			pathname = window.location.href.split("/").pop().split("=").pop();
		} else {
			var newsTitleFromUrl = pathname = window.location.href.split("/").pop().split("=").pop();
			pathname = window.location.href.split("/").pop().split("=");//.pop().replace("&?title", "");
			pathname = pathname[pathname.length - 2].replace("&title", "");
		}

		var subPageContent = {
			home: $("#homeId").html(),
			restaurant: $("#restaurantId").html(),
			kulinarik: $("#kulinarikId").html(),
			news: $("#newsId").html(),
			presse: $("#presseId").html(),
			impressum: $("#impressumId").html(),
			datenschutz: $("#datenschutzId").html()
		};
		
		if($("#newsId section .container .news-container .event").length < 3){
			$("#newsId section .container .news-container").css("margin", "0 auto");
			$("#newsId .pager").remove();
		}
		
		$(window).load(function(){
			if(pathname ===""){
				changeUrlPage(urlAndTitle[0].title, urlAndTitle[0].url, "#homeId", urlAndTitle[0].description );
			}else{
				var found = false;
				for(var i = 0; i  < urlAndTitle.length; i++){
					if(pathname === urlAndTitle[i].url){
						found = true;
						if(urlAndTitle[i].nthImg === undefined){
							changeUrlPage(urlAndTitle[i].title, urlAndTitle[i].url, urlAndTitle[i].section,  urlAndTitle[i].description );
						}else{
							changeUrl(urlAndTitle[i].section, 0, pathname );
						}
						document.title = urlAndTitle[i].title;
							$("body").animate({"scrollTop" : "0"}, 2000);
							$("body").find("div, a").css("pointer-events", "none");
							$("main > div").fadeOut();
							$("a.selected").removeClass("selected");
							
							switch(urlAndTitle[i].section){
								case "#homeId":
									$("#home-link").find("a").addClass("selected");
									break;
								case "#restaurantId":
									$("#restaurant-link").find("a").addClass("selected");
									break;
								case "#kulinarikId":
									$("#kulinarik-link").find("a").addClass("selected");
									break;
								case "#newsId":
									$("#news-link").find("a").addClass("selected");
									break;
								case "#impressumId":
									$(".impressum").find("a").addClass("selected");
									break;
								case "#presseId":
									$(".presse").find("a").addClass("selected");
									break;
							}
							
							$(".active-page").removeClass("active-page").fadeOut(1000);
							
							if( Modernizr.mq("(max-width: 1199px)") ){
								
								$(urlAndTitle[i].section).fadeIn(1000);
								//$("main").find("div").css("height", $(this).find("section.active").find(".cycle-slide img").height());
								$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
									$(this).css("top", ($(this).parent().find($(".cycloneslider-template-thumbnails.cycloneslider")).find($(".cycloneslider-slides")).find($(".cycloneslider-slide.cycle-slide-active")).find("img:nth-of-type(1)").height()) + "px");
								});
								if($("#menu").is(":visible")){
									$("#menu").slideToggle();
								}
								if(Modernizr.mq("(orientation: landscape)")){
									if( Modernizr.mq("(max-device-width: 996px)") ){
										$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
									}else{
										$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +190  + "px");
									}
								}else{
									$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
								}
								
								setTimeout(function(){
									/* it should check the slider image + content height dynamically, add more breakpoints if necessary */
									$("main").children("div:not(#homeId, #newsId)").each(function(){
										
										if($(this).is(":visible")){
											var padding, $this = $(this);
											if(Modernizr.mq("(max-device-width: 992px)")){
												padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
												$this.css("padding-bottom", padding + "px");
											}else{
												padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
												$this.css("padding-bottom", padding + "px");
											}
											
										}
									});
									$("body").find("div, a").css("pointer-events", "auto");
								}, 1650);
							}else{
								$(".sub-navigation").animate({"opacity": "0"}, 700);
								$(urlAndTitle[i].section).delay(1000).fadeIn(1000);
								$(".sub-navigation").delay(1000).animate({"opacity" : "1"}, 500, "linear");
								$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails, .cycloneslider-caption-wrapper").css("opacity", "0").delay(2000).animate({"opacity" : "1"}, 500, "linear");
								setTimeout(function(){
									if(newsTitleFromUrl !== undefined){
										var foundEvent = false;
										$("#newsId").find("h2").each(function(){
											var $this = $(this),
												id = $this.parent().attr('id');
											if($this.text().replace(/ /g, "-").toLowerCase() === newsTitleFromUrl && !foundEvent){
												var $openThis = $this.siblings(".news-open");
												$openThis.addClass("working");
												setTimeout(function(){
													$openThis.removeClass("working");
												}, 600);
												$(".content-container").find(".event-instance").html($openThis.siblings(".event-instance").html());
												var heightofevent = parseInt($(".content-container").find(".event-instance").height(),10);
												$(".content-container").addClass("opened").slideToggle();
												if(Modernizr.mq("(min-width: 1200px)")){
													setTimeout(function(){
														$(".content-container.opened").css("min-height", $(".content-container.opened").find(".event-instance").height() + 190 + "px");
													}, 600);
												}
												$("#events, .pager").fadeOut();
												history.pushState({newsInstance: true, link: "#newsId"}, null, "news-heritage-restaurant-hamburg-" +  id.replace("event_", ""));
											}
											foundEvent = true;
										});
									}

									if (!$('#event_' + newstitle).find('.news-open').hasClass("working")) {
										var $this = $('#event_' + newstitle).find('.news-open');
										if ( $this.length !== 0 ) {
											$this.addClass("working");
											$(".content-container").find(".event-instance").html($this.siblings(".event-instance").html());
											$(".content-container").addClass("opened").slideToggle();
											if (Modernizr.mq("(min-width: 1200px)")) {
												$(".content-container.opened").css("min-height", $(".content-container.opened").find(".event-instance").height() + 190 + "px");
											}
											$("#events, .pager").fadeOut();
											history.pushState({
												newsInstance: true,
												link: "#newsId"
											}, null, "news-heritage-restaurant-hamburg-" + $this.parent().attr('id').replace("event_", ""));
											$this.removeClass("working");
										}
									}
								}, 1000);
								
								setTimeout(function(){
									$("body").find("div, a").css("pointer-events", "auto");
									
								}, 3000);
							}
							if(urlAndTitle[i].nthImg !== undefined){
								$(urlAndTitle[i].section).find(".cycloneslider-thumbnails ul li:nth-of-type(" + urlAndTitle[i].nthImg + ")").click();
							}
					}
				}
				if(!found){
					if (window.location.href.indexOf("unsubscribe") > -1) { $("#newsletter-popup").fadeIn(); }
					changeUrlPage(urlAndTitle[0].title, urlAndTitle[0].url, "#homeId", urlAndTitle[0].description );
				}
			}
			if(BrowserDetect.browser ==="Explorer" || BrowserDetect.browser ==="MS Edge"){
				$(".cycloneslider-slide img").each(function(){
					var src = $(this).attr("src");
					$this = $(this);
					var heightOfImage = $( window ).width() * 0.624;
					if(Modernizr.mq("(min-width: 1200px)")){
						$(this).parent().prepend($("<div>").css({"background-image" : "url(" + src + ")", "background-size": "cover", "width" : "100vw", "height" : "100vh"}));
					}else{
						$(this).parent().prepend($("<div>").css({"background-image" : "url(" + src + ")", "background-size": "cover", "width" : "100vw", "height" : heightOfImage + "px"}));
					}
					$this.remove();
				});
			}
		
			if(Modernizr.mq("(min-width: 1200px)")){
				setTimeout(function(){
					if(!($(".footer-close-button").hasClass("closed"))){
						if(! $("footer").is(":hover")){
							toggleFooter();
						}else{
							$("footer").on("mouseleave", function(){
								toggleFooter();
								$("footer").off("mouseleave");
							});
						}
					}
				}, 4000);
			}
			if(pathname.charAt(0) === "#"){
				$(".sub-navigation").animate({"opacity": "0"}, 700);
				$(pathname).fadeIn(1000);
				$(".sub-navigation").delay(1000).animate({"opacity" : "1"}, 500, "linear");
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails, .cycloneslider-caption-wrapper").css("opacity", "0").delay(2000).animate({"opacity" : "1"}, 500, "linear");
				$(pathname).addClass("active-page");
				$("#menu div li a").each(function(){
					if($(this).attr("href") == pathname){
						$(this).addClass("selected");
					}
				});
			}else{
				$(".active-page").fadeIn(1000);
			}
			
		});
		
		$("#menu div li a, .bottom-menu a, #verpassen .checkboxes .checkbox-label a").on("click", function(event){
			event.preventDefault();
			$("body").animate({"scrollTop" : "0"}, 2000);
			$("body").find("div, a").css("pointer-events", "none");
			$("main > div").fadeOut();
			$("a.selected").removeClass("selected");
			
			link = $(this).attr("data-hash");
			$(".active-page").removeClass("active-page").fadeOut(1000);
			$($(this).attr("data-hash")).addClass("active-page");
			$(this).addClass("selected");
			
			pathname = window.location.href.split("/").pop();
			
			if( Modernizr.mq("(max-width: 1199px)") ){
				$(link).fadeIn(1000);
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
					$(this).css("top", ($(this).parent().find($(".cycloneslider-template-thumbnails.cycloneslider")).find($(".cycloneslider-slides")).find($(".cycloneslider-slide.cycle-slide-active")).find("img:nth-of-type(1)").height()) + "px");
				});
				if($("#menu").is(":visible")){
					$("#menu").slideToggle();
				}
				$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120 + "px");
				
				setTimeout(function(){
					/* it should check the slider image + content height dynamically, add more breakpoints if necessary */
					$("main").children("div:not(#homeId, #newsId)").each(function(){
										
						if($(this).is(":visible")){
							var padding, $this = $(this);
							if(Modernizr.mq("(max-device-width: 992px)")){
								padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
								$this.css("padding-bottom", padding + "px");
							}else{
								padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
								$this.css("padding-bottom", padding + "px");
							}
							
						}
					});
					if(BrowserDetect.browser ==="Firefox" || BrowserDetect.browser ==="Explorer" || BrowserDetect.browser ==="MS Edge" ){
						$(window).trigger('resize');
					}
					$("body").find("div, a").css("pointer-events", "auto");
				}, 1650);
			}else{
				$(".sub-navigation").animate({"opacity": "0"}, 700);
				$(link).delay(1000).fadeIn(1000);
				$(".sub-navigation").delay(1000).animate({"opacity" : "1"}, 500, "linear");
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails, .cycloneslider-caption-wrapper").css("opacity", "0").delay(2000).animate({"opacity" : "1"}, 500, "linear");
				setTimeout(function(){
					$("body").find("div, a").css("pointer-events", "auto");
				}, 3000);
			}

			if ( /^#(homeId|restaurantId|newsId|impressumId|datenschutzId|presseId)$/.test(link) ) {
				var filtered_array = urlAndTitle.filter(function(e){return e.section === link});
				changeUrlPage(filtered_array[0].title, filtered_array[0].url, link,  filtered_array[0].description);
			}
		});

	  	$("#restaurantId, #kulinarikId").find(".cycloneslider-thumbnails ul li").on("click", function(event){
			if( event.hasOwnProperty('originalEvent') ){
				var $this = $(this);
			  	changeUrl( "#" + $this.closest('section').parent().attr('id'), $this.index());
			}
	  	});

		$(".brand").on("click", function(){
			$("body").animate({"scrollTop" : "0"}, 2000);
			$("body").find("div, a").css("pointer-events", "none");
			$("a.selected").removeClass("selected");
			$(".active-page").removeClass("active-page").fadeOut(1000);
			$($(this).attr("data-hash")).addClass("active-page");
			$("#home-link").addClass("selected");
			
			if( Modernizr.mq("(max-width: 1199px)") ){
				$("#homeId").fadeIn(1000);
				$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120 + "px");
			}else{
				$("#homeId").delay(1000).fadeIn(1000);
				if ($(".footer-close-button").hasClass("closed")){
					toggleFooter();
				}				
			}
			setTimeout(function(){
				$("body").find("div, a").css("pointer-events", "auto");
			}, 3000);
			
		});
		
		$(".sub-navigation").find("div").on("click", function(){
			$("body").find("div, a").css("pointer-events", "none");
			var $clickedSection = $($(this).data("anchor"));
			$(this).parent().find(".active").removeClass("active");
			$(this).addClass("active");
			
			if( Modernizr.mq("(min-width: 1200px)") ){
				$(this).parent().parent().find("section.active").removeClass("active").fadeOut(700);
				$(".sub-navigation").animate({"opacity": "0"}, 700);
				
				$clickedSection.delay(1000).fadeIn(1000).addClass("active");
				$(".sub-navigation").delay(1000).animate({"opacity" : "1"}, 500, "linear");
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails, .cycloneslider-caption-wrapper").css("opacity", "0").delay(2000).animate({"opacity" : "1"}, 500, "linear");
				$("main").children("div:not(#homeId, #newsId)").each(function(){					
					if($(this).is(":visible")){
						var padding, $this = $(this);
						if(Modernizr.mq("(max-device-width: 992px)")){
							padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
							$this.css("padding-bottom", padding + "px");
						}else{
							padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
							$this.css("padding-bottom", padding + "px");
						}
					}
				});
				setTimeout(function(){
					$("body").find("div, a").css("pointer-events", "auto");
				}, 3000);
			}else if(Modernizr.mq("(max-width: 1199px)")){
				$(this).parent().parent().find("section.active").removeClass("active").hide();
				
				$clickedSection.fadeIn(1000).addClass("active");
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
					$(this).css("top", ($(this).parent().find($(".cycloneslider-template-thumbnails.cycloneslider")).find($(".cycloneslider-slides")).find($(".cycloneslider-slide.cycle-slide-active")).find("img:nth-of-type(1)").height()) + "px");
				});
				
				setTimeout(function(){
					$("main").children("div:not(#homeId, #newsId)").each(function(){
						if($(this).is(":visible")){
							var padding, $this = $(this);
							if(Modernizr.mq("(max-device-width: 992px)")){
								padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
								$this.css("padding-bottom", padding + "px");
							}else{
								padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
								$this.css("padding-bottom", padding + "px");
							}
						}
					});
					$("body").find("div, a").css("pointer-events", "auto");
				}, 1650);
			}
		});
		
		$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").on("click", function(){
			if( Modernizr.mq("(max-width: 1199px)") ){
				setTimeout(function(){
					$("main").children("div:not(#homeId, #newsId)").each(function(){
						if($(this).is(":visible")){
							var padding, $this = $(this);
							if(Modernizr.mq("(max-device-width: 992px)")){
								padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
								$this.css("padding-bottom", padding + "px");
							}else{
								padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
								$this.css("padding-bottom", padding + "px");
							}
						}
					});
					$("body").find("div, a").css("pointer-events", "auto");
				}, 1600);
			}
		});
		
		var pages = [{}];
		$(":not(#homeId) .cycloneslider-slide").each(function(){
			var $caption = $(this).find(".cycloneslider-caption");
			var buttons = $(this).find("img").attr("alt").split("|");
			var $caption_link = $(this).find('.cycloneslider-caption-more');
			var given_links_index = 0;
			if ( buttons[0] != "" ) {
				for(var i = 0; i < buttons.length; i++){
					var href = 'http://#';
					$.each(pdf, function(index, value) {
						if(buttons[i] == pdf[index].name){
							href = pdf[index].file;
						}
						if (buttons[i] == 'menu' && pdf[index].name == 'speisekarte' && $caption_link.length === 0) href = (pdf[index].file).replace(/Speisekarte_DE.pdf$/i, 'Menu_EN.pdf');
						if (buttons[i] == 'wine list' && pdf[index].name == 'weinkarte' && $caption_link.length === 0) href = pdf[index].file;
					});
					if ( href == 'http://#' && $caption_link.length !== 0 ) {
						var given_links = $caption_link.attr('href').split('|');
						while ( given_links_index < given_links.length ) {
							href = given_links[given_links_index];
							given_links_index++;
							break;
						}
					}

					$caption.append($("<a>").html($("<div>").html(buttons[i]).addClass("caption-button")).attr({"href": href, "target": "_blank"}));
					if(buttons[i] == "winzer"){
						$caption.find("a").on("click", function(){
							$("header").slideToggle();
							$("#winzer").slideDown();
							return false;
						});
					}
				}
			}
			$caption_link.find('img').unwrap();
		});
		
		$(".winzer-close").on("click", function(){
			if($("#winzer").find(".winzer-instance.opened").length){
				$("#winzer").find(".winzer-instance.opened").removeClass("opened").slideToggle(1000).find("div").toggle();
			}else{
				$("#winzer").slideToggle();
				$("header").slideToggle();
			}
		});
		
		$(".winzer-open").on("click", function(){
			$(this).parent().siblings(".winzer-instance").addClass("opened").slideToggle(1000).find("div").toggle();
			if(!$(".footer-close-button").hasClass("closed")){
				toggleFooter();
			}
		});
		
		$("#newsId").on("click", ".news-open, .event img", function(){
			if(!$(this).hasClass("working")){
				var $this = $(this);
				$this.addClass("working");
				setTimeout(function(){
					$this.removeClass("working");
				}, 600);
				$(".content-container").find(".event-instance").html($this.siblings(".event-instance").html());
				$(".content-container").addClass("opened").slideToggle();
				if(Modernizr.mq("(min-width: 1200px)")){
					$(".content-container.opened").css("min-height", $(".content-container.opened").find(".event-instance").height() + 190 + "px");
				}
				$("#events, .pager").fadeOut();
				history.pushState({newsInstance: true, link: "#newsId"}, null, "news-heritage-restaurant-hamburg-" +  $this.parent().attr('id').replace("event_", ""));
			}
		});
		
		$("#newsId").on("click", ".news-close", function(){
			var filtered_array = urlAndTitle.filter(function(e){return e.section === "#newsId"});
			changeUrlPage(filtered_array[0].title, filtered_array[0].url, filtered_array[0].section, filtered_array[0].description);
			$(".content-container").slideToggle();
			$("#events, .pager").fadeIn();
		});
		
		$(".menu-button").on("click", function(){
			$("#menu").slideToggle();
		});
		/*
		$("#pressetexte").on("click", function(){
			window.open(location.origin + "/wp-content/uploads/2015/11/Heritage_Restaurant_Hamburg_Dez2015.pdf");
		});

		$("#pressefotos").on("click", function(){
			window.open(location.origin + "/wp-content/uploads/2015/12/Pressefotos.zip");
		});
		  */
		
		/*$(".verpassen").find(".footer-close-button").on("click", function(){
			toggleFooter();
		});*/
		
		$(".email").on("click", function(){
			$(".checkboxes").slideDown();
			
			//hack in a styles into <head> to modify the properties of caption and thumbnails, if the newsletter checkboxes are opened
			$("head").append('<style id="headhack" type="text/css"></style>');
			var $newStyleElement = $("head").children(':last');
			$newStyleElement.html('.cycloneslider-template-thumbnails.cycloneslider-thumbnails, .cycloneslider-template-thumbnails .cycloneslider-caption-wrapper{bottom :440px }');
		});

		var group = 'Public';
		$('#verpassen .checkboxes input[type="checkbox"]').on( 'change', function() {
			if ( $('input#speisekarte').is(':checked') || $('input#eventsnews').is(':checked') ) {
				if ( $('input#eventsnews').is(':checked') && $('input#speisekarte').not(':checked') ) {
					group = 'News und events';
				}
				if ( $('input#speisekarte').is(':checked') && $('input#eventsnews').not(':checked') ) {
					group = 'Speise- oder Weinkarten';
				}
				if ( $('input#speisekarte').is(':checked') && $('input#eventsnews').is(':checked') ) {
					group = 'Public';
				}
			} else {
				group = 'Public';
			}
			$('#es_txt_group_pg').val(group);
		});
		
		$(".reserve-btn").on("click", function(){
			window.open("http://www.opentable.de/heritage-reservations-hamburg?restref=104139&rid=104139");
		});
		
		$(".reserve-btn").on("click", function(){
			window.open("http://www.opentable.de/heritage-reservations-hamburg?restref=104139&rid=104139");
		});

		$(window).on('load resize', function(){
			if( Modernizr.mq("(max-width: 1199px)") ){
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
					$(this).css("top", ($(this).parent().find($(".cycloneslider-template-thumbnails.cycloneslider")).find($(".cycloneslider-slides")).find($(".cycloneslider-slide.cycle-slide-active")).find("img:nth-of-type(1)").height()) + "px");
				});
				
				//$(".main div > section.active").parent().css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() + 490  + "px");
				if(BrowserDetect.browser == "Firefox" || BrowserDetect.browser == "Explorer" || BrowserDetect.browser == "MS Edge" ){
					//$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
				}
				if(Modernizr.mq("(orientation: landscape)")){
					if( Modernizr.mq("(max-device-width: 996px)") ){
						$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
					}else{
						$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +190  + "px");
					}
				}else{
					$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
				}
				
				newsSlideMarginLeft = "-66vw";
				newsSlideMarginRight = "-66vw";
				$(".news-container").css("width", $(".event").length * 66 + "vw");
				$(".sub-navigation").each(function(){
					$(this).css("width", ($(this).children().length * 86) + "px");
				});
				
				if($(".footer-close-button").hasClass("closed")){
					toggleFooter();
				}
				
				setTimeout(function(){
					if(Modernizr.mq('(max-device-width: 1024px) and (orientation: landscape)')){
						if($("#kulinarikId").hasClass("active-page") && $("#kulinarikId section.active").attr("id") == "kulinarik-slider-2"){
							$("main").children("div:not(#homeId, #newsId)").css("padding-bottom",  "470px");
						}else{
							$("main").children("div:not(#homeId, #newsId)").each(function(){
								if($(this).is(":visible")){
									var padding, $this = $(this);
									if(Modernizr.mq("(max-device-width: 992px)")){
										padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
										$this.css("padding-bottom", padding + "px");
									}else{
										padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
										$this.css("padding-bottom", padding + "px");
									}
									
								}
							});
							$("body").find("div, a").css("pointer-events", "auto");
						}
					}else{
						$("main").children("div:not(#homeId, #newsId)").each(function(){
							if($(this).is(":visible")){
								var padding, $this = $(this);
								if(Modernizr.mq("(max-device-width: 992px)")){
									padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
									$this.css("padding-bottom", padding + "px");
								}else{
									padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
									$this.css("padding-bottom", padding + "px");
								}
								
							}
						});
						$("body").find("div, a").css("pointer-events", "auto");
					}
				}, 1650);
			} else {
				$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
					$(this).css("top", ($(window).height() - $("footer").height() - 104) + "px");
				});
				newsSlideMarginLeft = "-386px";
				newsSlideMarginRight = "-386px";
				$(".news-container").css("width", $(".event").length * 386 + "px");
				$(".footer-top").on("click", function(){
					toggleFooter();
					$(".checkboxes").slideUp();
					$("head").children('#headhack').remove();
				});
			}
			
			$("#news-left").off("click");
			$("#news-right").off("click");
			
			$("#news-left").on("click", function(){
				if(!$(this).hasClass("working")){
					var $this = $(this);
					$this.addClass("working");
					$this.siblings(".pager").addClass("working");
					var $elem = $(".news-container").find(".event:last-of-type").remove();
					$(".news-container").prepend($elem);
					$(".news-container").css("margin-left", newsSlideMarginLeft);
					$(".news-container").animate({"margin-left": "0"}, 600);		
					setTimeout(function(){
						$this.removeClass("working");
						$this.siblings(".pager").removeClass("working");
					}, 650);				
				}
			});
			$("#news-right").on("click", function(){
				if(!$(this).hasClass("working")){
					var $this = $(this);
					$this.addClass("working");
					$this.siblings(".pager").addClass("working");
					$(".news-container").animate({"margin-left": newsSlideMarginRight}, 600);
					setTimeout(function(){
						$(".news-container").css("margin-left", "0");
						var $elem = $(".news-container").find(".event:first-of-type").remove();
						$(".news-container").append($elem);
						$this.removeClass("working");
						$this.siblings(".pager").removeClass("working");
					}, 650);
				}
			});
			var email;
			$("footer").on("change", ".email", function(){
				email = $(this).val();
			});
			$('footer').find('.send ').on("click",function(){
					var pattern = new RegExp(/[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm); 
					if(pattern.test(email) == true){
						$("#newsletter-popup").fadeIn();
						$("#newsletter-popup-inner, section").on("click", function(){
							$("#newsletter-popup").fadeOut();
							setTimeout(function(){
								var $innerHtml = $("#newsletter-popup-inner").html();
								$("#newsletter-popup-inner").children("p").remove();
								$("#newsletter-popup-inner").children("h2").html("Schönen Gruß aus dem Heritage");
								$("#newsletter-popup-inner").append($("<p>").html("Sie haben soeben eine E-Mail von uns erhalten. Bitte klicken Sie auf den Link in der E-Mail, um die Anmeldung für unseren Newsletter abzuschließen."));
								$("#newsletter-popup-inner").append($("<p>").html("E-Mail nicht erhalten?<br>Bitte prüfen Sie Ihren Spam-Ordner oder schreiben <a href='mailto:"+admin_mail+"'>Sie uns.</a>"));
							}, 1000);
						});
						$(".email").removeClass("error");
					}else{
						$(".email").addClass("error");
					}
				});
			$('footer').find('#es_txt_email_pg ').on('keyup', function(e){
				if(e.which ===13){
					e.preventDefault();
					var pattern = new RegExp(/[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm); 
					if(pattern.test(email) == true){
						$("#newsletter-popup").fadeIn();
						$("#newsletter-popup-inner").on("click", function(){
							$("#newsletter-popup, section").fadeOut();
							setTimeout(function(){
								var $innerHtml = $("#newsletter-popup-inner").html();
								$("#newsletter-popup-inner").children("p").remove();
								$("#newsletter-popup-inner").children("h2").html("Schönen Gruß aus dem Heritage");
								$("#newsletter-popup-inner").append($("<p>").html("Sie haben soeben eine E-Mail von uns erhalten. Bitte klicken Sie auf den Link in der E-Mail, um die Anmeldung für unseren Newsletter abzuschließen."));
								$("#newsletter-popup-inner").append($("<p>").html("E-Mail nicht erhalten?<br>Bitte prüfen Sie Ihren Spam-Ordner oder schreiben <a href='mailto:"+admin_mail+"'>Sie uns.</a>"));
							}, 1000);
						});
						$(".email").removeClass("error");
					}else{
						$(".email").addClass("error");
					}
				}
			});
			$("#newsletter-popup-inner").on("click", function(){
				$("#newsletter-popup").toggle();
				$("#newsletter-popup-inner").html('<div class="mail-image"></div><h2>Schönen Gruß aus dem Heritage</h2><p>Sie haben soeben eine E-Mail von uns erhalten. Bitte klicken Sie auf den Link in der E-Mail, um die Anmeldung für unseren Newsletter abzuschließen.</p><p>E-Mail nicht erhalten?<br>Bitte prüfen Sie Ihren Spam-Ordner oder schreiben <a href="mailto:'+ admin_mail +'">Sie uns.</a></p>');
			});
    });
		
		window.onpopstate = function(event){
			document.title = event.state.title;
			$('meta[name="og:description"]').attr('content', event.state.description);
			
			if(event.state.nthImage && $(event.state.link).is(":visible")){
				$(event.state.link).find(".cycloneslider-thumbnails ul li:nth-of-type(" + event.state.nthImage + ")").trigger("click", true);
			}else if($(event.state.link).is(":visible")){
				$(event.state.link).find(".cycloneslider-thumbnails ul li:nth-of-type(1)").trigger("click", true);
				if(event.state.link === "#newsId"){
					if($("#events").is(":visible")){
						$(".content-container").slideToggle();
						$("#events, .pager").fadeOut();
					}else{
						$(".content-container").slideToggle();
						$("#events, .pager").fadeIn();
					}
				}
			}else{
				$("body").animate({"scrollTop" : "0"}, 2000);
				$("body").find("div, a").css("pointer-events", "none");
				$("main > div").fadeOut();
				$("a.selected").removeClass("selected");
				
				switch(event.state.link){
					case "#homeId":
						$("#home-link").find("a").addClass("selected");
						break;
					case "#restaurantId":
						$("#restaurant-link").find("a").addClass("selected");
						break;
					case "#kulinarikId":
						$("#kulinarik-link").find("a").addClass("selected");
						break;
					case "#newsId":
						$("#news-link").find("a").addClass("selected");
						break;
					case "#impressumId":
						$(".impressum").find("a").addClass("selected");
						break;
					case "#presseId":
						$(".presse").find("a").addClass("selected");
						break;
				}
				
				$(".active-page").removeClass("active-page").fadeOut(1000);
				
				if( Modernizr.mq("(max-width: 1199px)") ){
					
					$(event.state.link).fadeIn(1000);
					//$("main").find("div").css("height", $(this).find("section.active").find(".cycle-slide img").height());
					$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails").each(function(){
						$(this).css("top", ($(this).parent().find($(".cycloneslider-template-thumbnails.cycloneslider")).find($(".cycloneslider-slides")).find($(".cycloneslider-slide.cycle-slide-active")).find("img:nth-of-type(1)").height()) + "px");
					});
					if($("#menu").is(":visible")){
						$("#menu").slideToggle();
					}
					
					if(Modernizr.mq("(orientation: landscape)")){
						if( Modernizr.mq("(max-device-width: 996px)") ){
							$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
						}else{
							$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +190  + "px");
						}
					}else{
						$("#homeId").css("padding-bottom", $(".cycloneslider-template-default .cycle-slide-active .cycloneslider-caption").height() +120  + "px");
					}
					
					setTimeout(function(){
						/* it should check the slider image + content height dynamically, add more breakpoints if necessary */
						$("main").children("div:not(#homeId, #newsId)").each(function(){
							if($(this).is(":visible")){
								var padding, $this = $(this);
								if(Modernizr.mq("(max-device-width: 992px)")){
									padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 190;
									$this.css("padding-bottom", padding + "px");
								}else{
									padding = $this.find(("section.active .cycloneslider-template-thumbnails .cycle-slide-active .cycloneslider-caption-wrapper")).height() + 250;
									$this.css("padding-bottom", padding + "px");
								}
								
							}
						});
						$("body").find("div, a").css("pointer-events", "auto");
					}, 1650);
				}else{
					$(".sub-navigation").animate({"opacity": "0"}, 700);
					$(event.state.link).delay(1000).fadeIn(1000);
					$(".sub-navigation").delay(1000).animate({"opacity" : "1"}, 500, "linear");
					$(".cycloneslider-template-thumbnails.cycloneslider-thumbnails, .cycloneslider-caption-wrapper").css("opacity", "0").delay(2000).animate({"opacity" : "1"}, 500, "linear");
					// if((event.state.link !== "#homeId") && (!$(".footer-close-button").hasClass("closed"))){
						// toggleFooter();
					// }else if((event.state.link === "#homeId")  && ($(".footer-close-button").hasClass("closed"))){
						// toggleFooter();
					// }
					setTimeout(function(){
						$("body").find("div, a").css("pointer-events", "auto");
					}, 3000);
				}
				
				if(event.state.nthImage){
					$(event.state.link).find(".cycloneslider-thumbnails ul li:nth-of-type(" + event.state.nthImage + ")").click();
				}else{
					$(event.state.link).find(".cycloneslider-thumbnails ul li:nth-of-type(1)").trigger("click", true);
				}
			}
			
		};
		
		function escapeRegExp(str) {
			return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
		}
		
		function replaceAll(str, find, replace) {
		  return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
		}

		BrowserDetect.init();
		
		if(BrowserDetect.browser ==="Firefox" || BrowserDetect.browser ==="Explorer" || BrowserDetect.browser ==="MS Edge" ){
			$(".email").css("margin-top", "10px");
			$(".send").css("transform", "none");
			$(".send").css("margin-top", "-2px");
		}
	},
		finalize: function() {
		// JavaScript to be fired on all pages, after page specific JS is fired
		}
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
