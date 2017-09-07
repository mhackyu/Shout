$(document).ready( function () {
//Todo: BUG WHEN USER GOES BACK FROM SHOWACTION. CSS GOES BACK TO DEFAULT RENDERED IN TWIG.
    // love reaction.
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

    $('.btn-loud').on('click', function (e) {
        var id = $(this).data('id');
        var isLoud = $(this).data('is-loud');
        // var isLoud = $(this).attr('data-is-loud');
        var loudCount = parseInt($('#loud-count-' + id).text());
        var addLoveUrl = "/loud/" + id + '/add';
        var removeLoveUrl = "/loud/" + id + '/remove';

        // alert(loudCount+1);

        if (isLoud) {
            // remove loud from shout.
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-outline-primary');
            $('.loud-caption').text("You loud this");
            $.ajax({
                url: removeLoveUrl,
                method: "GET",
                success: function (data) {
                    // alert(data);
                    $('#loud-count-' + id).text(loudCount-1);
                },
                error: function () {
                    alert("failed request");
                }
            });
        }
        else {
            // if the user press the loud reaction..
            $(this).removeClass('btn-outline-primary');
            $(this).addClass('btn-primary');
            $('.loud-caption').text("Love");
            $.ajax({
                url: addLoveUrl,
                method: "GET",
                success: function (data) {
                    // alert(data);
                    $('#loud-count-' + id).text(loudCount+1);
                },
                error: function () {
                    alert("failed request");
                }
            });
        }
        $(this).removeClass('animated bounceIn');
        $(this).addClass('animated bounceIn');
        // update data-is-loud value.
        $(this).data('is-loud',!isLoud);
        // $(this).attr('data-is-loud', !isLoud);
    });
});