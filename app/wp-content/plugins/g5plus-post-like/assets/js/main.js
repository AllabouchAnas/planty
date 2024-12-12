(function ($) {
    "use strict";
    var G5Plus_Post_Like = window.G5Plus_Post_Like || {};
    window.G5Plus_Post_Like = G5Plus_Post_Like;
    G5Plus_Post_Like = {
        ajax: false,
        init : function () {
            var _that = this;
            $(document).on('click', '[data-post-like]', function (event) {
                event.preventDefault();
                if (_that.ajax) return;
                var $this = $(this),
                    options = $this.data('options'),
                    laddaButton = $(this).ladda();
                laddaButton.ladda('start');


                _that.ajax = $.ajax({
                    type: 'POST',
                    url: gpl_variable.ajax_url,
                    data: options,
                    dataType: 'json',
                    success: function (response) {
                        _that.ajax = false;
                        laddaButton.ladda('stop');
                        if (response.success) {
                            $this.find('.post-like-count').text(response.data);
                            if (options.status == true) {
                                $this.find('i').attr('class', 'fa fa-heart-o');
                            } else {
                                $this.find('i').attr('class', 'fa fa-heart');
                            }
                            options.status = !options.status;
                            $this.data('options', options);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        _that.ajax = false;
                        laddaButton.ladda('stop');
                    }
                });

            });
        }
    };

    $(document).ready(function () {
        G5Plus_Post_Like.init();
    });

})(jQuery);