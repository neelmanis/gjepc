// left js uncompressed so it's easy to modify or use different functions

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: func href="http://toolscamp.ir/catgory/46/" target="_blank">»  تست واکنشگرا بودن</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/47/" target="_blank">»  کد خبرخوان (RSS خوان)</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/50/پسورد ساز قوی" target="_blank">»  پسورد ساز قوی</a></li>
     
     
    </ul>
   </li>
  
   <li title="تعداد مطالب درون این موضوع 43"><a href="http://toolscamp.ir/catgory/14/themes" target="_blank">» قالب سایت</a>
    <ul>
     
     <li title="تعداد مطالب درون این موضوع 37"><a href="http://toolscamp.ir/catgory/16/nasrblog" target="_blank">»  نصربلاگ</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/27/قالب 404" target="_blank">»  قالب 404</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/28/قالب لینک باکس" target="_blank">»  قالب لینک باکس</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/36/قالب آپلود سنتر" target="_blank">»  قالب آپلودسنتر</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 4"><a href="http://toolscamp.ir/catgory/37/" target="_blank">»  قالب HTML</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/55/theme-smu" target="_blank">»  سایت ساز سحر</a></li>
     
     
    </ul>
   </li>
  
   <li title="تعداد مطالب درون این موضوع 5"><a href="http://toolscamp.ir/catgory/17/forum_themes" target="_blank">» قالب انجمن</a>
    <ul>
     
     <li title="تعداد مطالب درون این موضوع 5"><a href="http://toolscamp.ir/catgory/18/theme_forum_for_nasrblog" target="_blank">»  نصربلاگ</a></li>
     
     
    </ul>
   </li>
  
   <li title="تعداد مطالب درون این موضوع 17"><a href="http://toolscamp.ir/catgory/19/learn" target="_blank">» آموزش</a>
    <ul>
     
     <li title="تعداد مطالب درون این موضوع 4"><a href="http://toolscamp.ir/catgory/20/coding" target="_blank">»  کدنویسی</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 3"><a href="http://toolscamp.ir/catgory/22/learn_html" target="_blank">»  HTML</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 3"><a href="http://toolscamp.ir/catgory/23/learn_css" target="_blank">»  CSS</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 6"><a href="http://toolscamp.ir/catgory/24/other_learns" target="_blank">»  دیگر آموزش ها</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 3"><a href="http://toolscamp.ir/catgory/39/" target="_blank">»  وبلاگ نویسی</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/48/" target="_blank">»  آموزش گرافیک</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/49/" target="_blank">»  آموزش کسب درآمد</a></li>
     
     
    </ul>
   </li>
  
   <li title="تعداد مطالب درون این موضوع 12"><a href="http://toolscamp.ir/catgory/29/" target="_blank">» گرافیک</a>
    <ul>
     
     <li title="تعداد مطالب درون این موضوع 4"><a href="http://toolscamp.ir/catgory/30/طرح های آماده" target="_blank">»  طرح های آماده</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/31/" target="_blank">»  لایه باز بنر</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/33/" target="_blank">»  لایه باز قالب</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/35/" target="_blank">»  لایه باز کاور</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 2"><a href="http://toolscamp.ir/catgory/38/" target="_blank">»  لایه باز پوستر</a></li>
     
     
     <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/51/icons" target="_blank">»  آیکون های آماده</a></li>
     
     
    </ul>
   </li>
  
   <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/53/" target="_blank">» نرم افزار</a>
    <ul>
     
     <li title="تعداد مطالب درون این موضوع 1"><a href="http://toolscamp.ir/catgory/54/" target="_blank">»  نرم افزار افزایش بازدید</a></li>
     
     
    </ul>
   </li>
  
  </div>
  
  <NB:Blog_Archive_Block>
  <div class="Archive_block_toolscamp">
  
   <li><a href="http://toolscamp.ir/archive/1394/9">آذر 1394 (16)</a></li>
  
   <li><a href="http://toolscamp.ir/archive/1394/8">آبان 1394 (13)</a></li>
  
   <li><a href="http://toolscamp.ir/archive/1394/7">مهر 1394 (26)</a></li>
  
   <li><a href="http://toolscamp.ir/archive/1394/6">شهریور 1394 (20)</a></li>
  
   <li><a href="http://toolscamp.ir/archive/1394/5">مرداد 1394 (24)</a></li>
  
   <li><a href="http://toolscamp.ir/archive/1394/4">تیر 1394 (12)</a></li>
  
   <li><a href="http://toolscamp.ir/archive/1394/10">دی 1394 (16)</a></li>
  
  <!--<li><a href="[NB:Blog_Archive_Link]" target="_blank">آرشیو کامل</a></li>-->
  </div>
  </NB:Blog_Archive_Block>
  <div id="Main_Block_Toolscamp">
   <div id="Window_Block_Toolscamp">
     <div class="Head_Title"> جستجو <a href="#"><span style="float:left;" id="Close_Window_Toolscamp">x</span></a></div>
     <div style="padding:5px; line-height:19px;">
     <form method="get" action="/">
      برای جستجو کلید واژه ی خود را در کادر پایین وارد کنید .<br /><br />
     <center><input type="text" dir="rtl" size="50" name="s" placeholder="جستجو ..." />
    
      <input type="submit" value="جستجو" /> </center>
       
