var slider_catalog__color_main_image_settings = { // это изначально slick слайдер для основного блока изображений
        slidesToShow: 1,  // по одному слайдеру 
        slidesToScroll: 1, // по одному менять
        arrows:false, // включение стрелок (если не нужны false)
        infinite: true,
        asNavFor: '.catalog__color' // указываем что навигация для слайдера будет отдельно (указываем класс куда вешаем навигацию)
    };
//slick показывает некорректно, если слайдов меньше, чем указано в настройке.
//Поэтому здесь указываем максимальное количество
var max_catalog__color_slidesToShow = 4;

var slider_catalog__color_settings = { // настройка навигации
        slidesToShow: 4, // указываем что нужно показывать 4 навигационных изображения
        asNavFor: '.catalog__color_main_image', // указываем что это навигация для блока выше
        infinite: true,
        focusOnSelect: true // указываем что бы слайделось по клику
    };
var location_status = '';


$(function() {
    //Добавляем активный класс в каталоге
    //Верхний уровень (слева)
    $('.catalog__tab-level3 li').on('click', function () {
        $(this).addClass('active');
        $('.catalog__tab-level3 li').not(this).removeClass('active');
        refresh_child_categories('main');
        sync_active_main_categories( 'desktop', $(this).data('categid') );
    });

    //Верхний уровень (моб)
    $('ul.catalog__tab-min li').on('click', function () {
        $(this).addClass('active');
        $('ul.catalog__tab-min li').not(this).removeClass('active');
        sync_active_main_categories( 'mobile', $(this).data('categid') );
        refresh_child_categories('main');
    });

    function sync_active_main_categories( source, activeCategoryID ){
        if ( source == 'mobile' ){
            $('.catalog__tab-level3 li').removeClass('active');
            $('.catalog__tab-level3 li[data-categid="' + activeCategoryID + '"]').addClass('active');
        }
        if ( source == 'desktop' ){
            $('ul.catalog__tab-min li').removeClass('active');
            $('ul.catalog__tab-min li[data-categid="' + activeCategoryID + '"]').addClass('active');
        }
    }

    set_events();
    set_events_variation_buttons();

    $('.catalog__color_main_image').slick(slider_catalog__color_main_image_settings);
    
    slider_catalog__color_settings.slidesToShow = Math.min( max_catalog__color_slidesToShow, $('.catalog__color').children().length );
    $('.catalog__color').slick(slider_catalog__color_settings);

    if (window.location.hash.length > 0){
        location_status = 'noChangeLocation';
        follow_to_location( window.location.hash.replace('#', '') );
        location_status='';
    }else{
        set_first_product( );  
    }

    function follow_to_location(hash){
        var $product = $('div.product-list-item[data-sku="' + hash +  '"]');
        if( $product.length > 0 ){
            var categories = $product.find('span.category').data();
            
            $('.catalog__tab-level3 li[data-categid="' + categories.cat1 + '"]').addClass('active');
            $('.catalog__tab-level3 li:not(li[data-categid="' + categories.cat1 + '"])').removeClass('active');

            sync_active_main_categories( 'desktop', categories.cat1 );

            refresh_child_categories( 'main' );
            
            $('.catalog__tab-level1 li[data-subcategid="' + categories.cat2 + '"]').addClass('active');
            $('.catalog__tab-level1 li:not(li[data-subcategid="' + categories.cat2 + '"])').removeClass('active');
            refresh_child_categories( 'subcategories' );
            
            $('.catalog__tab-level2 li[data-subsubcategid="' + categories.cat3 + '"]').addClass('active');
            $('.catalog__tab-level2 li:not(li[data-subsubcategid="' + categories.cat3 + '"])').removeClass('active');
            set_first_product( 'noChangeLocation', categories.cat1, categories.cat2, categories.cat3 ); 
           
            $('.variation_btn[data-slug="' + hash +'"]').click();
        }else{
             set_first_product(  ); 
        }
    }

    //Нажатие на кнопки вариаций
    function set_events_variation_buttons( status ){
        $('.variation_btn').click((e)=>{
            e.preventDefault();
            var button = $(e.currentTarget);
            button.addClass('active');
            $('.calc__info-color a').not(button).removeClass('active');
            if( location_status != 'noChangeLocation' ){
                window.location.hash = button.data('slug');
            }
            //Основное изображение
           // $('.catalog__calc .calc__wiew-wrap img').attr('src', button.data('img'));
           $('.catalog__color_main_image').slick('slickGoTo', button.data('img-locate'));
            //Цена
            var sale_price = button.data('sale');
            var price = button.data('regular');
            $('.calc__wiew-price').empty();
            $('.calc__wiew-price').append(
                ( sale_price && sale_price > 0 ? '<p class="sale_price">' + sale_price + '<span>&nbsp;&#8381;</span></p>' : '' ) + 
                '<p class="regular_price">' + price + '<span>&nbsp;&#8381;</span></p>'
            );
            var $product = $('div.product-list-item[data-sku="' + button.data('slug') +  '"]');
                if( $product.length > 0 ){
                    var categories = $product.find('span.category').html();
                    var prodText = button.text();
                    //$('#need_to_order_btn').data('category', categories).data('product', prodText);
                    //$('.selected-collection').html(categories);
                    var productName = $('.calc__wiew-title').html();
                    $('.selected-product').html( productName + ' ' + prodText);
                    $('input[name="variation"]').val(prodText);
                    $('input[name="product"]').val(productName);
                    var $descr = $('div.product-list-item[data-sku="' + button.data("slug") + '"] div.description').html();
                    if( $descr ){
                        $('.catalog__calc .calc__info-wrap .calc__info-prop').html( $descr.trim() );
                    }else{
                        $('.catalog__calc .calc__info-wrap .calc__info-prop').html( "" );
                    }
                    
                }else{
                    //$('#need_to_order_btn').data('category', '').data('product', '');
                    $('.selected-product').html( '' );
                    $('input[name="variation"]').val( '' );
                    $('input[name="product"]').val( '' );
                }
            return false;
        });
    }
    
    //Установка событий при переформировании категорий
    function set_events( level ){
        if( !level || level == 1 ){
            //подкатегория
            $('.catalog__tab-level1 li').click( function () {
                $(this).addClass('active');
                $('.catalog__tab-level1 li').not(this).removeClass('active');
                 refresh_child_categories('subcategories');
            });
        }
        if ( !level || level == 2){
            //подподкатегория
            $('.catalog__tab-level2 li').click(function () {
                $(this).addClass('active');
                $('.catalog__tab-level2 li').not(this).removeClass('active');
                set_first_product();
            });
        }
    }

    //Переформирование категорий
    function refresh_child_categories( level ){
        var counter = 0,
            subcounter = 0,
            active = '',
            subactive = "";
        // Изменение верхних категорий
        if ( level === 'main'){
            $(avaliableCategories[$('.catalog__tab-level3 li.active').data('categid')]['child']).each((i,e)=>{
                $('.catalog__tab-level1').empty();
                for (key in e){
                    active = '';
                    if (counter === 0){
                        active = 'class="active"';
                    }
                    counter++;
                    $('.catalog__tab-level1').append('<li ' + active + ' data-subcategid="' + e[key].id + '">' + e[key].name + '</li>');

                }
            })
            set_events(1);

        }
        if ( level == 'subcategories' || level == 'main'){
            //подкатегории
            $('.catalog__tab-level2').empty();
            subcounter = 0;
            var e = avaliableCategories[$('.catalog__tab-level3 li.active').data('categid')]['child'][$('.catalog__tab-level1 li.active').data('subcategid')];
            for(subcategoryKey in e.child){
                subactive = "";
                if (subcounter === 0){
                    subactive = 'class="active"';
                }
                $('.catalog__tab-level2').append(
                        '<li ' + subactive + 'data-subsubcategid="' + 
                            e.child[subcategoryKey].id + '">' + 
                            e.child[subcategoryKey].name + 
                        '</li>'
                        );
                subcounter++;
            }
            set_events(2);
            set_first_product();
        }
    }

    function set_first_product( status, category_main, subcategory, subsubcategory ){
        var mainCateg, subCateg, subSubCateg;

        //$('#need_to_order_btn').data('category', '').data('product', '');
        $('.selected-product').html( '' );
        $('input[name="variation"]').val( '' );
        $('input[name="product"]').val( '' );

        if (!category_main){
            mainCateg   = $('.catalog__tab-level3 li.active').data('categid');
        }else{
            mainCateg   = category_main;
        }

        if (!subcategory){
            subCateg    = $('.catalog__tab-level1 li.active').data('subcategid');
        }else{
            subCateg    = subcategory;
        }

        if(!subsubcategory){
            subSubCateg = $('.catalog__tab-level2 li.active').data('subsubcategid');    
        }else{
            subSubCateg = subsubcategory;
        }

        var attrib_holder_active_button='';
        var content = '', name = '', image = '';
        var attrib_holder = $('.calc__info-color');
        attrib_holder.empty();
        var catalog_color = $('.catalog__color');

        var catalog_color_main_image = $('.catalog__color_main_image');
		catalog_color_main_image.slick('unslick');
		catalog_color_main_image.empty();
        catalog_color.slick('unslick');
        catalog_color.empty();
        var counter = 0;
        var gallery_count = 0;
        $('.calc__wiew-price').empty();
        $('span.category[data-cat1="' + mainCateg + '"][data-cat2="' + subCateg + '"][data-cat3="' + subSubCateg + '"]').each((i,e)=>{
            var parent = $( e ).closest('.product-list-item'), color = '',type = '' ;
            //if (!content){
            content =  parent.find('div.description').html();
            //}
            //if(!image){
            image = parent.find('link[itemprop="image"]').attr('href');
            //}
            type = parent.data('type');//тип продукта - продукт или вариация
            color = parent.find('meta[itemprop="color"]').attr('content');
            //if (!name){
            name = parent.find('meta[itemprop="name"]').attr('content');
            //}
            if(counter === 0){
                attrib_holder_active_button = 'active';
                var gallery = parent.find('div.product_galleries');
                gallery_count = gallery.find('img.product-image').length;
                if( gallery_count >= 0 ){
                     catalog_color_main_image.append(gallery.html());
                     catalog_color.append(gallery.html());
                }
            }else{
               attrib_holder_active_button = ''; 
            }
            var slug        = parent.data('sku');
            var price       = parent.find('span.full_price').html();
            var sale_price  = parent.find('span.sale_price').html();
            var $title = $('.calc__info-wrap .calc__info .calc__info-title');
            //если нет вариации - не добавляем переключатель вариаций
            if ( type == 'product-variation' ){
                var $attr_holder = attrib_holder.append('<a href="#" class="btn heared_btn variation_btn ' + attrib_holder_active_button + ' calc__wiew_btn" data-img-locate="' + (gallery_count > 0 ? counter + gallery_count : counter) + '" data-img="' + image + '" data-slug=' + slug + 
                        ' data-sale="' + ( sale_price ? sale_price : 0 ) + '" data-regular="' + ( price ? price : 0 ) + '" >' + color + '</a>');
                $attr_holder.data("description", ( content ? content : "" ) );
                $title.html( $title.data('default') );
            }else{
                var categories = $( e ).html();
               // $('#need_to_order_btn').data('category', categories).data('product', name);

                $('.selected-collection').html(categories);
                $('.selected-product').html(name);
                $('input[name="collection"]').val(categories);
                $('input[name="product"]').val(name);

                $('.selected-product').html( name );
                $('input[name="variation"]').val('');
                $('input[name="product"]').val(name);

                if( location_status != 'noChangeLocation' ){
                    window.location.hash = slug;
                }
                $('.calc__wiew-price').empty();
                $('.calc__wiew-price').append(
                    ( sale_price && sale_price > 0 ? '<p class="sale_price">' + sale_price + '<span>&nbsp;&#8381;</span></p>' : '' ) + 
                '<p class="regular_price">' + price + '<span>&nbsp;&#8381;</span></p>'
                );
                $title.html( 'Характеристики' );
            }

            if ( image ){
                catalog_color.append('<li class="catalog__items"><p style="background: url(' + image + ')"></p></li>');
                catalog_color_main_image.append('<div class="product-image-wr"><img class="product-image" src="' + image + '" alt="Product image"></div>');
            }

            counter++;
        })
        $('.catalog__offer .calc__wiew-title').text(name);
        $('.catalog__calc .calc__info-wrap .calc__info-prop').html(content);
        
        set_events_variation_buttons( status );

        //установим первый товар
        if( !status || status != 'noChangeLocation' ){
            $('.calc__info-color a').first().click();
        }
        //Запуск слика
        slider_catalog__color_settings.slidesToShow = Math.min( max_catalog__color_slidesToShow, $('.catalog__color').children().length );
        catalog_color.slick(slider_catalog__color_settings);
        catalog_color_main_image.slick(slider_catalog__color_main_image_settings);
    }

    //Анимация треугольника и переключение data-rectangle
    var width = $(window).width();
    var rectangle = $('.rectangle');
    var one = $("[data-rectangle='163']");
    var two = $("[data-rectangle='353']");
    var three = $("[data-rectangle='543']");
    var fore = $("[data-rectangle='733']");
    var five = $("[data-rectangle='923']");

    if (width < 1200 && width >= 992) {
        rectangle.css('left', '133px');
        one.attr('data-rectangle', 133);
        two.attr('data-rectangle', 293);
        three.attr('data-rectangle', 453);
        fore.attr('data-rectangle', 613);
        five.attr('data-rectangle', 773);
    } else if (width < 992 && width >= 768) {
        rectangle.css('left', '93px');
        one.attr('data-rectangle', 93);
        two.attr('data-rectangle', 213);
        three.attr('data-rectangle', 333);
        fore.attr('data-rectangle', 453);
        five.attr('data-rectangle', 573);
    } else if (width < 768 && width >= 575) {
        rectangle.css('left', '63px');
        one.attr('data-rectangle', 63);
        two.attr('data-rectangle', 153);
        three.attr('data-rectangle', 243);
        fore.attr('data-rectangle', 333);
        five.attr('data-rectangle', 423);
    }
    $('.brand__wrap').on('click', function () {
        var data = $(this).find('.brand__item-text').attr('data-text');
        $('.brand__info').text(data);
        var data_rectangle = $(this).attr('data-rectangle');
        $('.rectangle').animate({
            left: data_rectangle
        },1000);
    });

    /* Модальное окно */
    var overlay = $('#overlay');
    var open_modal = $('.open_modal, .open_modal2, .open_modal3, .open_modal4');
    var close = $('.close1, .close2, .close4, #overlay');
    var modal = $('.modal1, .modal2, .modal3, .modal4');

    open_modal.on('click', function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(div)
                    .css('display', 'block')
                    .animate({opacity: 1, top: '50%'}, 200);
            });
    });

    close.on('click', function(){
        modal
            .animate({opacity: 0, top: '45%'}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
    });



    //слайдер отзыв 
    $('.reviews__slider-block').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed:10000,
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    arrows: false,
                }
            }
        ]
    });

    //Анимация цифр
    var block_show = false;
    function scrollTracking(){
        if (block_show) {
            return false;
        }
        var wt = $(window).scrollTop();
        var wh = $(window).height();
        var statistics__wrap = $('.statistics__wrap');
        if ($("div").is(statistics__wrap)) {
            var et = statistics__wrap.offset().top;
            var eh = statistics__wrap.outerHeight();
            var dh = $(document).height();
            if (wt + wh >= et || wh + wt == dh || eh + et < wh){
                block_show = true;

                $('.count').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
            }
        }
    }
    $(window).scroll(function(){
        scrollTracking();
    });

    //Прокрутка меню
    $("a.go").click(function () {
        elementClick = $(this).attr("href");
        elementClick = elementClick.slice(elementClick.indexOf("#"));
        destination = $(elementClick).offset().top;
        $("body,html").animate({scrollTop: destination }, 1500);
    });

    //Появление меню
   var $win = $(window),
    $fixed = $(".nav"),
    limit = 500;

    function tgl (state) {
        $fixed.toggleClass("hidden", state);
    }

    $win.on("scroll", function () {
        var top = $win.scrollTop();
        
        if (top < limit) {
            tgl(true);
        } else {
            tgl(false);
        }
    });

    //Выбор слайдера в галерее
    $('.gallery__slider').hide();
    $('.gallery__all').show();
    $('.gallery__catalog a').on('click', function(e) {
        e.preventDefault;
        $('.slick-track').css('opacity','1');
        $(this).addClass('active');
        $('.gallery__catalog a').not(this).removeClass('active');
        var slider = $(this).attr('data-slider_class');
        $('.gallery__slider').hide();
        $('.'+slider).show();
    });
    // Маска поля ввода формы
     $('.wpcf7-tel, .tel').mask('+7(999) 999-99-99');

     //Валидация промокода
    $('[data-submit]').on('click', function(e) {
        e.preventDefault();
        $(this).parents('form').submit();
    })
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

    // Функция валидации промокода и вывода сообщений
    function valEl(el) {

        el.validate({
            rules: {
                tel: {
                    required: true,
                    regex: '^([\+]+)*[0-9\x20\x28\x29\-]{5,20}$'
                }
            },
            messages: {
                tel: {
                    required: 'Поле обязательно для заполнения',
                    regex: 'Телефон может содержать символы + - ()'
                },
                name: {
                    required: 'Поле обязательно для заполнения',
                },
                email: {
                    required: 'Поле обязательно для заполнения',
                    email: 'Неверный формат E-mail'
                }
            },

            // Начинаем проверку id="" формы
            submitHandler: function(form) {
                var $form = $(form);
                var $formId = $(form).attr('id');
                switch ($formId) {
                    // Если у формы id="popupResult" - делаем:
                    case 'sms':
                        $.ajax({
                                type: 'POST',
                                url: $form.attr('action'),
                                data: $form.serialize(),
                            }).always(function(response) {
						        setTimeout(function(){
						        	$('#overlay').fadeIn(400,
						            function(){
						                $('#modal3')
					                    .css('display', 'block')
					                    .animate({opacity: 1, top: '50%'}, 200);
					            	});
						        },1000);
                                $(form).trigger('reset');
                                $('.valid').removeClass('valid');
                                var url = "https://grandline-diler.ru/sms";
                                $(location).attr('href',url);
                            });
                        break;
                }
                return false;
            }
        })
    }

    // Запускаем механизм валидации форм, если у них есть класс .js-form
    $('.js-form').each(function() {
        valEl($(this));
    });

    //Закрываем окно сообщения об успешной отправке
    $('.swal-button-container').click(function () {
            $('.swal-overlay').addClass("close__modal");
        });

    // Мобильное меню каталога

    $('.catalog__menu-main').on('click', function () {
            $('.catalog__tab-min').slideToggle("slow");
        });
    $('.catalog__menu-level1').on('click', function () {
            $('.catalog__tab-level1').slideToggle("slow");
        });
    $('.catalog__menu-level2').on('click', function () {
            $('.catalog__tab-level2').slideToggle("slow");
        });

    // Мобильное меню 
     $('.menu__bar, .go').on('click', function () {
            $('.nav_list').slideToggle("slow");
        });

    //Обертка блоками для contactform7
    $('.contacts .wpcf7-form p br, .checklist .wpcf7-form p br').detach();
    $('.contacts .text-name, .contacts .tel-868').wrapAll('<div class="wrap1-js"></div>');
    $('.contacts .text-1, .contacts .wpcf7-submit').wrapAll('<div class="wrap2-js"></div>');
    $('.contacts .wpcf7-form p br').detach();
    //медиазапросы
    if (width < 768) {
        $('.header .heared_btn, .nav .nav_btn').text('');
        $('.header .heared_btn, .nav .nav_btn').append('<i class="fas fa-phone"></i>');
        $('.nav i').css({'display':'block'});
    }

});

