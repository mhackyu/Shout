$(document).ready( function () {
    // found helpful.
    $('.btn-love').on('click', function (e) {
        var id = $(this).data('id');
        var isLove = $(this).data('is-love');
        // var isLove = $(this).attr('data-is-love');
        var loveCount = parseInt($('#love-count-' + id).text());
        var addLoveUrl = "/love/" + id + '/add';
        var removeLoveUrl = "/love/" + id + '/remove';

        // alert(loveCount+1);

        if (isLove) {
            // remove love from shout.
            $(this).removeClass('btn-danger');
            $(this).addClass('btn-outline-danger');
            $('.love-caption').text("You loved this");
            $.ajax({
                url: removeLoveUrl,
                method: "GET",
                success: function (data) {
                    // alert(data);
                    $('#love-count-' + id).text(loveCount-1);
                },
                error: function () {
                    alert("failed request");
                }
            });
        }
        else {
            // if the user press the love reaction..
            $(this).removeClass('btn-outline-danger');
            $(this).addClass('btn-danger');
            $('.love-caption').text("Love");
            $.ajax({
                url: addLoveUrl,
                method: "GET",
                success: function (data) {
                    // alert(data);
                    $('#love-count-' + id).text(loveCount+1);
                },
                error: function () {
                    alert("failed request");
                }
            });
        }
        $(this).removeClass('animated bounceIn');
        $(this).addClass('animated bounceIn');
        // update data-is-love value.
        $(this).data('is-love',!isLove);
        // $(this).attr('data-is-love', !isLove);
    });
});