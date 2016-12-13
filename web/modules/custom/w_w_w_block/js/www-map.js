(function ($) {
	Drupal.behaviors.WhereWeWork = {
		attach: function (context, settings) {
			console.log(settings.where_we_work.countries);
			if (!$('body').hasClass('www-map-processed')) {
				$('body').addClass('www-map-processed');

				var map_wrap = document.getElementById('www-map-container');

				var map = new google.maps.Map(map_wrap, {
					center: new google.maps.LatLng(0, 0),
					zoom: 2,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});

				var bounds = new google.maps.LatLngBounds();

				var infowindow = new google.maps.InfoWindow();

				var marker, i;

				$.each(settings.where_we_work.countries, function (index, country) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(country.geo[0].lat, country.geo[0].lon),
						map: map
					});
					bounds.extend(marker.position);

					google.maps.event.addListener(marker, 'click', (function(marker, country) {
						return function() {
							infowindow.setContent(country.link);
							infowindow.open(map, marker);
						}
					})(marker, country));
				});

				//for centering by points
				//map.fitBounds(bounds);
			}

		}
	};
})(jQuery);