var bigpie = bigpie || {};

// this exists in login.js temporarily becuase is has to be run
// after env_*.js (build order from grunt).
if (window.xdomain) {
    var slaves = {};
    slaves[bigpie.config.baseUrl] = '/proxy.html';
    xdomain.slaves(slaves);
}


(function ($, bigpie) {
    'use strict';
    var email;

    bigpie.loginHandler = function (evt) {
        evt.preventDefault();
        evt.stopPropagation();

        var email = $('#user_email').val();
        var password = $('#user_password').val();

        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.login,
            type: "POST",
            data: {"email": email, "password": password},
        })
            .done(function (data) {
                window.open(data.redirectUrl, "_self");
            })
            .error(function (errData) {
                // console.log(arguments);
                $(".user_password_error").show();
                // TODO Handle server error
            });
    };

    bigpie.passwordResetHandler = function (evt) {
        evt.preventDefault();
        evt.stopPropagation();

        $(".password_reset_error").hide();
        $(".password_reset_success").hide();

        email = $('#password_reset_user_email').val();

        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.forgot,
            type: "POST",
            data: {"email": email}
        })
            .done(function (data) {
                $(".password_reset_success").show();
            })
            .error(function (errData) {
                if (errData.status === 412) { // complete registration email was resent
                    return $(".password_reset_success").show();
                }
                // console.log(arguments);
                $(".password_reset_error").show();
                // TODO Handle server error
            });
    };

    bigpie.forgotPassword = function (evt) {
        evt.preventDefault();
        evt.stopPropagation();

        $('#signInModal').one('hidden.bs.modal', function () {
            bigpie.openForgotPasswordModal();
        });
        $('#signInModal').modal('hide');
    };

    // switch modals from sign-in to forgot password
    bigpie.openForgotPasswordModal = function () {
        $('#forgotPasswordModal').modal('show');

        setTimeout(function () {
            $('body').addClass('modal-open');
        }, 0);
    };

})(jQuery, bigpie);
