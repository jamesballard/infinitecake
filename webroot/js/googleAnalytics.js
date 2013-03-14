/**
 * Created with JetBrains PhpStorm.
 * User: James
 * Date: 14/03/13
 * Time: 15:29
 * To change this template use File | Settings | File Templates.
 */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-39286952-1']);
_gaq.push(['_setDomainName', 'infiniterooms.co.uk']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();