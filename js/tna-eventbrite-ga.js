/* Attach Google Analytics event tracking to all links inside .track-outbound */

$(document).on('click', '.track-outbound a', function (e) {

    var $currentTarget = $(e.currentTarget),
        href = $currentTarget.attr('href');

    _gaq.push(["_trackEvent", "outbound", "click", href]);

});

