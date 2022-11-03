//menu 
(function($){'use strict';$.fn.sinaNav=function(){return this.each(function(){var getNav=$(this),top=getNav.data('top')||getNav.offset().top,mdTop=getNav.data('md-top')||getNav.offset().top,xlTop=getNav.data('xl-top')||getNav.offset().top,navigation=getNav.find('.sina-menu'),getWindow=$(window).outerWidth(),anim=getNav.data('animate-prefix')||'',getIn=navigation.data('in'),getOut=navigation.data('out');$(window).on('resize',function(){getWindow=$(window).outerWidth();});getNav.find('.sina-menu').each(function(){var $menu=$(this);$menu.on('click',function(e){if('A'==e.target.tagName){$menu.find('li.active').removeClass('active');$(e.target).parent().addClass('active');}});$menu.find('li.active').removeClass('active');$menu.find('a[href="'+location.href+'"]').parent('li').addClass('active');});if(getNav.hasClass('logo-center')){var mainNav=getNav.find('.sina-menu'),rightNav=mainNav.clone(),lists=mainNav.children('li'),divided=Math.round(lists.length/2);mainNav.empty();rightNav.empty();for(var i=0;i<divided;i++){mainNav.append(lists[i]);}
mainNav.addClass('sina-menu-right').wrap('<div class="col-half left"></div>');for(var i=divided;i<lists.length;i++){rightNav.append(lists[i]);}
getNav.find('.col-half.left').after(rightNav.addClass('sina-menu-dropdown-right sina-menu-left'));rightNav.wrap('<div class="col-half right"></div>');}
if(getNav.hasClass('mobile-sidebar')){var $collapse=getNav.find('.navbar-collapse');if($('body').children('.wrapper').length<1){$('body').wrapInner('<div class="wrapper"></div>');}
if(getNav.hasClass('navbar-reverse')){$collapse.on('shown.bs.collapse',function(){$('body').addClass('mobile-right');});$collapse.on('hide.bs.collapse',function(){$('body').removeClass('mobile-right');});$(window).on('resize',function(){$('body').removeClass('mobile-right');getNav.find('.navbar-collapse').removeClass('show');getNav.find('.navbar-toggle .fa',this).removeClass('fa-times').addClass('fa-bars');});}
else{$collapse.on('shown.bs.collapse',function(){$('body').addClass('mobile-left');});$collapse.on('hide.bs.collapse',function(){$('body').removeClass('mobile-left');});$(window).on('resize',function(){$('body').removeClass('mobile-left');getNav.find('.navbar-collapse').removeClass('show');getNav.find('.navbar-toggle .fa',this).removeClass('fa-times').addClass('fa-bars');});}}
getNav.find('.sina-menu, .extension-nav').each(function(){var menu=this;$('.dropdown-toggle',menu).on('click',function(e){e.stopPropagation();return false;});$('.dropdown-menu',menu).addClass(anim+'animated');$('.dropdown',menu).on('mouseenter',function(){var dropdown=this;$('.dropdown-menu',dropdown).eq(0).removeClass(getOut).stop().fadeIn().addClass(getIn);$(dropdown).addClass('on');});$('.dropdown',menu).on('mouseleave',function(){var dropdown=this;$('.dropdown-menu',dropdown).eq(0).removeClass(getIn).stop().fadeOut().addClass(getOut);$(dropdown).removeClass('on');});$('.mega-menu-col',menu).children('.sub-menu').removeClass('dropdown-menu '+anim+'animated');});if(getWindow<1025){getNav.find('.menu-item-has-mega-menu').each(function(){var megamenu=this,$columnMenus=[];$('.mega-menu-col',megamenu).children('.sub-menu').addClass('dropdown-menu '+anim+'animated');$('.mega-menu-col',megamenu).each(function(){var megamenuColumn=this;$('.mega-menu-col-title',megamenuColumn).on('mouseenter',function(){var title=this;$(title).closest('.mega-menu-col').addClass('on');$(title).siblings('.sub-menu').stop().fadeIn().addClass(getIn);});if(!$(megamenuColumn).children().is('.mega-menu-col-title')){$columnMenus.push($(megamenuColumn).children('.sub-menu'));}});$(megamenu).on('mouseenter',function(){var submenu;for(submenu in $columnMenus){$columnMenus[submenu].stop().fadeIn().addClass(getIn);}});$(megamenu).on('mouseleave',function(){$('.dropdown-menu',megamenu).stop().fadeOut().removeClass(getIn);$('.mega-menu-col',megamenu).removeClass('on');});});}});}
$('.sina-nav').sinaNav();}(jQuery));$(window).on("load",function(){$("#status").fadeOut();$("#preloader").delay(1000).fadeOut("slow");});$(".reg_btn").hover(function(){$(".log_reg_btn").toggleClass("reg_btn_slide");});$(".navbar-toggle").click(function(){$(this).toggleClass("navbar-toggle-active");$(".menu_overlay").fadeToggle();});$(window).width()<767&&jQuery(".foot_head").click(function(e){jQuery(".foot_list").slideUp(),$(this).next("ul").is(":visible")?($(this).next("ul").slideUp(),jQuery(".foot_head").children("i").removeClass("fa-minus"),jQuery(".foot_head").children("i").addClass("fa-plus")):($(this).next("ul").slideDown(),jQuery(".foot_head").children("i").removeClass("fa-minus"),jQuery(".foot_head").children("i").addClass("fa-plus"),jQuery(this).children("i").removeClass("fa-plus"),jQuery(this).children("i").addClass("fa-minus"))});

