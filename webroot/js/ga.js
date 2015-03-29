/**
 * Created with JetBrains PhpStorm.
 * User: James
 * Date: 14/03/13
 * Time: 15:29
 * To change this template use File | Settings | File Templates.
 */
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-59997451-2', 'auto');

/* Service Level */
var serviceLevel = window.app.service;
ga('set', 'dimension1', serviceLevel);

/* Customer ID */
var customerID = window.app.customerID;
ga('set', 'dimension2', customerID);

/* Customer start date */
var startMonth = window.app.customerStart;
ga('set', 'dimension3', startMonth);

/* User ID */
var userID = window.app.userID;
ga('set', 'dimension4', userID);

// Set the user ID using signed-in user_id.
ga('set', '&uid', userID);

ga('send', 'pageview');

$('a').click(function() {
    ga('send','event','Button',$(this).prop('href'),null);
});