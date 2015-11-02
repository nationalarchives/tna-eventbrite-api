/* Attach Google Analytics event tracking to all external links inside #events
 Refer to http://www.axllent.org/docs/view/track-outbound-links-with-google-ga-js/ */

$(document).on('click', '#events a', function (e) {

    var $currentTarget = $(e.currentTarget),
        href = $currentTarget.attr('href');

    _gaq.push(["_trackEvent", "outbound", "click", href]);

});