//fixed nav
$(window).scroll(function () { var d = $(window).scrollTop(); $(window).width() > 991 && (d >= 100 ? $(".nav_bg").addClass("fixed_nav") : $(".nav_bg").removeClass("fixed_nav")) });


//$(window).scroll(function () { var d = $(window).scrollTop(); $(window).width() > 991 && (d >= 320 ? $(".page_subtabs").addClass("page_subtabs_fixed") : $(".page_subtabs").removeClass("page_subtabs_fixed")) });


$(document).ready(function(){
  $(".menu_btn").click(function(){
     $("body").toggleClass("open_menu");
	 $(".menu").slideToggle();
	 
  });
});



$('.quick_btn').click(function() {
$(this).toggleClass('active');
  $('.upper_link').toggleClass('active');
});

//onload popup
$(window).load(function(){null==localStorage.getItem("modalshown")&&($("#myModal").modal("show"),localStorage.setItem("modalshown","yes"))});
	
// Home banner slider
window.onload=function(){$(".banner_slider").slick({autoplay:!0,fade:!0,adaptiveHeight:true,speed:1800,arrows:!1,dots:!0}).slickAnimation();};

$('.ticker_slider').slick({
  slidesToShow: 1,
  autoplay:true,
  slidesToScroll: 1,
  speed:1800,
  arrows: false,
  fade: false,
});

// news slider
$(".news_slider").slick({slidesToShow:4,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,responsive:[{breakpoint:991,settings:{slidesToShow:2,arrows:!1, dots:!0, slidesToScroll:1}},{breakpoint:600,settings:{slidesToShow:1,arrows:!1, dots:!0,slidesToScroll:1,adaptiveHeight:!0}}]});
	
// event poster slider
$(".event_slider").slick({slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!0,dots:!0,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});


// event poster slider
$(".video_listing").slick({slidesToShow:3,infinite: false,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:991,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});

// event poster slider
$(".gallery_slider").slick({slidesToShow:3,infinite: false,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:991,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});


// logo ticker slider
$(".logo_ticker").slick({slidesToShow:4,slidesToScroll:1,autoplay:!0,autoplaySpeed:2000,arrows:!1,dots:!1,pauseOnHover:!0,responsive:[{breakpoint:768,settings:{slidesToShow:4}},{breakpoint:600,settings:{slidesToShow:2}}]});

$('.video_slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.video_thumb_slider'
});
$('.video_thumb_slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.video_slider',
  dots: true,
    focusOnSelect: true
});

$('.slider-nav').slick({
  asNavFor: '.slider-for',
  dots: false,
    variableWidth: true,

  slidesToShow: 5,
  slidesToScroll: 1,

  focusOnSelect: true
});


$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  draggable: false,

  asNavFor: '.slider-nav'
});






 $('.mobile_slider').slick({
    speed: 2000,
	autoplay:true,
    dots: false,
    arrows: false,
    fade:true
    
  });
  
   $('.enrolled_slider').slick({
    speed: 2000,
	autoplay:true,
    dots: false,
    arrows: true,
    
  });




$('[data-toggle="tooltip"]').tooltip();

$("[data-sticky_column]").stick_in_parent({parent:"[data-sticky_parent]",offset_top:80});

$(".tab-content").on("shown.bs.collapse",function(){var o=$(this).find('[aria-expanded="true"]');$("html, body").animate({scrollTop:o.offset().top-15},500)});

$(".right_box_submenu").click(function(){$(this).children("ul").slideToggle(),$(this).children("ul").parent("li").siblings().children("ul").slideUp(),$(this).toggleClass("right_box_submenuactive")});

$(window).width()<768&&jQuery(".right_box h2").click(function(i){$(".right_box_list").slideToggle()});
  
$(window).load(function(){
    $('.facebook').attr('href','https://www.facebook.com/GJEPC');
    $('.twitter').attr('href','https://twitter.com/GJEPCIndia');
    $('.instagram').attr('href','https://www.instagram.com/gjepcindia/?hl=en');
    $('.linkedin').attr('href','https://www.linkedin.com/in/sabyaray/');
    $('#youtubeLink1').attr('href','https://www.youtube.com/watch?list=PL54gOXLucCYf0z_fuu0xZgd07Juh6ESI1&amp;v=YXBy0B_od0c');
    $('#youtubeLink2').attr('href','https://www.youtube.com/watch?v=bqbdTqc7VVA&amp;feature=youtu.be');
});




// scroll



AOS.init({
  duration: 1000,
offset: -100,
once: true,
disable: function() {
    var maxWidth = 800;
    return window.innerWidth < maxWidth;
  }
})
