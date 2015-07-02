(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

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
