(function ($) {
    "use strict";
    var G5PlusCountdown = {
        init: function () {
            G5PlusCountdown.count_down();
        },
        count_down: function () {
            $('.gsf-countdown').each(function () {
                var date_end = $(this).data('date-end');
                var $this = $(this);
                $this.countdown(date_end, function (event) {
                    count_down_callback(event, $this);
                }).on('update.countdown', function (event) {
                    count_down_callback(event, $this);
                }).on('finish.countdown', function (event) {
                    $('.countdown-seconds .countdown-value', $this).html('00');
                    var $url_redirect = $this.attr('data-url-redirect');
                    if (typeof $url_redirect != 'undefined' && $url_redirect != '') {
                        window.location.href = $url_redirect;
                    }
                });
            });

            function count_down_callback(event, $this) {
                var seconds = parseInt(event.offset.seconds),
                    minutes = parseInt(event.offset.minutes),
                    hours = parseInt(event.offset.hours),
                    days = parseInt(event.offset.totalDays);
                if($this.is('.gsf-countdown-hide-day')) {
                    hours = parseInt(event.offset.totalHours);
                }
                if ((seconds == 0) && (minutes == 0) && (hours == 0) && (days == 0)) {
                    var $url_redirect = $this.attr('data-url-redirect');
                    if (typeof $url_redirect != 'undefined' && $url_redirect != '') {
                        window.location.href = $url_redirect;
                    }
                    return;
                }
                if (days < 10) days = '0' + days;
                if (hours < 10) hours = '0' + hours;
                if (minutes < 10) minutes = '0' + minutes;
                if (seconds < 10) seconds = '0' + seconds;

                $('.countdown-day .countdown-value', $this).text(days);
                $('.countdown-hours .countdown-value', $this).text(hours);
                $('.countdown-minutes .countdown-value', $this).text(minutes);
                $('.countdown-seconds .countdown-value', $this).text(seconds);
            }
        }
    };
    $(document).ready(function() {
        G5PlusCountdown.init()
    });
})(jQuery);