جستجو در : <select name="cs">
 <option value="all">همه دسته ها</option>

 <option value="1">+ تولز کمپ (84) </option>
 
 <option value="2"> - اخبار (32) </option>
  
 

 <option value="3">+ کد و ابزار (66) </option>
 
 <option value="4"> - ابزارهای کاربردی (82) </option>
  
 
 <option value="6"> - JavaScript و jQuery (57) </option>
  
 
 <option value="7"> - کد ها و فونتها (12) </option>
  
 
 <option value="8"> - کدهای css (24) </option>
  
 
 <option value="10"> - کدهای html (6) </option>
  
 
 <option value="11"> - کدهای ترکیبی (7) </option>
  
 
 <option value="12"> - مذهبی (1) </option>
  
 
 <option value="13"> - نصربلاگ (4) </option>
  
 
 <option value="40"> - منوی آماده (2) </option>
  
 
 <option value="41"> - اسلایدر آماده (2) </option>
  
 
 <option value="42"> - کد بنرهای محرم (1) </option>
  
 
 <option value="43"> - ابزار آیفریم (1) </option>
  
 
 <option value="44"> - ابزار انتقال به صفحه دیگر (1) </option>
  
 
 <option value="45"> - ابزار عشق سنج (1) </option>
  
 
 <option value="46"> - تست واکنشگرا بودن (1) </option>
  
 
 <option value="47"> - کد خبرخوان (RSS خوان) (1) </option>
  
 
 <option value="50"> - پسورد ساز قوی (1) </option>
  
 

 <option value="14">+ قالب سایت (43) </option>
 
 <option value="16"> - نصربلاگ (37) </option>
  
 
 <option value="27"> - قالب 404 (2) </option>
  
 
 <option value="28"> - قالب لینک باکس (1) </option>
  
 
 <option value="36"> - قالب آپلودسنتر (2) </option>
  
 
 <option value="37"> - قالب HTML (4) </option>
  
 
 <option value="55"> - سایت ساز سحر (2) </option>
  
 

 <option value="17">+ قالب انجمن (5) </option>
 
 <option value="18"> - نصربلاگ (5) </option>
  
 

 <option value="19">+ آموزش (17) </option>
 
 <option value="20"> - کدنویسی (4) </option>
  
 
 <option value="22"> - HTML (3) </option>
  
 
 <option value="23"> - CSS (3) </option>
  
 
 <option value="24"> - دیگر آموزش ها (6) </option>
  
 
 <option value="39"> - وبلاگ نویسی (3) </option>
  
 
 <option value="48"> - آموزش گرافیک (2) </option>
  
 
 <option value="49"> - آموزش کسب درآمد (2) </option>
  
 

 <option value="29">+ گرافیک (12) </option>
 
 <option value="30"> - طرح های آماده (4) </option>
  
 
 <option value="31"> - لایه باز بنر (2) </option>
  
 
 <option value="33"> - لایه باز قالب (1) </option>
  
 
 <option value="35"> - لایه باز کاور (2) </option>
  
 
 <option value="38"> - لایه باز پوستر (2) </option>
  
 
 <option value="51"> - آیکون های آماده (1) </option>
  
 

 <option value="53">+ نرم افزار (1) </option>
 
 <option value="54"> - نرم افزار افزایش بازدید (1) </option>
  
 

</select>
 
     </form>
     <br />
سعی کنید از تگ برای جستجو استفاده کنید مثل : ابزار ، کد و یا ... .<br />
همچنین شما می توانید از موضوعات سایت ، مطلب مورد نظر خود را پیدا کنید.<br /><br />
<p align="left">
 ورژن 1.0
</p>
     </div>
  </div>
  
   <div class="hr_main_toolscamp">
<div style="background:#fff; text-align:center; width:50px; margin:auto; font:13px BYekan , b yekan , byekan , tahoma;"> تبلیغات 
</div></div><br />
   
    <center>
       <a href="http://www.winson.ir/post/6/" target="_blank"> <img src="http://dl.up20.ir/up/up20/images/web-des-banner_10906.gif" width="460" height="60" alt="Your ADS!" class="bannerstyle_toolscamp" /></a>
       <a href="http://toolscamp.ir/ads" target="_blank"> <img src="http://s1.toolscamp.ir/up/toolscamp/images/ads-palen-b_15725.png" width="460" height="60" alt="Your ADS!" class="bannerstyle_toolscamp" /></a>
     </center>
    
 <div class="hr2_main_toolscamp"></div>
  <div class="text_block_toolscamp" style="margin-top:5px; margin-bottom:5px; margin-right:40px;">
   <div class="txt_block_toolscamp">
    <div class="icon_toolscamp"></div>
    <div class="text_block_2_toolscamp">کد و ابزار</div>
    <div class="txt2_block_toolscamp" style="text-align:justify; padding:5px;">
     کدنویسی در زمینه ی وب و وبسایت از اهمیت بالایی برخوردار است تمام سایت های
درون اینترنت از یه سری کدهایی تشکیل شده اند که محتویات سایت با کدها بــــــه
نمایش در آمده است ، ابزار هم کدی هست که برای شما کدی را تولید می کنـــــــــد
که می توانیـــــ