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
jQuery(function ($) {
    $(document).ready(function () {

        $('#block-shopsplus-search input.form-search').attr('placeholder', 'Search');

        //Expanding Search box
        //================================================================================

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

        //Close on click outside
        $(document).click(function (e) {
            var target = e.target;
            if (!$(target).is('#block-shopsplus-search input') && !$(target).is('#block-shopsplus-search .form-item')) {
                $('#block-shopsplus-search form').removeClass('open-form');
            }
            /* if (main_menu_opened && !$(target).is('.main-menu-content') && !$(target).is('.main-menu-btn')) {
             main_menu_toggle();
             }*/
        });
    });
});