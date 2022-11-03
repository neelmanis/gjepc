border: 1px solid #ddd;
    -webkit-box-shadow: 0 0 5px rgba(153, 153, 153, 0.6);
       -moz-box-shadow: 0 0 5px rgba(153, 153, 153, 0.6);
            box-shadow: 0 0 5px rgba(153, 153, 153, 0.6);
}

.box.shadow div.box-inner-block {
    padding: 0;
}

.box.info {
    background: #d6f6ff;
    border-color: #BFE3EC;
}

.box.info .tie-shortcode-boxicon:before {
    content: "\f05a";
    color: #2CB4DA
}

.box.success {
    background: #e2f2cb;
    border-color: #D1E4B7;
}

.box.success .tie-shortcode-boxicon:before {
    content: "\f05d";
    color: #8AB84D
}

.box.warning {
    background: #fffddb;
    border-color: #E9E59E;
}

.box.warning .tie-shortcode-boxicon:before {
    content: "\f071";
    color: #ECC21B;
}

.box.error {
    background: #ffe6e2;
    border-color: #EEBFB8;
}

.box.error .tie-shortcode-boxicon:before {
    content: "\f05e";
    color: #F03317;
}

.box.download {
    background: #e2f2cb;
    border-color: #D1E4B7;
}

.box.download .tie-shortcode-boxicon:before {
    content: "\f019";
    color: #8AB84D
}

.box.note {
    background: #fffddb;
    border-color: #E9E59E;
}
.box.note .tie-shortcode-boxicon:before {
    content: '\f15c';
    color: #ECC21B;
}

/* Buttons Shortcode */

a.shortc-button {
    border: none;
    cursor: pointer;
    padding: 0 10px;
    display: inline-block;
    margin: 10px 0 0;
    font-weight: 700;
    outline: none;
    position: relative;
    background: #bdc3c7;
    color: #fff !important;
    text-decoration: none;
    font-size: 10px;
    height: 25px;
    line-height: 25px;
    opacity: .9;
    overflow: hidden;
    -webkit-border-radius: 3px;
       -moz-border-radius: 3px;
            border-radius: 3px;
}

a.shortc-button:hover {
    opacity: 1;
}

a.shortc-button:active {
    top: 1px;
}

a.shortc-button i {
    margin-right: 10px;
}

a.shortc-button.red {
    background: #e74c3c;
}

a.shortc-button.green {
    background: #2ecc71;
}

a.shortc-button.blue {
    background: #3498db;
}

a.shortc-button.orange {
    background: #e67e22;
}

a.shortc-button.pink {
    background: #ff00a2;
}

a.shortc-button.purple {
    background: #9b59b6;
}

a.shortc-button.black {
    background: #222;
}

a.shortc-button.white {
    background: #ecf0f1;
    color: #333 !important;
}

a.shortc-button.medium {
    font-size: 14px;
    height: 45px;
    line-height: 45px;
    padding: 0 15px;
}

a.shortc-button.big {
    font-size: 24px;
    height: 65px;
    line-height: 65px;
    padding: 0 20px;
}

/* Flickr Shortcode */

.flickr-wrapper {
    overflow: hidden;
    margin-bottom: 20px;
}

.flickr-wrapper .flickr_badge_image {
    float: left;
    margin: 8px;
}

.flickr-wrapper .flickr_badge_image img {
    opacity: 1;
    padding: 4px;
    border:1px solid #eee;
}

.flickr-wrapper .flickr_badge_image a:hover img {
    opacity: 0.6 !important;
}

/* Toggle Shortcode */

.toggle {
    margin-bottom: 15px;
    border: 1px solid #eee;
    position: relative;
}

.toggle h3 {
    background: #F1F1F1;
    font-weight: normal;
    font-size: 14px;
    padding: 10px;
    margin: 0;
    cursor: pointer;
    -webkit-transition: background .2s ease;
       -moz-transition: background .2s ease;
         -o-transition: background .2s ease;
            transition: background .2s ease;
}

.toggle h3:hover{
    background: #E7E7E7;
}

h3.toggle-head-close {
    display: none;
}

h3.toggle-head-open i,
h3.toggle-head-close i {
    float: right;
    font-size: 16px;
}

.toggle-content {
    padding: 25px;
}

.toggle.close .toggle-content,
.toggle.close h3.toggle-head-open {
    display: none;
}

.toggle.close h3.toggle-head-close {
    display: block;
}

