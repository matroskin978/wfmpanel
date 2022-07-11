jQuery(document).ready(function($) {

    $( "#accordion" ).accordion({
        collapsible: true,
        active: false
    });

    $('.wfmpanel-select').on('change', function () {
        let $this = $(this),
            slideId = $this.val(),
            articleId = $this.data('article');
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                slide_id: slideId,
                article_id: articleId,
                wfmpanel_change_slide: wfmpanelSlide.nonce,
                action: 'wfmpanel_change_slide'
            },
            beforeSend: function () {
                $('#wfmpanel-loader').fadeIn();
            },
            success: function (res) {
                res = JSON.parse(res);
                $('#wfmpanel-loader').fadeOut(300, function () {
                    Swal.fire({
                        text: res.text,
                        icon: res.answer
                    });
                });
            },
            error: function () {
                alert('Error!');
            }
        });
    });

});
