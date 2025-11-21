var bigpie = bigpie || {};

(function ($, bigpie) {

    var _$emailExistsModal = null;
    var _$incompleteRegistrationModal = null;
    var _$emailSentModal = null;
    var _$GenericServerError = null;
    var _$emailInput = $('#accountEmail');
    var _$registerInput = $('.accountEmail');

    var _$registeredEmail = null;
    var _$oldRegisterSection = null;
    var _$oldRegisterModalSection = null;
    var _oldEmail = null;

    bigpie.registerModel = {};

    var _generateNotifyMeSentMessage = function (email) {
        return $(
            '<div class="notify_me_success">' +
            '<p class="notify_me_text text-shadow">' + email + ', thank you for registering, we\'ll be in touch.</p>' +
            '</div>'
        );
    };

    var _generateEmailSentModal = function () {
        return $(
            '<div class="modal fade" id="emailSentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="row">' +
            '<div class="col-sm-10 col-sm-offset-1">' +
            '<h2>Success!</h2>' +
            '<form accept-charset="UTF-8" class="email_exists" id="email_exists" role="form">' +
            '<h4>Check your email to continue the registration process.</h4>' +
            '<button class="btn btn-default">Ok</button>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>').appendTo('body').modal();
    };

    var _generateEmailExistsModal = function () {
        return $(
            '<div class="modal fade" id="emailExistsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="row">' +
            '<div class="col-sm-10 col-sm-offset-1">' +
            '<h2>Email already exits.<br>Forgot your password?</h2>' +
            '<form accept-charset="UTF-8" class="email_exists" id="email_exists" role="form">' +
            '<h4>Enter your email below and we\'ll send you a link to reset your password.</h4>' +
            '<div class="form-group">' +
            '<input class="form-control" id="email_addr" placeholder="email address" type="email" value="" />' +
            '</div>' +
            '<input class="btn btn-default" type="submit" value="Reset Password" style="margin-right: 8px;" id="send_email_confirm" />' +
            '<input class="btn btn-default" type="button" value="Cancel" id="send_email_cancel" />' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>').appendTo('body').modal();
    };

    var _generateIncompleteRegistrationModal = function () {
        return $(
            '<div class="modal fade" id="incompleteRegistrationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="row">' +
            '<div class="col-sm-10 col-sm-offset-1">' +
            '<h2>Thank your for registering.</h2>' +
            '<h4>Verification email was sent to your mailbox.</h4>' +
            '<button class="btn btn-default">Ok</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>').appendTo('body').modal();
    };

    var _generateGenericServerErrorModal = function () {
        return $(
            '<div class="modal fade" id="incompleteRegistrationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="row">' +
            '<div class="col-sm-10 col-sm-offset-1">' +
            '<h2>Server Error.</h2>' +
            '<h4>We\'re sorry. There was an unknown server error. Please try again later.</h4>' +
            '<button class="btn btn-default">Ok</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>').appendTo('body').modal();
    };

    var _getEmailExistsModal = function () {
        return _$emailExistsModal || (_$emailExistsModal = _generateEmailExistsModal());
    };

    var _getIncompleteRegistrationModal = function () {
        return _$incompleteRegistrationModal || (_$incompleteRegistrationModal = _generateIncompleteRegistrationModal());
    };

    var _getEmailSentModal = function () {
        return _$emailSentModal || (_$emailSentModal = _generateEmailSentModal());
    };

    var _getGenericServerErrorModal = function () {
        return _$GenericServerError || (_$GenericServerError = _generateGenericServerErrorModal());
    };

    bigpie.showForgotPasswordMessage = function (email, type) {
        // show check your mail message
        $('#' + type + '-registration').fadeOut("slow", function () {
            var div = bigpie.partials.forgotMessage(email, type);
            $(this).html(div);
            $(this).show();
            $('#register-success-html').hide();
            $('#register-success-html').fadeIn("slow");
        });
    };

    bigpie.showEmailExistsPopup = function (email) {
        var $modal = _getEmailExistsModal();
        var $confirm = $modal.find('#send_email_confirm');
        var $cancel = $modal.find('#send_email_cancel');
        var $emailInput = $modal.find('#email_addr');

        var _closeModal = function () {
            return $modal.modal('hide');
        };
        var _sendPasswordResetEmail = function () {
            return $.ajax({
                url: bigpie.config.baseUrl + bigpie.config.forgot,
                type: "POST",
                data: {"email": $emailInput.val()}
            });
        };

        $emailInput.val(email);
        $confirm.off().click(function (event) {
            event.preventDefault();
            $confirm.attr('disabled', 'disabled').val('Sending...');
            _sendPasswordResetEmail().then(function () {
                _closeModal();
                $confirm.removeAttr('disabled').val('Ok');
                $('.hero.bottom input:not(.btn)').val('');
                $('.user_email_register_error').hide();
            });
        });
        $cancel.off().click(function (event) {
            event.preventDefault();
            _closeModal();
        });

        $modal.modal('show');
    };

    bigpie.showIncompleteRegistrationPopup = function (email) {
        var $modal = _getIncompleteRegistrationModal();
        var _closeModal = function () {
            return $modal.modal('hide');
        };
        $modal.find('button').off().click(function (event) {
            event.preventDefault();
            _closeModal();
        });

        $modal.modal('show');
    };

    bigpie.showGenericServerErrorPopup = function () {
        var $modal = _getGenericServerErrorModal();
        var _closeModal = function () {
            return $modal.modal('hide');
        };
        $modal.find('button').off().click(function (event) {
            event.preventDefault();
            _closeModal();
        });

        $modal.modal('show');
    };

    bigpie.showEmailSentPopup = function () {
        var $modal = _getEmailSentModal();
        var _closeModal = function () {
            return $modal.modal('hide');
        };
        $modal.find('button').off().click(function (event) {
            event.preventDefault();
            _closeModal();
        });

        $modal.modal('show');
    };

    bigpie.resendEmail = function (evt, type) {

        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.register,
            type: "POST",
            data: {"email": _$registeredEmail, "type": type}
        })
            .done(function () {
                bigpie.showEmailSentPopup();
            })
            .error(function (err) {
                if (err.status === 412) {
                    bigpie.showEmailSentPopup();
                }
                else {
                    bigpie.showGenericServerErrorPopup();
                }

            });

    };

    bigpie.resendEmailModal = function (evt) {

        var email = bigpie.registerModel.email;
        var type = bigpie.registerModel.type;

        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.register,
            type: "POST",
            data: {"email": email, "type": type}
        })
            .done(function () {
                bigpie.showEmailSentPopup();
            })
            .error(function (err) {
                if (err.status === 412) {
                    bigpie.showEmailSentPopup();
                }
                else {
                    bigpie.showGenericServerErrorPopup();
                }

            });

    };

    bigpie.registerHandler = function (evt, type) {
        evt.preventDefault();
        evt.stopPropagation();
        var email = $('#accountEmail').val();
        // saves the email for later use in the resend email
        _$registeredEmail = email;
        if (!_verifyRegisterFormValidity()) {
            return;
        }

        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.register,
            type: "POST",
            data: {"email": email, "type": type}
        })
            .done(function (data) {

                // pick the section to switch
                var registerSection = $('#' + type + '-registration').length > 0 ? $('#' + type + '-registration') : $('#register-success-html');
                _$oldRegisterSection = registerSection;
                // show check your mail message
                $(registerSection).fadeOut("slow", function () {
                    var div = bigpie.partials.registerSuccessHtml(email, type);
                    $(this).replaceWith(div);
                    $('#register-success-html').hide();
                    $('#register-success-html').fadeIn("slow");
                });

                // old registration popup
                //showEmailSentPopup();
            })
            .error(function (err) {
                $('.user_email_register_error').hide();
                switch (err.status) {
                    case 409:
                    case 412:
                        bigpie.showForgotPasswordMessage(email, type);
                        break;
                    case 504:
                        bigpie.showGenericServerErrorPopup();
                        break;
                    default:
                        $('.user_email_register_error')
                            .text(err.responseJSON && err.responseJSON.message || 'Invalid mandatory fields')
                            .show();
                }
            });
    };

    bigpie.switchBackToRegister = function (evt, type) {
        evt.preventDefault();
        evt.stopPropagation();

        var completeRegisterSection = $('#register-success-html');
        // show check your mail message
        $(completeRegisterSection).fadeOut("slow", function () {
            var div = _$oldRegisterSection;
            $(this).replaceWith(div);
            $(_$oldRegisterSection).hide();
            // clear the input field
            $('#accountEmail').val('');
            $(_$oldRegisterSection).fadeIn("slow");
        });

    };

    bigpie.switchBackToRegisterModal = function (evt, email, type) {
        if (evt) {
            evt.preventDefault();
            evt.stopPropagation();
        }

        var completeRegisterSection = $('#register-success-html-modal');
        // show check your mail message
        $(completeRegisterSection).fadeOut("fast", function () {
            var div = _$oldRegisterModalSection;
            $(this).replaceWith(div);
            $(_$oldRegisterModalSection).hide();
            $(_$oldRegisterModalSection).fadeIn("fast");
        });

    };

    _$emailInput.on('keyup', function () {
        _setRegisterFormValidity(true);
    });

    var _setRegisterFormValidity = function (setValid) {
        var $errorMessage = $('.user_email_register_error');
        if (setValid) {
            _$emailInput.removeClass('invalid');
            $errorMessage.hide();
        } else {
            _$emailInput.addClass('invalid');
            $errorMessage.text('Please enter a valid email address')
                .show();
        }
    };

    var _verifyEmail = function (email) {
        var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(email);
    };

    var _verifyRegisterFormValidity = function () {
        var email = _$emailInput.val();

        if (_verifyEmail(email)) {
            _setRegisterFormValidity(true);
            return true;
        }
        _setRegisterFormValidity(false);
        return false;
    };

    var _displayExistingError = function (elem, setValid, errorMessage) {
        elem = elem || $('body');

        var $errorMessage = elem.find('.register_error');
        if (setValid) {
            elem.find('.accountEmail').removeClass('invalid');
            $errorMessage.hide();
        } else {
            elem.find('.accountEmail').addClass('invalid');
            $errorMessage.text(errorMessage).show();
        }
    };



    var _sendRegisterModal = function (email, type, registerFromSpecificType) {
        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.register,
            type: "POST",
            data: {"email": email, "type": type}
        })
            .done(function (data) {
                var $modalRegistration = $('#modal-registration');
                // pick the section to switch
                var registerSection = $modalRegistration.length > 0 ? $modalRegistration : $('#register-success-modal-html');
                _$oldRegisterModalSection = registerSection;

              // replace the register modal with the
              function _replaceRegisterModalContent(){
                  var div = bigpie.partials.registerSuccessModalHtml(email, type);
                  registerSection.replaceWith(div);
                  $('#register-success-modal-html').hide();
                  $('#register-success-modal-html').fadeIn("slow");
              }

              // show check your mail message
              if(registerFromSpecificType){
                  $('#registerModalSuccess').modal({
                      backdrop: 'static'
                  });
                  $('register-success-html-modal-success').fadeIn("slow");
                  bigpie.registerModel.email = email;
                  bigpie.registerModel.type = type;
              } else {
                  $(registerSection).fadeOut("slow", function () {
                      _replaceRegisterModalContent();
                  });
              }
            })
            .error(function (err) {
                $('.register_error').hide();
                switch (err.status) {
                    case 504:
                        bigpie.showGenericServerErrorPopup();
                        break;
                    default:
                        $('.register_error')
                            .text(err.responseJSON && err.responseJSON.message || 'Invalid mandatory fields')
                            .show();
                }
            });
    };


    bigpie.notifyMeHandler = function (event, type, pageSpacific) {
        event.preventDefault();
        event.stopPropagation();
        // Get the registered mail
        var $register = $(event.target);
        var $email = $(event.target).find('.accountEmail');
        var email = $email.val();

        if (_$oldRegisterModalSection) {
            bigpie.switchBackToRegisterModal(null, email, '');
        }

        // Check if the email is valid first
        if (!_verifyEmail(email)) {
            _displayExistingError($register, false, 'Please enter a valid email address');
            return true;
        } else {
            _displayExistingError($register, true);
        }

        _oldEmail = email;

        $.ajax({
            url: bigpie.config.baseUrl + bigpie.config.exists,
            type: "POST",
            data: {"email": email}
        })
            .done(function (users) {
                // If there is an email, means there is already an account like that
                if (users.length) {
                    _displayExistingError($register, false, 'Email already exists');
                } else {
                    _displayExistingError($register, true);
                    $('#signUpModal').modal('hide');
                    $('#registerModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            })
            .error(function (err) {
                if(!type){
                    _displayExistingError($register, true);
                    $('#signUpModal').modal('hide');
                    $('#registerModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                } else {
                    switch(type){
                        case 'nonprofit':
                            bigpie.openNonprofitRegistrationModal(event);
                            break;
                        case 'merchant':
                        case 'patron':
                            bigpie.register(event, type, pageSpacific);
                            break;
                    }
                }

            });
    };

    bigpie.register = function register (event, entityType, pageSpacific) {
        event.preventDefault();
        event.stopPropagation();

        var email = _oldEmail;
        _sendRegisterModal(email, entityType, pageSpacific);
    };

    bigpie.openNonprofitRegistrationModal = function (event) {
        event.preventDefault();
        event.stopPropagation();

        var email = _oldEmail;
        window.open(bigpie.config.bigpieUrl + '/#/registration/nonprofit?email=' + encodeURIComponent(email), '_self');
    };

})(jQuery, bigpie);
