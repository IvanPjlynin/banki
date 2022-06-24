! function (a) {
    a.fn.equalHeights = function () {
        var b = 0,
            c = a(this);
        return c.each(function () {
            var c = a(this).innerHeight();
            c > b && (b = c)
        }), c.css("height", b)
    }, a("[data-equal]").each(function () {
        var b = a(this),
            c = b.data("equal");
        b.find(c).equalHeights()
    })
}(jQuery);

var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
triggerTabList.forEach(function (triggerEl) {
    var tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', function (event) {
        event.preventDefault()
        tabTrigger.show()
    })
})
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

        }
    );

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

    $('.banner-wrapper').equalHeights();

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
