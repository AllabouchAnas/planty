(function ($) {
    var on_handle = false;
    $(document).ready(function () {
        $(document).on('click', 'a.portfolio-featured', function (event) {
            event.preventDefault();
            if(on_handle) return;
            on_handle = true;
            var $this = $(this),
                portfolio_id = $this.attr('data-portolio-id'),
                status = $this.attr('data-status'),
                icon = $this.children('span'),
                nonce = $this.attr('data-portfolio-featured-nonce'),
                data = {
                    action: 'gsf_portfolio_featured',
                    portfolio_id: portfolio_id,
                    status: status,
                    nonce: nonce
                };
            $.ajax({
                type: 'POST',
                data: data,
                url: portfolio_featured_variable.ajax_url,
                success: function (response) {
                    if(response.success) {
                        if('0' == status) {
                            icon.attr('class', 'dashicons dashicons-star-filled');
                            $this.attr('data-status', '1');
                        } else {
                            icon.attr('class', 'dashicons dashicons-star-empty');
                            $this.attr('data-status', '0');
                        }
                    }
                    on_handle = false;
                },
                error: function (xhr) {
                    console.log(xhr);
                    on_handle = false;
                }
            });
        });
    });
})(jQuery);
