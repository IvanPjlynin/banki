! function (t) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], t) : "undefined" != typeof module && module.exports ? module.exports = t(require("jquery")) : t(jQuery)
}(function (t) {
    var e = -1,
        o = -1,
        n = function (t) {
            return parseFloat(t) || 0
        },
        a = function (e) {
            var o = 1,
                a = t(e),
                i = null,
                r = [];
            return a.each(function () {
                var e = t(this),
                    a = e.offset().top - n(e.css("margin-top")),
                    s = r.length > 0 ? r[r.length - 1] : null;
                null === s ? r.push(e) : Math.floor(Math.abs(i - a)) <= o ? r[r.length - 1] = s.add(e) : r.push(e), i = a
            }), r
        },
        i = function (e) {
            var o = {
                byRow: !0,
                property: "height",
                target: null,
                remove: !1
            };
            return "object" == typeof e ? t.extend(o, e) : ("boolean" == typeof e ? o.byRow = e : "remove" === e && (o.remove = !0), o)
        },
        r = t.fn.matchHeight = function (e) {
            var o = i(e);
            if (o.remove) {
                var n = this;
                return this.css(o.property, ""), t.each(r._groups, function (t, e) {
                    e.elements = e.elements.not(n)
                }), this
            }
            return this.length <= 1 && !o.target ? this : (r._groups.push({
                elements: this,
                options: o
            }), r._apply(this, o), this)
        };
    r.version = "0.7.2", r._groups = [], r._throttle = 80, r._maintainScroll = !1, r._beforeUpdate = null, r._afterUpdate = null, r._rows = a, r._parse = n, r._parseOptions = i, r._apply = function (e, o) {
        var s = i(o),
            h = t(e),
            l = [h],
            c = t(window).scrollTop(),
            p = t("html").outerHeight(!0),
            u = h.parents().filter(":hidden");
        return u.each(function () {
            var e = t(this);
            e.data("style-cache", e.attr("style"))
        }), u.css("display", "block"), s.byRow && !s.target && (h.each(function () {
            var e = t(this),
                o = e.css("display");
            "inline-block" !== o && "flex" !== o && "inline-flex" !== o && (o = "block"), e.data("style-cache", e.attr("style")), e.css({
                display: o,
                "padding-top": "0",
                "padding-bottom": "0",
                "margin-top": "0",
                "margin-bottom": "0",
                "border-top-width": "0",
                "border-bottom-width": "0",
                height: "100px",
                overflow: "hidden"
            })
        }), l = a(h), h.each(function () {
            var e = t(this);
            e.attr("style", e.data("style-cache") || "")
        })), t.each(l, function (e, o) {
            var a = t(o),
                i = 0;
            if (s.target) i = s.target.outerHeight(!1);
            else {
                if (s.byRow && a.length <= 1) return void a.css(s.property, "");
                a.each(function () {
                    var e = t(this),
                        o = e.attr("style"),
                        n = e.css("display");
                    "inline-block" !== n && "flex" !== n && "inline-flex" !== n && (n = "block");
                    var a = {
                        display: n
                    };
                    a[s.property] = "", e.css(a), e.outerHeight(!1) > i && (i = e.outerHeight(!1)), o ? e.attr("style", o) : e.css("display", "")
                })
            }
            a.each(function () {
                var e = t(this),
                    o = 0;
                s.target && e.is(s.target) || ("border-box" !== e.css("box-sizing") && (o += n(e.css("border-top-width")) + n(e.css("border-bottom-width")), o += n(e.css("padding-top")) + n(e.css("padding-bottom"))), e.css(s.property, i - o + "px"))
            })
        }), u.each(function () {
            var e = t(this);
            e.attr("style", e.data("style-cache") || null)
        }), r._maintainScroll && t(window).scrollTop(c / p * t("html").outerHeight(!0)), this
    }, r._applyDataApi = function () {
        var e = {};
        t("[data-match-height], [data-mh]").each(function () {
            var o = t(this),
                n = o.attr("data-mh") || o.attr("data-match-height");
            n in e ? e[n] = e[n].add(o) : e[n] = o
        }), t.each(e, function () {
            this.matchHeight(!0)
        })
    };
    var s = function (e) {
        r._beforeUpdate && r._beforeUpdate(e, r._groups), t.each(r._groups, function () {
            r._apply(this.elements, this.options)
        }), r._afterUpdate && r._afterUpdate(e, r._groups)
    };
    r._update = function (n, a) {
        if (a && "resize" === a.type) {
            var i = t(window).width();
            if (i === e) return;
            e = i;
        }
        n ? o === -1 && (o = setTimeout(function () {
            s(a), o = -1
        }, r._throttle)) : s(a)
    }, t(r._applyDataApi);
    var h = t.fn.on ? "on" : "bind";
    t(window)[h]("load", function (t) {
        r._update(!1, t)
    }), t(window)[h]("resize orientationchange", function (t) {
        r._update(!0, t)
    })
});
//end func
var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
triggerTabList.forEach(function (triggerEl) {
    var tabTrigger = new bootstrap.Tab(triggerEl)
    triggerEl.addEventListener('click', function (event) {
        event.preventDefault()
        tabTrigger.show()
    })
})