/* Author Shortcode */

.author-info {
    margin-bottom: 15px;
    border: 1px solid #EEE;
    padding: 25px;
    position: relative;
}

.author-info-content {
    padding-left: 100px;
}

.author-info-content h3 {
    font-weight: normal;
    font-size: 16px;
    margin-bottom: 15px;
    margin-top: 0;
}

.author-info img.author-img {
    max-width: 70px;
    float: left;
    margin-right: 15px;
}

/* Columns Shortcode */

.one_half,
.one_third,
.two_third,
.three_fourth,
.one_fourth,
.one_fifth,
.two_fifth,
.three_fifth,
.four_fifth,
.one_sixth,
.five_sixth {
    position: relative;
    margin-right: 4%;
    float: left;
}

.one_half {
    width: 48%
}

.one_third {
    width: 30.66%
}

.two_third {
    width: 65.33%
}

.one_fourth {
    width: 22%
}

.three_fourth {
    width: 74%
}

.one_fifth {
    width: 16.8%
}

.two_fifth {
    width: 37.6%
}

.three_fifth {
    width: 58.4%
}

.four_fifth {
    width: 67.2%
}

.one_sixth {
    width: 13.33%
}

.five_sixth {
    width: 82.67%
}

.entry .last {
    margin-right: 0 !important;
    clear: right;
}

/* Tabs Shortcode */

.post-tabs {
    margin-bottom: 20px;
    border: 1px solid #eee;
}

.post-tabs ul.tabs-nav {
    margin: 0;
    background: #f1f1f1;
}

.post-tabs ul.tabs-nav li,
.post-tabs-ver ul.tabs-nav li {
    line-height: 32px;
    cursor: pointer;
    display: table-cell;
    width: 1%;
    margin: 0;
    padding: 0;
    text-align: center;
    border: 1px solid #FFF; 
    border-width: 0 1px 0 0;
    -webkit-transition: background .2s ease;
       -moz-transition: background .2s ease;
         -o-transition: background .2s ease;
            transition: background .2s ease;
}

.post-tabs ul.tabs-nav li:last-child,
.post-tabs-ver ul.tabs-nav li:last-child {
    border: 0;
}

.post-tabs ul.tabs-nav li:hover,
.post-tabs-ver ul.tabs-nav li:hover {
    background: #E7E7E7;
}

.post-tabs ul.tabs-nav li {
    text-align: center;
}

.post-tabs ul.tabs-nav li.current {
    background: #FFF;
    z-index: 1;
    height: 33px;
}

.post-tabs .pane,
.post-tabs-ver .pane {
    display: none;
    padding: 25px;
}

.post-tabs .pane:first-child,
.post-tabs-ver .pane:first-child {
    display: block;
}

.post-tabs-ver {
    margin-bottom: 20px;
}

.post-tabs-ver ul.tabs-nav {
    position: relative;
    left: 1px;
    float: left;
    width: 25%;
    margin: 0;
    background: #f1f1f1;
    border: 1px solid #eee;
    border-width: 1px 0 1px 1px;
}

.post-tabs-ver ul.tabs-nav li {
    display: block;
    width: 100%;
    padding: 0 8px;
    border: 0 none;
    border-bottom: 1px solid #FFF;
}

.post-tabs-ver ul.tabs-nav li.current {
    background: #FFF;
    z-index: 1;
}

.post-tabs-ver .pane {
    float: left;
    width: 75%;
    border: 1px solid #eee;
}

/* Full size image */

.tie-full-width-img img {
    height: auto;
    margin-right:-20px;
    margin-left: -20px;
    width: 660px;
    left: 0;
    max-width: none;
    margin-bottom: 10px;
}

.post-cover .tie-full-width-img img {
    width: 680px;
    margin-right: -24px;
    margin-left: -24px;
}

.full-width .tie-full-width-img img {
    width: 997px;
}

.full-width .post-cover .tie-full-width-img img {
    width: 1045px;
    margin-right: -24px;
    margin-left: -24px;
}

/* Full Width layout size full image */

.wide-layout .post-cover .tie-full-width-img img {
    width: 660px;
    margin-right: 0;
    margin-left: 0;
}

.wide-layout .full-width .post-cover .tie-full-width-img img {
    width: 1010px;
    margin-right: 0;
    margin-left: 0;
}

.wide-layout .full-width .tie-full-width-img img {
    width: 1010px;
}



