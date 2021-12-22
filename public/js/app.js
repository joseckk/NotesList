$('.finalize').on('click', function (e) {
    e.preventDefault();
    var $this = $(this),
        url = $this.data('url'),
        $title = $this.closest('tr').find('.title')
    var oppositeText = $this.data('oppositeText');
    var actualText = $this.text();

    $this.addClass('disabled');

    $.post(url, {})
        .done(function () {
            if (!$title.html().includes('<s>')) {
                $title.html('<s>' + $title.text() + '</s>');
            } else {
                $title.html($title.text());
            }
            $this.text(oppositeText);
            $this.data('oppositeText', actualText);
            $this.removeClass('disabled');
        })
        .fail(function () {
            $this.removeClass('disabled');
        });
});