!function(e,n,t){jQuery(function(e){e(document).ready(function(){e.fn.equivalent=function(n){n=n||10;var t=e(this),s=n;t.css("min-height",s),t.each(function(){s=e(this).outerHeight()>s?e(this).outerHeight():s}),t.css("min-height",s)},e(".block-views-block-news-and-updates").length&&(w=t.innerWidth,e(t).resize(function(){w=t.innerWidth,w>767&&e(".block-views-block-news-and-updates .views-row .node").equivalent()}),w>767&&e(".block-views-block-news-and-updates .views-row .node").equivalent()),e(".menu--main ul.menu ul").wrap('<span class="pos-block"></span>'),e(".views-exposed-form .open-form-more").on("click",function(){e(this).parent("form").toggleClass("open-form-true");var n=e(this).text();e(this).text("EXPAND SEARCH FILTERS"==n?"CLOSE SEARCH FILTERS":"EXPAND SEARCH FILTERS")}),e("table th").each(function(){var n=e(this).index();0!=n&&(n<5?e(this).attr("data-breakpoints","xs"):n<8?e(this).attr("data-breakpoints","xs sm md"):e(this).attr("data-breakpoints","xs sm md lg"))}),e("table tr:nth-child(2n)").addClass("tr-row"),e("table tr").each(function(){e("td",this).size()<9&&e("td:first",this).addClass("no-icon")}),e("table thead").each(function(){e("th",this).last().attr("data-breakpoints","")}),e("table").footable(),e("#block-shopsplus-search input.form-search").attr("placeholder","Search"),e("#block-shopsplus-search .form-actions .form-submit").on("click",function(n){var t=e(this).parents("form:first"),s=e("input.form-search",t).val();t.hasClass("open-form")?""==s&&(n.preventDefault(),t.removeClass("open-form")):(n.preventDefault(),t.addClass("open-form"))}),e("#header .menu--main > ul.menu > .menu-item--expanded").mouseenter(function(){e("#header .menu--main li").removeClass("open-top-menu"),e(this).addClass("open-top-menu")}),e("#header .menu--main > ul.menu > .menu-item--expanded").mouseleave(function(){e("#header .menu--main li").removeClass("open-top-menu")}),e("#block-shopsplus-main-menu > ul.menu").clone().appendTo("#mobile-menu"),e("#mobile-menu .menu-item--expanded").append('<span class="prev-next"></span>'),e("#mobile-menu .pos-block").each(function(){e(this).children().first().prepend('<li class="beck">'+e(this).parent().children().first().text()+"</li>")}),e(".mobile-menu-btn").on("click",function(){e(this).parent().toggleClass("open-mobile-menu")}),e("#mobile-menu .prev-next").on("click",function(){e(this).prev().addClass("right-none"),e(this).parent().addClass("pos-stat")}),e("#mobile-menu .beck").on("click",function(){e(this).parent().parent().removeClass("right-none"),e(this).parents("li.menu-item--expanded").first().removeClass("pos-stat")}),e(".block-current-active-submenu li.menu-item--expanded").on("click",function(){e(this).toggleClass("open-sub-menu")}),e(document).click(function(n){var t=n.target;e(t).is("#block-shopsplus-search input")||e(t).is("#block-shopsplus-search .form-item")||e("#block-shopsplus-search form").removeClass("open-form"),e(t).is("#mobile-menu *")||(e("#mobile-menu").removeClass("open-mobile-menu"),e("#mobile-menu .pos-block").removeClass("right-none"),e("li.menu-item--expanded").removeClass("pos-stat"))})})})}(Drupal,jQuery,this);