/**
 * Lightbox
 * -----------------------------------------------------------------------------
 */

.ilightbox-overlay, .ilightbox-loader, .ilightbox-loader *, .ilightbox-holder, .ilightbox-holder .ilightbox-container, .ilightbox-holder .ilightbox-container img.ilightbox-image, .ilightbox-holder .ilightbox-container .ilightbox-caption, .ilightbox-toolbar, .ilightbox-toolbar *, .ilightbox-thumbnails, .ilightbox-thumbnails *, .ilightbox-holder .ilightbox-container .ilightbox-social, .ilightbox-holder .ilightbox-container .ilightbox-social * {
    float:none;
    margin:0;
    padding:0;
    border:0;
    outline:0;
    font-size:100%;
    line-height:100%;
    vertical-align:baseline;
    background:transparent;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	   -moz-user-select: -moz-none;
	 -khtml-user-select: none;
	     -o-user-select: none;
	        user-select: none;
}

.ilightbox-overlay, .ilightbox-loader, .ilightbox-loader *, .ilightbox-holder .ilightbox-container .ilightbox-caption, .ilightbox-toolbar, .ilightbox-thumbnails, .ilightbox-thumbnails *, .ilightbox-holder .ilightbox-container .ilightbox-social {
	-webkit-transform: translateZ(0);
	   -moz-transform: translateZ(0);
}

.ilightbox-noscroll {
	overflow: hidden;
}

.ilightbox-closedhand * {
	cursor: url(css/ilightbox/closedhand.cur),default !important;
}

.ilightbox-overlay {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 100000;
}

.ilightbox-loader {
	position: fixed;
	z-index: 100005;
	top: 45%;
	left: -192px;
	padding-left: 30px;
	opacity: 0.9;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	filter: alpha(opacity=90);
	-webkit-border-radius: 0 100px 100px 0;
	        border-radius: 0 100px 100px 0;
}

.ilightbox-loader div {
	width: 72px;
	height: 72px;
	-webkit-border-radius: 0 100px 100px 0;
	        border-radius: 0 100px 100px 0;
}

.ilightbox-loader.horizontal {
	left: 45%;
	top: -192px;
	padding: 0;
	padding-top: 30px;
	-webkit-border-radius: 0 0 100px 100px;
	        border-radius: 0 0 100px 100px;
}

.ilightbox-loader.horizontal  div {
	-webkit-border-radius: 0 0 100px 100px;
	        border-radius: 0 0 100px 100px;
}

.ilightbox-toolbar {
	display: none;
	position: fixed;
	z-index: 100010;
}

.ilightbox-toolbar a {
	float: left;
	cursor: pointer;
}

.ilightbox-toolbar .ilightbox-prev-button,
.ilightbox-toolbar .ilightbox-next-button {
	display: none;
}

.ilightbox-thumbnails {
	display: block;
	position: fixed;
	z-index: 100009;
}

.ilightbox-thumbnails.ilightbox-horizontal {
	bottom: 0;
	left: 0;
	width: 100%;
	height: 100px;
}

.ilightbox-thumbnails.ilightbox-vertical {
	top: 0;
	right: 0;
	width: 140px;
	height: 100%;
	overflow: hidden;
}

.ilightbox-thumbnails .ilightbox-thumbnails-container {
	display: block;
	position: relative;
}

.ilightbox-thumbnails.ilightbox-horizontal .ilightbox-thumbnails-container {
	width: 100%;
	height: 100px;
}

.ilightbox-thumbnails.ilightbox-vertical .ilightbox-thumbnails-container {
	width: 140px;
	height: 100%;
}

.ilightbox-thumbnails .ilightbox-thumbnails-grid {
	display: block;
	position: absolute;
	-webkit-transform: translateZ(0);
	   -moz-transform: translateZ(0);
}

.ilightbox-thumbnails .ilightbox-thumbnails-grid .ilightbox-thumbnail {
	display: block;
	cursor: pointer;
	padding: 10px;
	position: relative;
}

.ilightbox-thumbnails .ilightbox-thumbnails-grid .ilightbox-thumbnail img {
	width: 100%;
	height: 100%;
	-webkit-border-radius: 2px;
	        border-radius: 2px;
	
	-ms-interpolation-mode: bicubic;
}

.ilightbox-thumbnails .ilightbox-thumbnails-grid .ilightbox-thumbnail .ilightbox-thumbnail-icon {
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
	opacity: .7;
}

