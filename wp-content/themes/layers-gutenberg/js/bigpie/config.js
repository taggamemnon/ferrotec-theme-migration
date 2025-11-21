'use strict';
// Create namespace
if (!window.bigpie) {
    window.bigpie = {};
}
var bigpie = window.bigpie;

bigpie.config = bigpie.config || {};

bigpie.config.register = '/register';
bigpie.config.exists = '/exists';
bigpie.config.login = '/login';
bigpie.config.forgot = '/passwordforgotten';
bigpie.config.notifyme = '/notifyme';
bigpie.config.contact = '/contact';
bigpie.config.config = '/config';
bigpie.config.tax = '/tax';
bigpie.config.registerNonprofit = '/lead/nonprofit';
bigpie.config.suggestNonprofit = '/public/suggestNonprofit';

bigpie.config.merchantDirectory = '/#/publicdirectory/merchants';
bigpie.config.nonprofitDirectory = '/#/publicdirectory/nonprofits';
bigpie.config.nonprofitInfo = '/#/publicdirectory/nonprofit';

bigpie.partials = {};

window.isIE = function () {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
};

$.ajaxSetup({cache: false, crossDomain: false});

bigpie.partials.forgotMessage = function (email, type) {
    var $template = $('#forgotMessageTemplate').html();
    $template = $template.replace(/\{\{email\}\}/g, email);
    $template = $template.replace(/\{\{type\}\}/g, type);

    return $template;
};

bigpie.partials.registerSuccessHtml = function (email, type) {
    return '<div id="register-success-html" class="container text-center"> <h1>Check your email.</h1>' +
           '<h2>' +
           'We sent a confirmation to email your address. Your account <br>' +
           'will be active after you confirm your email address.' +
           '<h2>' +
           '<h3>' +
           'Don\'t see the confirmation email? Look in your junk mail for an <br>' +
           'email from noreply@bigpie.com' +
           '</h3>' +
           '<input class="btn btn-default" name="commit" type="submit" value="Resend email" onclick="bigpie.resendEmail(event, \'' + type + '\')"/>' +
           '<input class="btn btn-default" name="commit" type="submit" value="Resend email" onclick="bigpie.resendEmail(event, \'' + type + '\')"/>' +
           '<h3>' +
           'We sent your email to ' + email + '. If this is the wrong address <br>' +
           'start over by <a class="click-here" onClick="bigpie.switchBackToRegister(event,\'' + type + '\')"> clicking here </a>' +
           '</h3> </div>';
};

bigpie.partials.registerSuccessModalHtml = function (email, type) {
    return '<div id="register-success-html-modal" class="text-center"> ' +
           '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>' +
           '<h1>Check your email.</h1>' +
           '<h2>We sent a confirmation email to your address.</h2>' +
           '<h2>Your account will be active once you confirm your email address.<h2>' +
           '<h3 class="footer">Don\'t see the confirmation email? Look in your junk mail for an email from noreply@bigpie.com</h3>' +
           '<input class="btn btn-default" name="commit" type="submit" value="Resend email" ' +
           'onclick="bigpie.resendEmailModal(event, \'' + email + '\', \'' + type + '\')"/>' +
           '</div>';
};
