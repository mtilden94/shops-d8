!function(e,n,t){jQuery(function(e){e(document).ready(function(){var n=e("#footer .menu--footer ul.menu li.menu-item:last-child a").text();e("#footer .menu--footer ul.menu li.menu-item:last-child a").replaceWith("<span class='no-link'>"+n+"</span>"),e(".menu--main ul.menu ul").wrap('<span class="pos-block"></span>'),e("table th").each(function(){var n=e(this).index();0!=n&&(n<5?e(this).attr("data-breakpoints","xs"):n<8?e(this).attr("data-breakpoints","xs sm md"):e(this).attr("data-breakpoints","xs sm md lg"))}),e("table tr:nth-child(2n)").addClass("tr-row"),e("table th").last().attr("data-breakpoints",""),e("table tr").each(function(){e("td",this).size()<9&&e("td:first",this).addClass("no-icon")}),e("table tr td").size()<9,e("table").footable(),e("#block-shopsplus-search input.form-search").attr("placeholder","Search"),e("#block-shopsplus-search .form-actions .form-submit").on("click",function(n){var t=e(this).parents("form:first"),s=e("input.form-search",t).val();t.hasClass("open-form")?""==s&&(n.preventDefault(),t.removeClass("open-form")):(n.preventDefault(),t.addClass("open-form"))}),e("#header .menu--main > ul.menu > .menu-item--expanded").mouseenter(function(){e("#header .menu--main li").removeClass("open-top-menu"),e(this).addClass("open-top-menu")}),e("#header .menu--main > ul.menu > .menu-item--expanded").mouseleave(function(){e("#header .menu--main li").removeClass("open-top-menu")}),e("#block-shopsplus-main-menu > ul.menu").clone().appendTo("#mobile-menu"),e("#mobile-menu .menu-item--expanded").append('<span class="prev-next"></span>'),e("#mobile-menu .pos-block").each(function(){e(this).children().first().prepend('<li class="beck">'+e(this).parent().children().first().text()+"</li>")}),e(".mobile-menu-btn").on("click",function(){e(this).parent().toggleClass("open-mobile-menu")}),e("#mobile-menu .prev-next").on("click",function(){e(this).prev().addClass("right-none"),e(this).parent().addClass("pos-stat")}),e("#mobile-menu .beck").on("click",function(){e(this).parent().parent().removeClass("right-none"),e(this).parents("li.menu-item--expanded").first().removeClass("pos-stat")}),e(".block-current-active-submenu li.menu-item--expanded").on("click",function(){e(this).toggleClass("open-sub-menu")}),e("strong").each(function(){e(this).prev().length<1&&e(this).next().length<1&&e(this).parent().addClass("only-strong")}),e(document).click(function(n){var t=n.target;e(t).is("#block-shopsplus-search input")||e(t).is("#block-shopsplus-search .form-item")||e("#block-shopsplus-search form").removeClass("open-form"),e(t).is("#mobile-menu *")||(e("#mobile-menu").removeClass("open-mobile-menu"),e("#mobile-menu .pos-block").removeClass("right-none"),e("li.menu-item--expanded").removeClass("pos-stat"))})})})}(Drupal,jQuery,this);