;
(function ($) {

    function appendContent($el, content) {
        if (!content) return;

        // Simple test for a jQuery element
        $el.append(content.jquery ? content.clone() : content);
    }

    function appendBody($body, $element, opt) {
        // Clone for safety and convenience
        // Calls clone(withDataAndEvents = true) to copy form values.
        var $content = $element.clone(opt.formValues);

        if (opt.formValues) {
            // Copy original select and textarea values to their cloned counterpart
            // Makes up for inability to clone select and textarea values with clone(true)
            copyValues($element, $content, 'select, textarea');
        }

        if (opt.removeScripts) {
            $content.find('script').remove();
        }

        if (opt.printContainer) {
            // grab $.selector as container
            $content.appendTo($body);
        } else {
            // otherwise just print interior elements of container
            $content.each(function () {
                $(this).children().appendTo($body)
            });
        }
    }

    // Copies values from origin to clone for passed in elementSelector
    function copyValues(origin, clone, elementSelector) {
        var $originalElements = origin.find(elementSelector);

        clone.find(elementSelector).each(function (index, item) {
            $(item).val($originalElements.eq(index).val());
        });
    }

    var opt;
    $.fn.printThis = function (options) {
        opt = $.extend({}, $.fn.printThis.defaults, options);
        var $element = this instanceof jQuery ? this : $(this);

        var strFrameName = "printThis-" + (new Date()).getTime();

        if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
            // Ugly IE hacks due to IE not inheriting document.domain from parent
            // checks if document.domain is set by comparing the host name against document.domain
            var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</s" + "cript></head><body></body>\")";
            var printI = document.createElement('iframe');
            printI.name = "printIframe";
            printI.id = strFrameName;
            printI.className = "MSIE";
            document.body.appendChild(printI);
            printI.src = iframeSrc;

        } else {
            // other browsers inherit document.domain, and IE works if document.domain is not explicitly set
            var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
            $frame.appendTo("body");
        }

        var $iframe = $("#" + strFrameName);

        // show frame if in debug mode
        if (!opt.debug) $iframe.css({
            position: "absolute",
            width: "0px",
            height: "0px",
            left: "-600px",
            top: "-600px"
        });

        // before print callback
        if (typeof opt.beforePrint === "function") {
            opt.beforePrint();
        }

        // $iframe.ready() and $iframe.load were inconsistent between browsers
        setTimeout(function () {

            // Add doctype to fix the style difference between printing and render
            function setDocType($iframe, doctype) {
                var win, doc;
                win = $iframe.get(0);
                win = win.contentWindow || win.contentDocument || win;
                doc = win.document || win.contentDocument || win;
                doc.open();
                doc.write(doctype);
                doc.close();
            }

            if (opt.doctypeString) {
                setDocType($iframe, opt.doctypeString);
            }

            var $doc = $iframe.contents(),
                $head = $doc.find("head"),
                $body = $doc.find("body"),
                $base = $('base'),
                baseURL;

            // add base tag to ensure elements use the parent domain
            if (opt.base === true && $base.length > 0) {
                // take the base tag from the original page
                baseURL = $base.attr('href');
            } else if (typeof opt.base === 'string') {
                // An exact base string is provided
                baseURL = opt.base;
            } else {
                // Use the page URL as the base
                baseURL = document.location.protocol + '//' + document.location.host;
            }

            $head.append('<base href="' + baseURL + '">');

            // import page stylesheets
            if (opt.importCSS) $("link[rel=stylesheet]").each(function () {
                var href = $(this).attr("href");
                if (href) {
                    var media = $(this).attr("media") || "all";
                    $head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>");
                }
            });

            // import style tags
            if (opt.importStyle) $("style").each(function () {
                $head.append(this.outerHTML);
            });

            // add title of the page
            if (opt.pageTitle) $head.append("<title>" + opt.pageTitle + "</title>");

            // import additional stylesheet(s)
            if (opt.loadCSS) {
                if ($.isArray(opt.loadCSS)) {
                    jQuery.each(opt.loadCSS, function (index, value) {
                        $head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
                    });
                } else {
                    $head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
                }
            }

            var pageHtml = $('html')[0];

            // CSS VAR in html tag when dynamic apply e.g.  document.documentElement.style.setProperty("--foo", bar);
            $doc.find('html').prop('style', pageHtml.style.cssText);

            // copy 'root' tag classes
            var tag = opt.copyTagClasses;
            if (tag) {
                tag = tag === true ? 'bh' : tag;
                if (tag.indexOf('b') !== -1) {
                    $body.addClass($('body')[0].className);
                }
                if (tag.indexOf('h') !== -1) {
                    $doc.find('html').addClass(pageHtml.className);
                }
            }

            // copy ':root' tag classes
            tag = opt.copyTagStyles;
            if (tag) {
                tag = tag === true ? 'bh' : tag;
                if (tag.indexOf('b') !== -1) {
                    $body.attr('style', $('body')[0].style.cssText);
                }
                if (tag.indexOf('h') !== -1) {
                    $doc.find('html').attr('style', pageHtml.style.cssText);
                }
            }

            // print header
            appendContent($body, opt.header);

            if (opt.canvas) {
                // add canvas data-ids for easy access after cloning.
                var canvasId = 0;
                // .addBack('canvas') adds the top-level element if it is a canvas.
                $element.find('canvas').addBack('canvas').each(function () {
                    $(this).attr('data-printthis', canvasId++);
                });
            }

            appendBody($body, $element, opt);

            if (opt.canvas) {
                // Re-draw new canvases by referencing the originals
                $body.find('canvas').each(function () {
                    var cid = $(this).data('printthis'),
                        $src = $('[data-printthis="' + cid + '"]');

                    this.getContext('2d').drawImage($src[0], 0, 0);

                    // Remove the markup from the original
                    if ($.isFunction($.fn.removeAttr)) {
                        $src.removeAttr('data-printthis');
                    } else {
                        $.each($src, function (i, el) {
                            el.removeAttribute('data-printthis');
                        });
                    }
                });
            }

            // remove inline styles
            if (opt.removeInline) {
                // Ensure there is a selector, even if it's been mistakenly removed
                var selector = opt.removeInlineSelector || '*';
                // $.removeAttr available jQuery 1.7+
                if ($.isFunction($.removeAttr)) {
                    $body.find(selector).removeAttr("style");
                } else {
                    $body.find(selector).attr("style", "");
                }
            }

            // print "footer"
            appendContent($body, opt.footer);

            // attach event handler function to beforePrint event
            function attachOnBeforePrintEvent($iframe, beforePrintHandler) {
                var win = $iframe.get(0);
                win = win.contentWindow || win.contentDocument || win;

                if (typeof beforePrintHandler === "function") {
                    if ('matchMedia' in win) {
                        win.matchMedia('print').addListener(function (mql) {
                            if (mql.matches) beforePrintHandler();
                        });
                    } else {
                        win.onbeforeprint = beforePrintHandler;
                    }
                }
            }
            attachOnBeforePrintEvent($iframe, opt.beforePrintEvent);

            setTimeout(function () {
                if ($iframe.hasClass("MSIE")) {
                    // check if the iframe was created with the ugly hack
                    // and perform another ugly hack out of neccessity
                    window.frames["printIframe"].focus();
                    $head.append("<script>  window.print(); </s" + "cript>");
                } else {
                    // proper method
                    if (document.queryCommandSupported("print")) {
                        $iframe[0].contentWindow.document.execCommand("print", false, null);
                    } else {
                        $iframe[0].contentWindow.focus();
                        $iframe[0].contentWindow.print();
                    }
                }

                // remove iframe after print
                if (!opt.debug) {
                    setTimeout(function () {
                        $iframe.remove();

                    }, 1000);
                }

                // after print callback
                if (typeof opt.afterPrint === "function") {
                    opt.afterPrint();
                }

            }, opt.printDelay);

        }, 333);

    };

    // defaults
    $.fn.printThis.defaults = {
        debug: false, // show the iframe for debugging
        importCSS: true, // import parent page css
        importStyle: true, // import style tags
        printContainer: true, // print outer container/$.selector
        loadCSS: "", // path to additional css file - use an array [] for multiple
        pageTitle: "", // add title to print page
        removeInline: false, // remove inline styles from print elements
        removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
        printDelay: 1000, // variable print delay
        header: null, // prefix to html
        footer: null, // postfix to html
        base: false, // preserve the BASE tag or accept a string for the URL
        formValues: true, // preserve input/form values
        canvas: true, // copy canvas content
        doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
        removeScripts: false, // remove script tags from print content
        copyTagClasses: true, // copy classes from the html & body tag
        copyTagStyles: true, // copy styles from html & body tag (for CSS Variables)
        beforePrintEvent: null, // callback function for printEvent in iframe
        beforePrint: null, // function called before iframe is filled
        afterPrint: null // function called before iframe is removed
    };
})(jQuery);