.ilightbox-thumbnails .ilightbox-thumbnails-grid .ilightbox-thumbnail .ilightbox-thumbnail-icon:hover {
	opacity: 1;
}

.ilightbox-holder {
	display: none;
	position: fixed;
	z-index: 100003;
	-webkit-transform: none;
	   -moz-transform: none;
}

.ilightbox-holder.ilightbox-next, .ilightbox-holder.ilightbox-prev {
	cursor: pointer;
}

.ilightbox-holder div.ilightbox-container {
	position: relative;
	width: 100%;
	height: 100%;
}

.ilightbox-holder.supportTouch div.ilightbox-container {
	overflow: scroll;
	-webkit-overflow-scrolling: touch;
}

.ilightbox-holder img.ilightbox-image {
	width: 100%;
	height: 100%;
}

.ilightbox-holder .ilightbox-container .ilightbox-caption {
	display: none;
	position: absolute;
	left: 30px;
	right: 30px;
	bottom: 0;
	max-width: 100%;
	padding: 5px 10px;
	margin: 0 auto;
	font-size: 12px;
    line-height: 150%;
	word-wrap: break-word;
	z-index: 20003;
	-webkit-box-sizing: border-box;
	   -moz-box-sizing: border-box;
	        box-sizing: border-box;
	
	-webkit-border-radius: 3px 3px 0 0;
	        border-radius: 3px 3px 0 0;
}

.ilightbox-holder .ilightbox-alert {
	display: block;
	position: absolute;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	text-align: center;
	padding-top: 100px;
	margin: auto;
	width: 300px;
	height: 50px;
}

.ilightbox-holder .ilightbox-wrapper {
	width: 100%;
	height: 100%;
	overflow: auto;
	-webkit-overflow-scrolling: touch;
}

.ilightbox-holder .ilightbox-inner-toolbar {
	position: relative;
	z-index: 100;
}

.ilightbox-holder .ilightbox-inner-toolbar .ilightbox-toolbar {
	position: absolute;
}

.ilightbox-button {
	position: fixed;
	z-index: 100008;
	cursor: pointer;
}

.isMobile .ilightbox-button,
.isMobile .ilightbox-thumbnails {
	display: none !important;
}

.isMobile .ilightbox-toolbar .ilightbox-prev-button,
.isMobile .ilightbox-toolbar .ilightbox-next-button {
	display: block;
}
.ilightbox-title{
    font-size: 12px !important;
}
.ilightbox-title a{
    color:#ccc;
}
.ilightbox-title a:hover{
    color:#FFF;
}
.ilightbox-holder.light .ilightbox-inner-toolbar .ilightbox-title a,
.ilightbox-holder.metro-white .ilightbox-inner-toolbar .ilightbox-title a{
    color:#555;
}
.ilightbox-holder.light .ilightbox-inner-toolbar .ilightbox-title a:hover,
.ilightbox-holder.metro-white .ilightbox-inner-toolbar .ilightbox-title a:hover{
    color:#000;
}


/**
 * Responsive Videos
 * -----------------------------------------------------------------------------
 */

.fluid-width-video-wrapper {
    width: 100%;
    position: relative;
    padding: 0;
}
    .entry .fluid-width-video-wrapper {
        clear: both;
    }

.fluid-width-video-wrapper iframe,
.fluid-width-video-wrapper object,
.fluid-width-video-wrapper embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}


/**
 * Off Canvas Mobile menu
 * -----------------------------------------------------------------------------
 */

#slide-out {
    background: #222;
    position: absolute;
    display: block;
    left: 0;
    top: 0;
    z-index: 1;
    height: 100%;
    width: 80%;
    color: #ddd;
    -webkit-transform: translate3d(-101%, 0, 0);
       -moz-transform: translate3d(-100%, 0, 0);
        -ms-transform: translate3d(-100%, 0, 0);
         -o-transform: translate3d(-100%, 0, 0);
            transform: translate3d(-100%, 0, 0);
    
    -webkit-backface-visibility: hidden;
       -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
         -o-backface-visibility: hidden;
            backface-visibility: hidden;
}

