!function(e,t,n){e.behaviors.shopPlus={attach:function(e,s){function o(e){e.parent("form").toggleClass("open-form-true");var t=e.text();e.text("EXPAND SEARCH FILTERS"==t?"CLOSE SEARCH FILTERS":"EXPAND SEARCH FILTERS")}if(t(".selected-filter").length){var i=t(".open-form-more");i.removeClass("selected-filter"),o(i)}t(".sort-block a",e).click(function(){var e=t(".form-item-sort-order option:selected"),n=t('.form-item-sort-order option:not(":selected")');return e.attr("selected",!1),n.attr("selected",!0).change(),!1}),t(".views-exposed-form .open-form-more",e).on("click",function(){o(t(this))}),t.fn.equivalent=function(e){e=e||10;var n=t(this),s=e;n.css("min-height",s),n.each(function(){s=t(this).outerHeight()>s?t(this).outerHeight():s}),n.css("min-height",s)};var a=function(e){t(e).length&&(w=n.innerWidth,t(n).resize(function(){w=n.innerWidth,w>499&&t(e).equivalent()}),w>499&&t(e).equivalent())};a(".block-original-latest_news_updates-block_1 .views-row .node > header"),a(".block-original-latest_news_updates-block_1 .views-row .node")}},t(document).ready(function(){t(".menu--main ul.menu ul").wrap('<span class="pos-block"></span>'),t("table th").each(function(){var e=t(this).index();0!=e&&(e<5?t(this).attr("data-breakpoints","xs"):e<8?t(this).attr("data-breakpoints","xs sm md"):t(this).attr("data-breakpoints","xs sm md lg"))}),t("table tr:nth-child(2n)").addClass("tr-row"),t("table tr").each(function(){t("td",this).size()<9&&t("td:first",this).addClass("no-icon")}),t("table thead").each(function(){t("th",this).last().attr("data-breakpoints","")}),t("table").footable(),t("#block-shopsplus-search input.form-search").attr("placeholder","Search"),t("#block-shopsplus-search .form-actions .form-submit").on("click",function(e){var n=t(this).parents("form:first"),s=t("input.form-search",n).val();n.hasClass("open-form")?""==s&&(e.preventDefault(),n.removeClass("open-form")):(e.preventDefault(),n.addClass("open-form"))}),t("#header .menu--main > ul.menu > .menu-item--expanded").mouseenter(function(){t("#header .menu--main li").removeClass("open-top-menu"),t(this).addClass("open-top-menu")}),t("#header .menu--main > ul.menu > .menu-item--expanded").mouseleave(function(){t("#header .menu--main li").removeClass("open-top-menu")}),t("#block-shopsplus-main-menu > ul.menu").clone().appendTo("#mobile-menu"),t("#mobile-menu .menu-item--expanded").append('<span class="prev-next"></span>'),t("#mobile-menu .pos-block").each(function(){t(this).children().first().prepend('<li class="beck">'+t(this).parent().children().first().text()+"</li>")}),t(".mobile-menu-btn").on("click",function(){t(this).parent().toggleClass("open-mobile-menu")}),t("#mobile-menu .prev-next").on("click",function(){t(this).prev().addClass("right-none"),t(this).parent().addClass("pos-stat")}),t("#mobile-menu .beck").on("click",function(){t(this).parent().parent().removeClass("right-none"),t(this).parents("li.menu-item--expanded").first().removeClass("pos-stat")}),t(".block-current-active-submenu li.menu-item--expanded").on("click",function(){t(this).toggleClass("open-sub-menu")}),t(document).click(function(e){var n=e.target;t(n).is("#block-shopsplus-search input")||t(n).is("#block-shopsplus-search .form-item")||t("#block-shopsplus-search form").removeClass("open-form"),t(n).is("#mobile-menu *")||(t("#mobile-menu").removeClass("open-mobile-menu"),t("#mobile-menu .pos-block").removeClass("right-none"),t("li.menu-item--expanded").removeClass("pos-stat"))})})}(Drupal,jQuery,this);