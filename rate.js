    function rateMedia(mediaId, rate, numStar, starWidth) {
        $('#' + mediaId + ' .star_bar #' + rate).removeAttr('onclick'); // Remove the onclick attribute: prevent multi-click
        $('.box' + mediaId).html('<img src="loader-small.gif" alt="Loading..." />'); // Display a processing icon
        var data = {mediaId: mediaId, rate: rate}; // Create JSON which will be send via Ajax
        $.ajax({ // JQuery Ajax
            type: 'POST',
            url: 'ajax.php', // URL to the PHP file which will insert new value in the database
            data: data, // We send the data string
            dataType: 'json',
            timeout: 3000,
            success: function(data) {
                $('.box' + mediaId).html('<div style="font-size: small; color: green">Thank you for rating</div>'); // Return "Thank you for rating"
                // We update the rating score and number of rates
                $('.resultMedia' + mediaId).html('<div style="font-size: small; color: grey">Rating: ' + data.avg + '/' + numStar + ' (' + data.nbrRate + ' votes)</div>');
                // We recalculate the star bar with new selected stars and unselected stars
                var nbrPixelsInDiv = numStar * starWidth;
                var numEnlightedPX = Math.round(nbrPixelsInDiv * data.avg / numStar);
                $('#' + mediaId + ' .star_bar').attr('style', 'width:' + nbrPixelsInDiv + 'px; height:' + starWidth + 'px; background: linear-gradient(to right, #ffc600 0%,#ffc600 ' + numEnlightedPX + 'px,#ccc ' + numEnlightedPX + 'px,#ccc 100%);');
                $.each($('#' + mediaId + ' .star_bar > div'), function () {
                    $(this).removeAttr('onmouseover onclick');
                });
            },
            error: function() {
                $('#box').text('Problem');
            }
        });
    }
     
    function overStar(mediaId, myRate, numStar) {
        for ( var i = 1; i <= numStar; i++ ) {
            if (i <= myRate) $('#' + mediaId + ' .star_bar #' + i).attr('class', 'star_hover');
            else $('#' + mediaId + ' .star_bar #' + i).attr('class', 'star');
        }
    }
     
    function outStar(mediaId, myRate, numStar) {
        for ( var i = 1; i <= numStar; i++ ) {
            $('#' + mediaId + ' .star_bar #' + i).attr('class', 'star');
        }
    }