.search-mobile {
    margin: 15px 10px;
    height: 30px;
    overflow: hidden;
    background: #fcfcfc;
    border: 1px solid #ddd;
    border-top-color: #d1d1d1;
    border-left-color: #d1d1d1;
    overflow: hidden;
    position: relative;
    -webkit-border-radius: 20px;
       -moz-border-radius: 20px;
            border-radius: 20px;
    
    -webkit-box-shadow: inset 0 2px 5px #eee;
       -moz-box-shadow: inset 0 2px 5px #eee;
            box-shadow: inset 0 2px 5px #eee;
}

.search-mobile #s-mobile {
    background: transparent;
    float: right;
    margin: 0;
    padding: 7px 12px;
    width: 100%;
    color: #444;
    border: 0 none;
}

.search-mobile button.search-button {
    background: transparent;
    position: absolute;
    top: 0;
    right: 0;
    height: 28px;
    padding: 0;
    width: 40px;
    font-size: 18px;
    color: #666;
}

.search-mobile button.search-button:hover {
    color: #000;
}

#slide-out .social-icons {
    margin-bottom: 15px;
}

#slide-out .social-icons a {
    color: #ccc;
    font-size: 16px;
    padding: 0 4px;
}

#slide-out .social-icons a:hover {
    color: #FFF;
}

#mobile-menu {
    border-top: 1px solid #2D2D2D;
    display: none;
}

#mobile-menu.mobile-hide-icons i.fa {
    display: none;
}

#slide-out #mobile-menu .mega-menu-block {
    padding: 0 !important;
    background: transparent !important;
    min-height: inherit !important;
}

#slide-out #mobile-menu ul ul,
#slide-out #mobile-menu .sub-menu-columns-item{
    display: none;
    background: #333;
}

#slide-out #mobile-menu li {
    list-style: none;
    position: relative
}

#slide-out #mobile-menu ul li.menu-item-has-children i.mobile-arrows{
    position: absolute;
    top: 0;
    right: 0;
    padding: 13px;
    border-left: 1px solid #333;
    margin: 0;
    cursor: pointer;
    display: block;
}

#slide-out #mobile-menu a {
    color: #ccc;
    display: block;
    font-size: 16px;
    padding: 10px;
    padding-right: 0;
    border-bottom: 1px solid #2D2D2D;
}

#slide-out #mobile-menu a:hover {
    background: #111;
    color: #FFF;
}

#slide-out #mobile-menu ul ul a {
    font-size: 14px;
    padding-left: 30px
}

#slide-out #mobile-menu ul ul ul a {
    font-size: 12px;
    padding-left: 40px
}

#slide-out #mobile-menu ul ul ul a {
    padding-left: 50px
}

#slide-out #mobile-menu ul ul ul ul a {
    padding-left: 60px
}

#mobile-menu li.menu-item-home a:before {
    content: "\f015";
}

#slide-out-open {
    display: none;
    margin: 0;
    position: absolute;
    top: 33px;
    left: 5px;
    opacity: 1;
    height: 33px;
    width: 40px;
    z-index: 505;
}

#slide-out-open span {
    left: 6px;
}

#slide-out-open span,
#slide-out-open span:after,
#slide-out-open span:before {
    top: 5px;
    position: absolute;
    content: ' ';
    display: block;
    height: 3px;
    width: 28px;
    background: #333;
    -webkit-border-radius: 10px;
       -moz-border-radius: 10px;
            border-radius: 10px;
}

#slide-out-open span:before {
    top: 8px;
}

#slide-out-open span:after {
    top: 16px;
}

#open-slide-overlay {
    position: fixed;
    top: 0;
    left: 80%;
    z-index: 500;
    overflow: hidden;
    width: 100%;
    height: 100%;
}


/* open and Close the SlideOut panel */

.csstransforms3d.csstransitions .js-nav .inner-wrapper {
    left: 80%;
}

.csstransforms3d.csstransitions .js-nav #mobile-menu {
    display: block;
}

.inner-wrapper,
#slide-out {
	-webkit-transition: -webkit-transform 500ms ease, opacity 500ms ease;
	   -moz-transition:    -moz-transform 500ms ease, opacity 500ms ease;
	     -o-transition:      -o-transform 500ms ease, opacity 500ms ease;
	        transition:         transform 500ms ease, opacity 500ms ease;
}

.csstransforms3d.csstransitions .js-nav .inner-wrapper{
	left: 0 !important;
	/*opacity: .5;*/
    -webkit-backface-visibility: hidden;
	   -moz-backface-visibility: hidden;
	    -ms-backface-visibility: hidden;
	     -o-backface-visibility: hidden;
	        backface-visibility: hidden;
}

