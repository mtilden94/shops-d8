!function(e,t,s){e.behaviors.shopPlus={attach:function(e,n){function a(e){e.parent("form").toggleClass("open-form-true");var t=e.text();e.text("EXPAND SEARCH FILTERS"==t?"CLOSE SEARCH FILTERS":"EXPAND SEARCH FILTERS")}if(t(".block-original-latest_news_updates-block_1, .block-original-latest_news_updates-block_2, .block-original-latest_news_updates-block_3, .block-original-latest_news_updates-block_4, .block-original-latest_news_updates-block_5, .block-original-latest_news_updates-block_6").waitForImages({finished:function(){t("div[class*='block-original-latest_news_updates-block_'] .views-row .node").matchHeight()},waitForAll:!0}),t(s).resize(function(){t("div[class*='block-original-latest_news_updates-block_'] .views-row .node").matchHeight()}),t("div[class*='block-original-latest_news_updates-block_'] .views-row .node").matchHeight(),t(".selected-filter").length){var i=t(".open-form-more");i.removeClass("selected-filter"),a(i)}t(".sort-block a",e).click(function(){var e=t(".form-item-sort-order option:selected"),s=t('.form-item-sort-order option:not(":selected")');return e.attr("selected",!1),s.attr("selected",!0).change(),!1}),t(".views-exposed-form .open-form-more",e).on("click",function(){a(t(this))}),t.fn.equivalent=function(e){e=e||10;var s=t(this),n=e;s.css("min-height",n),s.each(function(){n=t(this).outerHeight()>n?t(this).outerHeight():n}),s.css("min-height",n)};t(".flexslider.optionset-gallery",e).on("start",function(e){var s=t(this).find(".flex-sidebar-direction-nav-pager-webksde");s.length<=0&&(s=t('<div class="flex-sidebar-direction-nav-pager-webksde"><span class="pager-current"></span><span class="pager-separator">/</span><span class="pager-total"></span></div>'),t(this).find("ul.flex-direction-nav").prepend(s)),$flexslider=t(this).data("flexslider"),s.children(".pager-current").text($flexslider.currentSlide+1),s.children(".pager-total").text($flexslider.count)}),t(".flexslider.optionset-gallery",e).on("after",function(e){var s=t(this).find(".flex-sidebar-direction-nav-pager-webksde");s.length>=0&&($flexslider=t(this).data("flexslider"),s.children(".pager-current").text($flexslider.currentSlide+1),s.children(".pager-total").text($flexslider.count))}),t(".field.body figure img").attr("style","cursor: pointer;"),t(".field.body figure img",e).on("click",function(){var e=t(this).attr("src");t.colorbox({width:"70%",href:e})})}},t(document).ready(function(){t(".menu--main ul.menu ul").wrap('<span class="pos-block"></span>'),t(".block-latest-news-updates-block-3 .button").click(function(){t(".block-latest-news-updates-block-3 .views-content").addClass("more-true")}),t("table th").each(function(){var e=t(this).index();0!=e&&(e<5?t(this).attr("data-breakpoints","xs"):e<8?t(this).attr("data-breakpoints","xs sm md"):t(this).attr("data-breakpoints","xs sm md lg"))}),t("table tr:nth-child(2n)").addClass("tr-row"),t("table tr").each(function(){t("td",this).size()<9&&t("td:first",this).addClass("no-icon")}),t("table thead").each(function(){t("th",this).last().attr("data-breakpoints","")}),t("table").footable(),t("#block-shopsplus-search input.form-search").attr("placeholder","Search"),t("#block-searchform input.form-search").attr("placeholder","Search"),t("#block-shopsplus-search .form-actions .form-submit").on("click",function(e){var s=t(this).parents("form:first"),n=t("input.form-search",s).val();s.hasClass("open-form")?""==n&&(e.preventDefault(),s.removeClass("open-form")):(e.preventDefault(),s.addClass("open-form"))}),t("#header .menu--main > ul.menu > .menu-item--expanded").mouseenter(function(){t("#header .menu--main li").removeClass("open-top-menu"),t(this).addClass("open-top-menu")}),t("#header .menu--main > ul.menu > .menu-item--expanded").mouseleave(function(){t("#header .menu--main li").removeClass("open-top-menu")}),t("#block-shopsplus-main-menu > ul.menu").clone().appendTo("#mobile-menu .menu-wrapper"),t("#block-searchform").detach().prependTo("#mobile-menu .menu-wrapper > .menu"),t("#block-searchform").show(),t("#mobile-menu .menu-item--expanded").append('<span class="prev-next"></span>'),t("#mobile-menu .pos-block").each(function(){t(this).children().first().prepend('<li class="beck">'+t(this).parent().children().first().text()+"</li>")}),t(".mobile-menu-btn").on("click",function(){t(this).parent().toggleClass("open-mobile-menu")}),t("#mobile-menu .prev-next").on("click",function(){t(this).prev().addClass("right-none"),t(this).parent().addClass("pos-stat")}),t("#mobile-menu .beck").on("click",function(){t(this).parent().parent().removeClass("right-none"),t(this).parents("li.menu-item--expanded").first().removeClass("pos-stat")}),t(".block-current-active-submenu li.menu-item--expanded").on("click",function(){t(this).toggleClass("open-sub-menu")}),t(".block-current-active-submenu li a").each(function(){"is-active"==t(this).attr("class")&&t(this).parents(".menu-item--expanded").addClass("open-sub-menu")}),t(document).click(function(e){var s=e.target;t(s).is("#block-shopsplus-search input")||t(s).is("#block-shopsplus-search .form-item")||t("#block-shopsplus-search form").removeClass("open-form"),t(s).is("#mobile-menu *")||(t("#mobile-menu").removeClass("open-mobile-menu"),t("#mobile-menu .pos-block").removeClass("right-none"),t("li.menu-item--expanded").removeClass("pos-stat"))}),t(".line-group").each(function(){var e=null;t(this).find(".views-row").each(function(){e==t(this).find("h2 a").attr("href")&&t(this).hide(),e=t(this).find("h2 a").attr("href")})})})}(Drupal,jQuery,this);