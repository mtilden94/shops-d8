(function (Drupal, $) {
    Drupal.behaviors.downloadCount = {
        attach: function (context, settings) {
            $(".field.file a", context).on('click', function () {
                $.get(settings.download_count.url, function( data ) {
                    if(data.status == 1) {
                        $(".field.current-downloads .f_item").text(data.value);
                    }
                });
            });
        }
    };
}(Drupal, jQuery));