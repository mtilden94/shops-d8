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
    jQuery(function ($) {
        $(document).ready(function () {
            //remove footer last link
            var text_last_a_footer = $('#footer .menu--footer ul.menu li.menu-item:last-child a').text();
            $('#footer .menu--footer ul.menu li.menu-item:last-child a').replaceWith("<span class='no-link'>" + text_last_a_footer + "</span>");

            //
            $('.menu--main ul.menu ul').wrap('<span class="pos-block"></span>');

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
                  $('th',this).last().attr('data-breakpoints', '');
              }
            );
            $('table').footable();

            //Expanding Search box
            //================================================================================

            $('#block-shopsplus-search input.form-search').attr('placeholder', 'Search');
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
            $('#block-shopsplus-main-menu > ul.menu').clone().appendTo("#mobile-menu");
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
        });
    });
}(Drupal, jQuery, this));