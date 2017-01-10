/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
/*(function (Drupal, $, window) {

 // To understand behaviors, see https://www.drupal.org/node/2269515
 Drupal.behaviors.shopsPlus = {
 attach: function (context, settings) {

 // Execute code once the DOM is ready. $(document).ready() not required within Drupal.behaviors.

 $(window).load(function () {
 // Execute code once the window is fully loaded.
 });

 $(window).resize(function () {
 // Execute code when the window is resized.
 });

 $(window).scroll(function () {
 // Execute code when the window scrolls.
 });

 }
 };

 }(Drupal, jQuery, this));
 */
(function (Drupal, $, window) {
        Drupal.behaviors.shopPlus = {
            attach: function (context, settings) {
                //news update block
                $(".block-original-latest_news_updates-block_1, " +
                    ".block-original-latest_news_updates-block_2, " +
                    ".block-original-latest_news_updates-block_3, " +
                    ".block-original-latest_news_updates-block_4, " +
                    ".block-original-latest_news_updates-block_5, " +
                    ".block-original-latest_news_updates-block_6").waitForImages({
                    finished: function() {
                        $("div[class*='block-original-latest_news_updates-block_'] .views-row .node").matchHeight();
                    },
                    waitForAll: true
                });

                $(window).resize(function () {
                    $("div[class*='block-original-latest_news_updates-block_'] .views-row .node").matchHeight();
                });

                $("div[class*='block-original-latest_news_updates-block_'] .views-row .node").matchHeight();


                // views-exposed-form more

                function exposed_form_view($el) {
                    $el.parent('form').toggleClass('open-form-true');
                    var text = $el.text();
                    $el.text(text == "EXPAND SEARCH FILTERS" ? "CLOSE SEARCH FILTERS" : "EXPAND SEARCH FILTERS");
                }

                if ($('.selected-filter').length) {
                    var form_more = $('.open-form-more');
                    form_more.removeClass('selected-filter');
                    exposed_form_view(form_more);
                }

                $('.sort-block a', context).click(
                    function () {
                        var selected = $('.form-item-sort-order option:selected');
                        var not_selected = $('.form-item-sort-order option:not(":selected")');
                        selected.attr('selected', false);
                        not_selected.attr('selected', true).change();
                        return false;
                    }
                );

                $('.views-exposed-form .open-form-more', context).on('click',
                    function () {
                        exposed_form_view($(this));
                    }
                );


                $.fn.equivalent = function (min_height) {
                    min_height = min_height || 10;
                    var $blocks = $(this),
                        maxH = min_height;
                    $blocks.css('min-height', maxH);
                    $blocks.each(function () {
                        maxH = ( $(this).outerHeight() > maxH ) ? $(this).outerHeight() : maxH;
                    });
                    $blocks.css('min-height', maxH);
                };

                var minHeightViewsRow = function ($views_origin_class) {
                    if ($($views_origin_class).length) {
                        w = window.innerWidth;
                        $(window).resize(function () {
                            w = window.innerWidth;
                            if (w > 499) {
                                $($views_origin_class).equivalent();
                            }
                        });
                        if (w > 499) {
                            $($views_origin_class).equivalent();
                        }
                    }
                };


                $('.flexslider.optionset-gallery', context).on('start', function(event) {
                    var $pager = $(this).find('.flex-sidebar-direction-nav-pager-webksde');
                    if ($pager.length <= 0) {
                        $pager = $('<div class="flex-sidebar-direction-nav-pager-webksde"><span class="pager-current"></span><span class="pager-separator">/</span><span class="pager-total"></span></div>');
                        $(this).find('ul.flex-direction-nav').prepend($pager);
                    }
                    $flexslider = $(this).data('flexslider');
                    $pager.children('.pager-current').text($flexslider.currentSlide + 1);
                    $pager.children('.pager-total').text($flexslider.count);
                });

                $('.flexslider.optionset-gallery', context).on('after', function(event) {
                    var $pager = $(this).find('.flex-sidebar-direction-nav-pager-webksde');
                    if ($pager.length >= 0) {
                        $flexslider = $(this).data('flexslider');
                        $pager.children('.pager-current').text($flexslider.currentSlide + 1);
                        $pager.children('.pager-total').text($flexslider.count);
                    }
                });

                $('.field.body figure img').attr('style', 'cursor: pointer;');
                $('.field.body figure img', context).on('click', function () {
                    var $url = $(this).attr('src');

                    $.colorbox({
                        href: $url
                    });
                });
            }
        };
        // jQuery(function ($) {
        $(document).ready(function () {
            //remove footer last link
            // var text_last_a_footer = $('#footer .menu--footer ul.menu li.menu-item:last-child a').text();
            // $('#footer .menu--footer ul.menu li.menu-item:last-child a').replaceWith("<span class='no-link'>" + text_last_a_footer + "</span>");
            //wrap menu
            $('.menu--main ul.menu ul').wrap('<span class="pos-block"></span>');

            //add class infinite-scroll front news
            $('.block-latest-news-updates-block-3 .button').click(
              function () {
                  $('.block-latest-news-updates-block-3 .views-content').addClass('more-true');
              }
            );

            //table responsive
            $('table th').each(
                function () {
                    var index_th = $(this).index();
                    if (index_th != 0) {
                        if (index_th < 5) {
                            $(this).attr('data-breakpoints', 'xs');
                        } else {
                            if (index_th < 8) {
                                $(this).attr('data-breakpoints', 'xs sm md');
                            } else {
                                $(this).attr('data-breakpoints', 'xs sm md lg');
                            }
                        }
                    }
                }
            );
            $('table tr:nth-child(2n)').addClass('tr-row');
            $('table tr').each(
                function () {
                    if ($('td', this).size() < 9) {
                        $('td:first', this).addClass('no-icon');
                    }
                }
            );
            $('table thead').each(
                function () {
                    $('th', this).last().attr('data-breakpoints', '');
                }
            );
            $('table').footable();

            //Expanding Search box
            //================================================================================

            $('#block-shopsplus-search input.form-search').attr('placeholder', 'Search');
            $('#block-searchform input.form-search').attr('placeholder', 'Search');
            $('#block-shopsplus-search .form-actions .form-submit').on('click',
                function (e) {
                    var this_form = $(this).parents('form:first');
                    var text_input = $('input.form-search', this_form).val();
                    if (this_form.hasClass('open-form')) {
                        if (text_input == '') {
                            e.preventDefault();
                            this_form.removeClass('open-form');
                        }
                    } else {
                        e.preventDefault();
                        this_form.addClass('open-form');
                    }
                });

            // hover main top menu
            $('#header .menu--main > ul.menu > .menu-item--expanded').mouseenter(function () {
                $('#header .menu--main li').removeClass('open-top-menu');
                $(this).addClass('open-top-menu');
            });
            $('#header .menu--main > ul.menu > .menu-item--expanded').mouseleave(
                function () {
                    $('#header .menu--main li').removeClass('open-top-menu');
                }
            );

            // mobile menu

            $('#block-shopsplus-main-menu > ul.menu').clone().appendTo("#mobile-menu .menu-wrapper");
            $('#block-searchform').detach().prependTo("#mobile-menu .menu-wrapper > .menu");
            $('#block-searchform').show();
            $('#mobile-menu .menu-item--expanded').append('<span class="prev-next"></span>');
            $('#mobile-menu .pos-block').each(
                function () {
                    $(this).children().first().prepend('<li class="beck">' + $(this).parent().children().first().text() + '</li>');
                }
            );

            $('.mobile-menu-btn').on('click', function () {
                $(this).parent().toggleClass('open-mobile-menu');
            });
            $('#mobile-menu .prev-next').on('click',
                function () {
                    $(this).prev().addClass('right-none');
                    $(this).parent().addClass('pos-stat');
                });
            $('#mobile-menu .beck').on('click',
                function () {
                    $(this).parent().parent().removeClass('right-none');
                    $(this).parents('li.menu-item--expanded').first().removeClass('pos-stat');
                });

            //sidebar menu
            $('.block-current-active-submenu li.menu-item--expanded').on('click',
                function () {
                    $(this).toggleClass('open-sub-menu');
                }
            );

            //sidebar menu active
            $('.block-current-active-submenu li a').each(
                function () {
                    if($(this).attr('class')=="is-active"){
                        $(this).parents('.menu-item--expanded').addClass('open-sub-menu');
                    }
                }
            );

            //Close on click outside
            $(document).click(function (e) {
                var target = e.target;
                if (!$(target).is('#block-shopsplus-search input') && !$(target).is('#block-shopsplus-search .form-item')) {
                    $('#block-shopsplus-search form').removeClass('open-form');
                }
                if (!$(target).is('#mobile-menu *')) {
                    $('#mobile-menu').removeClass('open-mobile-menu');
                    $('#mobile-menu .pos-block').removeClass('right-none');
                    $('li.menu-item--expanded').removeClass('pos-stat');
                }
            });


            /* Temp fix for duplicate staff members */
            $(".line-group").each(function(){
              var last = null;
              $(this).find('.views-row').each(function(){
                if (last == $(this).find('h2 a').attr('href')){
                  $(this).hide();
                }
                last = $(this).find('h2 a').attr('href');
              });
            });
        });
        // });
    }
    (Drupal, jQuery, this)
)
;