jQuery(document).ready(function ($) {
    $(".type").chosen({
        disable_search_threshold: 10
    });
    let number = 1;
    $('.filter-fields > .jlmf-section .jlmf-list-1 div div label input[type="chekbox"]').on('click', function () {
        number++;
    });
    $('.filter > .jlmf-section').eq(1).after('<div class="search-filters">Фильтры поиска<span class="number">' + number + '</span><span class="arrow"></span></div>');
    $('.search-filters').on('click', function () {
        $(this).toggleClass('active');
        $('.filter-fields').slideToggle('300');
    });
    let field = $('.filter > .jlmf-section');
    field.slice(2, 7).wrapAll("<div class='filter-fields'></div>");
    $('.filter > .jlmf-section:nth-child(1), .filter > .jlmf-section:nth-child(2), .filter > .jlmf-section:last-child, .filter > .search-filters').addClass('col-md-3').wrapAll("<div class='row eq'></div>");
    $('.yrvote_box').appendTo($('.bank-info-row .rating'));
    //let articlesCount = $('#filter-items-cat > .items-row').length;
    //$('.jlmf-button').text('Показать ('+articlesCount+')');
    //$("#jlcontentfieldsfilter-ordering-107").chosen({disable_search_threshold: 10});
    // Calc
    var $range1 = $("#credit #range-one");
    var $range2 = $("#credit #range-two");
    var $range3 = $("#credit-card #range-one");
    var $range4 = $("#loan #range-one");
    var $range5 = $("#loan #range-two");
    var $range6 = $("#deposit #range-one");
    var $range7 = $("#deposit #range-two");
    var $range8 = $("#credit #range-three");
    $range1.ionRangeSlider({
        type: "single",
        grid: false,
        from: 250000,
        postfix: '',
        min: 10000,
        step: 10000,
        grid_num: 4,
        grid_snap: '',
        max: 5000000
    });
    $range2.ionRangeSlider({
        type: "single",
        grid: false,
        from: 3,
        postfix: '',
        min: 3,
        step: 1,
        grid_num: 4,
        grid_snap: '',
        max: 84
    });
    $range3.ionRangeSlider({
        type: "single",
        grid: false,
        from: 250000,
        postfix: '',
        min: 10000,
        step: 10000,
        grid_num: 4,
        grid_snap: '',
        max: 3000000
    });
    $range4.ionRangeSlider({
        type: "single",
        grid: false,
        from: 30000,
        postfix: '',
        min: 1000,
        step: 1000,
        grid_num: 4,
        grid_snap: '',
        max: 80000
    });
    $range5.ionRangeSlider({
        type: "single",
        grid: false,
        from: 5,
        postfix: '',
        min: 5,
        step: 1,
        grid_num: 4,
        grid_snap: '',
        max: 180
    });
    $range6.ionRangeSlider({
        type: "single",
        grid: false,
        from: 2500000,
        postfix: '',
        min: 10000,
        step: 10000,
        grid_num: 4,
        grid_snap: '',
        max: 50000000
    });
    $range7.ionRangeSlider({
        type: "single",
        grid: false,
        from: 12,
        postfix: '',
        min: 1,
        step: 1,
        grid_num: 4,
        grid_snap: '',
        max: 120
    });
    $range8.ionRangeSlider({
        type: "single",
        grid: false,
        from: 25,
        postfix: '',
        min: 18,
        step: 1,
        grid_num: 4,
        grid_snap: '',
        max: 85
    });
    //ivp изменение слайдеров на главной в зависимости от селекта    
    $("div.service.credit .type").chosen().change( //событие смены селекта
        function () {
            //console.log($(this).val());
            if ($(this).val() == 'Наличными') {
                sliderLinkUpdate(10000, 5000000, 3, 84, '/kredity/kredit-nalichnymi');
            }
            if ($(this).val() == 'Залог') {
                sliderLinkUpdate(100000, 15000000, 2, 240, '/kredity/kredit-pod-zalog');
            }
            if ($(this).val() == 'Авто') {
                sliderLinkUpdate(50000, 7500000, 6, 96, '/kredity/kredit-na-avtomobil');
            }
            if ($(this).val() == 'Рефинансирование') {
                sliderLinkUpdate(20000, 5000000, 3, 120, '/kredity/refinansirovanie');
            }
        });
    $('.credit .hover-block .service-button').attr('href', '/kredity/kredit-nalichnymi');
    //функция обновления слайдеров и ссылки
    function sliderLinkUpdate(min1, max1, min2, max2, link) {
        let my_range1 = $range1.data("ionRangeSlider");
        let my_range2 = $range2.data("ionRangeSlider");
        my_range1.update({
            min: min1,
            max: max1
        });
        my_range2.update({
            min: min2,
            max: max2
        });
        $('.credit .hover-block .service-button').attr('href', link);
    }
    //разбитие цены на разряды
    $('.summa .bank-field-value').each(function (i, elem) {
        let summ = parseInt($(this).html());
        //console.log(summ.toLocaleString());
        $(this).html(summ.toLocaleString());
    });
    //end ivp   
    //credit
    $range1.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#credit .range-group.one');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-price').attr('value', value);
    });
    $range2.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#credit .range-group.two');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-term').attr('value', value);
    });
    //credit-card
    $range3.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#credit-card .range-group.one');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-price').attr('value', value);
    });
    //loan	
    $range4.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#loan .range-group.one');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-price').attr('value', value);
    });
    $range5.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#loan .range-group.two');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-term').attr('value', value);
    });
    //deposit	
    $range6.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#deposit .range-group.one');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-price').attr('value', value);
    });
    $range7.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#deposit .range-group.two');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-term').attr('value', value);
    });
    $range8.on("change", function () {
        var $this = $(this),
            value = $this.prop("value"),
            box = $(this).closest('#credit .range-group.three');
        box.find('.range-summary').text((value + "").replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        box.find('.form-age').attr('value', value);
    });
    var slider1 = $range1.data("ionRangeSlider");
    var slider2 = $range2.data("ionRangeSlider");
    var slider3 = $range3.data("ionRangeSlider");
    var slider4 = $range4.data("ionRangeSlider");
    var slider5 = $range5.data("ionRangeSlider");
    var slider6 = $range5.data("ionRangeSlider");
    var slider7 = $range5.data("ionRangeSlider");
    var slider8 = $range8.data("ionRangeSlider");
    $('#credit .form-price').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider1.update({
            from: sval
        });
    });
    $('#credit .form-term').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider2.update({
            from: sval
        });
    });
    $('#credit-card .form-price').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider3.update({
            from: sval
        });
    });
    $('#loan .form-price').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider4.update({
            from: sval
        });
    });
    $('#loan .form-term').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider5.update({
            from: sval
        });
    });
    $('#deposit .form-price').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider4.update({
            from: sval
        });
    });
    $('#deposit .form-term').on("change", function () {
        var sval = parseInt($(this).prop("value"));
        slider5.update({
            from: sval
        });
    });
    $('.range-value').click(function () {
        $(this).closest('.range-place').addClass('choice');
        $('.form-number').focus();
    });
    $('.form-number').blur(function () {
        $(this).closest('.range-place').removeClass('choice');
    });
    if ($(location).attr('pathname') === $('.tabsmenu a').attr('href')) {
        $('.tabsmenu a').addClass('active');
    } else {
        $('.tabsmenu a').removeClass('active');
    }
    /*$('.credit .hover-block .top-block .chosen-container .chosen-drop .chosen-results .result-selected').onChange(function() {
       let selectIndex = $('.credit .hover-block .top-block .chosen-container .chosen-drop .chosen-results .result-selected').attr('data-option-array-index');
       if (selectIndex == 0) {
          $('.credit .hover-block .service-button').attr('href', 'kredity/kredit-nalichnymi');
       } else if (selectIndex == 1) {
          $('.credit .hover-block .service-button').attr('href', 'kredity/kredit-pod-zalog');
       } else if (selectIndex == 2) {
          $('.credit .hover-block .service-button').attr('href', 'kredity/kredit-na-avtomobil');
       } else if (selectIndex == 3) {
          $('.credit .hover-block .service-button').attr('href', 'kredity/refinansirovanie');
       }
    });*/
});
//ivp правки фильтра
jQuery(document).ready(function ($) {
    //выравниевание блоков по высоте
    $('.banner-wrapper').matchHeight();
    //форма калькулятора и расчет
    if ($('.form-credit-calc').length > 0) {

        //печать
        $('#exampleModalGrafic > div > div > div.modal-body > div.pb-4 > a').click(function (e) {
            e.preventDefault();
            $('#exampleModalGrafic > div > div > div.modal-body > div.pb-4 > a').toggle();
            $('#showTrTable').trigger('click');
            $('#exampleModalGrafic .modal-content').printThis();
            $('#exampleModalGrafic > div > div > div.modal-body > div.pb-4 > a').toggle();
        });



        let kredit = {
            "summ-kredit": 100000,
            "select-valute": "₽",
            "stavka-procent": "9.5",
            "srock-credit": "12"
        };
        getRezultElemForm();

        function digits_int(target) {
            //val = $(target).val().replace(/[^0-9]/g, '');
            val = $('#summ-kredit').val().replace(/[^0-9]/g, '');
            val = val.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
            //$(target).val(val);
            $('#summ-kredit').val(val);
        }

        function getRezultElemForm() {
            $('.form-credit-calc_valute').html(kredit['select-valute']);
            let stavka_procent = kredit['stavka-procent'] * 0.01;
            let annyPlateg = kredit['summ-kredit'] * ((stavka_procent * ((1 + stavka_procent) ** kredit['srock-credit'])) / (((1 + stavka_procent) ** kredit['srock-credit']) - 1));
            $('.form-credit-calc_mes-plat').html(Math.round(annyPlateg));
            $('.form-credit-calc_pereplat').html(Math.round((annyPlateg * kredit['srock-credit']) - kredit['summ-kredit']));
            $('.form-credit-calc_summ').html(Math.round(annyPlateg * kredit['srock-credit']));
            $('.form-credit-calc .progress .progress-bar').width(100 - ((Math.round((annyPlateg * kredit['srock-credit']) - kredit['summ-kredit'])) / (Math.round(annyPlateg * kredit['srock-credit']) / 100)) + '%');
            //$('input').val(String($('input').val().replace(/[^0-9.]/g, '')).replace(/\B(?=(\d{3})+(?!\d))/g, " "));
        }

        function setDataCalcFormEdit(elem) {
            $(elem).on("change keyup paste", function () {
                kredit[$(this).attr('id')] = $(this).val().replace(/\s+/g, '');
                getRezultElemForm();
                digits_int(this);
                console.log(kredit);
                renderTableGrafic();
            })
        }

        function renderTableGrafic() {
            let i = 1;
            let stavka_procent = kredit['stavka-procent'] * 0.01;
            let annyPlateg = Math.round(kredit['summ-kredit'] * ((stavka_procent * ((1 + stavka_procent) ** kredit['srock-credit'])) / (((1 + stavka_procent) ** kredit['srock-credit']) - 1)));
            let pogasheno = 0;
            let summaCredit = Math.round(annyPlateg * kredit['srock-credit']);
            let ostatok = summaCredit;
            let procent = Math.round((summaCredit - kredit['summ-kredit']) / kredit['srock-credit']);
            let summProcent = procent;

            moment.locale('ru');


            $("#exampleModalGrafic table.table-grafic tbody, #exampleModalGrafic table.table-footer tbody").empty();

            while (i <= kredit['srock-credit']) { // когда i будет равно 0, условие станет ложным, и цикл остановится
                pogasheno = pogasheno + annyPlateg;

                trClassShowHide = 'visually-hidden';
                if ((i <= 3) || (i > (kredit['srock-credit'] - 1))) {
                    trClassShowHide = 'show';
                }

                if (i == 4) {
                    $("#exampleModalGrafic table.table-grafic tbody").append(`
                    <tr class="tr-btn-click" style="background: #6e6e6e12;">
                        <td colspan="5">
                            <div class="section full-item-block block3 text-center p-2">
                                <a class="category-button block3 " id="showTrTable" href="#" target="_blank ">Показать все</a>
                            </div>
                        </td>
                    </tr>`);
                }

                moment().add('months', i);

                $("#exampleModalGrafic table.table-grafic tbody").append(`
                    <tr class="${trClassShowHide}">
                        <td><b>${i} платеж</b> <br>${moment().add('months', i).format('MMMM YYYY')};</th>
                        <td>${ostatok}</td>
                        <td>${summProcent}</td>
                        <td>${pogasheno}</td>
                        <td>${annyPlateg}</td>
                    </tr>`);

                ostatok = ostatok - annyPlateg;
                summProcent = summProcent + procent;
                i++;
            }

            $("#exampleModalGrafic table.table-footer tbody").append(`<tr>
                        <td><b>Итого </b></th>
                        <td>&nbsp;</td>
                        <td><b>${procent * kredit['srock-credit']}</b></td>
                        <td><b>${summaCredit}</b></td>
                        <td><b>${summaCredit}</b></td>
                    </tr>`);

            valSumCredit = $('#summ-kredit').val().replace(/[^0-9]/g, '');
            valSumCredit = valSumCredit.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

            $('#exampleModalGrafic .summ-credit').html(valSumCredit);
            $('#exampleModalGrafic .valute-credit').html(kredit['select-valute']);
            $('#exampleModalGrafic .sroc-credit').html(kredit['srock-credit']);
            $('#exampleModalGrafic .stavca-credit').html(kredit['stavka-procent']);

        }
        setDataCalcFormEdit('#summ-kredit, #select-valute, #srock-credit, #stavka-procent');
        renderTableGrafic();

        $(document).on('click', '#showTrTable', function (e) {
            e.preventDefault();
            $('#exampleModalGrafic table.table-grafic tbody tr.visually-hidden').removeClass();
            $('#exampleModalGrafic table.table-grafic tbody tr.tr-btn-click').remove();
        });
    }
    //смена количества в фильтре при зугрузке
    $('.search-filters > .number').text($('.filter-fields input[type="checkbox"]:checked').length);
    //смена количества в фильтре при отработки чебоксов
    $('.filter-fields input[type="checkbox"]').on('change', function () {
        $('.search-filters > .number').text($('.filter-fields input[type="checkbox"]:checked').length);
    });
    $('.form-search input, .form-search input[type="radio"], .form-search input[type="checkbox"], .form-search select').on('change', function () {
        console.log('изменен фильтр');
        loadDataFiltr().done(function (data) {
            console.log($(data).find('.item-content').length);
            let articlesCount = $(data).find('.item-content').length;
            $('.jlmf-button').text('Показать (' + articlesCount + ')');
        })
    });

    function loadDataFiltr() {
        var form = $('form.form-search');
        //console.log(form.serialize());
        return jQuery.ajax({
            type: 'POST',
            url: form.attr('action'),
            cache: 'false',
            data: form.serialize() + '&tmpl=jlcomponent_ajax',
            dataType: 'html',
        });
    }
    $('.jlmf-button').off('click.first');
    $('.jlmf-button').on('click', function (e) {
        e.preventDefault(); //отменить выполнение действия по умолчанию
        //e.stopPropagation();
        $('.blog-items').html('<img src="/modules/mod_jlcontentfieldsfilter/assets/images/ajax_loader.gif" style="width:30px;height:30px;margin:30 auto;display: block;">');
        loadDataFiltr().done(function (data) {
            //console.log($(data).find('.item-content').length);
            let articlesResult = $(data).find('.blog-item');
            //alert (articlesResult);
            $('.blog-items').html(articlesResult);
        });
    });
});
