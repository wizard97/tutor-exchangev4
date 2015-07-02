<!doctype html>
<html>
  <head>
      <meta name="google-site-verification" content="x91WvPNaAdw3bjXe9VZONNcImZP-iuspmgaPee1oqpM" />
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Lexington Tutor Exchange, Exclusively For Lexington MA Tutoring</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <!-- Include font Awesome -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
      <!-- jquery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>
body {
  padding-top: 70px;
}
</style>

      <script>

//for review box
(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);
//stars
var __slice=[].slice;!function(t){var n;return n=function(){function n(n,s){var r,i,a,e=this;this.options=t.extend({},this.defaults,s),this.$el=n,a=this.defaults;for(r in a)i=a[r],null!=this.$el.data(r)&&(this.options[r]=this.$el.data(r));this.createStars(),this.syncRating(),this.$el.on("mouseover.starrr","span",function(t){return e.syncRating(e.$el.find("span").index(t.currentTarget)+1)}),this.$el.on("mouseout.starrr",function(){return e.syncRating()}),this.$el.on("click.starrr","span",function(t){return e.setRating(e.$el.find("span").index(t.currentTarget)+1)}),this.$el.on("starrr:change",this.options.change)}return n.prototype.defaults={rating:void 0,numStars:5,change:function(){}},n.prototype.createStars=function(){var t,n,s;for(s=[],t=1,n=this.options.numStars;n>=1?n>=t:t>=n;n>=1?t++:t--)s.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));return s},n.prototype.setRating=function(t){return this.options.rating===t&&(t=void 0),this.options.rating=t,this.syncRating(),this.$el.trigger("starrr:change",t)},n.prototype.syncRating=function(t){var n,s,r,i;if(t||(t=this.options.rating),t)for(n=s=0,i=t-1;i>=0?i>=s:s>=i;n=i>=0?++s:--s)this.$el.find("span").eq(n).removeClass("glyphicon-star-empty").addClass("glyphicon-star");if(t&&5>t)for(n=r=t;4>=t?4>=r:r>=4;n=4>=t?++r:--r)this.$el.find("span").eq(n).removeClass("glyphicon-star").addClass("glyphicon-star-empty");return t?void 0:this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")},n}(),t.fn.extend({starrr:function(){var s,r;return r=arguments[0],s=2<=arguments.length?__slice.call(arguments,1):[],this.each(function(){var i;return i=t(this).data("star-rating"),i||t(this).data("star-rating",i=new n(t(this),r)),"string"==typeof r?i[r].apply(i,s):void 0})}})}(window.jQuery,window),$(function(){return $(".starrr").starrr()});


$(function() {
    $('#new-review').autosize({
        append: "\n"
    });
    var reviewBox = $('#post-review-box');
    var newReview = $('#new-review');
    var openReviewBtn = $('#open-review-box');
    var closeReviewBtn = $('#close-review-box');
    var ratingsField = $('#ratings-hidden');
    openReviewBtn.click(function(e) {
        reviewBox.slideDown(400, function() {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
        });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
    });
    closeReviewBtn.click(function(e) {
        e.preventDefault();
        reviewBox.slideUp(300, function() {
            newReview.focus();
            openReviewBtn.fadeIn(200);
        });
        closeReviewBtn.hide();
    });
    $('.starrr').on('starrr:change', function(e, value) {
        ratingsField.val(value);
    });
});


//runs when page is loaded
$(document).ready(function() {
    //expand and collapse large texts
    $('.about_me').readmore({
        collapsedHeight: 200,
        moreLink: '<a href="#">Read more</a>',
        lessLink: '<a href="#">Read less</a>',
        embedCSS: true,
        startOpen: false
    });
    $('.review').readmore({
        collapsedHeight: 200,
        moreLink: '<a href="#">Read more</a>',
        lessLink: '<a href="#">Read less</a>',
        embedCSS: true,
        startOpen: false
    });

    //to save tutors
    $(".text-center").on("click", "button.btn, #save_btn", function() {
        var $button = $(this);
        var id = $button.val();
        var url = $("#url").val();
        var $html = "";
        $.post(url, {
            'saved_tutors_id[]': [id]
        }, function(data) {
            var json = $.parseJSON(data);
            if (json[id] === true) {
                $html = $(
                    '<button type="button" id="save_btn" name="saved_tutors_id[]" value="" class="btn btn-info" aria-expanded="false"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> Saved!</button>'
                );
                $button.replaceWith($html);
                $html.val(id);
            } else {
                $html = $(
                    '<button type="button" id="save_btn" name="saved_tutors_id[]" value="" class="btn btn-warning" aria-expanded="false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save me!</button>'
                );
                $button.replaceWith($html);
                $html.val(id);
            }
            var url_feed = $("#url_feedback").val();
            $.ajax(url_feed, {
                success: function(data) {
                    //remove old feedback messages
                    $(".alert").remove();
                    $(".page-header").after(
                        data);
                }
            });
        });
    });
});

</script>


<script>
$(document).ready(function(){
    $('#resultsTable').dataTable();
	$(".integers").counterUp({delay: 10,time: 1000});

});
!function(e){"use strict";function t(e,t,a){var i;return function(){var n=this,o=arguments,r=function(){i=null,a||e.apply(n,o)},s=a&&!i;clearTimeout(i),i=setTimeout(r,t),s&&e.apply(n,o)}}function a(e){var t=++h;return String(null==e?"rmjs-":e)+t}function i(e){var t=e.clone().css({height:"auto",width:e.width(),maxHeight:"none",overflow:"hidden"}).insertAfter(e),a=t.outerHeight(),i=parseInt(t.css({maxHeight:""}).css("max-height").replace(/[^-\d\.]/g,""),10),n=e.data("defaultHeight");t.remove();var o=i||e.data("collapsedHeight")||n;e.data({expandedHeight:a,maxHeight:i,collapsedHeight:o}).css({maxHeight:"none"})}function n(e){if(!d[e.selector]){var t=" ";e.embedCSS&&""!==e.blockCSS&&(t+=e.selector+" + [data-readmore-toggle], "+e.selector+"[data-readmore]{"+e.blockCSS+"}"),t+=e.selector+"[data-readmore]{transition: height "+e.speed+"ms;overflow: hidden;}",function(e,t){var a=e.createElement("style");a.type="text/css",a.styleSheet?a.styleSheet.cssText=t:a.appendChild(e.createTextNode(t)),e.getElementsByTagName("head")[0].appendChild(a)}(document,t),d[e.selector]=!0}}function o(t,a){this.element=t,this.options=e.extend({},s,a),n(this.options),this._defaults=s,this._name=r,this.init(),window.addEventListener?(window.addEventListener("load",l),window.addEventListener("resize",l)):(window.attachEvent("load",l),window.attachEvent("resize",l))}var r="readmore",s={speed:100,collapsedHeight:200,heightMargin:16,moreLink:'<a href="#">Read More</a>',lessLink:'<a href="#">Close</a>',embedCSS:!0,blockCSS:"display: block; width: 100%;",startOpen:!1,beforeToggle:function(){},afterToggle:function(){}},d={},h=0,l=t(function(){e("[data-readmore]").each(function(){var t=e(this),a="true"===t.attr("aria-expanded");i(t),t.css({height:t.data(a?"expandedHeight":"collapsedHeight")})})},100);o.prototype={init:function(){var t=this,n=e(this.element);n.data({defaultHeight:this.options.collapsedHeight,heightMargin:this.options.heightMargin}),i(n);var o=n.data("collapsedHeight"),r=n.data("heightMargin");if(n.outerHeight(!0)<=o+r)return!0;var s=n.attr("id")||a(),d=t.options.startOpen?t.options.lessLink:t.options.moreLink;n.attr({"data-readmore":"","aria-expanded":!1,id:s}),n.after(e(d).on("click",function(e){t.toggle(this,n[0],e)}).attr({"data-readmore-toggle":"","aria-controls":s})),t.options.startOpen||n.css({height:o})},toggle:function(t,a,i){i&&i.preventDefault(),t||(t=e('[aria-controls="'+this.element.id+'"]')[0]),a||(a=this.element);var n=this,o=e(a),r="",s="",d=!1,h=o.data("collapsedHeight");o.height()<=h?(r=o.data("expandedHeight")+"px",s="lessLink",d=!0):(r=h,s="moreLink"),n.options.beforeToggle(t,a,!d),o.css({height:r}),o.on("transitionend",function(){n.options.afterToggle(t,a,d),e(this).attr({"aria-expanded":d}).off("transitionend")}),e(t).replaceWith(e(n.options[s]).on("click",function(e){n.toggle(this,a,e)}).attr({"data-readmore-toggle":"","aria-controls":o.attr("id")}))},destroy:function(){e(this.element).each(function(){var t=e(this);t.attr({"data-readmore":null,"aria-expanded":null}).css({maxHeight:"",height:""}).next("[data-readmore-toggle]").remove(),t.removeData()})}},e.fn.readmore=function(t){var a=arguments,i=this.selector;return t=t||{},"object"==typeof t?this.each(function(){if(e.data(this,"plugin_"+r)){var a=e.data(this,"plugin_"+r);a.destroy.apply(a)}t.selector=i,e.data(this,"plugin_"+r,new o(this,t))}):"string"==typeof t&&"_"!==t[0]&&"init"!==t?this.each(function(){var i=e.data(this,"plugin_"+r);i instanceof o&&"function"==typeof i[t]&&i[t].apply(i,Array.prototype.slice.call(a,1))}):void 0}}(jQuery);
(function(e){"use strict";e.fn.counterUp=function(t){var n=e.extend({time:400,delay:10},t);return this.each(function(){var t=e(this),r=n,i=function(){var e=[],n=r.time/r.delay,i=t.text(),s=/[0-9]+,[0-9]+/.test(i);i=i.replace(/,/g,"");var o=/^[0-9]+$/.test(i),u=/^[0-9]+\.[0-9]+$/.test(i),a=u?(i.split(".")[1]||[]).length:0;for(var f=n;f>=1;f--){var l=parseInt(i/n*f);u&&(l=parseFloat(i/n*f).toFixed(a));if(s)while(/(\d+)(\d{3})/.test(l.toString()))l=l.toString().replace(/(\d+)(\d{3})/,"$1,$2");e.unshift(l)}t.data("counterup-nums",e);t.text("0");var c=function(){t.text(t.data("counterup-nums").shift());if(t.data("counterup-nums").length)setTimeout(t.data("counterup-func"),r.delay);else{delete t.data("counterup-nums");t.data("counterup-nums",null);t.data("counterup-func",null)}};t.data("counterup-func",c);setTimeout(t.data("counterup-func"),r.delay)};t.waypoint(i,{offset:"100%",triggerOnce:!0})})}})(jQuery);
</script>

<style>
/*
 * Base structure
 */

/* Move down content because we have a fixed navbar that is 50px tall */

/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

/*
 * Top navigation
 * Hide default border to remove 1px line.
 */
.navbar-fixed-top {
  border: 0;
}

/*
 * Sidebar
 */

/* Hide for mobile, show later */
.sidebar {
  display: none;
}
@media (min-width: 768px) {
  .sidebar {
    position: fixed;
    top: 51px;
    bottom: 0;
    left: 0;
    z-index: 1000;
    display: block;
    padding: 20px;
    overflow-x: hidden;
    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    background-color: #f5f5f5;
    border-right: 1px solid #eee;
  }
}

/* Sidebar navigation */
.nav-sidebar {
  margin-right: -21px; /* 20px padding + 1px border */
  margin-bottom: 20px;
  margin-left: -20px;
}
.nav-sidebar > li > a {
  padding-right: 20px;
  padding-left: 20px;
}
.nav-sidebar > .active > a,
.nav-sidebar > .active > a:hover,
.nav-sidebar > .active > a:focus {
  color: #fff;
  background-color: #428bca;
}


/*
 * Main content
 */

.main {
  padding: 20px;
}
@media (min-width: 768px) {
  .main {
    padding-right: 40px;
    padding-left: 40px;
  }
}
.main .page-header {
  margin-top: 0;
}


/*
 * Placeholder dashboard ideas
 */

.placeholders {
  margin-bottom: 30px;
  text-align: center;
}
.placeholders h4 {
  margin-bottom: 0;
}
.placeholder {
  margin-bottom: 20px;
}
.placeholder img {
  display: inline-block;
  border-radius: 50%;
}
</style>


<style>
 .animated {
    -webkit-transition: height 0.2s;
    -moz-transition: height 0.2s;
    transition: height 0.2s;
}

.stars
{
    margin: 10px 0;
    font-size: 24px;
    color: #FEC601;
}
</style>

      <style type="text/css">
.table tbody>tr>td.vert-align{
    vertical-align: middle;
}
body { padding-bottom: 100px; }

.btn { white-space: normal; }

.social-title {text-transform: uppercase; letter-spacing: 1px; }
.count { font-size: 37px;margin-top: 10px;margin-bottom: 10px; }
.fa-stat { font-size: 100px;text-align: right;position: absolute;top: 7px;right: 27px;outline: none; }
.social .panel { color:#fff;text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); }
.social a { text-decoration:none; }
.box-a { background-color:#00acee; }
.box-b { background-color:#dd4b39; }
.box-c { background-color:#3b5998; }
.box-d { background-color:#eb6d20; }
</style>

  </head>

  <body>
    @include('templates/navbar')
        @yield('content')
    @include('templates/footer')
  </body>

</html>
