(function($) {
$(document).ready(function(){
    // Progress bars
    
    (function(){
        var $w = $(window);
        var start = $('.entry').offset().top;
        var $circ = $('.anicircle');
        var $progCount = $('.progress-count');
        var $prog2 = $('.progress-indicator-2');

        var wh, h, sHeight;

        function setSizes(){
            wh = $w.height();
            h = $('.entry').height() + start + 200;
            sHeight = h - wh;
        }
        setSizes();

        $w.on('scroll', function(){
            var perc = Math.max(0, Math.min(1, $w.scrollTop()/sHeight));            
            updateProgress(perc);
        }).on('resize', function(){
            setSizes();
            $w.trigger('scroll');
        });

        function updateProgress(perc){
            var circle_offset = 314 * perc;
            $circ.css({
                "stroke-dashoffset" : 0 - circle_offset
            });
            
            if(perc === 0) {
                $progCount.hide();
                $prog2.hide();
                $('.linktc').removeClass('active');
            } else if (perc === 1) {
                $prog2.hide();
                $('.linktc').removeClass('active');
            } else {
                $progCount.show().html(Math.round(perc * 100) + "%");
                $prog2.show().css({width : perc*100 + '%'});
                
                var scrollbot = perc * 100;
                //if ($(window).width() > 991) {
                    if(scrollbot >= 60 ) {
                        $('.linktc').addClass('active');
                    }
                //}
            }
        }
    }());
    
    
    // Copy protect link
    
    function protectLink() {
        var istS = 'Источник:';
        var copyR = '© https://sultan-tv.ru/';
        var body_element = document.getElementsByTagName('body')[0];
        var choose = window.getSelection();
        var myLink = document.location.href;
        var authorLink = "<br /><br />" + istS + ' ' + "<a href='"+myLink+"'>"+myLink+"</a><br />" + copyR;
        var copytext = choose + authorLink;
        var addDiv = document.createElement('div');
        addDiv.style.position='absolute';
        addDiv.style.left='-99999px';
        body_element.appendChild(addDiv);
        addDiv.innerHTML = copytext;
        choose.selectAllChildren(addDiv);
        window.setTimeout(function() {
            body_element.removeChild(addDiv);
        },0);
    }
    document.oncopy = protectLink;
    
    
    // Disable right click
    
    document.ondragstart = function() {
        return false;
    }
    function nocontext(e) {
	   return false;
	}
	document.oncontextmenu = nocontext;
    
    
    // Table of contents
    
    !(function (t) {
        var o = {};
        function e(n) {
            if (o[n]) return o[n].exports;
            var i = (o[n] = { i: n, l: !1, exports: {} });
            return t[n].call(i.exports, i, i.exports, e), (i.l = !0), i.exports;
        }
        (e.m = t),
            (e.c = o),
            (e.d = function (t, o, n) {
                e.o(t, o) || Object.defineProperty(t, o, { configurable: !1, enumerable: !0, get: n });
            }),
            (e.n = function (t) {
                var o =
                    t && t.__esModule
                        ? function () {
                              return t.default;
                          }
                        : function () {
                              return t;
                          };
                return e.d(o, "a", o), o;
            }),
            (e.o = function (t, o) {
                return Object.prototype.hasOwnProperty.call(t, o);
            }),
            (e.p = "/"),
            e((e.s = 0));
    })([
        function (t, o, e) {
            e(1), (t.exports = e(2));
        },
        function (t, o) {
            $(function () {
                var t = $("body"),
                    o = $(".post-toc");
                if (
                    (o.on("click", ".toggle", function () {
                        var t = $(".post-toc"),
                            o = $(this);
                        t.hasClass("visible") ? (t.removeClass("visible") && t.find('.toggle').text("Содержание")) : (t.addClass("visible") && t.find('.toggle').html("&#9776;"));
                    }),
                    o.find("a").on("click", function () {
                        var t = $(this).attr("href").substr(1),
                            e = $("#" + t),
                            n = 100;
                        return (
                            window.innerWidth < 992 && (o.removeClass("visible") && o.find('.toggle').text("Содержание"), (n += 40)),
                            $("html, body")
                                .stop()
                                .animate({ scrollTop: e.offset().top - n }, 200),
                            !1
                        );
                    }),
                    window.innerWidth >= 992 && t.hasClass("single-post") || window.innerWidth >= 992 && t.hasClass("single-turkey"))
                ) {
                    var e = function (t) {
                            var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null;
                            if (t.length) {
                                var n = o.find(".post-toc-wrap");
                                n.animate({ scrollTop: n[0].scrollTop + t.position().top }, null === e ? 50 : e);
                            }
                        },
                        n = function () {
                            (o = $(".post-toc")), (a = o.offset().top + 30);
                            var t = $(".post-content"),
                                n = a + 300 + t.height(),
                                s = null;
                            (i[t.offset().top] = "preface"),
                                t.find("h2, h3, h4, h5, h6").each(function () {
                                    i[$(this).offset().top] = $(this).attr("id");
                                });
                            var r = function () {
                                var t = (function () {
                                    for (var t in i) if (t > window.scrollY) return i[t];
                                    return i[i.length - 1];
                                })();
                                if (t !== s) {
                                    var r = $('[href="#' + t + '"]');
                                    (s = t), $(".post-toc .active").removeClass("active"), r.addClass("active"), e(r);
                                }

                                window.scrollY >= a && !o.hasClass("fixed") ? o.addClass("fixed") && o.find('.toggle').text("Содержание") : window.scrollY < a && o.hasClass("fixed") && o.removeClass("fixed visible"),

                                    window.scrollY + window.innerHeight >= n && !o.hasClass("bottom")
                                        ? o.addClass("bottom")
                                        : window.scrollY + window.innerHeight < n && o.hasClass("bottom") && (o.removeClass("bottom"), e(o.find('[href="#' + s + '"]'), 0));
                            };
                            r(), $(document).scroll(r);
                        };
                    setTimeout(function () {
                        return n();
                    }, 100);
                    var i = {},
                        a = o.offset().top + 30;
                }

                if (window.innerWidth < 992 && t.hasClass("single-post") || window.innerWidth < 992 && t.hasClass("single-turkey")) {
                    var s = o.offset().top + 400,
                        r = function () {
                            window.scrollY >= s && !o.hasClass("fixed-mobile") ? o.addClass("fixed-mobile") && o.find('.toggle').text("Содержание") : window.scrollY < s && o.hasClass("fixed-mobile") && o.removeClass("fixed-mobile visible");
                        };
                    r(), $(window).scroll(r);
                }




            });
        },
        function (t, o) {},
    ]);
    
    
});
	
})(jQuery);