.csstransforms3d.csstransitions .js-nav #slide-out-open span{
    top: 14px;
    -webkit-animation: fa-spin .2s 2 linear;
            animation: fa-spin .2s 2 linear;
    
    -webkit-transform: rotate(45deg);
       -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
            transform: rotate(45deg);
}

.csstransforms3d.csstransitions .js-nav #slide-out-open span:after{
    top:0;
    -webkit-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
            transform: rotate(-90deg);
}

.csstransforms3d.csstransitions .js-nav #slide-out-open span:before{
    opacity: 0;
}

.csstransforms3d.csstransitions .js-nav .inner-wrapper {
	-webkit-transform: translate3d(80%, 0, 0);
	   -moz-transform: translate3d(80%, 0, 0);
	    -ms-transform: translate3d(80%, 0, 0);
	     -o-transform: translate3d(80%, 0, 0);
	        transform: translate3d(80%, 0, 0);
}

.csstransforms3d.csstransitions .js-nav #slide-out {
	-webkit-transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
	   -moz-transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
	    -ms-transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
	     -o-transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
	        transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
}

/* Animation */

@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translateY(-20px);
    transform: translateY(-20px);
  }

  100% {
    opacity: 1;
    -webkit-transform: translateY(0);
    transform: translateY(0);
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translateY(-20px);
    -ms-transform: translateY(-20px);
    transform: translateY(-20px);
  }

  100% {
    opacity: 1;
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    transform: translateY(0);
  }
}

/* Reviews */

.review-box {
    padding: 0;
    background: transparent;
}

.review-top{
    width: 55%;
}

#review-box .review-item h5 {
    color: #666;
}

#review-box.review-percentage .review-item h5,
#review-box.review-percentage .review-item h5 {
    line-height: 28px;
}

.review-percentage .review-item span span{
    background-color: #FF8500;
    height: 6px;
    top: auto;
    bottom: 0;
}

.review-final-score {
    background-color: #FF8500;
}

.review-box,
#review-box h2.review-box-header,
.review-item,
.review-summary,
.user-rate-wrap,
#review-box h1,
#review-box h2,
#review-box h3,
#review-box h4,
#review-box h5,
#review-box h6,
#review-box p,
#review-box strong {
    color: #444;
}

#review-box h2.review-box-header {
    background: #eee;
}

.review-item,
.review-summary,
.user-rate-wrap,
.review-stars .review-item,
.review-percentage .review-item span {
    background: #F2F2F2;
}

.review-final-score {
    width: 110px;
}



/**
 * Dark Skin
 * -----------------------------------------------------------------------------
 */

body.dark-skin {
    background-color: #000;
    color: #bfbfbf;
}

body.dark-skin #wrapper.boxed #theme-header,
body.dark-skin #wrapper.boxed .breaking-news,
body.dark-skin #wrapper.boxed #main-content,
body.dark-skin #wrapper.boxed-all #theme-header,
body.dark-skin #wrapper.boxed-all{
    background-color: #3c3c3c;
    -webkit-box-shadow: 0 0 3px #141414;
       -moz-box-shadow: 0 0 3px #141414;
            box-shadow: 0 0 3px #141414;
}

body.dark-skin .cat-box-content,
body.dark-skin #sidebar .widget-container,
body.dark-skin #wrapper.boxed-all .breaking-news,
body.dark-skin #wrapper.wide-layout .breaking-news,
body.dark-skin .post-listing,
body.dark-skin #live-search_results,
body.dark-skin .arqam-lite-widget-counter,
body.dark-skin #commentform {
    background-color: #3c3c3c;
    -webkit-box-shadow: 0 0 3px #2A2A2A;
       -moz-box-shadow: 0 0 3px #2A2A2A;
            box-shadow: 0 0 3px #2A2A2A;
}

