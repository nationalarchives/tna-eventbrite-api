/* Attach Google Analytics event tracking to all external links inside #events
   Refer to http://www.axllent.org/docs/view/track-outbound-links-with-google-ga-js/ */

var _gaq = _gaq || [];

function _gaLt(event){
    var el = event.srcElement || event.target;

    /* Loop up the tree through parent elements if clicked element is not a link (eg: an image in a link) */
    while(el && (typeof el.tagName == 'undefined' || el.tagName.toLowerCase() != 'a' || !el.href))
        el = el.parentNode;

    if(el && el.href){
        if(el.href.indexOf(location.host) == -1){ /* external link */
            _gaq.push(["_trackEvent", "outbound", "click", el.href]);
            console.log(el.href);
            console.log(document.location.pathname);
        }

    }
}

/* Attach the event to all clicks in the document after page has loaded */
var w = window;
w.addEventListener ? w.addEventListener("load",function(){document.getElementById("events").addEventListener("click",_gaLt,!1)},!1)
    : w.attachEvent && w.attachEvent("onload",function(){document.getElementById("events").attachEvent("onclick",_gaLt)});