body.dark-skin #tabbed-widget .tabs-wrap li,
body.dark-skin .comments-avatar .widget-container li,
body.dark-skin .posts-list .widget-container li,
body.dark-skin .categort-posts .widget-container li,
body.dark-skin .authors-posts .widget-container li,
body.dark-skin .widget.woocommerce .widget-container li,
body.dark-skin .widget-container ul.reviews-posts li,
body.dark-skin .widget_categories .widget-container li,
body.dark-skin .widget_archive .widget-container li,
body.dark-skin .widget_nav_menu .widget-container li,
body.dark-skin .widget_meta .widget-container li,
body.dark-skin .widget_pages .widget-container li,
body.dark-skin .widget_recent_comments .widget-container li,
body.dark-skin .widget_recent_entries .widget-container li,
body.dark-skin #crumbs,
body.dark-skin .woocommerce-breadcrumb,
body.dark-skin .post-inner p.post-meta,
body.dark-skin .comment-wrap,
body.dark-skin .tie-weather-forecast,
body.dark-skin .share-post,
body.dark-skin #tabbed-widget .widget-top,
body.dark-skin .item-list,
body.dark-skin .widget.timeline-posts li h3,
body.dark-skin .widget.timeline-posts li span.tie-date:before,
body.dark-skin .entry #related_posts,
body.dark-skin .live-search_result_container li,
body.dark-skin .twitter-widget-content li,
body.dark-skin #theme-footer .twitter-widget-content li,
body.dark-skin .list-box li.other-news,
body.dark-skin .column2 li,
body.dark-skin .wide-box li,
body.dark-skin .cat-tabs-header,
body.dark-skin .sitemap-col h2,
body.dark-skin ul.authors-wrap li,
body.dark-skin .entry ul.best-reviews li,
body.dark-skin .arqam-lite-widget-counter li,
body.dark-skin .divider,
body.dark-skin .post-content-slideshow-outer,
body.dark-skin .woocommerce ul.products li.product .price,
body.dark-skin .woocommerce-page ul.products li.product .price,
body.dark-skin .flickr-wrapper .flickr_badge_image img,
body.dark-skin .review-final-score {
    border-color: #474747;
}

body.dark-skin .search-block-large #s,
body.dark-skin ul.timeline {
    border-color: #2F2F2F;
}

body.dark-skin #wrapper.wide-layout,
body.dark-skin #wrapper.wide-layout #theme-header,
body.dark-skin .share-post,
body.dark-skin .search-block-large #s,
body.dark-skin .commentlist .reply a,
body.dark-skin #tabbed-widget ul.tabs li.active a,
body.dark-skin .cat-tabs-header li.active,
body.dark-skin .post-tabs ul.tabs-nav li.current,
body.dark-skin .post-tabs-ver ul.tabs-nav li.current {
    background-color: #3c3c3c;
}

body.dark-skin .commentlist .reply a:hover,
body.dark-skin #tabbed-widget .widget-top,
body.dark-skin ul.timeline li.timeline-post:before,
body.dark-skin h2.timeline-head,
body.dark-skin .top-nav ul ul,
body.dark-skin .cat-tabs-header,
body.dark-skin .entry ul.best-reviews .best-review-score,
body.dark-skin #tabbed-widget .tabs-wrap.tagcloud a:hover,
body.dark-skin .woocommerce-pagination .page-numbers li .page-numbers.current {
    background-color: #2A2A2A;
}

body.dark-skin .search-block #s-header {
    background-color: #303030;
    border-color: #444;
}

body.dark-skin .scroll-nav {
    background-color: #373737;
}

body.dark-skin #tabbed-widget ul.tabs li.active a,
body.dark-skin .cat-tabs-header li.active {
    -webkit-box-shadow: 0 -1px 2px #282828;
       -moz-box-shadow: 0 -1px 2px #282828;
            box-shadow: 0 -1px 2px #282828;
}

body.dark-skin .top-nav .social-icons a {
    color: #999;
}

body.dark-skin a,
body.dark-skin .tie-weather-current-temp,
body.dark-skin #tabbed-widget ul.tabs li a,
body.dark-skin .search-block #s-header:focus {
    color: #ECECEC;
}

body.dark-skin p.post-meta a {
    color: #888;
}

body.dark-skin .breaking-news ul a {
    background: #3c3c3c;
}

body.dark-skin a:hover,
body.dark-skin p.post-meta a:hover,
body.dark-skin .author-comment cite,
body.dark-skin .post-title,
body.dark-skin #tabbed-widget ul.tabs li.active a,
body.dark-skin textarea:focus,
body.dark-skin input[type=text]:focus,
body.dark-skin input[type=password]:focus,
body.dark-skin input[type=email]:focus,
body.dark-skin input[type=url]:focus,
body.dark-skin input[type=tel]:focus,
body.dark-skin input[type=number]:focus,
body.dark-skin input[type=date]:focus,
body.dark-skin input[type=file]:focus,
body.dark-skin input[type=search]:focus,
